<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Admin\CaixaBalcaoController;
use App\Http\Controllers\Admin\PainelController;
use App\Http\Controllers\Admin\EstoqueController;
use App\Http\Controllers\Admin\CaixaGestaoController;
use App\Http\Controllers\Admin\CaixaRelatorioController;
use App\Http\Controllers\Admin\PagamentoController;

// 1. Ao acessar o site (rota raiz), o usuário vai para a HOME pública
Route::get('/', [PublicController::class, 'index'])->name('home');

// Rotas de Login do seu Site (Tela Colorida)
Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');
// Rotas de Cadastro
Route::get('/cadastro', [CustomAuthController::class, 'showCadastro'])->name('cadastro');
Route::post('/cadastro', [CustomAuthController::class, 'cadastro'])->name('cadastro.post');
// Rotas de Recuperar Senha
Route::get('/recuperar-senha', [CustomAuthController::class, 'showRecuperar'])->name('senha.recuperar');
// Rota de Logout
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

// 3. Painel Administrativo do Usuário cadastrado (Caixa)
// Mudamos o prefixo para '/admin' para deixar o '/panel' livre e exclusivo para o Backpack!
Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/caixa', [CaixaBalcaoController::class, 'index'])->name('admin.caixa');
    Route::get('/faturamento', [PainelController::class, 'index'])->name('admin.painel');
    Route::post('/caixa/salvar', [CaixaBalcaoController::class, 'salvar'])->name('admin.caixa.salvar');
    // Rotas de Estoque
    Route::get('/estoque', [EstoqueController::class, 'index'])->name('admin.estoque');
    Route::post('/estoque/repor/{id}', [EstoqueController::class, 'repor'])->name('admin.estoque.repor');
    // Rotas de Fluxo de Caixa Físico
    Route::post('/caixa/abrir', [CaixaGestaoController::class, 'abrir'])->name('admin.caixa.abrir');
    Route::post('/caixa/movimentar', [CaixaGestaoController::class, 'movimentar'])->name('admin.caixa.movimentar');
    Route::post('/caixa/fechar', [CaixaGestaoController::class, 'fechar'])->name('admin.caixa.fechar');
    Route::get('/admin/relatorio-mensal', [CaixaRelatorioController::class, 'relatorioMensal'])->name('admin.relatorio_mensal');
    Route::get('/admin/caixa/dados-fechamento', [CaixaGestaoController::class, 'dadosFechamento'])->name('admin.caixa.dados_fechamento');
    // Gestão de Colaboradores 
    Route::get('/admin/colaboradores', [PainelController::class, 'colaboradores'])->name('admin.colaboradores');

    Route::post('/admin/colaboradores/pagar', [PagamentoController::class, 'registrarPagamento'])->name('admin.pagamentos.store');

    Route::get('/admin/colaboradores/evolucao', [PainelController::class, 'evolucao'])->name('admin.colaboradores.evolucao');

    Route::post('/estoque/baixa/{id}', [EstoqueController::class, 'darBaixa'])->name('admin.estoque.darBaixa');
});

// Bloqueia e desativa completamente a rota de registro do Backpack
Route::any('admin/register', function () {
    abort(403, 'O registro de novos administradores está desativado.');
});
<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Barbeiro;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Busca os barbeiros cadastrados
        $barbeiros = Barbeiro::all();

        // Busca os serviços e agrupa pela coluna 'categoria'
        $servicosHome = Servico::all()->groupBy('categoria');

        // Passa as variáveis para a view welcome
        return view('welcome', compact('barbeiros', 'servicosHome'));
    }
}

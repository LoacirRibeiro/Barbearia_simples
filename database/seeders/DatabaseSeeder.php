<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Cria as Roles caso elas não existam
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operadorRole = Role::firstOrCreate(['name' => 'operador']);

        // 2. Cria ou atualiza o usuário Admin mestre de forma limpa
        // Deixamos a senha como string pura para o Backpack criptografar apenas UMA vez
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@admin.com'], 
            [
                'name'              => 'Admin Barbearia',
                'password'          => 'admin123', // 👈 Texto puro aqui
                'email_verified_at' => now(),
            ]
        );

        // 3. Garante que o usuário Admin mestre tenha a role 'admin'
        $adminUser->assignRole($adminRole);

        // 4. Chama os outros Seeders do seu projeto
        $this->call([
            ProdutoSeeder::class,
            ServicoSeeder::class,
        ]);
    }
}
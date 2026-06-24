<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CrudTrait;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone', // 📞 Adicionado aqui para o cadastro do site funcionar!
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // ❌ REMOVIDO: 'password' => 'hashed' para não duplicar com o mutator abaixo
        ];
    }

    /**
     * Mutator inteligente para a senha
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            // Se a senha já vier criptografada (padrão do laravel começa com $2y$), salva direto.
            // Se vier em texto limpo (vinda do formulário ou do Tinker), aplica a criptografia.
            $this->attributes['password'] = str_starts_with($value, '$2y$') ? $value : \Hash::make($value);
        }
    }
}
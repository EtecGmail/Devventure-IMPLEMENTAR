<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Professor extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $table = 'professor';

    protected $fillable = [
        'nome',
        'cpf',
        'areaEnsino',
        'formacao',
        'telefone',
        'email',
        'password',
        'avatar',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code', // Oculta o código de segurança
    ];

    /**
     * Os atributos que devem ter seu tipo de dado alterado.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime', // Informa ao Laravel que este campo é uma data
    ];

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'professor_id');
    }
}
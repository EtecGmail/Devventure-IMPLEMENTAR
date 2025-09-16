<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Define as configurações padrão de autenticação.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Aqui ficam os guards de autenticação. 
    | Cada guard usa um provider que define de onde vêm os dados do usuário.
    |
    | Suportados: "session"
    |
    */

    'guards' => [
        // Guard padrão do Laravel
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard para professores
        'professor' => [
            'driver' => 'session',
            'provider' => 'professores',
        ],

        // Guard para Auno
        'aluno' => [
            'driver' => 'session',
            'provider' => 'alunos',
        ],

        // Guard para Admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
    ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Providers definem como os usuários são recuperados do banco de dados.
    | Aqui você pode ter "users", "professores", etc.
    |
    */

    'providers' => [
        // Usuário padrão do Laravel
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Provider para professores
        'professores' => [
            'driver' => 'eloquent',
            'model' => App\Models\professorModel::class, // certifique-se de criar essa Model
        ],

        // Provider para alunos
        'alunos' => [
            'driver' => 'eloquent',
            'model' => App\Models\alunoModel::class, // certifique-se de criar essa Model       
    ],

        // Provider para admins
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\admModel::class, // certifique-se de criar essa Model
    ],  

        // Exemplo de provider usando a tabela diretamente
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Cada tipo de usuário pode ter sua própria configuração de reset de senha.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'professores' => [
            'provider' => 'professores',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'alunos' => [
            'provider' => 'alunos',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
    ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Tempo em segundos antes da confirmação de senha expirar.
    | Padrão: 3 horas (10800 segundos).
    |
    */

    'password_timeout' => 10800,

];

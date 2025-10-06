<?php

namespace Database\Seeders;

use App\Models\Adm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD');

        if (empty($password)) {
            $password = Str::random(12);
            if (app()->environment(['local', 'testing'])) {
                Log::info('Generated admin password', ['password' => $password]);
            }
        }

        Adm::updateOrCreate(
            ['email' => $email],
            [
                'nome' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make($password ?? Str::random(12)),
            ]
        );
    }
}

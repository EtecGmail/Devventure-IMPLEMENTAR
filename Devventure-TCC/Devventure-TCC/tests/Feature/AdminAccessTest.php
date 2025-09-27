<?php

namespace Tests\Feature;

use App\Models\Adm;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admDashboard');
        $response->assertRedirect('/loginAdm');
    }

    public function test_aluno_cannot_access_admin_dashboard(): void
    {
        Aluno::create([
            'nome' => 'Aluno',
            'ra' => '123',
            'semestre' => '1',
            'email' => 'aluno@example.com',
            'telefone' => '111',
            'password' => Hash::make('secret'),
        ]);

        $this->post('/login-aluno', ['email' => 'aluno@example.com', 'password' => 'secret']);
        $response = $this->get('/admDashboard');
        $response->assertRedirect('/loginAdm');
    }

    public function test_professor_cannot_access_admin_dashboard(): void
    {
        Professor::create([
            'nome' => 'Prof',
            'cpf' => '12345678900',
            'areaEnsino' => 'Area',
            'formacao' => 'Formacao',
            'telefone' => '111',
            'email' => 'prof@example.com',
            'password' => Hash::make('secret'),
        ]);

        $this->post('/login-verify', ['email' => 'prof@example.com', 'password' => 'secret']);
        $response = $this->get('/admDashboard');
        $response->assertRedirect('/loginAdm');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        Adm::create([
            'nome' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
        ]);

        $this->post('/login-adm', ['email' => 'admin@example.com', 'password' => 'secret']);
        $response = $this->get('/admDashboard');
        $response->assertOk();
    }

    public function test_login_routes_redirect_to_dashboards(): void
    {
        Adm::create([
            'nome' => 'Admin',
            'email' => 'admin2@example.com',
            'password' => Hash::make('secret'),
        ]);
        Professor::create([
            'nome' => 'Prof',
            'cpf' => '98765432100',
            'areaEnsino' => 'Area',
            'formacao' => 'Formacao',
            'telefone' => '111',
            'email' => 'prof2@example.com',
            'password' => Hash::make('secret'),
        ]);
        Aluno::create([
            'nome' => 'Aluno',
            'ra' => '456',
            'semestre' => '1',
            'email' => 'aluno2@example.com',
            'telefone' => '111',
            'password' => Hash::make('secret'),
        ]);

        $this->post('/login-adm', ['email' => 'admin2@example.com', 'password' => 'secret'])
            ->assertRedirect('/admDashboard');

        $this->post('/login-verify', ['email' => 'prof2@example.com', 'password' => 'secret'])
            ->assertRedirect('/professorDashboard');

        $this->post('/login-aluno', ['email' => 'aluno2@example.com', 'password' => 'secret'])
            ->assertRedirect('/alunoDashboard');
    }
}

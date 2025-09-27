<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil do Professor</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('css/professorPerfil.css') }}">
</head>
<body>
    @include('layouts.navbar') 

    <main class="page-perfil-professor">
        <div class="container">
            <a href="{{ route('professorDashboard') }}" class="btn-voltar-topo">
                <i class='bx bx-arrow-back'></i>
                <span>Voltar</span>
            </a>

            <h1>Editar Perfil</h1>
            <p>Mantenha suas informações profissionais sempre atualizadas.</p>

            <div class="card-perfil">
                <form method="POST" action="{{ route('professor.perfil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 

                    <div class="form-header">
                        <div class="avatar-upload">
                            <img src="{{ $professor->avatar ? asset('storage/' . $professor->avatar) : asset('images/avatar-default-professor.png') }}" alt="Avatar" id="avatar-preview">
                            <label for="avatar" class="btn-trocar-foto" title="Trocar Foto">
                                <i class='bx bx-camera'></i>
                            </label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">
                        </div>
                        <div class="info-pessoal">
                             <h2>{{ $professor->nome }}</h2>
                             <p>{{ $professor->email }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', $professor->nome) }}" required>
                        @error('nome') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $professor->email) }}" required>
                            @error('email') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $professor->telefone) }}">
                            @error('telefone') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- CAMPOS ESPECÍFICOS PARA PROFESSOR --}}
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $professor->cpf) }}" required>
                        @error('cpf') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" id="areaEnsino" name="areaEnsino" value="{{ old('areaEnsino', $professor->areaEnsino) }}" required>
                        @error('area') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="formacao">Formação Acadêmica</label>
                        <textarea id="formacao" name="formacao" rows="4" required>{{ old('formacao', $professor->formacao) }}</textarea>
                        @error('formacao') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    {{------------------------------------}}
                    
                    <hr>
                    
                    <h4>Alterar Senha</h4>
                    <p class="subtitle">Deixe os campos abaixo em branco para manter a senha atual.</p>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" id="password" name="password">
                             @error('password') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Nova Senha</label>
                            <input type="password" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-salvar">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer') 

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Script para pré-visualização do avatar
        document.getElementById('avatar').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById('avatar-preview').src = URL.createObjectURL(file);
            }
        };

        // Script para SweetAlert2
        @if (session('sweet_success'))
            Swal.fire({
                title: "Sucesso!",
                text: "{{ session('sweet_success') }}", 
                icon: "success",
                confirmButtonText: "Ok"
            });
        @endif
    </script>
</body>
</html>
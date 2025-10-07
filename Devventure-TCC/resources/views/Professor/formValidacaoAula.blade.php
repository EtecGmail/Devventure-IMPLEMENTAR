<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construir Formulário - {{ $aula->titulo }}</title>

    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
    <link href="{{ asset('css/Professor/formValidacao.css') }}" rel="stylesheet">

    

</head>
<body>
    

    <main class="container">
        <header>
            <h1>Etapa 2: Construir Formulário</h1>
            <p class="intro-text">Para a Aula: "{{ $aula->titulo }}"</p>
        </header>

        <form action="{{ route('formularios.store', $aula) }}" method="POST">
            @csrf

            <div class="card form-builder-card">
                
                <div class="form-group mb-4">
                    <label for="titulo" class="h5">Título do Formulário</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ex: Exercício de Fixação sobre Funções" required>
                </div>

                <hr>

                <div id="perguntas-container">
                    
                    <div class="pergunta-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label></label>
                            
                        </div>
                        <div class="input-group">
                            <input type="text" name="perguntas[]" class="form-control" placeholder="Digite o texto da pergunta aqui" required>
                        </div>
                    </div>

                </div>

                <button type="button" id="add-pergunta-btn" class="btn mt-2">
                    <i class='bx bx-plus'></i> Adicionar Nova Pergunta
                </button>
            </div>

            <div class="text-end mt-4"> 
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-check-double'></i> Salvar Formulário Completo
                </button>
            </div>
        </form>
    </main>

    
    <script src="{{ asset('js/Professor/formValidacaoAula.js') }}"></script>

</body>
</html>
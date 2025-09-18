<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gerenciador de Exercicios</title>
  
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./css/exercicioProfessor.css" />
</head>
<body>

  @include('layouts.navbar')

  <main>
    <section class="intro">
        <a href="/professorDashboard" class="btn-voltar">
            <i class='bx bx-chevron-left'></i>
            Voltar
        </a>

      <h1>Exercicios</h1>
      <p>Crie e gerencie Exercicios com total facilidade</p>

      <div class="add-exercicio">
        <button>Adicionar Exercicio</button>
      </div>
    </section>

    <section class="exercicios">
      <div class="exercicios-header">
        <div>
          <h2>Meus Exercicios</h2>
          <p>Clique em um exercicio para gerenciá-lo</p>
          <div class="toggle-buttons">
          <a href="{{ url('/professorExercicios', ['status' => 'disponiveis']) }}" 
            class="toggle-button {{ $status == 'disponiveis' ? 'ativo' : 'inativo' }}">
            Disponíveis
          </a>
          <a href="{{ url('/professorExercicios', ['status' => 'concluidas']) }}" 
            class="toggle-button {{ $status == 'concluidas' ? 'ativo' : 'inativo' }}">
            Concluídas
          </a>
          </div>
          
          
        </div>
      <form action="{{ url('/professorExercicios') }}" method="GET" class="search">

        <input type="hidden" name="status" value="{{ $status }}">

        <input type="text" name="search" placeholder="Pesquisar exercício..." value="{{ request('search') }}">

        <button type="submit"><i class='bx bx-search'></i></button>

      </form>
      </div>

      <!-- ENVOLVE AQUI PARA SCROLL HORIZONTAL -->
    <div class="exercicios-scroll">
    <div class="exercicios-grid">

        @forelse ($exercicios as $exercicio)
            <div class="card">
                <h3>{{ $exercicio->turma->nome_turma }}</h3>

                <div class="tags">
                    <span class="tag">{{ ucfirst($exercicio->turma->turno) }}</span>
                    <span class="tag">{{ $exercicio->nome }}</span>
                </div>
                
                <p class="info">Abre em: {{ \Carbon\Carbon::parse($exercicio->data_publicacao)->format('d/m/Y H:i') }}</p>
                <p class="info">Fecha em: {{ \Carbon\Carbon::parse($exercicio->data_fechamento)->format('d/m/Y H:i') }}</p>
            </div>
        @empty
            <div class="sem-resultados">
                <p>Nenhum exercício encontrado para este filtro.</p>
            </div>
        @endforelse

    </div>
        
        </div>
      <div class="ver-tudo">
        <button  id="btnVerTudo">Ver tudo</button>
      </div>
    </section>
  </main>

  <div class="modal-overlay" id="modal">
    <div class="modal-content">

        <form action="/professorCriarExercicios" method="POST" enctype="multipart/form-data">
            @csrf

            <h2>Criar Exercício</h2>

            <input name="nome" type="text" placeholder="Nome do Exercício" required />
            
            <textarea name="descricao" placeholder="Descrição do Exercício" rows="3"></textarea>
            
            <select name="turma_id" required>
                <option value="" disabled selected>Escolha uma Turma</option>
                @foreach ($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                @endforeach
            </select>
            
            <label>Data de Publicação</label>
            <input name="data_publicacao" type="datetime-local" required />

            <label>Data de Fechamento</label>
            <input name="data_fechamento" type="datetime-local" required />

            <label for="arquivo" class="upload-label">
                Escolher arquivo <i id="upload-icon" class='bx bx-upload'></i> 
            </label>
            <input name="arquivo" type="file" id="arquivo" class="input-file" />
            <span id="nomeArquivo" class="nomeArquivo">Nenhum arquivo selecionado</span>

            <div class="modal-buttons">
                <button type="button" id="cancelar">Cancelar</button>
                <button type="submit" class="criar">Criar Exercício</button>
            </div>
            
        </form>
    </div>
  </div>

  @include('layouts.footer')

  <script src="./js/exercicioProfessor.js"></script>

</body>
</html>

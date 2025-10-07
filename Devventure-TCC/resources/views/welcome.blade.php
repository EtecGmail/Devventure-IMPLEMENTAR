<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevVenture - Lógica de Programação Interativa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('landing/style.css') }}">
</head>
<body>
    <header>
        @include('layouts.navbar')
    </header>

    <main>
        <section class="hero" aria-labelledby="hero-title">
            <canvas id="canvas" aria-hidden="true"></canvas>

            <div class="hero-container">
                <div class="hero-textos">
                    <h1 id="hero-title">DevVenture</h1>
                    <h2>Lógica de Programação <br> Interativa</h2>
                    <p>
                        Sistema web educacional completo que permite a professores e alunos uma imersão
                        no ensino e aprendizado da lógica de programação básica.
                    </p>
                    <div class="buttons">
                        <a href="{{ route('aluno.login') }}" class="btn primary">Começar a aprender</a>
                        <a href="#modulos" class="btn secondary">Conhecer a plataforma</a>
                    </div>
                </div>
                <div class="hero-carousel" aria-hidden="true">
                    <figure class="icon-cards mt-3">
                        <div class="icon-cards__content">
                            <div class="icon-cards__item d-flex align-items-center justify-content-center">
                                <span class="h1"><img src="{{ asset('landing/images/tela-aluno.jpg') }}" alt="Tela do aluno"></span>
                            </div>
                            <div class="icon-cards__item d-flex align-items-center justify-content-center">
                                <span class="h1"><img src="{{ asset('landing/images/tela-aula.jpg') }}" alt="Tela da aula"></span>
                            </div>
                            <div class="icon-cards__item d-flex align-items-center justify-content-center">
                                <span class="h1"><img src="{{ asset('landing/images/tela-video.jpg') }}" alt="Tela de vídeo"></span>
                            </div>
                        </div>
                    </figure>
                </div>
            </div>
        </section>

        <section id="modulos" class="modulos reveal" aria-labelledby="modules-title">
            <h2 id="modules-title">Nossos Módulos</h2>
            <div class="modulos-container">
                <article class="modulo-card purple">
                    <div class="icon-area-modulo">
                        <div class="icon"><i class='bxr bxs-laptop' aria-hidden="true"></i></div>
                    </div>
                    <h3>Simulador de Algoritmos</h3>
                    <p>Execute e visualize fluxogramas de forma interativa.</p>
                </article>
                <article class="modulo-card blue">
                    <div class="icon-area-modulo">
                        <div class="icon"><i class='bxr bxs-trophy bx-flip-horizontal' aria-hidden="true"></i></div>
                    </div>
                    <h3>Rankings & Gamificação</h3>
                    <p>Participe de desafios e acompanhe seu desempenho.</p>
                </article>
                <article class="modulo-card pink">
                    <div class="icon-area-modulo">
                        <div class="icon"><i class='bxr bxs-camcoder' aria-hidden="true"></i></div>
                    </div>
                    <h3>Vídeos Explicativos</h3>
                    <p>Aulas dinâmicas para facilitar seu aprendizado.</p>
                </article>
                <article class="modulo-card darkblue">
                    <div class="icon-area-modulo">
                        <div class="icon"><i class='bxr bxs-message-dots-2' aria-hidden="true"></i></div>
                    </div>
                    <h3>Fórum Interativo</h3>
                    <p>Tire suas dúvidas e interaja com a comunidade.</p>
                </article>
            </div>
        </section>

        <section class="jornada reveal" aria-labelledby="journey-title">
            <h1 id="journey-title">Uma jornada de aprendizado intuitiva</h1>
            <p class="subtitulo">Em apenas três passos, você estará no caminho para dominar a lógica.</p>

            <div class="etapas">
                <article class="etapa">
                    <div class="numero" aria-hidden="true">1</div>
                    <div class="card">
                        <h2>Explore os Módulos</h2>
                        <p>Navegue por aulas, vídeos e desafios gamificados projetados para um aprendizado eficaz e divertido.</p>
                    </div>
                </article>

                <article class="etapa">
                    <div class="numero" aria-hidden="true">2</div>
                    <div class="card">
                        <h2>Pratique no Simulador</h2>
                        <p>Teste seus conhecimentos com nosso simulador de algoritmos, recebendo feedback visual e instantâneo.</p>
                    </div>
                </article>

                <article class="etapa">
                    <div class="numero" aria-hidden="true">3</div>
                    <div class="card">
                        <h2>Suba no Ranking</h2>
                        <p>Complete exercícios, ganhe pontos e mostre suas habilidades competindo de forma saudável com outros alunos.</p>
                    </div>
                </article>
            </div>
        </section>

        <section class="secao-depoimentos reveal" aria-labelledby="testimonials-title">
            <h2 id="testimonials-title">O que nossos alunos dizem</h2>
            <div class="container-depoimentos-grid">
                <div class="formulario-depoimento">
                    <h3>Deixe seu depoimento</h3>
                    <form id="formDepoimento" aria-label="Formulário para envio de depoimento">
                        <div class="campo-formulario">
                            <label for="textoDepoimento">Seu depoimento:</label>
                            <textarea
                                id="textoDepoimento"
                                name="mensagem"
                                required
                                maxlength="300"
                                placeholder="Compartilhe sua experiência com a plataforma..."
                            ></textarea>
                            <span class="contador-caracteres" aria-live="polite">0/300</span>
                        </div>

                        <div class="campo-formulario">
                            <label for="autorDepoimento">Seu nome e informações:</label>
                            <input
                                type="text"
                                id="autorDepoimento"
                                name="autor"
                                required
                                placeholder="Ex: Maria Silva, Estudante de ADS"
                            >
                        </div>

                        <button type="submit" class="btn-enviar">Enviar Depoimento</button>
                    </form>
                </div>

                <div class="carrossel-depoimentos" aria-live="polite">
                    <div class="container-depoimentos" id="containerDepoimentos">
                        <div class="card-wrapper active">
                            <div class="camada-fundo">
                                <div class="card-fundo"></div>
                                <div class="card-fundo"></div>
                            </div>
                            <div class="card-depoimento">
                                <p>"Aprender lógica ficou muito mais divertido com os desafios da plataforma!"</p>
                                <span>- Júlia Santos, 2º semestre</span>
                            </div>
                        </div>

                        <div class="card-wrapper">
                            <div class="camada-fundo">
                                <div class="card-fundo"></div>
                                <div class="card-fundo"></div>
                            </div>
                            <div class="card-depoimento">
                                <p>"As aulas interativas e os rankings me motivam a continuar evoluindo."</p>
                                <span>- Pedro Almeida, 3º semestre</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('landing/hero.js') }}" defer></script>
    <script src="{{ asset('landing/script.js') }}" defer></script>
</body>
</html>

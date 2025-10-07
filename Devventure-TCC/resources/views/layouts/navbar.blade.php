@once
    <script>
        (function () {
            const head = document.head;
            if (!head) {
                return;
            }

            const assets = [
                {
                    href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css",
                    rel: 'stylesheet'
                },
                {
                    href: "https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css",
                    rel: 'stylesheet'
                },
                {
                    href: "{{ asset('css/layouts/navbar.css') }}",
                    rel: 'stylesheet'
                }
            ];

            assets.forEach(asset => {
                if (!document.querySelector(`link[href="${asset.href}"]`)) {
                    const link = document.createElement('link');
                    link.rel = asset.rel;
                    link.href = asset.href;
                    head.appendChild(link);
                }
            });
        })();
    </script>
@endonce

<nav class="navbar" role="navigation" aria-label="Principal">
    <div class="navbar-container">
        <a href="{{ url('/') }}" class="navbar-logo" aria-label="Página inicial">
            <img src="{{ asset('images/logoDevventure.png') }}" alt="Logo Devventure">
        </a>

        <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="navbar-links">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <div class="navbar-links" id="navbar-links" role="menubar">
            <a href="{{ url('/') }}" role="menuitem" {{ request()->is('/') ? "aria-current=\"page\"" : '' }}><i class="fa fa-home"></i><span>Home</span></a>
            <a href="{{ url('/loginProfessor') }}" role="menuitem" {{ request()->is('loginProfessor') ? "aria-current=\"page\"" : '' }}><i class="fa fa-user"></i><span>Login Professor</span></a>
            <a href="{{ url('/loginAluno') }}" role="menuitem" {{ request()->is('loginAluno') ? "aria-current=\"page\"" : '' }}><i class="fa fa-graduation-cap"></i><span>Login Aluno</span></a>
        </div>

        @auth('aluno')
            <div class="navbar-profile">
                <button id="profile-dropdown-btn-aluno" class="profile-button" type="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ Auth::guard('aluno')->user()->avatar ? asset('storage/' . Auth::guard('aluno')->user()->avatar) : asset('images/default-avatar.png') }}" alt="Foto de Perfil" class="profile-avatar">
                    <span class="profile-name">{{ Auth::guard('aluno')->user()->nome }}</span>
                    <i class='bx bx-chevron-down' aria-hidden="true"></i>
                </button>
                <div id="profile-dropdown-aluno" class="profile-dropdown-content" role="menu" aria-labelledby="profile-dropdown-btn-aluno">
                    <a href="{{ route('aluno.perfil.edit') }}" class="dropdown-item" role="menuitem">
                        <i class='bx bxs-edit'></i>
                        <span>Editar Perfil</span>
                    </a>
                    <div class="dropdown-divider" role="separator"></div>
                    <form method="POST" action="{{ route('aluno.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-item-logout" role="menuitem">
                            <i class='bx bx-log-out'></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        @auth('professor')
            <div class="navbar-profile">
                <button id="profile-dropdown-btn-professor" class="profile-button" type="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ Auth::guard('professor')->user()->avatar ? asset('storage/' . Auth::guard('professor')->user()->avatar) : asset('images/default-avatar.png') }}" alt="Foto de Perfil" class="profile-avatar">
                    <span class="profile-name">{{ Auth::guard('professor')->user()->nome }}</span>
                    <i class='bx bx-chevron-down' aria-hidden="true"></i>
                </button>
                <div id="profile-dropdown-professor" class="profile-dropdown-content" role="menu" aria-labelledby="profile-dropdown-btn-professor">
                    <a href="{{ route('professor.perfil.edit') }}" class="dropdown-item" role="menuitem">
                        <i class='bx bxs-edit'></i>
                        <span>Editar Perfil</span>
                    </a>
                    <div class="dropdown-divider" role="separator"></div>
                    <form method="POST" action="{{ route('professor.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-item-logout" role="menuitem">
                            <i class='bx bx-log-out'></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

@once
    <script src="{{ asset('js/layouts/navbar.js') }}" defer></script>
@endonce

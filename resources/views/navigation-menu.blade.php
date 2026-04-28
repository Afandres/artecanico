<nav x-data="{ open: false }" class="pp-nav">
    <div class="pp-nav-inner">

        {{-- IZQUIERDA: Logo + Links --}}
        <div class="pp-nav-left">

            {{-- Logo --}}
            <a href="{{ auth()->check() ? route('appointment.index') : (request()->route('code') ? route('appointment.client.index', ['code' => request()->route('code')]) : '#') }}"
                class="pp-logo">
                <div class="pp-logo-icon">
                    <img src="{{ asset('images/logo.png') }}" width="28" height="28" style="object-fit:contain;">
                </div>
                <span class="pp-logo-text">{{ config('app.name') }}</span>
            </a>

            {{-- Links desktop --}}
            <div class="pp-links">

                @auth
                    {{-- Dropdown Parámetros --}}
                    <div class="pp-dropdown" x-data="{ ddOpen: false }" @mouseenter="ddOpen=true" @mouseleave="ddOpen=false">
                        <button class="pp-link" :class="{ 'active': ddOpen }">
                            <span class="pp-link-icon">⚙️</span>
                            Parámetros
                            <svg class="pp-chevron" :class="{ 'rotated': ddOpen }" xmlns="http://www.w3.org/2000/svg"
                                width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="pp-dropdown-menu" x-show="ddOpen" x-transition>
                            <a class="pp-dropdown-item" href="{{ route('breed.index') }}">🐕 Razas</a>
                            <a class="pp-dropdown-item" href="{{ route('treatment.index') }}">💊 Tratamientos</a>
                        </div>
                    </div>

                    {{-- Dropdown Reportes --}}
                    <div class="pp-dropdown" x-data="{ ddOpenReportes: false }" @mouseenter="ddOpenReportes=true"
                        @mouseleave="ddOpenReportes=false">
                        <button class="pp-link" :class="{ 'active': ddOpenReportes }">
                            <span class="pp-link-icon">📊</span>
                            Reportes
                            <svg class="pp-chevron" :class="{ 'rotated': ddOpenReportes }"
                                xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="pp-dropdown-menu" x-show="ddOpenReportes" x-transition>
                            <a class="pp-dropdown-item" href="{{ route('report.expenses') }}">💰 Gestion de gastos</a>
                            <a class="pp-dropdown-item" href="{{ route('report.daily') }}">📅 Reporte diario</a>
                            <a class="pp-dropdown-item" href="{{ route('report.monthly') }}">📆 Reporte mensual</a>
                            <a class="pp-dropdown-item" href="{{ route('reports.finance') }}">💹 Reporte de finanzas</a>
                        </div>
                    </div>
                @endauth

                @php
                    $code = request()->route('code');
                    $appointmentRoute = auth()->check()
                        ? route('appointment.index')
                        : ($code
                            ? route('appointment.client.index', ['code' => $code])
                            : '#');
                    $petRoute = auth()->check()
                        ? route('pet.index')
                        : ($code
                            ? route('pet.client.index', ['code' => $code])
                            : '#');
                    $historyRoute = auth()->check()
                        ? route('history.index')
                        : ($code
                            ? route('history.client.index', ['code' => $code])
                            : '#');
                @endphp

                <a class="pp-link {{ request()->routeIs('appointment.index', 'appointment.client.index') ? 'active' : '' }}"
                    href="{{ $appointmentRoute }}">
                    <span class="pp-link-icon">📅</span> Citas
                </a>

                <a class="pp-link {{ request()->routeIs('pet.index', 'pet.client.index') ? 'active' : '' }}"
                    href="{{ $petRoute }}">
                    <span class="pp-link-icon">🐶</span> Mascotas
                </a>

                <a class="pp-link {{ request()->routeIs('history.index', 'history.client.index') ? 'active' : '' }}"
                    href="{{ $historyRoute }}">
                    <span class="pp-link-icon">📋</span> Historial
                </a>
            </div>
        </div>

        {{-- DERECHA: Usuario / Login --}}
        <div class="pp-nav-right">

            @auth
                {{-- Teams dropdown (si aplica) --}}
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        <button type="button" class="pp-link" style="font-size:12.5px;">
                            {{ Auth::user()->currentTeam->name }}
                            <svg class="pp-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-60 bg-white rounded-lg shadow-lg z-50" style="display: none;">
                            <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Team') }}</div>
                            <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Team Settings</a>
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <a href="{{ route('teams.create') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create New Team</a>
                            @endcan
                            @if (Auth::user()->allTeams()->count() > 1)
                                <div class="border-t border-gray-200"></div>
                                @foreach (Auth::user()->allTeams() as $team)
                                    <a href="{{ route('team.switch', $team) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $team->name }}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Avatar / nombre --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="pp-user-pill">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="pp-avatar-img" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <div class="pp-avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        @endif
                        <span class="pp-user-name">{{ Auth::user()->name }}</span>
                        <svg class="pp-chevron" :class="{ 'rotated': open }" xmlns="http://www.w3.org/2000/svg"
                            width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg z-50" style="display: none;">
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <a href="{{ route('api-tokens.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">API Tokens</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>

                <div class="pp-separator"></div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="pp-logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Salir
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="pp-login-btn">
                    Iniciar sesión
                </a>
            @endguest
        </div>

        {{-- Hamburger --}}
        <button @click="open = !open" class="pp-hamburger">
            <svg class="size-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Menú móvil --}}
    <div x-show="open" x-cloak class="pp-mobile-menu">
        @auth
            <div class="pp-mobile-section">
                <div class="pp-mobile-label">⚙️ Parámetros</div>
                <a class="pp-mobile-link" href="{{ route('breed.index') }}">🐕 Razas</a>
                <a class="pp-mobile-link" href="{{ route('treatment.index') }}">💊 Tratamientos</a>
            </div>

            <div class="pp-mobile-section">
                <div class="pp-mobile-label">📊 Reportes</div>
                <a class="pp-mobile-link" href="{{ route('report.expenses') }}">💰 Gestion de gastos</a>
                <a class="pp-mobile-link" href="{{ route('report.daily') }}">📅 Reporte diario</a>
                <a class="pp-mobile-link" href="{{ route('report.monthly') }}">📆 Reporte mensual</a>
                <a class="pp-mobile-link" href="{{ route('reports.finance') }}">💹 Reporte de finanzas</a>
            </div>
        @endauth

        <div class="pp-mobile-section">
            <a class="pp-mobile-link {{ request()->routeIs('appointment.index', 'appointment.client.index') ? 'active' : '' }}"
                href="{{ $appointmentRoute }}">
                📅 Citas
            </a>
            <a class="pp-mobile-link {{ request()->routeIs('pet.index', 'pet.client.index') ? 'active' : '' }}"
                href="{{ $petRoute }}">
                🐶 Mascotas
            </a>
            <a class="pp-mobile-link {{ request()->routeIs('history.index', 'history.client.index') ? 'active' : '' }}"
                href="{{ $historyRoute }}">
                📋 Historial de mascotas
            </a>
        </div>

        <div class="pp-mobile-user">
            @auth
                <div class="pp-mobile-user-info">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="pp-avatar-img" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}">
                    @else
                        <div class="pp-avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    @endif
                    <span class="pp-user-name">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="pp-mobile-link"
                        style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="pp-login-btn" style="display:inline-flex;margin:8px 16px;">
                    Iniciar sesión
                </a>
            @endguest
        </div>
    </div>
</nav>

<x-guest-layout>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="pg-login-bg">
    <div class="pg-blob pg-blob-1"></div>
    <div class="pg-blob pg-blob-2"></div>
    <div class="pg-blob pg-blob-3"></div>
</div>
<div class="pg-paws-bg" id="pgPawsBg"></div>

<div class="pg-wrapper">

    {{-- PANEL IZQUIERDO --}}
    <div class="pg-left">
        <div class="pg-brand">
            {{-- Logo sobre fondo blanco --}}
            <a href="#" class="pg-logo-box">
                <img src="{{ asset('images/logo.png') }}" width="150" alt="{{ config('app.name') }}">
            </a>
            <div class="pg-brand-tag">✨ Gestión profesional para tu peluquería</div>
        </div>
        <div class="pg-features">
            <div class="pg-feat">
                <div class="pg-feat-icon">✂️</div>
                <div>
                    <strong>Turnos en un click</strong>
                    <span>Agenda y gestiona citas fácilmente</span>
                </div>
            </div>
            <div class="pg-feat">
                <div class="pg-feat-icon">🐶</div>
                <div>
                    <strong>Historial de mascotas</strong>
                    <span>Fichas completas de cada perrito</span>
                </div>
            </div>
            <div class="pg-feat">
                <div class="pg-feat-icon">📊</div>
                <div>
                    <strong>Reportes de negocio</strong>
                    <span>Control de ingresos y clientes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- PANEL DERECHO --}}
    <div class="pg-right">

        {{-- Logo mini en panel derecho --}}
        <div class="pg-logo-mini-wrap">
            <a href="#" class="pg-logo-mini">
                <img src="{{ asset('images/logo.png') }}" width="130" alt="{{ config('app.name') }}">
            </a>
        </div>

        <div>
            <h1 class="pg-title">¡Bienvenido de vuelta! 🐾</h1>
            <p class="pg-sub">Ingresa a tu cuenta para continuar</p>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">{{ $value }}</div>
        @endsession

        <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:15px;">
            @csrf

            <div class="pg-group">
                <label for="email" class="pg-label">Correo electrónico</label>
                <div class="pg-input-wrap">
                    <span class="pg-icon">📧</span>
                    <input id="email" name="email" type="email" class="pg-input"
                        placeholder="hola@mipeluqueria.com"
                        value="{{ old('email') }}" required autofocus autocomplete="username" />
                </div>
            </div>

            <div class="pg-group">
                <label for="password" class="pg-label">Contraseña</label>
                <div class="pg-input-wrap">
                    <span class="pg-icon">🔒</span>
                    <input id="password" name="password" type="password" class="pg-input"
                        placeholder="••••••••" required autocomplete="current-password" />
                </div>
            </div>

            <div class="pg-row-check">
                <label class="pg-check-label">
                    <input type="checkbox" name="remember" id="remember_me" />
                    Recordarme
                </label>
                @if (Route::has('password.request'))
                    <a class="pg-forgot" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="pg-btn-login">
                Iniciar sesión 🐾
            </button>
        </form>

        <div class="pg-footer">
            Sistema de gestión para peluquería canina
            <div class="pg-pawdots">
                <span>🐾</span><span>🐾</span><span>🐾</span>
            </div>
        </div>
    </div>
</div>

<script>
    const bg = document.getElementById('pgPawsBg');
    [{top:'7%',left:'4%',d:0},{top:'18%',left:'87%',d:1.2},
     {top:'62%',left:'2%',d:2},{top:'82%',left:'72%',d:.6},
     {top:'11%',left:'58%',d:2.4},{top:'88%',left:'28%',d:.9}
    ].forEach(p=>{
        const el=document.createElement('div');
        el.className='pg-paw'; el.textContent='🐾';
        el.style.cssText=`top:${p.top};left:${p.left};animation-delay:${p.d}s`;
        bg.appendChild(el);
    });
</script>
</x-guest-layout>
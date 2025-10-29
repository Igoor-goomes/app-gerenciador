<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Acesso')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body { height: 100%; }
    </style>
</head>
<body class="bg-body text-body">

    @php($hideNav = request()->routeIs('signin') || request()->routeIs('signin.form'))
    @if(auth()->check() && !$hideNav)
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary-subtle">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Gerenciador</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
            <li class="nav-item"><a class="nav-link" href="{{ route('sobre') }}">Sobre</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('contato') }}">Contato</a></li>
          </ul>
          <div class="d-flex align-items-center">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-danger" type="submit">Sair</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
    @endif

    @include('partials.flash')
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastArea"></div>
    <script>
      // Session lifetime warning/refresh (10 minutes default via .env)
      (function(){
        const LIFETIME_MIN = {{ (int) (env('SESSION_LIFETIME', 10)) }}; // minutes
        const WARN_BEFORE_MS = 60 * 1000; // warn 1 min before
        const start = Date.now();
        const warnAt = start + (LIFETIME_MIN*60*1000) - WARN_BEFORE_MS;

        function showRenewModal(){
          const id = 'sessionRenewModal';
          if (!document.getElementById(id)) {
            const html = `
            <div class="modal fade" id="${id}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-body border-secondary-subtle">
                  <div class="modal-header"><h5 class="modal-title">Sessão prestes a expirar</h5></div>
                  <div class="modal-body">
                    Sua sessão expira em breve. Deseja permanecer logado?
                  </div>
                  <div class="modal-footer">
                    <form id="logoutFormAuto" method="POST" action="{{ route('logout') }}">@csrf</form>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="document.getElementById('logoutFormAuto').submit()">Sair</button>
                    <button type="button" class="btn btn-primary" id="btnRenovarSessao">Permanecer logado</button>
                  </div>
                </div>
              </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', html);
          }
          const modal = new bootstrap.Modal(document.getElementById(id));
          modal.show();
          const btn = document.getElementById('btnRenovarSessao');
          if (btn) {
            btn.onclick = async function(){
              try {
                await fetch('{{ route('home') }}', { credentials: 'same-origin' });
              } catch (e) {}
              modal.hide();
              // restart timer
              setTimeout(showRenewModal, LIFETIME_MIN*60*1000 - WARN_BEFORE_MS);
            }
          }
        }

        setTimeout(showRenewModal, Math.max(0, warnAt - Date.now()));
      })();
    </script>
    <script>
      // Sanctum PAT auto-refresh (requires client to store token in localStorage as 'api_token')
      (function(){
        const TTL_MIN = {{ (int) (env('SANCTUM_TOKEN_TTL', 10)) }}; // minutes
        const WARN_BEFORE_MS = 60 * 1000; // 1 minute

        function getToken(){ try { return localStorage.getItem('api_token') || ''; } catch(e){ return ''; } }
        function setToken(t){ try { localStorage.setItem('api_token', t || ''); } catch(e){} }

        function showToast(msg){
          const area = document.getElementById('toastArea');
          if (!area) return;
          const el = document.createElement('div');
          el.className = 'toast align-items-center text-bg-success border-0';
          el.setAttribute('role','alert');
          el.setAttribute('aria-live','assertive');
          el.setAttribute('aria-atomic','true');
          el.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="bi bi-shield-check me-2"></i>'+ (msg || 'Tudo certo! Atualizamos seu acesso com segurança.') +'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
          area.appendChild(el);
          const t = new bootstrap.Toast(el, { delay: 3000 });
          t.show();
          el.addEventListener('hidden.bs.toast', ()=> el.remove());
        }

        async function refreshToken(){
          const token = getToken();
          if (!token) return;
          try {
            const resp = await fetch('/api/v1/token/refresh', {
              method: 'POST',
              headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
              credentials: 'same-origin'
            });
            if (!resp.ok) return;
            const data = await resp.json();
            if (data && data.token) { setToken(data.token); showToast('Token renovado com sucesso.'); }
          } catch (e) { /* noop */ }
        }

        function schedule(){
          setTimeout(async () => { await refreshToken(); schedule(); }, Math.max(0, TTL_MIN*60*1000 - WARN_BEFORE_MS));
        }
        schedule();
      })();
    </script>
    @yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'e-car') — Vente de Voitures à Madagascar</title>
    <meta name="description" content="@yield('description', 'Trouvez votre voiture idéale en Ariary. Large choix de berlines, SUV, pickups, citadines neuves et d\'occasion.')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg-dark:    #0a0a0f;
            --bg-card:    #12121a;
            --bg-border:  #1e1e2e;
            --bg-hover:   #16162a;
            --accent:     #e8a000;
            --accent-lt:  #ffb800;
            --text-white: #f0f0f8;
            --text-muted: #8888aa;
            --success:    #22c55e;
            --danger:     #ef4444;
            --radius:     12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-dark); color: var(--text-white); min-height: 100vh; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }

        /* NAV */
        .navbar { position: sticky; top: 0; z-index: 100; background: rgba(10,10,15,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--bg-border); padding: 0 1.5rem; }
        .nav-inner { max-width: 1280px; margin: 0 auto; display: flex; align-items: center; gap: 1rem; height: 64px; }
        .nav-logo { font-size: 1.4rem; font-weight: 900; background: linear-gradient(135deg, var(--accent), var(--accent-lt)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.5px; white-space: nowrap; text-transform: uppercase; }
        .nav-logo span { -webkit-text-fill-color: var(--text-white); }
        .nav-links { display: flex; gap: 0.25rem; margin-left: 1rem; flex: 1; }
        .nav-links a { padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); transition: all 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--text-white); background: var(--bg-border); }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }

        /* BUTTONS */
        .btn-primary { padding: 0.5rem 1.1rem; border-radius: 8px; background: linear-gradient(135deg, var(--accent), var(--accent-lt)); color: #000; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(232,160,0,0.4); }
        .btn-outline { padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--bg-border); color: var(--text-muted); font-size: 0.88rem; font-weight: 500; transition: all 0.2s; background: transparent; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
        .btn-danger { padding: 0.4rem 0.9rem; border-radius: 8px; background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-danger:hover { background: var(--danger); color: #fff; }
        .btn-sm { padding: 0.3rem 0.75rem; font-size: 0.8rem; }

        /* CART */
        .cart-btn { position: relative; display: flex; align-items: center; gap: 0.4rem; padding: 0.45rem 1rem; border-radius: 8px; background: var(--bg-border); color: var(--text-white); font-size: 0.88rem; font-weight: 600; transition: all 0.2s; }
        .cart-btn:hover { background: var(--accent); color: #000; }
        .cart-badge { position: absolute; top: -6px; right: -6px; background: var(--accent); color: #000; font-size: 0.68rem; font-weight: 900; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

        /* LAYOUT */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }
        .section { padding: 4rem 0; }
        .section-sm { padding: 2rem 0; }
        .section-title { font-size: 1.8rem; font-weight: 800; margin-bottom: 0.4rem; }
        .section-subtitle { font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2rem; }
        .heading-accent { color: var(--accent); }
        .text-muted { color: var(--text-muted); }

        /* GRID */
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        @media(max-width:1024px){ .grid-4{grid-template-columns:repeat(3,1fr);} .grid-3{grid-template-columns:repeat(2,1fr);} }
        @media(max-width:768px){ .grid-4,.grid-3,.grid-2{grid-template-columns:1fr 1fr;} .nav-links{display:none;} }
        @media(max-width:560px){ .grid-4,.grid-3,.grid-2{grid-template-columns:1fr;} }

        /* CAR CARDS */
        .car-card { background: var(--bg-card); border: 1px solid var(--bg-border); border-radius: var(--radius); overflow: hidden; transition: all 0.3s; display: flex; flex-direction: column; }
        .car-card:hover { transform: translateY(-4px); border-color: rgba(232,160,0,0.3); box-shadow: 0 12px 40px rgba(0,0,0,0.5); }
        .car-card-img { width: 100%; height: 200px; object-fit: cover; }
        .car-card-img-ph { width:100%; height:200px; background:linear-gradient(135deg,#1a1a2e,#16213e); display:flex; align-items:center; justify-content:center; font-size:3rem; }
        .car-card-body { padding: 1.1rem; flex: 1; display: flex; flex-direction: column; }
        .car-card-title { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.35rem; }
        .car-card-meta { font-size: 0.78rem; color: var(--text-muted); display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 0.75rem; }
        .car-card-price { font-size: 1.15rem; font-weight: 900; color: var(--accent); margin-top: auto; margin-bottom: 0.75rem; }
        .car-card-footer { display: flex; gap: 0.5rem; flex-wrap: wrap; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; padding: 0.18rem 0.55rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700; }
        .badge-neuf { background: rgba(34,197,94,0.12); color: var(--success); }
        .badge-occasion { background: rgba(232,160,0,0.12); color: var(--accent); }
        .badge-cat { background: rgba(139,92,246,0.12); color: #a78bfa; }
        .badge-warning { background: rgba(234,179,8,0.12); color: #eab308; }
        .badge-info { background: rgba(59,130,246,0.12); color: #60a5fa; }
        .badge-success { background: rgba(34,197,94,0.12); color: var(--success); }
        .badge-danger { background: rgba(239,68,68,0.12); color: var(--danger); }

        /* ALERTS */
        .alert { padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25); color: var(--success); }
        .alert-error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25); color: var(--danger); }

        /* FORMS */
        .form-group { margin-bottom: 1.1rem; }
        .form-label { display: block; margin-bottom: 0.4rem; font-size: 0.83rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.3px; }
        .form-control { width: 100%; padding: 0.65rem 0.9rem; border-radius: 8px; background: var(--bg-card); border: 1px solid var(--bg-border); color: var(--text-white); font-size: 0.9rem; font-family: inherit; transition: border-color 0.2s; }
        .form-control:focus { outline: none; border-color: var(--accent); }
        .form-control option { background: var(--bg-card); }
        .form-error { color: var(--danger); font-size: 0.78rem; margin-top: 0.3rem; }

        /* TABLE */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 0.7rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.4px; border-bottom: 1px solid var(--bg-border); }
        .data-table td { padding: 0.8rem 1rem; border-bottom: 1px solid rgba(30,30,46,0.5); font-size: 0.88rem; vertical-align: middle; }
        .data-table tr:hover td { background: rgba(255,255,255,0.015); }

        /* PAGINATION */
        .pagination-wrap { display: flex; justify-content: center; gap: 0.4rem; margin-top: 2.5rem; flex-wrap: wrap; }
        .page-item { padding: 0.4rem 0.85rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; background: var(--bg-card); border: 1px solid var(--bg-border); color: var(--text-muted); transition: all 0.2s; cursor: pointer; }
        .page-item:hover, .page-item.active { background: var(--accent); color: #000; border-color: var(--accent); }

        /* FOOTER */
        .footer { background: var(--bg-card); border-top: 1px solid var(--bg-border); padding: 3rem 0 1.5rem; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; margin-bottom: 2rem; }
        .footer-logo-txt { font-size: 1.4rem; font-weight: 900; background: linear-gradient(135deg, var(--accent), var(--accent-lt)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; }
        .footer-desc { color: var(--text-muted); font-size: 0.88rem; line-height: 1.8; }
        .footer-title { font-weight: 700; margin-bottom: 0.9rem; color: var(--accent); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 0.5rem; }
        .footer-links a { color: var(--text-muted); font-size: 0.86rem; transition: color 0.2s; }
        .footer-links a:hover { color: var(--text-white); }
        .footer-bottom { border-top: 1px solid var(--bg-border); padding-top: 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.82rem; }
        @media(max-width:768px){ .footer-grid{grid-template-columns:1fr;gap:2rem;} }

        /* CARD BOX */
        .card { background: var(--bg-card); border: 1px solid var(--bg-border); border-radius: var(--radius); padding: 1.5rem; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--bg-border); border-radius: var(--radius); padding: 1.5rem; }
        .stat-card-value { font-size: 2rem; font-weight: 900; }
        .stat-card-label { font-size: 0.82rem; color: var(--text-muted); margin-top: 0.25rem; text-transform: uppercase; letter-spacing: 0.4px; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">e<span>-car</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('voitures.index') }}" class="{{ request()->routeIs('voitures.*') ? 'active' : '' }}">Voitures</a>
            @auth
            <a href="{{ route('orders.historique') }}" class="{{ request()->routeIs('orders.historique') ? 'active' : '' }}">Mes commandes</a>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--accent)">Admin Panel</a>
            @endauth
        </div>
        <div class="nav-actions">
            @php
                $cartController = new \App\Http\Controllers\CartController();
                $cartCount = $cartController->nombreItems();
            @endphp
            <a href="{{ route('cart.index') }}" class="cart-btn">
                Panier
                @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
                    <button type="submit" class="btn-outline">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
            @endauth
        </div>
    </div>
</nav>

@if(session('success'))
<div class="container" style="padding-top:1rem">
    <div class="alert alert-success">{{ session('success') }}</div>
</div>
@endif
@if(session('error'))
<div class="container" style="padding-top:1rem">
    <div class="alert alert-error">{{ session('error') }}</div>
</div>
@endif

@yield('content')

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-logo-txt">e-car</div>
                <p class="footer-desc">La première plateforme de vente de voitures à Madagascar. Voitures neuves et d'occasion, prix en Ariary.</p>
            </div>
            <div>
                <div class="footer-title">Navigation</div>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('voitures.index') }}">Toutes les voitures</a></li>
                    <li><a href="{{ route('voitures.index') }}?etat=neuf">Voitures neuves</a></li>
                    <li><a href="{{ route('voitures.index') }}?etat=occasion">Occasions</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-title">Contact</div>
                <ul class="footer-links">
                    <li><a href="#">+261 34 00 000 00</a></li>
                    <li><a href="#">contact@e-car.mg</a></li>
                    <li><a href="#">Antananarivo, Madagascar</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">&copy; {{ date('Y') }} e-car Madagascar — Prix en Ariary (Ar)</div>
    </div>
</footer>
@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#eef2f9;
            --card:#ffffff;
            --ink:#0f172a;
            --muted:#64748b;
            --border:rgba(15,23,42,.07);
            --shadow:0 10px 30px -12px rgba(15,23,42,.18);
            --sidebar-w:265px;
            --grad:linear-gradient(135deg,#6366f1,#a855f7);
        }
        body.dark{
            --bg:#080e1c;
            --card:#0f172a;
            --ink:#e2e8f0;
            --muted:#8fa1bb;
            --border:rgba(255,255,255,.07);
            --shadow:0 10px 30px -12px rgba(0,0,0,.7);
        }

        *{box-sizing:border-box;}
        html,body{height:100%;}
        body{
            margin:0;
            font-family:'Cairo','Segoe UI',Tahoma,sans-serif;
            background:var(--bg);
            color:var(--ink);
            transition:background .35s ease,color .35s ease;
            overflow-x:hidden;
        }

        body::before{
            content:"";
            position:fixed;inset:0;
            background:
                radial-gradient(600px 400px at 12% 8%, rgba(99,102,241,.18), transparent 60%),
                radial-gradient(700px 500px at 92% 15%, rgba(168,85,247,.16), transparent 60%),
                radial-gradient(600px 500px at 70% 95%, rgba(16,185,129,.12), transparent 60%);
            pointer-events:none;
            z-index:0;
            animation:floatBg 18s ease-in-out infinite alternate;
        }
        @keyframes floatBg{
            from{transform:translate3d(0,0,0) scale(1);}
            to{transform:translate3d(-30px,-20px,0) scale(1.06);}
        }

        .sidebar{
            position:fixed;
            inset:0 auto 0 0;
            width:var(--sidebar-w);
            padding:24px 16px;
            background:linear-gradient(180deg,#111827 0%,#0b1220 60%,#070c17 100%);
            display:flex;
            flex-direction:column;
            gap:6px;
            z-index:1050;
            overflow-y:auto;
            transition:transform .35s cubic-bezier(.4,0,.2,1);
            box-shadow:6px 0 40px -20px rgba(0,0,0,.6);
        }
        .sidebar::-webkit-scrollbar{width:5px;}
        .sidebar::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15);border-radius:10px;}

        .brand{
            display:flex;align-items:center;gap:13px;
            padding:4px 8px 26px;
        }
        .brand-icon{
            width:46px;height:46px;flex:0 0 46px;
            border-radius:15px;
            display:grid;place-items:center;
            background:var(--grad);
            color:#fff;font-size:20px;
            box-shadow:0 10px 24px -6px rgba(99,102,241,.75);
            animation:pulseGlow 3s ease-in-out infinite;
        }
        @keyframes pulseGlow{
            0%,100%{box-shadow:0 10px 24px -6px rgba(99,102,241,.75);}
            50%{box-shadow:0 10px 34px -4px rgba(168,85,247,.95);}
        }
        .brand-text h5{
            margin:0;color:#fff;font-weight:800;font-size:17px;letter-spacing:.4px;line-height:1.1;
        }
        .brand-text span{font-size:11px;color:#7c8aa5;letter-spacing:1.6px;text-transform:uppercase;}

        .nav-label{
            color:#4d5c74;font-size:10.5px;font-weight:700;letter-spacing:1.8px;
            text-transform:uppercase;padding:14px 14px 8px;
        }

        .nav-link{
            display:flex;align-items:center;gap:14px;
            color:#94a3b8;text-decoration:none;
            padding:12px 14px;border-radius:14px;
            font-size:14.5px;font-weight:600;
            position:relative;
            transition:all .25s ease;
        }
        .nav-link i{width:20px;text-align:center;font-size:15.5px;}
        .nav-link:hover{
            background:rgba(255,255,255,.07);
            color:#fff;
            transform:translateX(5px);
        }
        .nav-link.active{
            background:var(--grad);
            color:#fff;
            box-shadow:0 12px 26px -10px rgba(99,102,241,.95);
        }
        .nav-link.active::before{
            content:"";
            position:absolute;left:-16px;top:50%;transform:translateY(-50%);
            width:5px;height:26px;border-radius:0 6px 6px 0;
            background:#fff;
        }

        .sidebar-footer{
            margin-top:auto;padding:16px 10px 4px;
            border-top:1px solid rgba(255,255,255,.07);
        }
        .user-chip{
            display:flex;align-items:center;gap:12px;
            padding:10px;border-radius:16px;
            background:rgba(255,255,255,.05);
        }
        .user-chip img{
            width:38px;height:38px;border-radius:12px;object-fit:cover;
            border:2px solid rgba(255,255,255,.15);
        }
        .user-chip b{display:block;color:#fff;font-size:13px;line-height:1.2;}
        .user-chip small{color:#7c8aa5;font-size:11px;}

        .main{
            margin-left:var(--sidebar-w);
            min-height:100vh;
            position:relative;
            z-index:1;
            transition:margin .35s ease;
        }

        .topbar{
            position:sticky;top:0;z-index:900;
            display:flex;align-items:center;gap:16px;
            padding:16px 30px;
            background:color-mix(in srgb, var(--card) 82%, transparent);
            backdrop-filter:blur(14px);
            -webkit-backdrop-filter:blur(14px);
            border-bottom:1px solid var(--border);
        }
        .burger{
            display:none;
            border:0;background:var(--bg);color:var(--ink);
            width:42px;height:42px;border-radius:12px;font-size:17px;
        }
        .search-box{
            position:relative;flex:1;max-width:420px;
        }
        .search-box i{
            position:absolute;left:16px;top:50%;transform:translateY(-50%);
            color:var(--muted);font-size:14px;
        }
        .search-box input{
            width:100%;
            border:1px solid var(--border);
            background:var(--bg);
            color:var(--ink);
            border-radius:14px;
            padding:11px 16px 11px 42px;
            font-size:14px;
            outline:none;
            transition:.25s;
        }
        .search-box input:focus{
            border-color:#6366f1;
            box-shadow:0 0 0 4px rgba(99,102,241,.15);
        }
        .icon-btn{
            position:relative;
            width:44px;height:44px;flex:0 0 44px;
            border-radius:14px;border:1px solid var(--border);
            background:var(--card);color:var(--ink);
            display:grid;place-items:center;font-size:16px;
            cursor:pointer;transition:.25s;
        }
        .icon-btn:hover{background:var(--grad);color:#fff;border-color:transparent;transform:translateY(-2px);}
        .icon-btn .dot{
            position:absolute;top:9px;right:10px;
            width:9px;height:9px;border-radius:50%;
            background:#ef4444;border:2px solid var(--card);
            animation:blink 1.6s infinite;
        }
        @keyframes blink{0%,100%{opacity:1}50%{opacity:.35}}

        .content{padding:26px 30px 50px;}

        .hero{
            position:relative;overflow:hidden;
            border-radius:26px;
            padding:30px 34px;
            color:#fff;
            background:linear-gradient(120deg,#4f46e5 0%,#7c3aed 45%,#a855f7 100%);
            box-shadow:0 26px 50px -24px rgba(99,102,241,.9);
            margin-bottom:26px;
            animation:fadeUp .65s both;
        }
        .hero::before,.hero::after{
            content:"";position:absolute;border-radius:50%;
            background:rgba(255,255,255,.13);
        }
        .hero::before{width:230px;height:230px;top:-90px;right:-40px;}
        .hero::after{width:150px;height:150px;bottom:-80px;right:170px;background:rgba(255,255,255,.08);}
        .hero h2{font-weight:800;font-size:27px;margin:0 0 6px;position:relative;z-index:2;}
        .hero p{margin:0;opacity:.85;font-size:14.5px;position:relative;z-index:2;}
        .hero-actions{position:relative;z-index:2;display:flex;gap:10px;flex-wrap:wrap;margin-top:15px;}
        .btn-glass{
            display:inline-flex;align-items:center;gap:9px;
            padding:11px 20px;border-radius:14px;
            background:rgba(255,255,255,.18);
            border:1px solid rgba(255,255,255,.3);
            color:#fff;font-weight:700;font-size:13.5px;
            text-decoration:none;backdrop-filter:blur(8px);
            transition:.25s;
        }
        .btn-glass:hover{background:#fff;color:#4f46e5;transform:translateY(-3px);box-shadow:0 12px 24px -10px rgba(0,0,0,.5);}

        .kpi{
            position:relative;overflow:hidden;
            border-radius:22px;
            padding:22px;
            color:#fff;
            height:100%;
            box-shadow:var(--shadow);
            transition:transform .35s cubic-bezier(.34,1.56,.64,1), box-shadow .35s;
            animation:fadeUp .65s both;
        }
        .kpi::after{
            content:"";position:absolute;
            width:150px;height:150px;border-radius:50%;
            background:rgba(255,255,255,.14);
            top:-58px;right:-46px;
            transition:.5s;
        }
        .kpi:hover{transform:translateY(-8px);box-shadow:0 26px 44px -18px rgba(15,23,42,.5);}
        .kpi:hover::after{transform:scale(1.35);}
        .kpi-icon{
            width:48px;height:48px;border-radius:15px;
            display:grid;place-items:center;font-size:19px;
            background:rgba(255,255,255,.22);
            backdrop-filter:blur(6px);
            margin-bottom:16px;
        }
        .kpi .label{font-size:13px;font-weight:600;opacity:.9;letter-spacing:.3px;}
        .kpi .value{font-size:36px;font-weight:800;line-height:1.1;margin:2px 0 8px;}
        .kpi .trend{
            display:inline-flex;align-items:center;gap:6px;
            font-size:11.5px;font-weight:700;
            background:rgba(255,255,255,.2);
            padding:4px 10px;border-radius:20px;
        }

        .g-indigo{background:linear-gradient(135deg,#6366f1,#4338ca);}
        .g-emerald{background:linear-gradient(135deg,#10b981,#047857);}
        .g-amber{background:linear-gradient(135deg,#f59e0b,#b45309);}
        .g-violet{background:linear-gradient(135deg,#a855f7,#6d28d9);}
        .g-rose{background:linear-gradient(135deg,#f43f5e,#be123c);}

        .panel{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:22px;
            padding:22px 24px;
            box-shadow:var(--shadow);
            height:100%;
            animation:fadeUp .7s both;
        }
        .panel-head{
            display:flex;align-items:center;justify-content:space-between;
            margin-bottom:18px;gap:10px;
        }
        .panel-head h5{
            margin:0;font-size:16.5px;font-weight:800;
            display:flex;align-items:center;gap:10px;
        }
        .panel-head h5 i{color:#6366f1;}

        .quick{
            display:block;text-decoration:none;color:inherit;
            background:var(--card);
            border:1px solid var(--border);
            border-radius:20px;
            padding:20px;
            height:100%;
            position:relative;overflow:hidden;
            box-shadow:var(--shadow);
            transition:.35s cubic-bezier(.34,1.56,.64,1);
        }
        .quick:hover{transform:translateY(-7px);border-color:#6366f1;}
        .quick i.q{
            width:46px;height:46px;border-radius:14px;
            display:grid;place-items:center;font-size:18px;color:#fff;
            margin-bottom:14px;
        }
        .quick h6{margin:0 0 3px;font-weight:800;font-size:15px;color:var(--ink);}
        .quick p{margin:0;font-size:12.5px;color:var(--muted);}
        .quick .arrow{
            position:absolute;top:20px;right:20px;
            color:var(--muted);font-size:13px;opacity:0;
            transform:translateX(-6px);transition:.3s;
        }
        .quick:hover .arrow{opacity:1;transform:translateX(0);color:#6366f1;}

        @keyframes fadeUp{
            from{opacity:0;transform:translateY(22px);}
            to{opacity:1;transform:translateY(0);}
        }
        .d1{animation-delay:.05s}.d2{animation-delay:.12s}.d3{animation-delay:.19s}
        .d4{animation-delay:.26s}.d5{animation-delay:.33s}.d6{animation-delay:.40s}

        .overlay{
            position:fixed;inset:0;background:rgba(2,6,23,.6);
            backdrop-filter:blur(3px);
            opacity:0;visibility:hidden;transition:.3s;z-index:1040;
        }
        .overlay.show{opacity:1;visibility:visible;}

        @media (max-width:1200px){
            .kpi .value{font-size:30px;}
        }
        @media (max-width:991px){
            .sidebar{transform:translateX(-100%);}
            .sidebar.open{transform:translateX(0);}
            .main{margin-left:0;}
            .burger{display:grid;place-items:center;}
            .content{padding:20px 18px 40px;}
            .topbar{padding:14px 18px;}
            .search-box{max-width:none;}
            .hero{padding:24px;border-radius:22px;}
            .hero h2{font-size:21px;}
        }
        @media (max-width:575px){
            .search-box{display:none;}
            .kpi .value{font-size:28px;}
            .panel{padding:18px;}
        }
    </style>
</head>

<body>

<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div class="brand-icon"><i class="fa-solid fa-mug-hot"></i></div>
        <div class="brand-text">
            <h5>Cafeteria</h5>
            <span>Management</span>
        </div>
    </div>

    <div class="nav-label">Main Menu</div>

    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>

    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-box-open"></i> Products
    </a>

    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <i class="fa-solid fa-layer-group"></i> Categories
    </a>

    <a href="{{ route('food_items.index') }}" class="nav-link {{ request()->routeIs('food_items.*') ? 'active' : '' }}">
        <i class="fa-solid fa-burger"></i> Food Items
    </a>

    <a href="{{ route('beverages.index') }}" class="nav-link {{ request()->routeIs('beverages.*') ? 'active' : '' }}">
        <i class="fa-solid fa-mug-saucer"></i> Beverages
    </a>

    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping"></i> Orders
    </a>

    <div class="nav-label">System</div>

    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i> Reports
    </a>
    <a href="#" class="nav-link"><i class="fa-solid fa-gear"></i> Settings</a>

    <div class="sidebar-footer">
        <div class="user-chip">
            <img src="https://i.pravatar.cc/80?img=12" alt="admin">
            <div>
                <b>{{ auth()->user()->name ?? 'Admin User' }}</b>
                <small>Super Admin</small>
            </div>
        </div>
    </div>

</aside>

<div class="overlay" id="overlay"></div>

<div class="main">

    <header class="topbar">
        <button class="burger" id="burger"><i class="fa-solid fa-bars"></i></button>

        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search products, orders, categories...">
        </div>

        <div class="ms-auto d-flex align-items-center gap-2">
            <button class="icon-btn" id="themeToggle" title="Dark mode">
                <i class="fa-solid fa-moon"></i>
            </button>
            <button class="icon-btn" title="Notifications">
                <i class="fa-regular fa-bell"></i>
                <span class="dot"></span>
            </button>
            <button class="icon-btn d-none d-sm-grid" title="Messages">
                <i class="fa-regular fa-comment-dots"></i>
            </button>
        </div>
    </header>

    <div class="content">

        <div class="hero">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <h2><i class="fa-solid fa-mug-hot me-2"></i>Welcome back, {{ auth()->user()->name ?? 'Admin' }} 👋</h2>
                    <p>AI-Powered Cafeteria Management System — here's what's happening today.</p>
                    
                    <div class="hero-actions">
                        <a href="{{ route('reports.index') }}" class="btn-glass">
                            <i class="fa-solid fa-chart-line"></i> View Reports
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn-glass">
                            <i class="fa-solid fa-cart-shopping"></i> View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-indigo d1">
                    <div class="kpi-icon"><i class="fa-solid fa-receipt"></i></div>
                    <div class="label">Total Orders</div>
                    <div class="value">{{ \App\Models\Order::count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-emerald d2">
                    <div class="kpi-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="label">Completed Orders</div>
                    <div class="value">{{ \App\Models\Order::where('status', 'completed')->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-amber d3">
                    <div class="kpi-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="label">Pending Orders</div>
                    <div class="value">{{ \App\Models\Order::where('status', 'pending')->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-rose d4">
                    <div class="kpi-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="label">Total Revenue</div>
                    <div class="value" style="font-size:26px;">
                        {{ number_format(\App\Models\Order::where('status', '!=', 'cancelled')->sum('total_price'), 0) }} EGP
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('products.index') }}" class="quick">
                    <i class="fa-solid fa-box-open" style="background:linear-gradient(135deg,#6366f1,#4338ca);"></i>
                    <h6>Products</h6>
                    <p>Manage all products</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('orders.index') }}" class="quick">
                    <i class="fa-solid fa-cart-shopping" style="background:linear-gradient(135deg,#10b981,#047857);"></i>
                    <h6>Orders</h6>
                    <p>Track and manage orders</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('reports.index') }}" class="quick">
                    <i class="fa-solid fa-chart-line" style="background:linear-gradient(135deg,#a855f7,#6d28d9);"></i>
                    <h6>Reports & Statistics</h6>
                    <p>View detailed analytics</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('categories.index') }}" class="quick">
                    <i class="fa-solid fa-layer-group" style="background:linear-gradient(135deg,#f59e0b,#b45309);"></i>
                    <h6>Categories</h6>
                    <p>Organize menu structure</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('food_items.index') }}" class="quick">
                    <i class="fa-solid fa-burger" style="background:linear-gradient(135deg,#f43f5e,#be123c);"></i>
                    <h6>Food Items</h6>
                    <p>Manage food menu</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('beverages.index') }}" class="quick">
                    <i class="fa-solid fa-mug-saucer" style="background:linear-gradient(135deg,#06b6d4,#0e7490);"></i>
                    <h6>Beverages</h6>
                    <p>Manage drinks menu</p>
                    <i class="fa-solid fa-arrow-right arrow"></i>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const burger = document.getElementById('burger');
    const overlay = document.getElementById('overlay');
    const themeToggle = document.getElementById('themeToggle');

    if (burger) {
        burger.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
    }
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            const icon = themeToggle.querySelector('i');
            if (document.body.classList.contains('dark')) {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-moon';
            }
        });
    }
</script>

</body>
</html>
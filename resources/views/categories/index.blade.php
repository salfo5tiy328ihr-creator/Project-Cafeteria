<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Categories</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: #eef2f9;
            color: #0f172a;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background:
                radial-gradient(600px 400px at 12% 8%, rgba(99, 102, 241, .15), transparent 60%),
                radial-gradient(700px 500px at 92% 15%, rgba(168, 85, 247, .13), transparent 60%),
                radial-gradient(600px 500px at 70% 95%, rgba(16, 185, 129, .10), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar {
            position: fixed; inset: 0 auto 0 0; width: 260px;
            padding: 24px 16px;
            background: linear-gradient(180deg, #111827 0%, #0b1220 60%, #070c17 100%);
            display: flex; flex-direction: column; gap: 6px;
            z-index: 1050;
            box-shadow: 6px 0 40px -20px rgba(0,0,0,.6);
        }
        .brand { display: flex; align-items: center; gap: 13px; padding: 4px 8px 26px; }
        .brand-icon {
            width: 46px; height: 46px; flex: 0 0 46px;
            border-radius: 15px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; font-size: 20px;
            box-shadow: 0 10px 24px -6px rgba(99,102,241,.75);
        }
        .brand-text h5 { margin: 0; color: #fff; font-weight: 800; font-size: 17px; line-height: 1.1; }
        .brand-text span { font-size: 10.5px; color: #7c8aa5; letter-spacing: 1.6px; text-transform: uppercase; }

        .nav-label {
            color: #4d5c74; font-size: 10.5px; font-weight: 700;
            letter-spacing: 1.8px; text-transform: uppercase;
            padding: 14px 14px 8px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 14px;
            color: #94a3b8; text-decoration: none;
            padding: 12px 14px; border-radius: 14px;
            font-size: 14.5px; font-weight: 600;
            position: relative;
            transition: all .25s ease;
        }
        .nav-link i { width: 20px; text-align: center; font-size: 15px; }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; transform: translateX(5px); }
        .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            box-shadow: 0 12px 26px -10px rgba(99,102,241,.95);
        }
        .nav-link.active::before {
            content: "";
            position: absolute; left: -16px; top: 50%; transform: translateY(-50%);
            width: 5px; height: 26px; border-radius: 0 6px 6px 0;
            background: #fff;
        }

        .sidebar-footer {
            margin-top: auto; padding: 16px 10px 4px;
            border-top: 1px solid rgba(255,255,255,.07);
        }
        .user-chip {
            display: flex; align-items: center; gap: 12px;
            padding: 10px; border-radius: 16px;
            background: rgba(255,255,255,.05);
        }
        .user-chip .avatar {
            width: 38px; height: 38px; border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; font-weight: 800; font-size: 14px;
        }
        .user-chip b { display: block; color: #fff; font-size: 13px; line-height: 1.2; }
        .user-chip small { color: #7c8aa5; font-size: 11px; }

        .main { margin-left: 260px; min-height: 100vh; position: relative; z-index: 1; }

        .topbar {
            position: sticky; top: 0; z-index: 900;
            display: flex; align-items: center; gap: 16px;
            padding: 16px 30px;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(15,23,42,.07);
        }
        .burger { display: none; border: 0; background: #eef2f9; color: #0f172a; width: 42px; height: 42px; border-radius: 12px; font-size: 17px; }

        .search-box { position: relative; flex: 1; max-width: 420px; }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 14px; }
        .search-box input {
            width: 100%;
            border: 1px solid rgba(15,23,42,.07);
            background: #eef2f9;
            border-radius: 14px;
            padding: 11px 16px 11px 42px;
            font-size: 14px; outline: none; transition: .25s;
        }
        .search-box input:focus { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,.15); }

        .icon-btn {
            position: relative;
            width: 44px; height: 44px; flex: 0 0 44px;
            border-radius: 14px; border: 1px solid rgba(15,23,42,.07);
            background: #fff; color: #0f172a;
            display: grid; place-items: center; font-size: 16px;
            cursor: pointer; transition: .25s;
        }
        .icon-btn:hover { background: linear-gradient(135deg, #6366f1, #a855f7); color: #fff; border-color: transparent; }
        .icon-btn .dot {
            position: absolute; top: 9px; right: 10px;
            width: 9px; height: 9px; border-radius: 50%;
            background: #ef4444; border: 2px solid #fff;
            animation: blink 1.6s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.35} }

        .content { padding: 26px 30px 50px; }

        .hero {
            position: relative; overflow: hidden;
            border-radius: 26px;
            padding: 30px 34px;
            color: #fff;
            background: linear-gradient(120deg, #4f46e5 0%, #7c3aed 45%, #a855f7 100%);
            box-shadow: 0 26px 50px -24px rgba(99,102,241,.9);
            margin-bottom: 26px;
        }
        .hero::before, .hero::after {
            content: ""; position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.13);
        }
        .hero::before { width: 230px; height: 230px; top: -90px; right: -40px; }
        .hero::after { width: 150px; height: 150px; bottom: -80px; right: 170px; background: rgba(255,255,255,.08); }
        .hero h2 { font-weight: 800; font-size: 26px; margin: 0 0 6px; position: relative; z-index: 2; }
        .hero p { margin: 0; opacity: .88; font-size: 14.5px; position: relative; z-index: 2; }

        .btn-glass {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 12px 22px; border-radius: 14px;
            background: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.35);
            color: #fff; font-weight: 700; font-size: 14px;
            text-decoration: none;
            backdrop-filter: blur(8px);
            transition: .3s;
            position: relative; z-index: 2;
        }
        .btn-glass:hover { background: #fff; color: #4f46e5; transform: translateY(-3px); }

        .kpi {
            position: relative; overflow: hidden;
            border-radius: 22px; padding: 22px; color: #fff;
            height: 100%;
            box-shadow: 0 10px 30px -12px rgba(15,23,42,.15);
            transition: transform .35s cubic-bezier(.34,1.56,.64,1);
        }
        .kpi::after {
            content: ""; position: absolute;
            width: 150px; height: 150px; border-radius: 50%;
            background: rgba(255,255,255,.14);
            top: -58px; right: -46px;
            transition: .5s;
        }
        .kpi:hover { transform: translateY(-8px); }
        .kpi:hover::after { transform: scale(1.35); }
        .kpi-icon {
            width: 48px; height: 48px; border-radius: 15px;
            display: grid; place-items: center; font-size: 19px;
            background: rgba(255,255,255,.22);
            margin-bottom: 16px;
            position: relative; z-index: 2;
        }
        .kpi .label { font-size: 13px; font-weight: 600; opacity: .92; position: relative; z-index: 2; }
        .kpi .value { font-size: 34px; font-weight: 800; line-height: 1.1; margin: 2px 0 0; position: relative; z-index: 2; }

        .g-indigo { background: linear-gradient(135deg, #6366f1, #4338ca); }
        .g-emerald { background: linear-gradient(135deg, #10b981, #047857); }
        .g-rose { background: linear-gradient(135deg, #f43f5e, #be123c); }
        .g-amber { background: linear-gradient(135deg, #f59e0b, #b45309); }

        .category-card {
            background: #fff;
            border-radius: 22px;
            border: 1px solid rgba(15,23,42,.07);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
            box-shadow: 0 10px 30px -12px rgba(15,23,42,.15);
        }
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px -15px rgba(15,23,42,.25);
            border-color: #6366f1;
        }

        .category-img-wrapper {
            height: 180px;
            display: grid;
            place-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #6366f1, #a855f7);
        }
        .category-img-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255,255,255,.25), transparent 70%);
            z-index: 1;
        }
        .category-img-wrapper::after {
            content: "";
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            bottom: -80px; left: -60px;
            z-index: 1;
        }
        .category-img-wrapper i {
            font-size: 65px;
            color: #fff;
            position: relative;
            z-index: 2;
            text-shadow: 0 4px 20px rgba(0,0,0,.15);
            transition: transform .5s ease;
        }
        .category-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0; left: 0;
            z-index: 2;
            transition: transform .6s ease;
        }
        .category-card:hover .category-img-wrapper i {
            transform: scale(1.15) rotate(-5deg);
        }
        .category-card:hover .category-img-wrapper img {
            transform: scale(1.08);
        }

        .category-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
        .category-title { font-weight: 800; font-size: 18px; margin-bottom: 8px; color: #0f172a; }
        .category-desc {
            font-size: 13px; color: #64748b;
            line-height: 1.5; margin-bottom: 16px; flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .category-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(15,23,42,.07);
        }

        .badge-id {
            font-size: 11px;
            color: #6366f1;
            font-weight: 700;
            background: rgba(99,102,241,.12);
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btns { display: flex; gap: 8px; }
        .btn-icon {
            width: 38px; height: 38px; border-radius: 12px;
            border: 1px solid rgba(15,23,42,.07);
            display: grid; place-items: center;
            background: #eef2f9; color: #0f172a;
            cursor: pointer; text-decoration: none;
            font-size: 13px; padding: 0;
            transition: all .25s;
        }
        .btn-icon:hover {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; border-color: transparent;
            transform: translateY(-2px);
        }
        .btn-icon.delete:hover { background: #ef4444; color: #fff; }

        .empty-state {
            background: #fff; border-radius: 22px;
            padding: 60px 30px; text-align: center;
            border: 2px dashed rgba(15,23,42,.1);
        }
        .empty-state i {
            font-size: 70px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }
        .empty-state h5 { font-weight: 800; margin-bottom: 8px; }
        .empty-state p { color: #64748b; margin: 0 0 15px; }

        .alert-success-custom {
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.3);
            color: #059669;
            padding: 14px 20px; border-radius: 16px;
            font-weight: 700; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .d1 { animation: fadeUp .5s both; animation-delay: .05s; }
        .d2 { animation: fadeUp .5s both; animation-delay: .12s; }
        .d3 { animation: fadeUp .5s both; animation-delay: .19s; }
        .d4 { animation: fadeUp .5s both; animation-delay: .26s; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); transition: transform .3s; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .burger { display: grid; place-items: center; }
            .content { padding: 20px 18px 40px; }
            .topbar { padding: 14px 18px; }
            .hero { padding: 24px; }
            .hero h2 { font-size: 20px; }
        }
        @media (max-width: 575px) {
            .search-box { display: none; }
            .kpi .value { font-size: 28px; }
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

    <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="nav-link">
        <i class="fa-solid fa-box-open"></i> Products
    </a>
    <a href="{{ route('categories.index') }}" class="nav-link active">
        <i class="fa-solid fa-layer-group"></i> Categories
    </a>
    <a href="{{ route('orders.index') }}" class="nav-link">
        <i class="fa-solid fa-cart-shopping"></i> Orders
    </a>

    <div class="nav-label">Analytics</div>

    <a href="#" class="nav-link">
        <i class="fa-solid fa-chart-line"></i> Reports
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-robot"></i> AI Assistant
    </a>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="avatar">SH</div>
            <div>
                <b>Salem Hussien</b>
                <small>Super Admin</small>
            </div>
        </div>
    </div>
</aside>

<div class="main">

    <header class="topbar">
        <button class="burger" id="burger"><i class="fa-solid fa-bars"></i></button>

        <form action="{{ route('categories.index') }}" method="GET" class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="Search categories..." value="{{ request('search') }}">
        </form>

        <div class="ms-auto d-flex align-items-center gap-2">
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

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="hero">
            <div class="row align-items-center g-3">
                <div class="col-lg-7">
                    <h2><i class="fa-solid fa-layer-group me-2"></i>Categories Management</h2>
                    <p>Organize your products into categories for a better menu structure.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('categories.create') }}" class="btn-glass">
                        <i class="fa-solid fa-plus"></i> Add New Category
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-indigo d1">
                    <div class="kpi-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="label">Total Categories</div>
                    <div class="value">{{ $categories->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-emerald d2">
                    <div class="kpi-icon"><i class="fa-solid fa-list-check"></i></div>
                    <div class="label">With Description</div>
                    <div class="value">{{ $categories->whereNotNull('description')->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-rose d3">
                    <div class="kpi-icon"><i class="fa-solid fa-star"></i></div>
                    <div class="label">Latest Category</div>
                    <div class="value" style="font-size:22px;">
                        {{ $categories->count() > 0 ? $categories->first()->name : '—' }}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-amber d4">
                    <div class="kpi-icon"><i class="fa-solid fa-hashtag"></i></div>
                    <div class="label">Latest ID</div>
                    <div class="value">#{{ $categories->count() > 0 ? $categories->first()->id : 0 }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="font-size:17px;">
                <i class="fa-solid fa-list" style="color:#6366f1;"></i>
                All Categories
                <span class="badge rounded-pill" style="background:rgba(99,102,241,.12); color:#6366f1; font-size:11px;">
                    {{ $categories->count() }}
                </span>
            </h5>
        </div>

        <div class="row g-4">
            @forelse($categories as $index => $category)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="category-card">

                        {{-- ✅ الصورة هنا --}}
                        <div class="category-img-wrapper">
                            @if(!empty($category->image))
                                @if(\Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']))
                                    <img src="{{ $category->image }}" alt="{{ $category->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                @endif
                            @else
                                <i class="fa-solid fa-layer-group"></i>
                            @endif
                        </div>

                        <div class="category-body">
                            <div class="category-title">{{ $category->name }}</div>
                            <div class="category-desc">
                                {{ $category->description ?? 'No description available for this category.' }}
                            </div>

                            <div class="category-footer">
                                <span class="badge-id">
                                    <i class="fa-solid fa-hashtag"></i>
                                    {{ $category->id }}
                                </span>

                                <div class="action-btns">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn-icon" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this category?')"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fa-solid fa-layer-group"></i>
                        <h5>No Categories Available</h5>
                        <p>Start by adding your first category to organize your products.</p>
                        <a href="{{ route('categories.create') }}"
                           class="btn-glass"
                           style="background:linear-gradient(135deg,#6366f1,#a855f7); border:0; display:inline-flex;">
                            <i class="fa-solid fa-plus"></i> Add First Category
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const burger = document.getElementById('burger');
    if (burger) {
        burger.addEventListener('click', () => sidebar.classList.toggle('open'));
    }
</script>

</body>
</html>
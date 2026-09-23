<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Food Items</title>

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

        /* ============ SIDEBAR ============ */
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

        /* ============ MAIN ============ */
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

        /* ============ HERO ============ */
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

        /* ============ KPI ============ */
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

        /* ============ FOOD CARD ============ */
        .food-card {
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
        .food-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px -15px rgba(15,23,42,.25);
            border-color: #6366f1;
        }

        .food-img-wrapper {
            height: 190px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            display: grid;
            place-items: center;
            position: relative;
            overflow: hidden;
        }
        .food-img-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(99,102,241,.08), transparent 70%);
        }
        .food-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 2;
            transition: transform .5s ease;
        }
        .food-card:hover .food-img-wrapper img {
            transform: scale(1.08);
        }
        .food-img-wrapper i.placeholder {
            font-size: 75px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 2;
            transition: transform .5s ease;
        }
        .food-card:hover .food-img-wrapper i.placeholder {
            transform: scale(1.15) rotate(-5deg);
        }

        .food-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }

        .food-category-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #6366f1;
            background: rgba(99,102,241,.1);
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
            width: fit-content;
        }

        .food-title {
            font-weight: 800;
            font-size: 17px;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .food-desc {
            font-size: 12.5px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 14px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .food-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }

        .tag {
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .tag-calories { background: rgba(168,85,247,.12); color: #7c3aed; }
        .tag-available { background: rgba(16,185,129,.13); color: #059669; }
        .tag-not-available { background: rgba(239,68,68,.13); color: #dc2626; }
        .tag-spicy { background: rgba(239,68,68,.13); color: #dc2626; }

        .food-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid rgba(15,23,42,.07);
            gap: 8px;
            flex-wrap: wrap;
        }

        .food-price {
            font-size: 21px;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .action-btns { display: flex; gap: 6px; }

        .btn-icon {
            width: 36px; height: 36px; border-radius: 11px;
            border: 1px solid rgba(15,23,42,.07);
            display: grid; place-items: center;
            background: #eef2f9; color: #0f172a;
            cursor: pointer; text-decoration: none;
            font-size: 12.5px; padding: 0;
            transition: all .25s;
        }
        .btn-icon:hover {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; border-color: transparent;
            transform: translateY(-2px);
        }
        .btn-icon.delete:hover { background: #ef4444; color: #fff; }
        .btn-icon.favorite { background: rgba(245,158,11,.12); color: #d97706; }
        .btn-icon.favorite:hover { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }

        /* ============ EMPTY ============ */
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

        /* ============ ALERT ============ */
        .alert-success-custom {
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.3);
            color: #059669;
            padding: 14px 20px; border-radius: 16px;
            font-weight: 700; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }

        /* ============ ANIMATION ============ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .d1 { animation: fadeUp .5s both; animation-delay: .05s; }
        .d2 { animation: fadeUp .5s both; animation-delay: .12s; }
        .d3 { animation: fadeUp .5s both; animation-delay: .19s; }
        .d4 { animation: fadeUp .5s both; animation-delay: .26s; }

        /* ============ RESPONSIVE ============ */
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
    <a href="{{ route('categories.index') }}" class="nav-link">
        <i class="fa-solid fa-layer-group"></i> Categories
    </a>
    <a href="{{ route('food_items.index') }}" class="nav-link active">
        <i class="fa-solid fa-burger"></i> Food Items
    </a>
    <a href="{{ route('beverages.index') }}" class="nav-link">
        <i class="fa-solid fa-mug-saucer"></i> Beverages
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

        <form action="{{ route('food_items.index') }}" method="GET" class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="Search food items..." value="{{ request('search') }}">
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

        <!-- HERO -->
        <div class="hero">
            <div class="row align-items-center g-3">
                <div class="col-lg-7">
                    <h2><i class="fa-solid fa-burger me-2"></i>Food Items Management</h2>
                    <p>Manage your cafeteria food menu, calories, and availability.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('food_items.create') }}" class="btn-glass">
                        <i class="fa-solid fa-plus"></i> Add New Food Item
                    </a>
                </div>
            </div>
        </div>

        <!-- KPI CARDS -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-indigo d1">
                    <div class="kpi-icon"><i class="fa-solid fa-burger"></i></div>
                    <div class="label">Total Food Items</div>
                    <div class="value">{{ $foodItems->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-emerald d2">
                    <div class="kpi-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="label">Available</div>
                    <div class="value">{{ $foodItems->where('is_available', true)->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-rose d3">
                    <div class="kpi-icon"><i class="fa-solid fa-pepper-hot"></i></div>
                    <div class="label">Spicy Items</div>
                    <div class="value">{{ $foodItems->where('is_spicy', true)->count() }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-amber d4">
                    <div class="kpi-icon"><i class="fa-solid fa-fire"></i></div>
                    <div class="label">Total Calories</div>
                    <div class="value" style="font-size:26px;">
                        {{ number_format($foodItems->sum('calories')) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION TITLE -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="font-size:17px;">
                <i class="fa-solid fa-list" style="color:#6366f1;"></i>
                All Food Items
                <span class="badge rounded-pill" style="background:rgba(99,102,241,.12); color:#6366f1; font-size:11px;">
                    {{ $foodItems->count() }}
                </span>
            </h5>
        </div>

        <!-- FOOD ITEMS GRID -->
        <div class="row g-4">
            @forelse($foodItems as $foodItem)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="food-card">

                        <div class="food-img-wrapper">
                            @if(!empty($foodItem->image))
                                @if(\Illuminate\Support\Str::startsWith($foodItem->image, ['http://', 'https://']))
                                    <img src="{{ $foodItem->image }}" alt="{{ $foodItem->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $foodItem->image) }}" alt="{{ $foodItem->name }}">
                                @endif
                            @else
                                <i class="fa-solid fa-burger placeholder"></i>
                            @endif
                        </div>

                        <div class="food-body">

                            @if($foodItem->category)
                                <span class="food-category-badge">
                                    <i class="fa-solid fa-tag"></i>
                                    {{ $foodItem->category->name }}
                                </span>
                            @endif

                            <div class="food-title">{{ $foodItem->name }}</div>
                            <div class="food-desc">
                                {{ $foodItem->description ?? 'No description available.' }}
                            </div>

                            <div class="food-tags">
                                @if($foodItem->calories)
                                    <span class="tag tag-calories">
                                        <i class="fa-solid fa-fire"></i>
                                        {{ $foodItem->calories }} Cal
                                    </span>
                                @endif

                                @if($foodItem->is_available)
                                    <span class="tag tag-available">
                                        <i class="fa-solid fa-check"></i>
                                        Available
                                    </span>
                                @else
                                    <span class="tag tag-not-available">
                                        <i class="fa-solid fa-xmark"></i>
                                        Not Available
                                    </span>
                                @endif

                                @if($foodItem->is_spicy)
                                    <span class="tag tag-spicy">
                                        <i class="fa-solid fa-pepper-hot"></i>
                                        Spicy
                                    </span>
                                @endif
                            </div>

                            <div class="food-footer">
                                <div class="food-price">${{ number_format($foodItem->price, 2) }}</div>

                                <div class="action-btns">
                                    <a href="{{ route('food_items.edit', $foodItem->id) }}" class="btn-icon" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('food_items.destroy', $foodItem->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this food item?')"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                    @auth
                                        <form action="{{ route('favorites.store') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="item_type" value="food">
                                            <input type="hidden" name="item_id" value="{{ $foodItem->id }}">
                                            <button type="submit" class="btn-icon favorite" title="Favorite">
                                                <i class="fa-regular fa-star"></i>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fa-solid fa-burger"></i>
                        <h5>No Food Items Available</h5>
                        <p>Start by adding your first food item to the cafeteria menu.</p>
                        <a href="{{ route('food_items.create') }}"
                           class="btn-glass"
                           style="background:linear-gradient(135deg,#6366f1,#a855f7); border:0; display:inline-flex;">
                            <i class="fa-solid fa-plus"></i> Add First Food Item
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
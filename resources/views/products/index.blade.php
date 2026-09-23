<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Cairo', sans-serif; background: #eef2f9; color: #0f172a; }

        .sidebar {
            position: fixed; inset: 0 auto 0 0; width: 260px;
            padding: 24px 16px;
            background: linear-gradient(180deg, #111827 0%, #0b1220 60%, #070c17 100%);
            z-index: 1050;
        }
        .brand { display: flex; align-items: center; gap: 13px; padding: 4px 8px 26px; }
        .brand-icon {
            width: 46px; height: 46px; border-radius: 15px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; font-size: 20px;
        }
        .brand-text h5 { margin: 0; color: #fff; font-weight: 800; font-size: 17px; }
        .brand-text span { font-size: 10px; color: #7c8aa5; letter-spacing: 1.5px; text-transform: uppercase; }
        .nav-link {
            display: flex; align-items: center; gap: 14px;
            color: #94a3b8; text-decoration: none;
            padding: 12px 14px; border-radius: 14px;
            font-size: 14.5px; font-weight: 600;
            margin-bottom: 6px; transition: all .25s;
        }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-link.active { background: linear-gradient(135deg, #6366f1, #a855f7); color: #fff; }

        .main { margin-left: 260px; min-height: 100vh; }

        .topbar {
            display: flex; align-items: center; gap: 16px;
            padding: 16px 30px;
            background: rgba(255,255,255,.85);
            border-bottom: 1px solid rgba(15,23,42,.07);
        }
        .search-box { position: relative; flex: 1; max-width: 420px; }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; }
        .search-box input {
            width: 100%; border: 1px solid rgba(15,23,42,.07); background: #eef2f9;
            border-radius: 14px; padding: 11px 16px 11px 42px;
            font-size: 14px; outline: none;
        }

        .content { padding: 26px 30px 50px; }

        .hero {
            border-radius: 26px; padding: 30px 34px; color: #fff;
            background: linear-gradient(120deg, #4f46e5 0%, #7c3aed 45%, #a855f7 100%);
            margin-bottom: 26px;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 15px;
        }
        .hero h2 { font-weight: 800; font-size: 26px; margin: 0 0 6px; }
        .hero p { margin: 0; opacity: .88; font-size: 14.5px; }
        .btn-glass {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 12px 22px; border-radius: 14px;
            background: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.35);
            color: #fff; font-weight: 700; font-size: 14px;
            text-decoration: none;
        }
        .btn-glass:hover { background: #fff; color: #4f46e5; }

        .kpi {
            border-radius: 22px; padding: 22px; color: #fff;
            height: 100%; position: relative; overflow: hidden;
        }
        .kpi-icon {
            width: 48px; height: 48px; border-radius: 15px;
            display: grid; place-items: center; font-size: 19px;
            background: rgba(255,255,255,.22); margin-bottom: 16px;
        }
        .kpi .label { font-size: 13px; font-weight: 600; opacity: .92; }
        .kpi .value { font-size: 34px; font-weight: 800; line-height: 1.1; }
        .g-indigo { background: linear-gradient(135deg, #6366f1, #4338ca); }
        .g-emerald { background: linear-gradient(135deg, #10b981, #047857); }
        .g-rose { background: linear-gradient(135deg, #f43f5e, #be123c); }
        .g-amber { background: linear-gradient(135deg, #f59e0b, #b45309); }

        .product-card {
            background: #fff; border-radius: 22px;
            border: 1px solid rgba(15,23,42,.07);
            overflow: hidden; height: 100%;
            display: flex; flex-direction: column;
            transition: all .3s;
        }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -15px rgba(15,23,42,.2); }

        .product-img-wrapper {
            height: 200px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            display: grid; place-items: center;
            overflow: hidden;
        }
        .product-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .product-img-wrapper i {
            font-size: 65px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        .product-title { font-weight: 800; font-size: 17px; margin-bottom: 6px; }
        .product-quantity { font-size: 12.5px; color: #64748b; font-weight: 600; margin-bottom: 12px; }
        .product-quantity i { color: #6366f1; }
        .status-badge {
            font-size: 11px; font-weight: 700;
            padding: 6px 14px; border-radius: 20px;
            display: inline-block; margin-bottom: 14px; width: fit-content;
        }
        .status-in { background: rgba(16,185,129,.13); color: #059669; }
        .status-out { background: rgba(239,68,68,.13); color: #dc2626; }
        .product-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: auto; padding-top: 15px;
            border-top: 1px solid rgba(15,23,42,.07);
        }
        .price { font-size: 21px; font-weight: 800; color: #6366f1; }
        .action-btns { display: flex; gap: 8px; }
        .btn-icon {
            width: 38px; height: 38px; border-radius: 12px;
            border: 1px solid rgba(15,23,42,.07);
            display: grid; place-items: center;
            background: #eef2f9; color: #0f172a;
            cursor: pointer; text-decoration: none;
            font-size: 13px; padding: 0; transition: all .25s;
        }
        .btn-icon:hover { background: linear-gradient(135deg, #6366f1, #a855f7); color: #fff; border-color: transparent; }
        .btn-icon.delete:hover { background: #ef4444; color: #fff; }

        .empty-state {
            background: #fff; border-radius: 22px;
            padding: 60px 30px; text-align: center;
            border: 2px dashed rgba(15,23,42,.1);
        }
        .empty-state i { font-size: 70px; color: #6366f1; margin-bottom: 20px; }
        .empty-state h5 { font-weight: 800; margin-bottom: 8px; }
        .empty-state p { color: #64748b; margin: 0 0 15px; }

        .alert-success-custom {
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.3);
            color: #059669;
            padding: 14px 20px; border-radius: 16px;
            font-weight: 700; margin-bottom: 20px;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        <div class="brand-icon"><i class="fa-solid fa-mug-hot"></i></div>
        <div class="brand-text">
            <h5>Cafeteria</h5>
            <span>Management</span>
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="nav-link active">
        <i class="fa-solid fa-box-open"></i> Products
    </a>
    <a href="{{ route('categories.index') }}" class="nav-link">
        <i class="fa-solid fa-layer-group"></i> Categories
    </a>
    <a href="{{ route('orders.index') }}" class="nav-link">
        <i class="fa-solid fa-cart-shopping"></i> Orders
    </a>
</aside>

<div class="main">
    <header class="topbar">
        <form action="{{ route('products.index') }}" method="GET" class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
        </form>
    </header>

    <div class="content">

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="hero">
            <div>
                <h2><i class="fa-solid fa-box-open me-2"></i>Products Management</h2>
                <p>Manage your cafeteria menu, track inventory, and update prices.</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn-glass">
                <i class="fa-solid fa-plus"></i> Add New Product
            </a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-indigo">
                    <div class="kpi-icon"><i class="fa-solid fa-box"></i></div>
                    <div class="label">Total Products</div>
                    <div class="value">{{ $totalProducts }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-emerald">
                    <div class="kpi-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="label">In Stock</div>
                    <div class="value">{{ $inStock }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-rose">
                    <div class="kpi-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="label">Out of Stock</div>
                    <div class="value">{{ $outOfStock }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi g-amber">
                    <div class="kpi-icon"><i class="fa-solid fa-coins"></i></div>
                    <div class="label">Stock Value</div>
                    <div class="value">${{ number_format($totalStockValue, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card">

                        <div class="product-img-wrapper">
                            @if($product->image)
                                @if(\Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']))
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @endif
                            @else
                                <i class="fa-solid fa-mug-hot"></i>
                            @endif
                        </div>

                        <div class="product-body">
                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-quantity">
                                <i class="fa-solid fa-cubes"></i>
                                Available: {{ $product->quantity }} units
                            </div>

                            @if($product->quantity > 0)
                                <span class="status-badge status-in">In Stock</span>
                            @else
                                <span class="status-badge status-out">Out of Stock</span>
                            @endif

                            <div class="product-footer">
                                <div class="price">${{ number_format($product->price, 2) }}</div>
                                <div class="action-btns">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn-icon" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure?')" style="display:inline;">
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
                        <i class="fa-solid fa-box-open"></i>
                        <h5>No Products Available</h5>
                        <p>Start by adding your first product to the cafeteria menu.</p>
                        <a href="{{ route('products.create') }}" class="btn-glass" style="background:linear-gradient(135deg,#6366f1,#a855f7); border:0;">
                            <i class="fa-solid fa-plus"></i> Add First Product
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

</body>
</html>
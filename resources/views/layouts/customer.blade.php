<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cafeteria')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --sidebar-bg: #1e1b4b;
            --bg-light: #f3f4f6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        
        body { 
            background-color: var(--bg-light); 
            display: flex; 
            min-height: 100vh; 
            direction: ltr; 
        }

        .sidebar {
            width: 260px; background-color: var(--sidebar-bg); color: white;
            display: flex; flex-direction: column; position: fixed; height: 100vh; 
            left: 0; 
            right: auto;
            top: 0;
        }
        .sidebar-header {
            padding: 25px 20px; display: flex; align-items: center; gap: 10px;
            font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header i { color: var(--primary); font-size: 1.5rem; }
        .sidebar-menu { list-style: none; flex: 1; padding-top: 15px; overflow-y: auto; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 12px; padding: 15px 25px;
            color: #cbd5e1; text-decoration: none; transition: 0.3s; border-left: 3px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: rgba(99, 102, 241, 0.1); color: white; border-left-color: var(--primary);
        }
        .sidebar-user {
            padding: 20px; border-top: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.2);
        }

        .main-content { 
            flex: 1; 
            margin-left: 260px; 
            margin-right: 0;
            padding: 30px; 
        }
        .top-nav {
            background: white; padding: 15px 25px; border-radius: 15px;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .top-nav input {
            border: none; outline: none; background: #f3f4f6; padding: 10px 20px;
            border-radius: 30px; width: 300px; font-family: 'Cairo';
        }

        .card { background: white; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 25px 30px; color: white; }
        .card-body { padding: 30px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { font-weight: 600; color: #1f2937; font-size: 0.95rem; }
        .form-group input, .form-group select {
            padding: 12px 15px; border: 2px solid #e5e7eb; border-radius: 10px;
            font-size: 1rem; outline: none; background: #f9fafb; transition: 0.3s; font-family: 'Cairo';
        }
        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;
            border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem;
            font-weight: 600; cursor: pointer; width: 100%; transition: 0.3s;
            display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 10px; font-family: 'Cairo';
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(99,102,241,0.4); }
        .alert-success { background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-mug-hot"></i>
            <span>Cafeteria <br><small style="font-size:0.6rem; color:#a5b4fc;">MANAGEMENT</small></span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}"><i class="fas fa-utensils"></i> Menu</a></li>
            <li><a href="{{ route('smart.search') }}" class="{{ request()->routeIs('smart.*') ? 'active' : '' }}"><i class="fas fa-search-plus"></i> Smart Search</a></li>
            <li><a href="{{ route('customer.recommendations') }}" class="{{ request()->routeIs('customer.recommendations') ? 'active' : '' }}"><i class="fas fa-magic"></i> For You</a></li>
            <li><a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}"><i class="fas fa-robot"></i> AI Chat</a></li>
            <li><a href="{{ route('customer.preferences.edit') }}" class="{{ request()->routeIs('customer.preferences.*') ? 'active' : '' }}"><i class="fas fa-user-cog"></i> My Preferences</a></li>
            <li><a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}"><i class="fas fa-shopping-basket"></i> Purchase Cart</a></li>
            <li><a href="{{ route('customer.orders.index') }}" class="{{ request()->routeIs('customer.orders.index') ? 'active' : '' }}"><i class="fas fa-receipt"></i> My Orders</a></li>
            <li><a href="{{ route('favorites.index') }}" class="{{ request()->routeIs('favorites.*') ? 'active' : '' }}"><i class="fas fa-heart"></i> Favorites</a></li>
            <li><a href="{{ route('comparison.index') }}" class="{{ request()->routeIs('comparison.*') ? 'active' : '' }}"><i class="fas fa-balance-scale"></i> Compare</a></li>
            <li style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none; border:none; width:100%; text-align:left; color:#cbd5e1; padding:15px 25px; cursor:pointer; display:flex; align-items:center; gap:12px; font-family:'Cairo'; font-size:1rem;">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </button>
                </form>
            </li>
        </ul>
        <div class="sidebar-user">
            <i class="fas fa-user-circle fa-2x" style="color: #a5b4fc;"></i>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                <div style="font-size: 0.7rem; color: #a5b4fc;">Customer</div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-nav">
            <input type="text" placeholder="Search menu...">
            <div style="display:flex; gap:15px; color:#6b7280;">
                <i class="fas fa-bell"></i>
                <i class="fas fa-comment"></i>
            </div>
        </div>

        @yield('content')
    </div>

</body>
</html>
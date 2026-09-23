<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Cafeteria</title>
    <!-- Cairo font for Arabic -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1; /* Same purple color as the dashboard */
            --primary-dark: #4f46e5;
            --sidebar-bg: #1e1b4b;
            --bg-light: #f3f4f6;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: white;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            right: 0; /* Since we are Arabic, keep it on the right */
            left: auto;
        }

        .sidebar-header {
            padding: 0 20px 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-header i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .sidebar-menu {
            list-style: none;
            flex: 1;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-right: 3px solid transparent;
        }

        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: white;
            border-right-color: var(--primary);
        }

        .sidebar-menu li a i {
            width: 20px;
            text-align: center;
        }

        /* Main Content Styling */
        .main-content {
            flex: 1;
            margin-right: 260px; /* To compensate for the Sidebar width */
            padding: 40px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title i {
            color: var(--primary);
        }

        /* Card Styling */
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 25px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h4 {
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 30px;
        }

        /* Form Styling */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-group input, .form-group select {
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
            background-color: #f9fafb;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 992px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .sidebar {
                display: none; /* Hide it on mobile for better appearance */
            }
            .main-content {
                margin-right: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-mug-hot"></i>
            <span>Cafeteria</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('menu') }}"><i class="fas fa-utensils"></i> Menu</a></li>
            <li><a href="{{ route('customer.profile.edit') }}" class="active"><i class="fas fa-user-cog"></i> My Preferences</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Shopping Cart</a></li>
            <li><a href="#"><i class="fas fa-heart"></i> Favorites</a></li>
            <li style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none; border:none; width:100%; text-align:left; color:#cbd5e1; padding:15px 20px; cursor:pointer; display:flex; align-items:center; gap:12px; font-family:'Cairo'; font-size:1rem;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-title">
            <i class="fas fa-user-cog"></i>
            <span>Preference Settings</span>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <ul style="list-style:none; margin:0; padding:0;">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-sliders-h"></i> Let AI Know You Better</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Example: 01012345678">
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" name="age" value="{{ old('age', $user->age) }}" placeholder="Example: 25">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Spicy Level</label>
                            <select name="spicy_level">
                                <option value="">Choose...</option>
                                <option value="Low" {{ $user->spicy_level == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $user->spicy_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ $user->spicy_level == 'High' ? 'selected' : '' }}>Very Hot</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Food Preferences (Dietary)</label>
                            <input type="text" name="dietary_preferences" value="{{ old('dietary_preferences', $user->dietary_preferences) }}" placeholder="Vegetarian, Keto, None">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Preferred Taste</label>
                            <input type="text" name="preferred_taste" value="{{ old('preferred_taste', $user->preferred_taste) }}" placeholder="Sweet, Salty, Sour">
                        </div>
                        <div class="form-group">
                            <label>Maximum Budget (Price Preference)</label>
                            <input type="number" name="price_preference" value="{{ old('price_preference', $user->price_preference) }}" placeholder="Example: 150">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Save Preferences
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
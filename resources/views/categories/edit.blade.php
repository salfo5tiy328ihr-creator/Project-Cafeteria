<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Cafeteria</title>

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background:
                radial-gradient(600px 400px at 12% 8%, rgba(99, 102, 241, .2), transparent 60%),
                radial-gradient(700px 500px at 92% 15%, rgba(168, 85, 247, .18), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .form-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 600px;
        }

        .form-card {
            background: #fff;
            border-radius: 26px;
            padding: 40px 36px;
            box-shadow: 0 25px 60px -20px rgba(15, 23, 42, .25);
            border: 1px solid rgba(15, 23, 42, .06);
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-icon {
            width: 70px; height: 70px;
            border-radius: 20px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff; font-size: 30px;
            margin: 0 auto 18px;
            box-shadow: 0 15px 30px -10px rgba(99, 102, 241, .8);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 15px 30px -10px rgba(99, 102, 241, .8); }
            50% { box-shadow: 0 15px 40px -8px rgba(168, 85, 247, 1); }
        }

        .form-header h2 {
            font-weight: 800;
            font-size: 24px;
            margin: 0 0 6px;
        }
        .form-header p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }

        .form-label {
            font-weight: 700;
            font-size: 13.5px;
            margin-bottom: 8px;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-label i {
            color: #6366f1;
            font-size: 14px;
        }

        .form-control {
            border: 1.5px solid rgba(15, 23, 42, .1);
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 14.5px;
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            transition: .25s;
            width: 100%;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
            background: #fff;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .invalid-feedback {
            font-size: 12.5px;
            font-weight: 600;
            color: #dc2626;
            margin-top: 6px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 15px 30px -10px rgba(99, 102, 241, .8);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Cairo', sans-serif;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 1);
        }

        .btn-cancel {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            border-radius: 14px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: .25s;
            margin-top: 12px;
            border: 1.5px solid rgba(15, 23, 42, .08);
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 700;
            font-size: 13.5px;
            margin-top: 20px;
            justify-content: center;
            width: 100%;
            transition: .25s;
        }

        .back-link:hover {
            color: #6366f1;
        }

        .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(99, 102, 241, .1);
            color: #6366f1;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .d-flex-btns {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .d-flex-btns .btn-submit {
            flex: 1;
            margin: 0;
        }

        .d-flex-btns .btn-cancel {
            flex: 0 0 auto;
            width: auto;
            padding: 14px 24px;
            margin: 0;
        }

        @media (max-width: 480px) {
            .form-card { padding: 30px 22px; }
            .form-header h2 { font-size: 20px; }
            .d-flex-btns { flex-direction: column; }
            .d-flex-btns .btn-cancel { width: 100%; }
        }
    </style>
</head>
<body>

<div class="form-wrapper">
    <div class="form-card">

        <div class="form-header">
            <div class="form-icon"><i class="fa-solid fa-pen"></i></div>
            <h2>Edit Category</h2>
            <p>Update category information below</p>
        </div>

        <div style="text-align:center;">
            <span class="info-badge">
                <i class="fa-solid fa-hashtag"></i>
                Category ID: {{ $category->id }}
            </span>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-tag"></i>
                    Category Name
                </label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="e.g. Drinks, Pizza, Burgers..."
                       value="{{ old('name', $category->name) }}"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="form-label">
                    <i class="fa-solid fa-align-left"></i>
                    Description
                </label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4"
                          placeholder="Write a short description for this category...">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="d-flex-btns">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i>
                    Update Category
                </button>

                <a href="{{ route('categories.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </a>
            </div>

        </form>

        <a href="{{ route('categories.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Categories
        </a>

    </div>
</div>

</body>
</html>
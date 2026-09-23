<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Cafeteria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Cairo', sans-serif; background: #eef2f9; color: #0f172a; min-height: 100vh; padding: 30px 15px; }
        body::before { content: ""; position: fixed; inset: 0; background: radial-gradient(600px 400px at 12% 8%, rgba(99,102,241,.2), transparent 60%), radial-gradient(700px 500px at 92% 15%, rgba(168,85,247,.18), transparent 60%); pointer-events: none; z-index: 0; }
        .form-wrapper { position: relative; z-index: 1; width: 100%; max-width: 800px; margin: 0 auto; }
        .form-card { background: #fff; border-radius: 26px; padding: 40px 36px; box-shadow: 0 25px 60px -20px rgba(15,23,42,.25); border: 1px solid rgba(15,23,42,.06); }
        .form-header { text-align: center; margin-bottom: 32px; }
        .form-icon { width: 70px; height: 70px; border-radius: 20px; display: grid; place-items: center; background: linear-gradient(135deg, #6366f1, #a855f7); color: #fff; font-size: 30px; margin: 0 auto 18px; box-shadow: 0 15px 30px -10px rgba(99,102,241,.8); }
        .form-header h2 { font-weight: 800; font-size: 24px; margin: 0 0 6px; }
        .form-header p { color: #64748b; margin: 0; font-size: 14px; }
        .form-label { font-weight: 700; font-size: 13.5px; margin-bottom: 8px; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .form-label i { color: #6366f1; font-size: 14px; }
        .form-control, .form-select { border: 1.5px solid rgba(15,23,42,.1); border-radius: 14px; padding: 13px 16px; font-size: 14.5px; font-family: 'Cairo', sans-serif; background: #f8fafc; transition: .25s; width: 100%; }
        .form-control:focus, .form-select:focus { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,.15); background: #fff; outline: none; }
        textarea.form-control { resize: vertical; min-height: 90px; }
        .invalid-feedback { font-size: 12.5px; font-weight: 600; color: #dc2626; margin-top: 6px; }
        .image-upload-box { border: 2px dashed rgba(99,102,241,.4); border-radius: 18px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer; margin-bottom: 20px; display: block; }
        .image-upload-box:hover { border-color: #6366f1; background: rgba(99,102,241,.04); }
        .image-upload-box input[type="file"] { display: none; }
        .upload-icon { width: 60px; height: 60px; margin: 0 auto 12px; border-radius: 16px; display: grid; place-items: center; background: rgba(99,102,241,.15); color: #6366f1; font-size: 24px; }
        .upload-text { font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px; }
        .upload-hint { font-size: 12px; color: #64748b; }
        #preview { width: 100%; height: 220px; object-fit: cover; border-radius: 15px; margin-top: 14px; display: none; border: 2px solid rgba(99,102,241,.3); }
        .d-flex-btns { display: flex; gap: 10px; margin-top: 10px; }
        .btn-submit { flex: 1; padding: 14px; border: 0; border-radius: 14px; background: linear-gradient(135deg, #6366f1, #a855f7); color: #fff; font-weight: 800; font-size: 15px; cursor: pointer; box-shadow: 0 15px 30px -10px rgba(99,102,241,.8); display: flex; align-items: center; justify-content: center; gap: 10px; font-family: 'Cairo', sans-serif; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -10px rgba(99,102,241,1); }
        .btn-cancel { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 24px; border-radius: 14px; background: #f1f5f9; color: #475569; font-weight: 700; font-size: 14px; text-decoration: none; border: 1.5px solid rgba(15,23,42,.08); }
        .btn-cancel:hover { background: #e2e8f0; color: #0f172a; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-weight: 700; font-size: 13.5px; margin-top: 20px; justify-content: center; width: 100%; }
        .back-link:hover { color: #6366f1; }
        .form-select { appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236366f1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 16px center; background-size: 14px; padding-right: 42px; }
        .row-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .mb-3 { margin-bottom: 18px; }
        .mb-4 { margin-bottom: 24px; }
        @media (max-width: 575px) {
            .form-card { padding: 30px 22px; }
            .d-flex-btns { flex-direction: column; }
            .btn-cancel { width: 100%; }
            .row-2col { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="form-wrapper">
    <div class="form-card">

        <div class="form-header">
            <div class="form-icon"><i class="fa-solid fa-plus"></i></div>
            <h2>Add New Product</h2>
            <p>Create a new cafeteria product</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-layer-group"></i> Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-tag"></i> Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Pizza, Burger..." value="{{ old('name') }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-align-left"></i> Description</label>
                <textarea name="description" rows="3" class="form-control" placeholder="Write a short description...">{{ old('description') }}</textarea>
            </div>

            {{-- Price + Quantity --}}
            <div class="row-2col mb-3">
                <div>
                    <label class="form-label"><i class="fa-solid fa-dollar-sign"></i> Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" value="{{ old('price') }}" required>
                </div>
                <div>
                    <label class="form-label"><i class="fa-solid fa-cubes"></i> Quantity</label>
                    <input type="number" name="quantity" class="form-control" placeholder="0" value="{{ old('quantity') }}" required>
                </div>
            </div>

            {{-- Calories + Spicy Level --}}
            <div class="row-2col mb-3">
                <div>
                    <label class="form-label"><i class="fa-solid fa-fire"></i> Calories</label>
                    <input type="number" name="calories" class="form-control" placeholder="e.g. 400" value="{{ old('calories') }}">
                </div>
                <div>
                    <label class="form-label"><i class="fa-solid fa-pepper-hot"></i> Spicy Level</label>
                    <select name="spicy_level" class="form-select">
                        <option value="">Select...</option>
                        <option value="Low" {{ old('spicy_level') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('spicy_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('spicy_level') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            {{-- Preparation Time + Status --}}
            <div class="row-2col mb-3">
                <div>
                    <label class="form-label"><i class="fa-solid fa-clock"></i> Preparation Time (mins)</label>
                    <input type="number" name="preparation_time" class="form-control" placeholder="e.g. 15" value="{{ old('preparation_time') }}">
                </div>
                <div>
                    <label class="form-label"><i class="fa-solid fa-circle-check"></i> Status</label>
                    <select name="status" class="form-select">
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>

            {{-- Ingredients --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-list"></i> Ingredients</label>
                <textarea name="ingredients" rows="3" class="form-control" placeholder="Example: chicken, cheese, tomato">{{ old('ingredients') }}</textarea>
            </div>

            {{-- Image --}}
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-image"></i> Product Image</label>
                <label for="imageInput" class="image-upload-box">
                    <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                    <div class="upload-text">Click to upload an image</div>
                    <div class="upload-hint">JPG, PNG, GIF — Max 2MB</div>
                    <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(event)">
                    <img id="preview" alt="Preview">
                </label>
            </div>

            {{-- Buttons --}}
            <div class="d-flex-btns">
                <button type="submit" class="btn-submit"><i class="fa-solid fa-check"></i> Save Product</button>
                <a href="{{ route('products.index') }}" class="btn-cancel"><i class="fa-solid fa-xmark"></i> Cancel</a>
            </div>

        </form>

        <a href="{{ route('products.index') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Products</a>

    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
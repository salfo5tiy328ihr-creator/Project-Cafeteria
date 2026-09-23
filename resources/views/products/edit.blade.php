<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Cafeteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: 'Cairo', sans-serif;
            background: #eef2f9; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 30px 15px;
        }
        .form-card {
            background: #fff; border-radius: 26px;
            padding: 40px 36px; width: 100%; max-width: 580px;
            box-shadow: 0 25px 60px -20px rgba(15,23,42,.25);
        }
        .form-header { text-align: center; margin-bottom: 32px; }
        .form-icon {
            width: 70px; height: 70px; border-radius: 20px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff; font-size: 30px;
            margin: 0 auto 18px;
        }
        .form-header h2 { font-weight: 800; font-size: 24px; margin: 0 0 6px; }
        .form-header p { color: #64748b; margin: 0; font-size: 14px; }
        .form-label { font-weight: 700; font-size: 13.5px; margin-bottom: 8px; display: block; }
        .form-label i { color: #f59e0b; margin-right: 6px; }
        .form-control {
            border: 1.5px solid rgba(15,23,42,.1);
            border-radius: 14px; padding: 13px 16px;
            font-size: 14.5px; background: #f8fafc;
            font-family: 'Cairo', sans-serif; width: 100%;
        }
        .form-control:focus { border-color: #f59e0b; outline: none; box-shadow: 0 0 0 4px rgba(245,158,11,.15); }
        .btn-submit {
            width: 100%; padding: 14px; border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff; font-weight: 800; font-size: 15px;
            cursor: pointer; font-family: 'Cairo', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-back {
            display: block; text-align: center;
            color: #64748b; text-decoration: none;
            font-weight: 700; font-size: 13.5px;
            margin-top: 20px;
        }
        .mb-3 { margin-bottom: 18px; }
        .mb-4 { margin-bottom: 24px; }
        .current-img {
            width: 100%; height: 180px; object-fit: cover;
            border-radius: 15px; margin-bottom: 12px;
            border: 2px solid rgba(15,23,42,.1);
        }
        .preview-img {
            width: 100%; height: 180px; object-fit: cover;
            border-radius: 15px; margin-top: 12px; display: none;
        }
        .invalid-feedback { color: #dc2626; font-size: 12.5px; margin-top: 6px; font-weight: 600; }
        .row-2col {
            display: grid; grid-template-columns: 1fr 1fr; gap: 18px;
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fa-solid fa-pen"></i></div>
        <h2>Edit Product</h2>
        <p>Update the product information below</p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-layer-group"></i> Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-tag"></i> Product Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $product->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-align-left"></i> Description</label>
            <textarea name="description" rows="3" class="form-control" placeholder="Write a short description...">{{ old('description', $product->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Price + Quantity --}}
        <div class="row-2col mb-3">
            <div>
                <label class="form-label"><i class="fa-solid fa-dollar-sign"></i> Price</label>
                <input type="number" step="0.01" name="price" class="form-control" 
                       value="{{ old('price', $product->price) }}" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label"><i class="fa-solid fa-cubes"></i> Quantity</label>
                <input type="number" name="quantity" class="form-control" 
                       value="{{ old('quantity', $product->quantity) }}" required>
                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Calories + Spicy Level --}}
        <div class="row-2col mb-3">
            <div>
                <label class="form-label"><i class="fa-solid fa-fire"></i> Calories</label>
                <input type="number" name="calories" class="form-control" 
                       value="{{ old('calories', $product->calories) }}" placeholder="e.g. 400">
                @error('calories')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label"><i class="fa-solid fa-pepper-hot"></i> Spicy Level</label>
                <select name="spicy_level" class="form-control">
                    <option value="">Select...</option>
                    <option value="Low"    {{ old('spicy_level', $product->spicy_level) == 'Low'    ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ old('spicy_level', $product->spicy_level) == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High"   {{ old('spicy_level', $product->spicy_level) == 'High'   ? 'selected' : '' }}>High</option>
                </select>
                @error('spicy_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-image"></i> Product Image</label>

            @if($product->image)
                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="current-img" id="currentImg">
            @endif

            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            <small style="color:#64748b; font-size:12px;">اتركه فاضي لو مش عايز تغير الصورة</small>
            <img id="preview" class="preview-img">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Preparation Time + Status --}}
        <div class="row-2col mb-3">
            <div>
                <label class="form-label"><i class="fa-solid fa-clock"></i> Preparation Time (mins)</label>
                <input type="number" name="preparation_time" class="form-control" 
                       value="{{ old('preparation_time', $product->preparation_time) }}" 
                       placeholder="Example: 15">
                @error('preparation_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label"><i class="fa-solid fa-circle-check"></i> Status</label>
                <select name="status" class="form-control">
                    <option value="available"   {{ old('status', $product->status ?? 'available') == 'available'   ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Ingredients --}}
        <div class="mb-4">
            <label class="form-label"><i class="fa-solid fa-list"></i> Ingredients</label>
            <textarea name="ingredients" rows="3" class="form-control" 
                      placeholder="Example: chicken, cheese, tomato">{{ old('ingredients', $product->ingredients) }}</textarea>
            @error('ingredients')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-submit">
            <i class="fa-solid fa-check"></i> Update Product
        </button>
    </form>

    <a href="{{ route('products.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Back to Products
    </a>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const currentImg = document.getElementById('currentImg');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (currentImg) currentImg.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beverage - Cafeteria</title>

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
            max-width: 800px;
            margin: 0 auto;
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
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            color: #fff; font-size: 30px;
            margin: 0 auto 18px;
            box-shadow: 0 15px 30px -10px rgba(139, 92, 246, .8);
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

        .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(139, 92, 246, .12);
            color: #6d28d9;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
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
            color: #8b5cf6;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid rgba(15, 23, 42, .1);
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 14.5px;
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            transition: .25s;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .15);
            background: #fff;
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .invalid-feedback {
            font-size: 12.5px;
            font-weight: 600;
            color: #dc2626;
            margin-top: 6px;
        }

        .image-upload-box {
            border: 2px dashed rgba(139, 92, 246, .4);
            border-radius: 18px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            transition: .25s;
            cursor: pointer;
            margin-bottom: 20px;
            display: block;
        }
        .image-upload-box:hover {
            border-color: #8b5cf6;
            background: rgba(139, 92, 246, .04);
        }
        .image-upload-box input[type="file"] {
            display: none;
        }
        .upload-icon {
            width: 60px; height: 60px;
            margin: 0 auto 12px;
            border-radius: 16px;
            display: grid; place-items: center;
            background: rgba(139, 92, 246, .15);
            color: #8b5cf6;
            font-size: 24px;
        }
        .upload-text {
            font-weight: 700;
            font-size: 14px;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .upload-hint {
            font-size: 12px;
            color: #64748b;
        }
        .current-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 14px;
            border: 2px solid rgba(139, 92, 246, .3);
        }
        #preview {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
            margin-top: 14px;
            display: none;
            border: 2px solid rgba(139, 92, 246, .3);
        }

        .d-flex-btns {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-submit {
            flex: 1;
            padding: 14px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 15px 30px -10px rgba(139, 92, 246, .8);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Cairo', sans-serif;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -10px rgba(139, 92, 246, 1);
        }

        .btn-cancel {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 14px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: .25s;
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
            color: #8b5cf6;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%238b5cf6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 14px;
            padding-right: 42px;
        }

        .row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .mb-3 { margin-bottom: 18px; }
        .mb-4 { margin-bottom: 24px; }

        @media (max-width: 575px) {
            .form-card { padding: 30px 22px; }
            .form-header h2 { font-size: 20px; }
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
            <div class="form-icon"><i class="fa-solid fa-pen"></i></div>
            <h2>Edit Beverage</h2>
            <p>Update the beverage information below</p>
        </div>

        <div style="text-align:center;">
            <span class="info-badge">
                <i class="fa-solid fa-hashtag"></i>
                Beverage ID: {{ $beverage->id }}
            </span>
        </div>

        <form action="{{ route('beverages.update', $beverage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-layer-group"></i>
                    Category
                </label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $beverage->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-tag"></i>
                    Beverage Name
                </label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="e.g. Cola, Iced Coffee..."
                       value="{{ old('name', $beverage->name) }}"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-align-left"></i>
                    Description
                </label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3"
                          placeholder="Write a short description for this beverage...">{{ old('description', $beverage->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Price + Calories --}}
            <div class="row-2col mb-3">
                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-dollar-sign"></i>
                        Price
                    </label>
                    <input type="number"
                           name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           step="0.01"
                           min="0"
                           placeholder="0.00"
                           value="{{ old('price', $beverage->price) }}"
                           required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-fire"></i>
                        Calories
                    </label>
                    <input type="number"
                           name="calories"
                           class="form-control @error('calories') is-invalid @enderror"
                           min="0"
                           placeholder="e.g. 140"
                           value="{{ old('calories', $beverage->calories) }}">
                    @error('calories')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Size --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-ruler"></i>
                    Size
                </label>
                <input type="text"
                       name="size"
                       class="form-control @error('size') is-invalid @enderror"
                       placeholder="e.g. Small, Medium, Large"
                       value="{{ old('size', $beverage->size) }}">
                @error('size')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-image"></i>
                    Beverage Image
                </label>

                @if(!empty($beverage->image))
                    @if(\Illuminate\Support\Str::startsWith($beverage->image, ['http://', 'https://']))
                        <img src="{{ $beverage->image }}" class="current-img" id="currentImg" alt="{{ $beverage->name }}">
                    @else
                        <img src="{{ asset('storage/' . $beverage->image) }}" class="current-img" id="currentImg" alt="{{ $beverage->name }}">
                    @endif
                @endif

                <label for="imageInput" class="image-upload-box">
                    <div class="upload-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div class="upload-text">
                        {{ !empty($beverage->image) ? 'Click to change image' : 'Click to upload an image' }}
                    </div>
                    <div class="upload-hint">JPG, PNG, GIF — Max 2MB</div>
                    <input type="file"
                           id="imageInput"
                           name="image"
                           accept="image/*"
                           onchange="previewImage(event)">
                    <img id="preview" alt="Preview">
                </label>

                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Temperature + Status --}}
            <div class="row-2col mb-3">
                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-temperature-half"></i>
                        Temperature
                    </label>
                    <select name="temperature" class="form-select @error('temperature') is-invalid @enderror">
                        <option value="">Select...</option>
                        <option value="Hot"  {{ old('temperature', $beverage->temperature) == 'Hot'  ? 'selected' : '' }}>Hot</option>
                        <option value="Cold" {{ old('temperature', $beverage->temperature) == 'Cold' ? 'selected' : '' }}>Cold</option>
                        <option value="Iced" {{ old('temperature', $beverage->temperature) == 'Iced' ? 'selected' : '' }}>Iced</option>
                    </select>
                    @error('temperature')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-circle-check"></i>
                        Status
                    </label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="available"   {{ old('status', $beverage->status ?? 'available') == 'available'   ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status', $beverage->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Ingredients --}}
            <div class="mb-4">
                <label class="form-label">
                    <i class="fa-solid fa-list"></i>
                    Ingredients
                </label>
                <textarea name="ingredients"
                          rows="3"
                          class="form-control @error('ingredients') is-invalid @enderror"
                          placeholder="Example: water, sugar, flavor">{{ old('ingredients', $beverage->ingredients) }}</textarea>
                @error('ingredients')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="d-flex-btns">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i>
                    Update Beverage
                </button>

                <a href="{{ route('beverages.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </a>
            </div>

        </form>

        <a href="{{ route('beverages.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Beverages
        </a>

    </div>
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
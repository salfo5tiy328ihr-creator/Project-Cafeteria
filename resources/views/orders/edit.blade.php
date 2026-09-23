<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Cafeteria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: 'Cairo', sans-serif;
            background: #eef2f9; color: #0f172a;
            min-height: 100vh; padding: 30px 15px;
        }
        body::before {
            content: ""; position: fixed; inset: 0;
            background:
                radial-gradient(600px 400px at 12% 8%, rgba(99,102,241,.2), transparent 60%),
                radial-gradient(700px 500px at 92% 15%, rgba(245,158,11,.15), transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .form-wrapper {
            position: relative; z-index: 1;
            width: 100%; max-width: 800px; margin: 0 auto;
        }
        .form-card {
            background: #fff; border-radius: 26px;
            padding: 40px 36px;
            box-shadow: 0 25px 60px -20px rgba(15,23,42,.25);
            border: 1px solid rgba(15,23,42,.06);
        }
        .form-header { text-align: center; margin-bottom: 32px; }
        .form-icon {
            width: 70px; height: 70px; border-radius: 20px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff; font-size: 30px; margin: 0 auto 18px;
            box-shadow: 0 15px 30px -10px rgba(245,158,11,.8);
        }
        .form-header h2 { font-weight: 800; font-size: 24px; margin: 0 0 6px; }
        .form-header p { color: #64748b; margin: 0; font-size: 14px; }
        .form-label {
            font-weight: 700; font-size: 13.5px;
            margin-bottom: 8px; color: #0f172a;
            display: flex; align-items: center; gap: 8px;
        }
        .form-label i { color: #f59e0b; font-size: 14px; }
        .form-control, .form-select {
            border: 1.5px solid rgba(15,23,42,.1);
            border-radius: 14px; padding: 13px 16px;
            font-size: 14.5px; font-family: 'Cairo', sans-serif;
            background: #f8fafc; transition: .25s; width: 100%;
        }
        .form-control:focus, .form-select:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245,158,11,.15);
            background: #fff; outline: none;
        }
        .items-box {
            background: #f8fafc;
            border: 2px dashed rgba(245,158,11,.3);
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 20px;
        }
        .item-row {
            display: grid;
            grid-template-columns: 1fr 100px 100px 40px;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }
        .btn-add-item {
            background: rgba(245,158,11,.1);
            color: #d97706;
            border: 1.5px dashed #f59e0b;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            font-size: 13.5px;
            width: 100%;
            transition: .25s;
        }
        .btn-add-item:hover { background: rgba(245,158,11,.2); }
        .btn-remove {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(239,68,68,.1);
            color: #dc2626;
            border: 0;
            cursor: pointer;
            display: grid; place-items: center;
            transition: .25s;
        }
        .btn-remove:hover { background: #ef4444; color: #fff; }
        .total-box {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 16px;
            padding: 18px 24px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .total-box span { font-size: 14px; opacity: .9; }
        .total-box strong { font-size: 28px; font-weight: 800; }
        .btn-submit {
            width: 100%; padding: 14px; border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff; font-weight: 800; font-size: 15px;
            cursor: pointer; transition: .3s;
            box-shadow: 0 15px 30px -10px rgba(245,158,11,.8);
            display: flex; align-items: center; justify-content: center;
            gap: 10px; font-family: 'Cairo', sans-serif;
        }
        .btn-submit:hover { transform: translateY(-3px); }
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: #64748b; text-decoration: none;
            font-weight: 700; font-size: 13.5px;
            margin-top: 20px; justify-content: center;
            width: 100%;
        }
        .back-link:hover { color: #f59e0b; }
    </style>
</head>
<body>

<div class="form-wrapper">
    <div class="form-card">

        <div class="form-header">
            <div class="form-icon"><i class="fa-solid fa-pen"></i></div>
            <h2>Edit Order #{{ $order->id }}</h2>
            <p>Update order information below</p>
        </div>

        <form action="{{ route('orders.update', $order) }}" method="POST" id="orderForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-user"></i> Customer Name
                </label>
                <input type="text" name="customer_name" class="form-control"
                       value="{{ old('customer_name', $order->customer_name) }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="fa-solid fa-circle-info"></i> Order Status
                </label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ old('status', $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="preparing" {{ old('status', $order->status) === 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="completed" {{ old('status', $order->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <label class="form-label mb-2">
                <i class="fa-solid fa-cubes"></i> Order Items
            </label>

            <div class="items-box">
                <div id="itemsContainer">
                    @forelse($order->items as $i => $item)
                        <div class="item-row">
                            <select name="items[{{ $i }}][product_id]" class="form-select product-select" required>
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="items[{{ $i }}][quantity]" class="form-control qty-input"
                                   min="1" value="{{ $item->quantity }}" required>
                            <input type="text" class="form-control line-total" readonly>
                            <button type="button" class="btn-remove" onclick="removeItem(this)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    @empty
                        <div class="item-row">
                            <select name="items[0][product_id]" class="form-select product-select" required>
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="items[0][quantity]" class="form-control qty-input"
                                   min="1" value="1" required>
                            <input type="text" class="form-control line-total" readonly value="$0.00">
                            <button type="button" class="btn-remove" onclick="removeItem(this)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn-add-item" onclick="addItem()">
                    <i class="fa-solid fa-plus"></i> Add Another Item
                </button>
            </div>

            <div class="total-box">
                <span><i class="fa-solid fa-receipt"></i> Total Price</span>
                <strong id="grandTotal">$0.00</strong>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-check"></i> Update Order
            </button>

        </form>

        <a href="{{ route('orders.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>

    </div>
</div>

<script>
    let itemIndex = {{ $order->items->count() }};

    function updateTotals() {
        let grandTotal = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const qty = row.querySelector('.qty-input');
            const lineTotal = row.querySelector('.line-total');

            const price = parseFloat(select.options[select.selectedIndex]?.dataset.price || 0);
            const quantity = parseInt(qty.value || 0);
            const subtotal = price * quantity;

            lineTotal.value = '$' + subtotal.toFixed(2);
            grandTotal += subtotal;
        });

        document.getElementById('grandTotal').textContent = '$' + grandTotal.toFixed(2);
    }

    function addItem() {
        const container = document.getElementById('itemsContainer');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
        newRow.querySelector('.qty-input').value = 1;
        newRow.querySelector('.line-total').value = '$0.00';

        container.appendChild(newRow);
        itemIndex++;
        attachListeners();
        updateTotals();
    }

    function removeItem(btn) {
        const container = document.getElementById('itemsContainer');
        if (container.querySelectorAll('.item-row').length > 1) {
            btn.closest('.item-row').remove();
            updateTotals();
        }
    }

    function attachListeners() {
        document.querySelectorAll('.product-select, .qty-input').forEach(el => {
            el.removeEventListener('change', updateTotals);
            el.removeEventListener('input', updateTotals);
            el.addEventListener('change', updateTotals);
            el.addEventListener('input', updateTotals);
        });
    }

    attachListeners();
    updateTotals();
</script>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>CSRF Test Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container { max-width: 500px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .info { background: #e9ecef; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>CSRF Test Form</h2>
        
        <div class="info">
            <strong>CSRF Token:</strong> {{ csrf_token() }}<br>
            <strong>Session Token:</strong> {{ session()->token() }}<br>
            <strong>App Key Set:</strong> {{ config('app.key') ? 'Yes' : 'No' }}
        </div>
        
        <form action="{{ route('test-form') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" value="Test Product" required>
            </div>
            
            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" name="sku" id="sku" value="TST001" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="">Select Category</option>
                    <option value="crop">Crop</option>
                    <option value="livestock">Livestock</option>
                    <option value="dairy">Dairy</option>
                    <option value="poultry">Poultry</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" value="10.00" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="100" required>
            </div>
            
            <button type="submit">Test Form Submission</button>
        </form>
    </div>
</body>
</html>

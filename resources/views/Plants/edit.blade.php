
@extends('layouts.plant')

@section('title', 'Edit Plant')

@section('content')

<div class="card">

    <h1>Edit Plant</h1>
    <p>Update the information of this plant.</p>

    <form action="{{ route('plants.update', ['plant' => $plant->id]) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="plant_name">Plant Name</label>
            <input
                type="text"
                id="plant_name"
                name="plant_name"
                class="form-control"
                value="{{ old('plant_name', $plant->plant_name) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="category">Category</label>

            <select id="category" name="category"
                    class="form-control" required>

                @foreach(['Ornamental', 'Flowering', 'Succulent', 'Herb'] as $category)
                    <option value="{{ $category }}"
                        {{ old('category', $plant->category) == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="unit_price">Unit Price (₱)</label>

            <input
                type="number"
                id="unit_price"
                name="unit_price"
                class="form-control"
                step="0.01"
                min="0"
                value="{{ old('unit_price', $plant->unit_price) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Description</label>

            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="4"
                required
            >{{ old('description', $plant->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="stock_status">Stock Status</label>

            <select id="stock_status" name="stock_status"
                    class="form-control" required>

                <option value="in_stock"
                    {{ old('stock_status', $plant->stock_status) == 'in_stock' ? 'selected' : '' }}>
                    In Stock
                </option>

                <option value="out_of_stock"
                    {{ old('stock_status', $plant->stock_status) == 'out_of_stock' ? 'selected' : '' }}>
                    Out of Stock
                </option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Plant
        </button>

        <a href="{{ route('plants.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection

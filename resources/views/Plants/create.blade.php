
@extends('layouts.plant')

@section('title', 'Add New Plant')

@section('content')

<div class="card">

    <h1>Add New Plant</h1>
    <p>Enter the details of the new plant.</p>

    <form action="{{ route('plants.store') }}" method="POST">

        @csrf

       <div class="form-group">
    <label>Plant Name</label>

    <input type="text"
           name="plant_name"
           class="form-control"
           value="{{ old('plant_name') }}">

    @error('plant_name')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

        <div class="form-group">
            <label>Category</label>

            <select name="category" class="form-control">
                <option value="">Select Category</option>

                @foreach(['Ornamental', 'Flowering', 'Succulent', 'Herb'] as $category)
                    <option value="{{ $category }}"
                        {{ old('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
    <label>Unit Price (₱)</label>

    <input type="number"
           name="unit_price"
           class="form-control"
           step="0.01"
           min="0"
           value="{{ old('unit_price') }}">

    @error('unit_price')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

        <div class="form-group">
            <label>Description</label>

            <textarea name="description"
                      class="form-control"
                      rows="4"
                      placeholder="Enter plant description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>Stock Status</label>

            <select name="stock_status" class="form-control">

                <option value="">Select Stock Status</option>

                <option value="in_stock"
                    {{ old('stock_status') == 'in_stock' ? 'selected' : '' }}>
                    In Stock
                </option>

                <option value="out_of_stock"
                    {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                    Out of Stock
                </option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Save Plant
        </button>

        <a href="{{ route('plants.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection

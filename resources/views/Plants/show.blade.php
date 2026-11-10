
@extends('layouts.plant')

@section('title', 'Plant Details')

@section('content')

<div class="card">

    <h1>Plant Details</h1>

    <table>
        <tr>
            <th>Plant ID</th>
            <td>{{ $plant->id }}</td>
        </tr>

        <tr>
            <th>Plant Name</th>
            <td>{{ $plant->plant_name }}</td>
        </tr>

        <tr>
            <th>Category</th>
            <td>{{ $plant->category }}</td>
        </tr>

        <tr>
            <th>Unit Price</th>
            <td>₱{{ number_format($plant->unit_price, 2) }}</td>
        </tr>

        <tr>
            <th>Description</th>
            <td>{{ $plant->description }}</td>
        </tr>

        <tr>
            <th>Stock Status</th>
            <td>
                {{ ucfirst(str_replace('_', ' ', $plant->stock_status)) }}
            </td>
        </tr>

        <tr>
            <th>Created By</th>
            <td>{{ $plant->user->name }}</td>
        </tr>

        <tr>
            <th>Date Created</th>
            <td>{{ $plant->created_at->format('M d, Y') }}</td>
        </tr>
    </table>

    <div style="margin-top:20px;">

        <a href="{{ route('plants.edit', $plant) }}"
           class="btn btn-primary">
            Edit Plant
        </a>

        <a href="{{ route('plants.index') }}"
           class="btn btn-secondary">
            Back to Inventory
        </a>

    </div>

</div>

@endsection

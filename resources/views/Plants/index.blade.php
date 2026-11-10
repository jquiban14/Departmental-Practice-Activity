
@extends('layouts.plant')

@section('title', 'Plant Inventory')

@section('content')

<div class="inventory-container">

    {{-- Page Header --}}
    <div class="inventory-header">
        <div>
            <h1>Plant Inventory</h1>
            <p>Manage, monitor, and organize your nursery plant records.</p>
        </div>

        <a href="{{ route('plants.create') }}" class="btn-add">
            <span>＋</span> Add New Plant
        </a>
    </div>

    {{-- Inventory Summary --}}
    <div class="inventory-summary">

        <div class="summary-item">
            <span class="summary-label">Total Plants</span>
            <strong>{{ $plants->total() }}</strong>
            <small>Registered plant records</small>
        </div>

        <div class="summary-item">
            <span class="summary-label">Current Page</span>
            <strong>{{ $plants->count() }}</strong>
            <small>Plants displayed</small>
        </div>

    </div>

    {{-- Plant Table --}}
    <div class="inventory-card">

        <div class="table-heading">
            <div>
                <h2>All Plants</h2>
                <p>Your nursery inventory records</p>
            </div>
        </div>

        <div class="table-wrapper">

            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plant Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Stock Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($plants as $plant)

                        <tr>
                            <td class="plant-id">#{{ $plant->id }}</td>

                            <td class="plant-name">
                                {{ $plant->plant_name }}
                            </td>

                            <td>
                                <span class="category-badge">
                                    {{ $plant->category }}
                                </span>
                            </td>

                            <td class="plant-price">
                                ₱{{ number_format($plant->unit_price, 2) }}
                            </td>

                            <td>
                                @if($plant->stock_status === 'in_stock')
                                    <span class="status-badge in-stock">
                                        ● In Stock
                                    </span>
                                @else
                                    <span class="status-badge out-stock">
                                        ● Out of Stock
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('plants.show', $plant) }}"
                                       class="action-btn view-btn">
                                        View
                                    </a>

                                    <a href="{{ route('plants.edit', $plant) }}"
                                       class="action-btn edit-btn">
                                        Edit
                                    </a>

                                    <form action="{{ route('plants.destroy', $plant) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this plant?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-btn delete-btn">
                                            Delete
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-icon">🌱</div>
                                <strong>No Plant Records Found</strong>
                                <p>Start by adding your first nursery plant.</p>

                                <a href="{{ route('plants.create') }}" class="btn-add">
                                    + Add Your First Plant
                                </a>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $plants->links() }}
        </div>

    </div>

</div>

<style>
    .inventory-container {
        max-width: 1250px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .inventory-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .inventory-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1f5138;
        margin-bottom: 5px;
    }

    .inventory-header p,
    .table-heading p {
        color: #718096;
        font-size: 14px;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #217a49;
        color: white;
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: background .2s;
    }

    .btn-add:hover {
        background: #185d36;
    }

    .inventory-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .summary-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e5eee8;
        border-left: 4px solid #26965a;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .summary-item strong {
        display: block;
        font-size: 27px;
        color: #1f5138;
        margin: 8px 0;
    }

    .summary-label {
        color: #64748b;
        font-size: 13px;
    }

    .summary-item small {
        color: #94a3b8;
    }

    .inventory-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,.05);
        overflow: hidden;
        border: 1px solid #edf1ed;
    }

    .table-heading {
        padding: 23px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-heading h2 {
        color: #1f2937;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .inventory-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .inventory-table thead {
        background: #edf5ef;
    }

    .inventory-table th {
        padding: 16px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        color: #42644f;
        letter-spacing: .4px;
    }

    .inventory-table td {
        padding: 17px 16px;
        border-bottom: 1px solid #edf0ed;
        font-size: 14px;
        color: #475569;
    }

    .inventory-table tbody tr:hover {
        background: #f8fbf8;
    }

    .plant-id {
        font-weight: 600;
        color: #94a3b8 !important;
    }

    .plant-name {
        font-weight: 600;
        color: #263d30 !important;
    }

    .plant-price {
        font-weight: 600;
        color: #217a49 !important;
    }

    .category-badge {
        display: inline-block;
        padding: 5px 10px;
        background: #eef4ff;
        color: #4263a3;
        border-radius: 20px;
        font-size: 12px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .in-stock {
        background: #dcfce7;
        color: #15803d;
    }

    .out-stock {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .view-btn {
        background: #e0e7ff;
        color: #4338ca;
    }

    .edit-btn {
        background: #dcfce7;
        color: #15803d;
    }

    .delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .view-btn:hover,
    .edit-btn:hover,
    .delete-btn:hover {
        filter: brightness(.95);
    }

    .empty-state {
        text-align: center !important;
        padding: 55px 20px !important;
    }

    .empty-icon {
        font-size: 35px;
        margin-bottom: 10px;
    }

    .empty-state strong {
        display: block;
        color: #334155;
        font-size: 17px;
    }

    .empty-state p {
        color: #94a3b8;
        margin: 8px 0 20px;
    }

    .pagination-container {
        padding: 20px;
    }

    @media (max-width: 650px) {
        .inventory-summary {
            grid-template-columns: 1fr;
        }

        .inventory-header h1 {
            font-size: 23px;
        }
    }
</style>

@endsection

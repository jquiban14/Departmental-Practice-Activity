
@extends('layouts.plant')

@section('title', 'Plant Reports')

@section('content')

<div class="reports-container">

    {{-- Page Header --}}
    <div class="reports-header">
        <div>
            <h1>Plant Reports</h1>
            <p>Monitor, filter, and export your nursery inventory records.</p>
        </div>

        <a href="{{ route('plants.index') }}" class="back-btn">
            ← Back to Inventory
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="report-card">

        <div class="section-heading">
            <h2>Filter Inventory</h2>
            <p>Choose a category or stock status to filter your reports.</p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET">

            <div class="filter-grid">

                <div class="filter-group">
                    <label for="category">Plant Category</label>

                    <select name="category" id="category">
                        <option value="">All Categories</option>

                        <option value="Ornamental" {{ request('category') == 'Ornamental' ? 'selected' : '' }}>
                            Ornamental
                        </option>

                        <option value="Flowering" {{ request('category') == 'Flowering' ? 'selected' : '' }}>
                            Flowering
                        </option>

                        <option value="Succulent" {{ request('category') == 'Succulent' ? 'selected' : '' }}>
                            Succulent
                        </option>

                        <option value="Herb" {{ request('category') == 'Herb' ? 'selected' : '' }}>
                            Herb
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="stock_status">Stock Status</label>

                    <select name="stock_status" id="stock_status">
                        <option value="">All Stock Status</option>

                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                            In Stock
                        </option>

                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                            Out of Stock
                        </option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="apply-btn">
                        Apply Filters
                    </button>

                    <a href="{{ route('reports.index') }}" class="clear-btn">
                        Clear Filters
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- Export Section --}}
    <div class="export-card">

        <div>
            <h2>Export Reports</h2>
            <p>Download your inventory records in your preferred format.</p>
        </div>

        <div class="export-actions">

            <a href="{{ route('reports.pdf', request()->query()) }}"
               class="export-btn pdf-btn">
                ↓ Download PDF
            </a>

            <a href="{{ route('reports.excel', request()->query()) }}"
               class="export-btn excel-btn">
                ↓ Download Excel
            </a>

        </div>

    </div>

    {{-- Inventory Table --}}
    <div class="report-card inventory-report">

        <div class="section-heading table-title">
            <div>
                <h2>Plant Inventory List</h2>
                <p>Records matching your selected filters.</p>
            </div>

            <span class="record-count">
                {{ $plants->total() }} Records
            </span>
        </div>

        <div class="table-wrapper">

            <table class="report-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plant Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Description</th>
                        <th>Stock Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($plants as $plant)

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

                            <td class="price">
                                ₱{{ number_format($plant->unit_price, 2) }}
                            </td>

                            <td>{{ $plant->description }}</td>

                            <td>
                                @if ($plant->stock_status === 'in_stock')
                                    <span class="status-badge in-stock">
                                        ● In Stock
                                    </span>
                                @else
                                    <span class="status-badge out-stock">
                                        ● Out of Stock
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-icon">🌱</div>
                                <strong>No Plant Records Found</strong>
                                <p>No plants match your selected filters.</p>

                                <a href="{{ route('reports.index') }}" class="clear-btn">
                                    Clear Filters
                                </a>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination-container">
            {{ $plants->links() }}
        </div>

    </div>

</div>

<style>
    .reports-container {
        max-width: 1250px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .reports-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .reports-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1f5138;
        margin-bottom: 5px;
    }

    .reports-header p,
    .section-heading p,
    .export-card p {
        color: #718096;
        font-size: 14px;
    }

    .back-btn {
        text-decoration: none;
        color: #217a49;
        font-weight: 600;
        font-size: 14px;
        padding: 11px 16px;
        border: 1px solid #c9dfd0;
        border-radius: 8px;
    }

    .back-btn:hover {
        background: #edf5ef;
    }

    .report-card,
    .export-card {
        background: white;
        border: 1px solid #edf1ed;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,.04);
        margin-bottom: 22px;
    }

    .report-card {
        padding: 23px;
    }

    .section-heading {
        margin-bottom: 20px;
    }

    .section-heading h2,
    .export-card h2 {
        font-size: 18px;
        font-weight: 700;
        color: #263d30;
        margin-bottom: 5px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        align-items: end;
        gap: 18px;
    }

    .filter-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .filter-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #d5ded7;
        border-radius: 7px;
        background: white;
        color: #334155;
        font-size: 14px;
        outline: none;
    }

    .filter-group select:focus {
        border-color: #217a49;
        box-shadow: 0 0 0 2px rgba(33,122,73,.12);
    }

    .filter-actions,
    .export-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .apply-btn,
    .clear-btn,
    .export-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 12px 17px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: .2s;
        white-space: nowrap;
    }

    .apply-btn {
        background: #217a49;
        color: white;
    }

    .apply-btn:hover {
        background: #185d36;
    }

    .clear-btn {
        background: #f1f5f2;
        color: #475569;
    }

    .clear-btn:hover {
        background: #e2e8e3;
    }

    .export-card {
        padding: 23px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .pdf-btn {
        background: #fee2e2;
        color: #b91c1c;
    }

    .excel-btn {
        background: #dcfce7;
        color: #15803d;
    }

    .pdf-btn:hover,
    .excel-btn:hover {
        filter: brightness(.96);
    }

    .table-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .record-count {
        background: #edf5ef;
        color: #217a49;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .report-table thead {
        background: #edf5ef;
    }

    .report-table th {
        padding: 15px;
        text-align: left;
        color: #42644f;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .report-table td {
        padding: 16px 15px;
        border-bottom: 1px solid #edf0ed;
        font-size: 14px;
        color: #475569;
    }

    .report-table tbody tr:hover {
        background: #f8fbf8;
    }

    .plant-id {
        color: #94a3b8 !important;
        font-weight: 600;
    }

    .plant-name {
        color: #263d30 !important;
        font-weight: 600;
    }

    .price {
        color: #217a49 !important;
        font-weight: 600;
        white-space: nowrap;
    }

    .category-badge {
        background: #eef4ff;
        color: #4263a3;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        white-space: nowrap;
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
        margin: 8px 0 18px;
    }

    .pagination-container {
        padding-top: 20px;
    }

    @media(max-width: 850px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-actions {
            grid-column: 1 / -1;
        }
    }

    @media(max-width: 550px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            grid-column: auto;
        }

        .export-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .reports-header h1 {
            font-size: 23px;
        }
    }
</style>

@endsection

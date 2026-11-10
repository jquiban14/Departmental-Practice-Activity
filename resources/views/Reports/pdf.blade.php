
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plant Inventory Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            color: #22613d;
        }

        p {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #dcefe2;
        }
    </style>
</head>
<body>

    <h2>Plant Nursery Inventory Report</h2>

    <p>Plant Inventory List</p>

    <table>
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
                    <td>{{ $plant->id }}</td>
                    <td>{{ $plant->plant_name }}</td>
                    <td>{{ $plant->category }}</td>
                    <td>₱{{ number_format($plant->unit_price, 2) }}</td>
                    <td>{{ $plant->description }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $plant->stock_status)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No plants found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>

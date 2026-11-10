
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Plant Nursery System')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f4;
            margin: 0;
            color: #26352a;
        }

        .navbar {
            background: #245c3a;
            color: white;
            padding: 18px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 16px;
        }

        .container {
            width: 90%;
            max-width: 1150px;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary { background: #287a48; color: white; }
        .btn-secondary { background: #64748b; color: white; }
        .btn-danger { background: #dc3545; color: white; }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th { background: #edf4ee; }

        .success {
            padding: 12px;
            background: #d9f5df;
            color: #17632d;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        @media(max-width: 650px) {
            .table-wrapper { overflow-x: auto; }
            .navbar { align-items: flex-start; }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div>
            <strong>🌿 Plant Nursery</strong>
        </div>

        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('plants.index') }}">Plants</a>
            <a href="{{ route('reports.index') }}">Reports</a>

            <form action="{{ route('logout') }}"
                  method="POST"
                  style="display:inline;">
                @csrf
                <button type="submit"
                        class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="container">

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card">
                <strong>Please correct the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</body>
</html>

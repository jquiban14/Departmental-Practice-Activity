
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Plant Nursery Dashboard
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Welcome back, {{ Auth::user()->name }}!
                </h3>
                <p class="text-gray-500">
                    Here's an overview of your plant nursery inventory.
                </p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-600">
                    <p class="text-sm text-gray-500">Total Plants</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalPlants }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">All registered plants</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
                    <p class="text-sm text-gray-500">In Stock</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $inStockPlants }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">Available plants</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                    <p class="text-sm text-gray-500">Out of Stock</p>
                    <h3 class="text-3xl font-bold text-red-600 mt-2">
                        {{ $outOfStockPlants }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">Unavailable plants</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Plant Categories</p>
                    <h3 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalCategories }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">Distinct categories</p>
                </div>

            </div>
        
{{-- Plant Category Analytics --}}
<div class="bg-white rounded-xl shadow-sm mt-8 p-6">

    <h3 class="text-lg font-bold text-gray-800">
        Plant Category Analytics
    </h3>

    <p class="text-sm text-gray-500 mb-6">
        Distribution of plants by category
    </p>

    <div class="max-w-md mx-auto" style="height: 300px;">
        <canvas id="categoryChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const categoryLabels = @json($categoryStats->pluck('category'));
        const categoryTotals = @json($categoryStats->pluck('total'));

        const ctx = document.getElementById('categoryChart');

        new Chart(ctx, {
            type: 'doughnut',

            data: {
                labels: categoryLabels,

                datasets: [{
                    label: 'Number of Plants',
                    data: categoryTotals,
                    backgroundColor: [
                        '#16a34a',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 2
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

    });
</script>

            {{-- Recent Plants --}}
            <div class="bg-white rounded-xl shadow-sm mt-8 overflow-hidden">

                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Recent Plants
                        </h3>
                        <p class="text-sm text-gray-500">
                            Your latest registered plants
                        </p>
                    </div>

                    <a href="{{ route('plants.index') }}"
                       class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">
                        View All Plants
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Plant Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Unit Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Stock Status
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($recentPlants as $plant)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $plant->plant_name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $plant->category }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        ₱{{ number_format($plant->unit_price, 2) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($plant->stock_status === 'in_stock')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                In Stock
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        No plants registered yet.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlantsExport;

class PlantReportController extends Controller
{
    private function validateFilters(Request $request): array
    {
        return $request->validate([
            'category' => 'nullable|in:Ornamental,Flowering,Succulent,Herb',
            'stock_status' => 'nullable|in:in_stock,out_of_stock',
        ]);
    }

    private function filteredPlants(array $filters): Builder
    {
        return Plant::query()
            ->where('user_id', auth()->id())
            ->when(
                $filters['category'] ?? null,
                fn ($query, $category) => $query->where('category', $category)
            )
            ->when(
                $filters['stock_status'] ?? null,
                fn ($query, $status) => $query->where('stock_status', $status)
            );
    }

    public function index(Request $request)
    {
        $filters = $this->validateFilters($request);

        $plants = $this->filteredPlants($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact('plants', 'filters'));
    }

    public function pdf(Request $request)
    {
        $filters = $this->validateFilters($request);

        $plants = $this->filteredPlants($filters)->latest()->get();

        $pdf = Pdf::loadView('reports.pdf', compact('plants', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('plant-report.pdf');
    }

    public function excel(Request $request)
    {
        $filters = $this->validateFilters($request);

        $plants = $this->filteredPlants($filters)->latest()->get();

        return Excel::download(
            new PlantsExport($plants),
            'plant-report.xlsx'
        );
    }
}

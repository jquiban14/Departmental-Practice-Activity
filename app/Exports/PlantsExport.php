<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantsExport implements FromCollection, WithHeadings
{
    protected Collection $plants;

    public function __construct(Collection $plants)
    {
        $this->plants = $plants;
    }

    public function collection(): Collection
    {
        return $this->plants->map(function ($plant) {
            return [
                $plant->id,
                $plant->plant_name,
                $plant->category,
                $plant->unit_price,
                $plant->description,
                $plant->stock_status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Plant Name',
            'Category',
            'Unit Price',
            'Description',
            'Stock Status',
        ];
    }
}

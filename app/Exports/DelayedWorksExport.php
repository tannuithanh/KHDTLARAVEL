<?php

namespace App\Exports;


use App\Models\CarBrands;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DelayedWorksExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $carBrands = CarBrands::all();
        foreach ($carBrands as $carBrand) {
            $sheets[] = new CarBrandSheet($carBrand);
        }

        return $sheets;
    }
}
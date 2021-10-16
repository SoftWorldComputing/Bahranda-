<?php
namespace App\Exports;

use App\Models\Commodity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
class CommodityPriceExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        $commodities = Commodity::all();
        $commodity_array = [];
        foreach($commodities as $commodity){
            array_push($commodity_array,["commodity_name" => $commodity->commodity_name,"buy_price" => $commodity->buy_price,"profit_margin" => $commodity->profit_margin,"state_tax" => $commodity->state_tax,"transportation" => $commodity->transportation,"warehousing" => $commodity->transportation,"other_costs" => $commodity->other_costs,"uuid" => base64_encode($commodity->id)]);
        }
        return new Collection(
              $commodity_array
            );
    }

    public function headings(): array
    {
        return [
            'Commodity Name',
            'Buy Price',
            'Percentage profit',
            'State tax',
            'Transportation',
            'Warehousing',
            'Other cost',
            'UUID',
        ];
    }
}
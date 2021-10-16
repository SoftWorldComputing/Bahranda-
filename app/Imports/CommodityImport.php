<?php
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Commodity;
use App\Models\BatchPriceUpload;
use App\Models\BatchPriceUploadData;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class CommodityImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        //
        $batch_no = $this->generateBatchNo();
        $batch = BatchPriceUpload::create(["batch_no" => $batch_no,"no_of_data" => 0,"status" => 0]);
        $count = 0;
        foreach ($rows as $row) 
        {
            //
         
            if(!isset($row['uuid'])){
                return null;
            }
            $id = base64_decode($row['uuid']);
            $commodity = Commodity::whereId($id)->first();
            if(!$commodity)
            {
                return null;
            }
            $state_tax = ($row['state_tax']/100) * $row['buy_price'];
            $total_purchase_price = $state_tax + $row['state_tax'] + $row['buy_price'] + $row['transportation'] + $row['warehousing'] + $row['other_cost'];
            $target_sale_price = (($row['percentage_profit'] /100 ) * $total_purchase_price) + $total_purchase_price;
            BatchPriceUploadData::create([
                        "commodity_id" => $commodity->id,
                        "commodity_name" =>  $row['commodity_name'],
                        "buy_price" => $row['buy_price'],
                        "state_tax" => $row['state_tax'],
                        "transportation" => $row['transportation'], 
                        "warehousing" => $row['warehousing'], 
                        "other_costs" => $row['other_cost'], 
                        "profit_margin" => $row['percentage_profit'], 
                        "batch_no" => $batch_no,
                        "total_purchase_price" => $total_purchase_price,
                        "target_sale_price" => $target_sale_price
            ]);
          $count++;
        }

        $batch->no_of_data = $count;
        $batch->save();
        
    }

    public function generateBatchNo()
    {
        return "PRICEUPLOADXX".(BatchPriceUpload::count() + 1);
    }
}
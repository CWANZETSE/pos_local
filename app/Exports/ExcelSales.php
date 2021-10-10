<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelSales implements FromCollection,withMapping,withHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings():array
    {
        return [
          'Sale ID',
          'Tax Rate',
          'Tax Amount',
          'Discount',
          'Total Amount',
        ];
    }

    public function map($sale):array
    {
        return [
          $sale->txn_code,
          $sale->tax_rate,
          $sale->tax,
          $sale->discount,
          $sale->total,
        ];
    }


    public function collection()
    {
        return $this->data;
    }
}

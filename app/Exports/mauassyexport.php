<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class mauassyexport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
   
    public function collection()
    {
        
        return collect([
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
            ['B0L5-67-A30', '61' , '1', 'C', '0707', 'C', 'Z201'],
        ]);
    
    }
    public function headings(): array
    {
        return [
            'Model',
            'Ver',
            'ASSY',
            'Màu',
            'Số thiết kế',
            'Màu',
            'Số thiết kế',
        ];
    }
}

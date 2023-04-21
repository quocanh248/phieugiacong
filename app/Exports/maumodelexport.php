<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class maumodelexport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
   
    public function collection()
    {
        
        return collect([
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
            ['B0L5-67-A30', '61', '0707', 'C'],
        ]);
    
    }
    public function headings(): array
    {
        return [
            'Model',
            'Ver',            
            'Số thiết kế',
            'Màu',            
        ];
    }
}

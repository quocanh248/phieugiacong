<?php

namespace App\Exports;

use App\Models\Lsquetmodel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class lsquetExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }
    public function collection()
    {
        return Lsquetmodel::select('lot','tenmodel', 'tenversion', 'tenthietke', 'stt', 'maline', 'updated_at')
            ->whereDate('updated_at', $this->date)
            ->orderBy('updated_at')
            ->orderBy('tenthietke', 'desc')
            ->get();

    
    }
    public function headings(): array
    {
        return [
            'Lot',
            'Model',
            'Ver',
            'Số thiết kế',
            'STT',
            'Mã line',
            'Ngày quét'
        ];
    }
}

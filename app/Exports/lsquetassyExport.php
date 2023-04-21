<?php

namespace App\Exports;

use App\Models\Lsquetassy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class lsquetassyExport implements FromCollection, WithHeadings
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
        
        return Lsquetassy::select('lot', 'tenmodel', 'tenversion', 'assy', 'tenthietke', 'stt', 'maline',  'updated_at')
            ->whereDate('updated_at', $this->date)
            ->orderBy('updated_at')
            ->orderBy('assy', 'desc')
            ->orderBy('tenthietke', 'desc')
            ->get();

    
    }
    public function headings(): array
    {
        return [
            'Lot',
            'Model',
            'Ver',
            'ASSY',
            'Số thiết kế',
            'STT',
            'Mã line',
            'Ngày quét'
        ];
    }
}

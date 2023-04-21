<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearLsquetassy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:lsquetassy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   
    public function handle():void
    {
        DB::table('lsquetassy')->where('created_at', '<=', Carbon::now()->subDays(1))->delete();
        $this->info('Successfully cleared lsquetassy table.');
    }
}

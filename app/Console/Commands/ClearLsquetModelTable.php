<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearLsquetModelTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:lsquetmodel';

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
        DB::table('lsquetmodel')->where('created_at', '<=', Carbon::now()->subDays(1))->delete();
        $this->info('Successfully cleared lsquetmodel table.');
    }
}

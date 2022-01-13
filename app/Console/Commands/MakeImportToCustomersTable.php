<?php

namespace App\Console\Commands;


use App\Services\ImportCustomerService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Log;

class MakeImportToCustomersTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выполнить импорт из .csv файла в таблицу "customers"';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ImportCustomerService $service
     * @return int
     */
    public function handle(ImportCustomerService $service)
    {
        try {
            $service->import();
        } catch (\Exception | FileNotFoundException $e) {
            Log::info($e->getMessage());
        }
        return 0;
    }
}

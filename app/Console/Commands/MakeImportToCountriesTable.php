<?php

namespace App\Console\Commands;


use App\Services\ImportCountriesService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Log;

class MakeImportToCountriesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выполнить импорт из .json файла в таблицу "countries"';

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
     * @param ImportCountriesService $service
     * @return int
     */
    public function handle(ImportCountriesService $service)
    {
        try {
            $service->import();
        } catch (\Exception | FileNotFoundException $e) {
            Log::info($e->getMessage());
        }
        return 0;
    }
}

<?php

namespace App\Services;

use App\Exports\ImportCustomersErrorExport;
use App\Models\Customer;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportCustomerService
{
    const FILENAME = 'random.csv';

    /**
     * @return bool|ResponseFactory|PendingDispatch|Response
     * @throws FileNotFoundException
     */
    public function import()
    {
        $raw = Storage::disk('local')->get('import/' . self::FILENAME);

        $data = collect($this->matchFields($raw));
        $notExistingCustomers = $data->filter(
            fn($item) => !in_array($item['email'], Customer::pluck('email')->toArray())
        );

        $withErrors = [];
        foreach ($notExistingCustomers as $item) {
            $item = collect($item)->except(['id'])->toArray();
            try {
                (new Customer($item))->save();
            } catch (\Exception $e) {
                $item['error'] =  $e->getMessage();
                $withErrors[] = $item;
            }
        }

        if (!empty($withErrors))
            return (new ImportCustomersErrorExport(
                $withErrors,
                collect($data[0])->except(['id'])->keys()->add('error')->toArray()
            ))
                ->store('customers_import_error/customers_error.xlsx', 'local');

        return response('ok');
    }

    /**
     * @param $raw
     * @return array
     */
    private function matchFields($raw)
    {
        $result = [];
        $rows = preg_split('/\n|\r\n?\s*/', $raw);
        $headers = explode(',', array_shift($rows));
        array_splice($headers, 2, 0, ['surname']);

        foreach ($rows as $row) {
            if (!empty($row)) {
                $row = explode(',', $row);
                $nameAndSurname = explode(" ", $row[1]);
                array_splice($row, 1, 1, $nameAndSurname);
                $result[] = array_combine($headers, $row);
            }
        }

        return $result;
    }


}

<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportCountriesService
{
    const FILENAME = 'world.json';

    /**
     * @return ResponseFactory|Response
     * @throws FileNotFoundException
     */
    public function import()
    {
        $raw = Storage::disk('local')->get('import/' . self::FILENAME);
        $data = json_decode($raw, true);
        foreach ($data as $item) {
            $item = collect($item)->except(['id'])->toArray();
            $country = new Country();
            $country->fill($item);
            try {
                $country->save();
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return response('ok');
    }
}

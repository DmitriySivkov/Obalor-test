<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportCustomersErrorExport implements FromArray, WithHeadings
{
    use Exportable;

    protected array $unsuccessful;
    protected array $headings;

    public function __construct($arUnsuccessful, $headings)
    {
        $this->unsuccessful = $arUnsuccessful;
        $this->headings = $headings;
    }

    /**
     * @inheritDoc
     */
    public function array(): array
    {
        return $this->unsuccessful;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return $this->headings;
    }
}

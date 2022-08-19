<?php

namespace App\Imports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

//use Maatwebsite\Excel\Concerns\ToModel;

class PaymentsImport implements ToCollection, WithMultipleSheets, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private  $tableSettings = [];

    public function __construct($tableSettings)
    {
        $this->tableSettings = $tableSettings;
    }


    public function sheets(): array
    {
        return [
            $this->tableSettings['sheatName'] => new PaymentsImport($this->tableSettings)
        ];
    }


    public function collection(Collection $rows)
    {
    }

    public function headingRow(): int
    {
        return $this->tableSettings['RowStart'];
    }
}

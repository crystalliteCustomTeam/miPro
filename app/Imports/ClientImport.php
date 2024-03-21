<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\ClientMeta;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'name' => $row[0],
            'phone'=> $row[1],
            'email' => $row[2],
            'brand' => $row[3],
            'frontSeler' => $row[4],
            'website' => $row[5],
            'service' => $row[6],
            'packageName' => $row[7],
            'amountPaid' => $row[8],
            'remainingAmount' => $row[9],
            'nextPayment' => $row[10],
            'paymentRecuring' => $row[11],
            "KEYWORD_COUNT" => $row[12],
            "TARGET_MARKET" => $row[13],
            "OTHER_SERVICE" => $row[14],
            "LEAD_PLATFORM" => $row[15],
            "Payment_Nature" => $row[16],
            "ANY_COMMITMENT" => $row[17]
        ]);
    }
}

<?php


namespace App\Services;


class StoreParamsService
{
    public function getStoreParams(){
        $settingparams=[
            'mid' => '123123456',
            'store_name' => 'NAKUMATT LIMITED',
            'store_address' => '78452-00100 NRB',
            'store_phone' => '1234567890',
            'store_email' => 'dashlitePOS@dashlite.com',
            'store_website' => 'www.dashlite.com',
            'tax_percentage' => 0,
            'transaction_id' => 'TX123ABC456',
            'currency' => 'KES',

        ];
        return $settingparams;
    }
}

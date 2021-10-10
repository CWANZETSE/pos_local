<?php

namespace Database\Factories;

use App\Models\SupplierBank;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierBankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierBank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $bank_names=['KCB','COOP','Standard Chartered','ABSA','American Bank'];
        return [
            'supplier_id' => mt_rand(1,99),
            'bank_name' => $bank_names[mt_rand(0,4)],
            'account_number' => mt_rand(0,9).mt_rand(1000000000,9999999999),
            'bank_additional_details' => 'Account Number: '.mt_rand(111111111111,999999999999).' Bank: '.$this->faker->unique()->city,
        ];

    }
}

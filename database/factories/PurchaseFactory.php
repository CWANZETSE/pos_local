<?php

namespace Database\Factories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'supplier_id'=>mt_rand(1,10),
            'branch_id'=>mt_rand(1,10),
            'category_id'=>mt_rand(1,10),
            'product_id'=>mt_rand(1,10),
            'size_id'=>mt_rand(1,10),
            'code' => 'RQ'.mt_rand(10000,99999),
            'stock' => mt_rand(10,100),
            'cost' => mt_rand(500,999),
            'rrp' => mt_rand(1000,1500),
        ];
    }
}

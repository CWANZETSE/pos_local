<?php

namespace Database\Factories;

use App\Models\ProductsAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductsAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sizes=['100 ml','300 ml','500 ml','1000 ml'];
        return [
            'branch_id' => mt_rand(1,10),
            'product_id' => mt_rand(1,10),
            'price' => mt_rand(1000,9999),
            'size' => $sizes[mt_rand(0,3)],
            'sku' => mt_rand(100000000,999999990),
            'stock'=>mt_rand(0,5),
        ];
    }
}

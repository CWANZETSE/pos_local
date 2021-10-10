<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Size::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sizes=['ml','g', 'Kg','kg', 'L','M','Cm','Moles'];
        return [
            'product_id'=>mt_rand(1,9999),
            'reorder_level'=>mt_rand(20,200),
            'name' => mt_rand(100,1000).' '.$sizes[mt_rand(0,7)],
            'sku' => mt_rand(1000000,9999999),
            'status' => mt_rand(0,1),
        ];
    }
}

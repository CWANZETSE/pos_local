<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names=['Limited','East Africa','Kenya Limited','Pvt Supplies','US Ltd'];
        return [
            'name' => $this->faker->unique()->city.' '.$names[mt_rand(0,4)],
            'address' => 'P.O BOX '.mt_rand(111111,999999).' '.$this->faker->unique()->city,
            'supplier_code' => random_int(100000000,9999999999),
            'contact' => '+2547'.mt_rand(0,2).''.mt_rand(0000000,7777777),
            'email' => $this->faker->unique()->email,
            'status'=>mt_rand(0,1),
            'invoice_due_days'=>mt_rand(0,30),
        ];
    }
}

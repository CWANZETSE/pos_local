<?php

namespace Database\Factories;

use App\Models\GeneralSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GeneralSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'logo' => 'testlogo.png',
            'store_footer_copyright' => 'Welcome Back',
            'store_name'=>'Easy Mart limited',
            'store_address'=>'54647-00200 Nairobi',
            'store_phone'=>'254720705815',
            'store_email'=>'info@easymart.com',
            'store_website'=>'www.easymart.com',
            'printer_name'=>'Receipt',
            'tax_percentage'=>16,
            'mpesa'=>14,
            'cash'=>10,
            'kcb_pinpad'=>15,
        ];
    }
}

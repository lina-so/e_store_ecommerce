<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorBusinessDetail>
 */
class VendorBusinessDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => 1,
            'shop_name' => $this->faker->name(),
            'shop_address' => $this->faker->address(),
            'shop_city' => $this->faker->city(),
            'shop_country' => $this->faker->country(),
            'shop_mobile' => $this->faker->phoneNumber(),
            'shop_email' => $this->faker->email()
        ];
    }
}

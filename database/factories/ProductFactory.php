<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'PD0000'.$this->faker->randomNumber(5),
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->unique()->sentence,
            'buy_price' => $this->faker->numberBetween(10000, 100000),
            'sell_price' => $this->faker->numberBetween(10000, 100000),
            'discount' => $this->faker->numberBetween(5000, 9000),
            'sku' => $this->faker->numberBetween(10000, 99999),
            'in_stock' => $this->faker->boolean,
            'quantity' => $this->faker->randomNumber(),
            'weight' => $this->faker->randomNumber(2),
            'is_listed' => $this->faker->boolean,
        ];
    }
}

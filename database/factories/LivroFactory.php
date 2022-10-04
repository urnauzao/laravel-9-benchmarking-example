<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => fake()->name(),
            'editora' => Str::random(20),
            'email' => fake()->email(),
            'ano_lancamento' => now()->year,
            'numero_paginas' => rand(0, 10000),
        ];
    }
}

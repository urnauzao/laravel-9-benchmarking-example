<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BenchmarkingController extends Controller
{
    public function populateUser(){
        User::factory(100)->create();
        return response()->json(["usuarios" => User::all()->count()]);
    }
    public function populateLivro(){
        Livro::factory(10)->create();
        return response()->json(["livros" => Livro::all()->count()]);
    }

    public function totalLivros(){
        return response()->json(["livros" => Livro::all()->count()]);
    }

    public function benchmarkingLivros(){
        $total = 10;
        $result = Benchmark::measure([
        // Benchmark::dd([
            'Cenario Factory' => fn () => Livro::factory($total)->create(),
            'Cenario Massive' => fn () => $this->saveLivros($total),
            'Cenario DB Massive' => fn() => DB::table('livros')->insert($this->generateLivros($total)),
            'Cenario Individual' => fn() => $this->insertLivroIndividual($total),
            'Cenario Individual Upsert' => function() use ($total) { $this->updateOrCreateLivroIndividual($total); },
        ], 5);
        return response()->json($result);
    }

    private function saveLivros($total){
        return Livro::insert($this->generateLivros($total));
    }

    private function generateLivros($total):array{
        for($i=1;$i<=$total; $i++){
            $inserts[] = [
                'titulo' => fake()->name(),
                'editora' => Str::random(20),
                'email' => fake()->email(),
                'ano_lancamento' => now()->year,
                'numero_paginas' => rand(0, 10000),
            ];
        }
        return $inserts;
    }

    private function insertLivroIndividual($total){
        for($i=1;$i<=$total; $i++){
            Livro::create([
                'titulo' => fake()->name(),
                'editora' => Str::random(20),
                'email' => fake()->email(),
                'ano_lancamento' => now()->year,
                'numero_paginas' => rand(0, 10000),
            ]);
        }
    }
    private function updateOrCreateLivroIndividual($total){
        for($i=1;$i<=$total; $i++){
            Livro::updateOrCreate([
                'titulo' => fake()->name(),
                'editora' => Str::random(20),
                'email' => fake()->email(),
                'ano_lancamento' => now()->year,
                'numero_paginas' => rand(0, 10000),
            ]);
        }
    }


    public function benchmarkingCache(){
        $total=1000;
        Benchmark::dd([
            'Cenario Database' => fn () => $this->saveIntoCache('database', $total),
            'Cenario File' => fn() => $this->saveIntoCache('file', $total),
            'Cenario Redis' => fn() => $this->saveIntoCache('redis', $total),
        ],5);
    }

    private function saveIntoCache(string $drive, int $total){
        for($i=1;$i<=$total; $i++){
            Cache::store($drive)->add(Str::uuid(), [
                'titulo' => fake()->name(),
                'editora' => Str::random(20),
                'email' => fake()->email(),
                'ano_lancamento' => now()->year,
                'numero_paginas' => rand(0, 10000)
            ]);
        }
    }


}

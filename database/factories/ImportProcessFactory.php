<?php

namespace Database\Factories;

use App\Models\ImportProcess;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportProcessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ImportProcess::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'processed' => false,
            'filepath' => 'csv/test.csv',
        ];
    }
}

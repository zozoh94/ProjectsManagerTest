<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeSeeder::class);
        factory(App\Project::class, 50)->create()->each(function($e) {
            $rand = rand(0, 30);
            $e->performers()->attach(App\Employee::inRandomOrder()->take($rand)->pluck('id')->toArray());
        });
    }
}

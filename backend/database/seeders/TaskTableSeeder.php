<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create(['project_id' => 1, 'title' => 'Task One', ]);
        Task::create(['project_id' => 2, 'title' => 'Task Two']);
        Task::create(['project_id' => 3, 'title' => 'Task Three']);
    }


}

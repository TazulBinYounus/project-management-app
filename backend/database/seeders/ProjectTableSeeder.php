<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectOne = Project::create(['group_id' => 1, 'title' => 'Project One', ]);
        $projectOne->users()->sync([1,2]);

        $projectTwo = Project::create(['group_id' => 2, 'title' => 'Project Two']);
        $projectTwo->users()->sync([3,4]);

        $projectThree = Project::create(['group_id' => 3, 'title' => 'Project Three']);
        $projectThree->users()->sync([5]);
    }


}

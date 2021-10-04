<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addDepartment('Department 1');
        $this->addDepartment('Department 2');
        $this->addDepartment('Department 3');
    }

    private function addDepartment($name) {
        $department = Department::where('name', '=', $name);

        if ($department->count() === 0) {
            Department::create(['name' => $name]);
        }
    }
}

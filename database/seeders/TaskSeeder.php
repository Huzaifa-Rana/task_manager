<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Create Task 1: Deadline 2025-03-24
        $task1 = Task::create([
            'title'             => 'Task 1',
            'description'       => 'First task description',
            'due_date'          => Carbon::create(2025, 3, 24)->toDateString(),
            'priority'          => 'high',
            'status'            => 'pending',
            'user_id'           => 3, // Assuming the admin (ID 1) is the creator
            'assignee_id'       => 2, // Assign to manager (ID 2)
            'category_id'       => 1, // Assuming category with ID 1 exists
            'dependent_task_id' => 2,
        ]);

        // Create Task 2: Deadline 2025-03-25
        $task2 = Task::create([
            'title'             => 'Task 2',
            'description'       => 'Second task description',
            'due_date'          => Carbon::create(2025, 3, 25)->toDateString(),
            'priority'          => 'medium',
            'status'            => 'pending',
            'user_id'           => 3,
            'assignee_id'       => 2, // Assign to normal user (ID 3)
            'category_id'       => 2, // Assuming category with ID 2 exists
            'dependent_task_id' => 3,
        ]);

        // Create Task 3: Deadline 2025-03-26
        $task3 = Task::create([
            'title'             => 'Task 3',
            'description'       => 'Third task description',
            'due_date'          => Carbon::create(2025, 3, 26)->toDateString(),
            'priority'          => 'low',
            'status'            => 'pending',
            'user_id'           => 2,
            'assignee_id'       => 3,
            'category_id'       => 3, // Assuming category with ID 3 exists
            'dependent_task_id' => 1,
        ]);

        // Now update dependencies:
        // Set Task 1's dependency to Task 2
        $task1->update(['dependent_task_id' => $task2->id]);
        // Set Task 3's dependency to Task 1
        $task3->update(['dependent_task_id' => $task1->id]);
    }
}

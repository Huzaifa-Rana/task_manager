<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDependentTaskIdToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add a nullable foreign key that references the tasks table itself
            $table->foreignId('dependent_task_id')->nullable()->constrained('tasks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the foreign key and column when rolling back
            $table->dropForeign(['dependent_task_id']);
            $table->dropColumn('dependent_task_id');
        });
    }
}

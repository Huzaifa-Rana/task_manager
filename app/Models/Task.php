<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'user_id',
        'category_id'
    ];

    // Task belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Task belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Task has many comments
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function dependency()
    {
        return $this->belongsTo(Task::class, 'dependent_task_id');
    }

    // Returns all tasks that depend on this task
    public function dependentTasks()
    {
        return $this->hasMany(Task::class, 'dependent_task_id');
    }
}

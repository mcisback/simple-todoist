<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Create relation between task and user
     * so this task can belong to just one user
     */
    public function user() {
        return $this->belongsTo(App\User::class);
    }
}

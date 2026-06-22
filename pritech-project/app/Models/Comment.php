<?php

namespace App\Models;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}

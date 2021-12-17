<?php
namespace App\repositories;

use App\Models\Comment;

class CommentRepository
{
    /**
     * fetch comments of companies from database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getComment()
    {
        $select = ['id', 'name'];
        $comments = Comment::query()->CommentCompany($select)->take(10)->get();

        return $comments;
    }
}

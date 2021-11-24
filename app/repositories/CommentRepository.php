<?php


namespace App\repositories;


use App\Models\Comment;
use App\Models\companyInfo;

class CommentRepository
{
    /* fetch comments of companies from database */
    public function getComment()
    {
        $select = ['id', 'name'];
        $comments = Comment::query()->CommentCompany($select)->take(10)->get();

        return $comments;
    }



}

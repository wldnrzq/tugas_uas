<?php
namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function update(User $user, News $news)
    {
        return $user->role == 'admin' || $user->id == $news->user_id;
    }

    public function delete(User $user, News $news)
    {
        return $user->role == 'admin' || $user->id == $news->user_id;
    }

    public function approve(User $user, News $news)
    {
        return $user->role == 'editor';
    }
}
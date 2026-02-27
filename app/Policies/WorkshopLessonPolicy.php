<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WorkshopLesson;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkshopLessonPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WorkshopLesson');
    }

    public function view(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('View:WorkshopLesson');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WorkshopLesson');
    }

    public function update(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('Update:WorkshopLesson');
    }

    public function delete(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('Delete:WorkshopLesson');
    }

    public function restore(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('Restore:WorkshopLesson');
    }

    public function forceDelete(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('ForceDelete:WorkshopLesson');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WorkshopLesson');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WorkshopLesson');
    }

    public function replicate(AuthUser $authUser, WorkshopLesson $workshopLesson): bool
    {
        return $authUser->can('Replicate:WorkshopLesson');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WorkshopLesson');
    }

}
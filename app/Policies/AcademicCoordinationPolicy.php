<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AcademicCoordination;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicCoordinationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AcademicCoordination');
    }

    public function view(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('View:AcademicCoordination');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AcademicCoordination');
    }

    public function update(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('Update:AcademicCoordination');
    }

    public function delete(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('Delete:AcademicCoordination');
    }

    public function restore(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('Restore:AcademicCoordination');
    }

    public function forceDelete(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('ForceDelete:AcademicCoordination');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AcademicCoordination');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AcademicCoordination');
    }

    public function replicate(AuthUser $authUser, AcademicCoordination $academicCoordination): bool
    {
        return $authUser->can('Replicate:AcademicCoordination');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AcademicCoordination');
    }

}
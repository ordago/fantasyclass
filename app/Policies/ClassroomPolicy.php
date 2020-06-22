<?php

namespace App\Policies;

use App\Classroom;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    public function isTeacher(User $user, Classroom $classroom) {
        return $user->classrooms->where('id', $classroom->id)->where('pivot.role', '>', 0)->first() ? true : false;      
    }

    public function isAdmin(User $user, Classroom $classroom) {
        return $user->classrooms->where('id', $classroom->id)->where('pivot.role', '=', 2)->first() ? true : false;      
    }

    public function isStudent(User $user, Classroom $classroom) {
        return $user->classrooms->where('id', $classroom->id)->where('pivot.role', '=', 0)->first() ? true : false;      
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function view(User $user, Classroom $classroom)
    {
        return $this->isTeacher($user, $classroom);
    }
    
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }
    
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function update(User $user, Classroom $classroom)
    {
        return $this->isTeacher($user, $classroom);
    }

    /**
     * Determine whether the user is admin.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function admin(User $user, Classroom $classroom)
    {
        return $this->isAdmin($user, $classroom);
    }
    
    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function delete(User $user, Classroom $classroom)
    {
        return $this->isAdmin($user, $classroom);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function restore(User $user, Classroom $classroom)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Classroom  $classroom
     * @return mixed
     */
    public function forceDelete(User $user, Classroom $classroom)
    {
        //
    }
}

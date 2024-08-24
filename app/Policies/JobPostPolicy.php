<?php

namespace App\Policies;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPostPolicy
{
    // this user parameter is always passed by laravel and the second paramter is passed by us 
    public function apply(User $user, JobPost $job): bool
    {
        return !$job->hasUserApplied($user);
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function viewAnyEmployer(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, JobPost $jobPost): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {   //if user does not have associated employer data under it ,it means user is not employer thus cannot create job 
        return $user->employer != null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobPost $jobPost): bool|Response
    {   // we are checking if the currently authenticated user is the owner of this job
        if ($jobPost->employer->user_id !== $user->id) {
            return false;
        }
        // if there are already any job applications submitted to the job then we don't allow any edits
        if ($jobPost->jobApplications()->count() > 0) {
            return Response::deny('Cannot change the job with applications');
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobPost $jobPost): bool
    {
        // return $jobPost->employer->user_id === $user->id;
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, JobPost $jobPost): bool
    {
        // return $jobPost->employer->user_id === $user->id;
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, JobPost $jobPost): bool
    {
        // return $jobPost->employer->user_id === $user->id;
        return true;
    }


}

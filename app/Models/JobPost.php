<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;


class JobPost extends Model
{
    use HasFactory;

    public static array $experience = ['entry', 'intermeidate', 'senior'];
    public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];

    protected $fillable = ['title', 'location', 'description', 'salary', 'experience', 'category'];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    // checking whether user has applied for job already before
    public function hasUserApplied(Authenticatable|User|int $user): bool
    {
        // here we  get job with the id of this current job model
        return $this->where('id', $this->id)
            // whereHas is used to check the existing of a specific relationship so we check if a job application for a specific user exist
            ->whereHas(
                'jobApplications',
                fn($query) => $query->where('user_id', '=', $user->id ?? $user)
                // instead of get we use exists which will give us whether true or false based on above statement
            )->exists();
    }

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder
    {   //if the value in the $filters array is not null it will be passed as a second argument in the callback function by laravel
        return $query->when($filters['search'] ?? null, function ($query, $search) {

            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    //here we cannot use where or orWhere since it is nested relationship, you have to use whereHas or orWhereHas and pass the relationship name and only then we add callback as we are filtering on a nested relationship so we are not checking the field of the job table, instead we are checking something or filtering the constraints on a relationship, so on a employer's table checking the company name
                    ->orWhereHas('employer', function ($query) use ($search) {
                        $query->where('company_name', 'like', '%' . $search . '%');
                    });
            });
        })->when($filters['min_salary'] ?? null, function ($query, $min_salary) {
            $query->where('salary', '>=', $min_salary);
        })->when($filters['max_salary'] ?? null, function ($query, $max_salary) {
            $query->where('salary', '<=', $max_salary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', $experience);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });
    }
}

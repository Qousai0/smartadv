<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'specialization_id',
        'academic_year',
    ];

    /**
     * The attributes that should be hidden.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'academic_year' => 'integer',
    ];

    /**
     * User Role Relationship.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User Specialization Relationship.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    // /**
    //  * Student Projects Relationship.
    //  */
    // public function projects()
    // {
    //     return $this->hasMany(Project::class, 'student_id');
    // }

    // /**
    //  * AI Conversations Relationship.
    //  */
    // public function conversations()
    // {
    //     return $this->hasMany(AiConversation::class);
    // }

    // /**
    //  * Student Courses Relationship.
    //  */
    // public function studentCourses()
    // {
    //     return $this->hasMany(StudentCourse::class, 'student_id');
    // }

    // /**
    //  * Quiz Attempts Relationship.
    //  */
    // public function quizAttempts()
    // {
    //     return $this->hasMany(QuizAttempt::class, 'student_id');
    // }

    // /**
    //  * User Notifications Relationship.
    //  */
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    // /**
    //  * User Badges Relationship.
    //  */
    // public function badges()
    // {
    //     return $this->belongsToMany(
    //         Badge::class,
    //         'user_badges'
    //     )->withPivot('earned_at');
    // }
}

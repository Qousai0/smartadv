<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    protected $fillable = [
        'name',
        'specialization_id',
        'version',
        'total_credit_hours',
    ];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'study_plan_courses')
                    ->withPivot('semester_number', 'is_elective')
                    ->withTimestamps();
    }
}

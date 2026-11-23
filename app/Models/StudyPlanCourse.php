<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyPlanCourse extends Model
{
    protected $fillable = [
        'study_plan_id',
        'course_id',
        'semester_number',
        'is_elective',
    ];

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
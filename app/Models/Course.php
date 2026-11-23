<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'name',
        'description',
        'credit_hours',
        'specialization_id',
        'syllabus',
    ];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function studyPlans()
{
    return $this->belongsToMany(StudyPlan::class, 'study_plan_courses')
                ->withPivot('semester_number', 'is_elective')
                ->withTimestamps();
}
// المواد التي تتطلب هذه المادة
public function prerequisites()
{
    return $this->belongsToMany(
        Course::class,
        'course_prerequisites',
        'course_id',
        'prerequisite_course_id'
    );
}

// المواد التي تعتبر هذه المادة متطلباً سابقاً لها
public function requiredFor()
{
    return $this->belongsToMany(
        Course::class,
        'course_prerequisites',
        'prerequisite_course_id',
        'course_id'
    );
}
public function studentCourses()
{
    return $this->hasMany(StudentCourse::class);
}
}

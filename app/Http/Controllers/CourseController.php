<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // 1. إضافة مادة جديدة إلى النظام
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => 'required|string|max:255|unique:courses,course_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:255',
            'specialization_id' => 'required|exists:specializations,id',
            'syllabus' => 'nullable|string',
        ]);

        $course = Course::create($data);

        return response()->json([
            'message' => 'تمت إضافة المادة بنجاح',
            'course' => $course
        ], 201);
    }

    // 2. تسجيل مادة لطالب
    public function registerStudentCourse(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $studentCourse = StudentCourse::create([
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
            'status' => 'registered',
        ]);

        return response()->json([
            'message' => 'تم تسجيل المادة للطالب بنجاح',
            'student_course' => $studentCourse
        ], 201);
    }

    // 3. عرض المواد المسجلة لطالب معين
    public function studentCourses($studentId)
    {
        $courses = StudentCourse::with('course')
            ->where('student_id', $studentId)
            ->get();

        return response()->json([
            'student_id' => $studentId,
            'courses' => $courses
        ]);
    }
}

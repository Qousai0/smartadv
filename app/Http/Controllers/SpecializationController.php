<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    // 1. إضافة تخصص جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:specializations,name',
            'description' => 'nullable|string',
        ]);

        $specialization = Specialization::create($data);

        return response()->json([
            'message' => 'تمت إضافة التخصص بنجاح',
            'specialization' => $specialization
        ], 201);
    }

    // 2. ربط طالب بتخصص
    public function assignToStudent(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $student = User::findOrFail($data['student_id']);

        $student->specialization_id = $data['specialization_id'];
        $student->save();

        return response()->json([
            'message' => 'تم ربط الطالب بالتخصص بنجاح',
            'student' => $student->load('specialization')
        ]);
    }
}

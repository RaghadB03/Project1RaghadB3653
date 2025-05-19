<?php

namespace App\Http\Controllers;

use App\Http\Resources\studentCourseResource;
use App\Models\studentCourse;
use Illuminate\Http\Request;

class studentCourseController extends Controller
{
    public function index()
    {
        $studentCourses = studentCourse::all();
        return studentCourseResource::collection($studentCourses);
    }

    public function store(Request $request)
    {
       
        $input = $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'courseId'  => ['required', 'exists:courses,id'],
            'mark'      => ['required', 'numeric'],
        ]);

        studentCourse::create($input);

        return response()->json(['message' => 'Adding new mark for this student in this course is done']);
    }

    public function show(string $id)
    {
     
        $studentCourse = studentCourse::with(['student', 'course'])->findOrFail($id);
        return new studentCourseResource($studentCourse);
    }

    public function update(Request $request, string $id)
    {
        $input = $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'courseId'  => ['required', 'exists:courses,id'],
            'mark'      => ['required', 'numeric'],
        ]);

        $studentCourse = studentCourse::findOrFail($id);
        $studentCourse->update($input);

        return response()->json(['message' => 'Mark of this student in this course is updated']);
    }

    public function destroy(string $id)
    {
        $studentCourse = studentCourse::findOrFail($id);
        $studentCourse->delete();

        return response()->json(['message' => 'Student in this course is deleted']);
    }
}

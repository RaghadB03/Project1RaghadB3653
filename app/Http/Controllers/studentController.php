<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class studentController extends Controller
{
    
    public function index()
    {
        $student = Student::all();
        return response()->json(['data' => $student]);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'no' => ['required', 'unique:students'],
            'email' => ['required', 'email', 'unique:students'],
            'password' => ['required'],
            'image' => ['nullable', 'image', 'mimes:png,jpg']
        ]);

        $studentData = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('students', 'public');
            $studentData['imgUrl'] = Storage::url($path);
        }

        Student::create($studentData);
        return response()->json(['message' => 'new student is added successfully']);
    }

    
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        return response()->json(['data' => $student]);
    }

    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'no' => ['required', 'unique:students,no,' . $id],
            'email' => ['required', 'email', 'unique:students,email,' . $id],
            'password' => ['required'],
            'image' => ['nullable', 'image', 'mimes:png,jpg']
        ]);

        $studentData = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('students', 'public');
            $studentData['imgUrl'] = Storage::url($path);
        }

        $student = Student::findOrFail($id);
        $student->update($studentData);

        return response()->json(['message' => 'student is updated successfully']);
    }

  
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->isActive = 0;
        $student->dismissed = 1;
        $student->save();

        return response()->json(['message' => 'student is dismissed successfully']);
    }

    
    public function graduated(string $id)
    {
        $student = Student::findOrFail($id);
        $student->isActive = 0;
        $student->isGraduated = 1;
        $student->save();

        return response()->json(['message' => 'student is graduated successfully']);
    }
}
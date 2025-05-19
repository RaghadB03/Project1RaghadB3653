<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Course;


class courseController extends Controller
{
    public function index(){
        $courses = Course::all();
        return response()->json(['data'=>$courses]);
    }

    public function show(string $id){
        $course = Course::findOrFail($id);
        return response()->json(['data'=>$course]);
    }

    public function store(Request $request)
    {
        $input = $request ->validate([
            'name'=> ['required', 'string'],
            'symbol'=> ['required', 'unique:courses'],
            'unit'=> ['required','numeric'] ]);

          
            $course = Course::create($input);
            return response()->json(['message'=> 'new course added successfully']);
    }

    public function update(Request $request, string $id)
    {
        $input = $request -> validate([
            'name'=> ['required', 'string'],
            'symbol'=> ['required', 'unique:courses'],
            'unit'=>['required','numeric'] ]);
            $course = Course::findOrFail($id);
            $course->update($input);
            return response()->json(['message'=> 'course updated successfully']);
        }
        
        public function destroy(string $id)
        {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json(['message'=> 'course deleted successfully']);
        }
}

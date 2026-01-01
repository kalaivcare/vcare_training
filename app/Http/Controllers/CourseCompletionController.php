<?php
namespace App\Http\Controllers;

use App\CourseCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseCompletionController extends Controller
{
     public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'completed_courses' => 'required|array',
            'completed_courses.*' => 'exists:course_classes,id',
            'e_signature' => 'nullable',
            'course_id'=>'required'
        
        ]);

        
        $e_signature_path = null;
        // if ($request->hasFile('e_signature')) {
        //     $e_signature_path = $request->file('e_signature')->store('e_signatures', 'public');
        // }

        
        $completion = CourseCompletion::create([
            'user_id' => auth()->id(),
            'completed_courses' => json_encode($request->completed_courses),
            'e_signature' => $request->e_signature,
            'course_id'=>$request->course_id,
        ]);

        
        return response()->json(['success' => true]);
    }
}

?>
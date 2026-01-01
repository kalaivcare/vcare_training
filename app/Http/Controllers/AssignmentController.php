<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Course;
use Mail;
use App\Mail\UserAssignment;
use Auth;

class AssignmentController extends Controller
{
    public function downloadAssignment($file)
    {
        $path = public_path('files/assignment/'.$file);

        if (file_exists($path)) {
            return response()->download($path, $file);
        }

                abort(404);
        }
    public function submit(Request $request, $id) {


    	if($file = $request->file('assignment'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('files/assignment', $name);
            $input['assignment'] = $name;
        }

    	$assignment = Assignment::create([
                'user_id' => Auth::User()->id,
                'instructor_id' => $request->instructor_id,
                'course_id' => $id,
                'title' => $request->title,
                'assignment' => $name,
            ]
        );
        $course = Course::where('id',$id)->first();
        // Mail::to('info@nihaws.com')->send(new UserAssignment($assignment,$course));
        return back()->with('success','Assignment is Submitted Successfully'); 

    }

    public function index() 
    {
    	$assignment = Assignment::all();
        return view('admin.course.assignment.index', compact('assignment'));
    }

    public function show($id)
    {
        $assign = Assignment::find($id);
        return view('admin.course.assignment.view', compact('assign'));
    }

    public function destroy($id)
    {

        $assign = Assignment::find($id);

        if($assign->assignment != null)
        {
                
            $image_file = @file_get_contents(public_path().'/files/assignment/'.$assign->assignment);

            if($image_file)
            {
                unlink(public_path().'/files/assignment/'.$assign->assignment);
            }
        }

        Assignment::where('id', $id)->delete();
        return back()->with('delete','Assignment is Deleted');
    }

    public function delete($id)
    {

        $assign = Assignment::find($id);

        if($assign->assignment != null)
        {
                
            $image_file = @file_get_contents(public_path().'/files/assignment/'.$assign->assignment);

            if($image_file)
            {
                unlink(public_path().'/files/assignment/'.$assign->assignment);
            }
        }

        Assignment::where('id', $id)->delete();
        return back()->with('delete','Assignment is Deleted');
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assigndetail; 

class AssigndetailController extends Controller
{
    public function index()
    {
        $Assigndetail = Assigndetail::all();
        return view('admin.course.Assigndetail.index', compact('Assigndetail'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'assignment' => 'required|string|max:1000',
        ]);

        $assignment = new Assigndetail();
        
        $assignment->assignment = $validated['assignment'];
        $assignment->save();

        return redirect()->route('assignmentindex')->with('success', 'Assignment created successfully!');
    }
    public function edit($id)
        {
            $assignment = Assigndetail::findOrFail($id);
    

            return view('admin.course.Assigndetail.edit', compact('assignment'));
        }
        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'assignment' => 'required|string|max:1000',
            ]);

            // Find assignment
            $assignment = Assigndetail::findOrFail($id);
            $assignment->assignment = $validated['assignment'];
            $assignment->save();

            return redirect()->route('assignmentindex')
                            ->with('success', 'Assignment updated successfully!');
        }
        
public function destroy($id)
{
    $assignment = Assigndetail::findOrFail($id);
    $assignment->delete();

    return redirect()->route('assignmentindex')
                     ->with('success', 'Assignment deleted successfully!');
}


}

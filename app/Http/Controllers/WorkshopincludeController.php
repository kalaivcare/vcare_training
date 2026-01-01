<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workshopinclude;
use App\Workshop;
use Session;
use DB;

class WorkshopincludeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshopinclude = Workshopinclude::all();
        return view('admin.workshop.workshopinclude.index',compact("workshopinclude"));
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workshopinclude = Workshopinclude::all();
        return view('admin.workshop.workshopinclude.index',compact("workshopinclude"));
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'detail' => 'required|max:50',
        ]);

        $input = $request->all();
        $data = Workshopinclude::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        $data->save();

        Session::flash('success','Added Successfully !');
        return redirect()->route('workshop.show',$request->workshop_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cate = Workshopinclude::find($id);
        $courses = Workshop::all();
        return view('admin.workshop.workshopinclude.edit',compact('cate','courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'detail' => 'required|max:50',
        ]);

        $data = Workshopinclude::findorfail($id);
        $input = $request->all();

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $data->update($input);

        Session::flash('success','Updated Successfully !'); 
        return redirect()->route('workshop.show',$request->workshop_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('workshopincludes')->where('id',$id)->delete();
        return back(); 
    }
}

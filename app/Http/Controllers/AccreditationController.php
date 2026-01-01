<?php

namespace App\Http\Controllers;

use App\Accreditation;
use Illuminate\Http\Request;
use DB;
use Image;

class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $accreditation = Accreditation::all();
         return view('admin.accreditation.index',compact('accreditation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.accreditation.insert');
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
            'status' => 'required',
            'image'=>'required',
        ]);


        $input = $request->all();
        if ($file = $request->file('image')) 
         {        
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/accreditation/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['image'] = $image;
          
        }

        $data = Accreditation::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }
        
        $data->save();

      return redirect('accreditation');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
      
        $accreditation = Accreditation::find($id);
        return view('admin.accreditation.edit',compact('accreditation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function edit(Accreditation $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $accreditation = Accreditation::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image')) {
          $name = 'trust_' . time() . $file->getClientOriginalName();
          if($accreditation->image != null) {
            $content = @file_get_contents(public_path().'/images/accreditation/'.$accreditation->image);
            if ($content) {
              unlink(public_path().'/images/accreditation/'.$accreditation->image);
            }
          }
          $file->move('images/accreditation', $name);
          $input['image'] = $name;
          $accreditation->update([
          'image' => $input['image']
          ]);
          
        }

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $accreditation->update($input);

        return redirect('accreditation');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $accreditation = Accreditation::find($id);
        if ($accreditation->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/accreditation/'.$accreditation->image);

            if($image_file)
            {
                unlink(public_path().'/images/accreditation/'.$accreditation->image);
            }
        }
        
        $value = $accreditation->delete();
        if($value){
            session()->flash("category_message","accreditation Has Been Deleted");
            return redirect("accreditation");
        }

    }
}

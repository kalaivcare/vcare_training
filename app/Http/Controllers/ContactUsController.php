<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contactus;


class ContactUsController extends Controller
{
    public function index()
    {

        $items = Contact::orderby('id', 'desc')->get();

        return view('admin.contact.index', compact('items'));
    }

    public function edit($id)
    {
        $show = Contact::where('id', $id)->first();
        return view('admin.contact.view', compact('show'));
    }

    public function update(Request $request, $id)
    {
        $data = Contact::findorfail($id);
        $input = $request->all();
        $data->update($input);

        return redirect()->route('usermessage.index');
    }

    public function destroy($id)
    {
        Contact::where('id', $id)->delete();
        return redirect()->route('usermessage.index');
    }

    public function usermessage(Request $request)
    {
        $data = $request->validate(
            [
                'user_id' => ['required', 'integer'],
                'fname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'min:2', 'max:100'],
                'mobile'  => ['required', 'regex:/^[6-9][0-9]{9}$/'],
                'email'   => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'subject' => ['required', 'string', 'max:1000'],
                'message' => ['required', 'string', 'max:1000'],
            ],
            [
                // user_id
                'user_id.required' => 'User ID is required',
                'user_id.integer'  => 'User ID must be a valid number',

                // fname
                'fname.required' => 'Name is required',
                'fname.string'   => 'Name must be a string',
                'fname.regex'    => 'Name allows only letters and spaces',
                'fname.min'      => 'Name must be at least 2 characters',
                'fname.max'      => 'Name may not be greater than 50 characters',

                // mobile

                'mobile.required' => 'Mobile number is required',
                'mobile.regex'    => 'Mobile number must be 10 digits starting with 6–9',

                // email
                'email.required' => 'Email is required',
                'email.string'   => 'Email must be a valid string',
                'email.email'    => 'Enter a valid email address',
                'email.max'      => 'Email may not be greater than 255 characters',

                // subject
                'subject.required' => 'subject is required',
                'subject.string'   => 'subject must be text only',
                'subject.max'      => 'subject may not be greater than 1000 characters',

                // message
                'message.required' => 'Message is required',
                'message.string'   => 'Message must be text only',
                'message.max'      => 'Message may not be greater than 1000 characters',
            ]
        );

        //dd($request);
        $val = decrypt($request->check);
        // dd($val);
        $input = $request->all();
        if ($val == "nihaws") {
            $data = Contact::create($input);
            $data->save();



            Mail::to('info@nihaws.com')->send(new Contactus($data));


            return back()->with('success', 'Message send successfully!');
        } else {
            return back()->with('error', 'Invalid data!');
        }
    }
}

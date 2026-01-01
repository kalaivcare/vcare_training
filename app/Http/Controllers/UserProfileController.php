<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Country;
use App\State;
use App\City;
use App\Currency;
use Session;
use Image;
use Auth;
use Hash;
use Redirect;

class UserProfileController extends Controller
{
    public function userprofilepage($id)
    {
        if (Auth::check()) {
            $course = Course::all();
            $countries = Country::all();
            $states = State::all();
            $cities = City::all();
            $orders = User::where('id', Auth::User()->id)->first();
            return view('front.user_profile.profile', compact('orders', 'course', 'countries', 'states', 'cities'));
        }
        return Redirect::route('login')->withInput()->with('delete', 'Please Login to access restricted area.');
    }


    public function rewards($id)
    {
        $user = User::find($id);
        $currency = Currency::first();

        $referral = Auth::user()->referrals;

        return view('front.user_profile.rewards', compact('user', 'currency', 'referral'));
    }

    public function userprofile(Request $request, $id)
    {
        // dd($request->all());

            $validator = Validator::make(
            $request->all(),
            [
                'fname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'min:2', 'max:50'],
                'lname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
                'email'   => ['required', 'string', 'email:rfc,dns', 'max:255','unique:users,email,'.$id,],
                'mobile'  => ['required', 'regex:/^[6-9][0-9]{9}$/','unique:users,mobile,'.$id, ],
              
            ],


            [
                'fname.required' => 'First Name is required',
                'fname.string'   => 'First Name must be a string',
                'fname.regex'    => 'First Name allows characters only',
                'fname.min'      => 'First Name must be at least 2 characters',
                'fname.max'      => 'First Name may not be greater than 50 characters',

                'lname.required' => 'Last Name is required',
                'lname.string'   => 'Last Name must be a string',
                'lname.regex'    => 'Last Name allows characters only',
                'lname.max'      => 'Last Name may not be greater than 50 characters',
                  'email.required'  => 'Email is required',
                'email.email'     => 'Email must be a valid email address',
                  'email.unique'    => 'This Email is already registered',
                
                'mobile.required' => 'Mobile number is required',
                'mobile.regex'    => 'Mobile number must be 10 digits starting with 6–9',
                'mobile.unique'    => 'This Mobile number is already registered',

 

            ],


            [
                'fname' => 'First Name',
                'lname' => 'Last Name',
                'email' => 'Email Address',
                'mobile' => 'Mobile Number',
            ]
        );

        $validator->stopOnFirstFailure()->validate();
                $request->validate([
            'user_img' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user = User::findorfail($id);
// dd('tet');
        $input = $request->all();

        if ($file = $request->file('user_img')) {
            if ($user->user_img != "") {
                $content = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);

                if ($content) {
                    unlink(public_path() . '/images/user_img/' . $user->user_img);
                }
            }

            $name = time() . $file->getClientOriginalName();
            $file->move('images/user_img', $name);
            $input['user_img'] = $name;
        }
        if (isset($request->update_pass)) {
            if (Hash::check($request->password, $user->password)) {
                // dd($user->password);

                Session::flash('error', 'New password cannot be the same as the old password.');
                return back();
            }

            $input['password'] = Hash::make($request->password);
        } else {
            $input['password'] = $user->password;
        }

        $user->update($input);

        Session::flash('success', 'User Updated Successfully !');
        return back();
    }
}

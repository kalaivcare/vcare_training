<?php

namespace App\Http\Controllers\Auth;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;
use App\Setting;
use App\Course;
use App\CourseChapter;
use App\CourseProgress;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $setting = Setting::first();
        // dd($setting);

        if ($setting->captcha_enable == 1) {
            return Validator::make($data, [
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                // 'g-recaptcha-response' => 'required|captcha',
            ], [
                'fname' => "First Name"
            ]);
        } else {

            return Validator::make(
                $data,
                [
                    'fname' => ['required', 'string', 'max:255'],
                    'lname' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ],
                [
                    'fname' => "First Name"
                ]
            );
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            //  Validation Rules
            [
                'fname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'min:2', 'max:50'],
                'lname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
                // 'lname'   => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'min:1', 'max:50'],
                'emp_id'  => ['required', 'unique:users,emp_id'],
                'email'   => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
                'mobile'  => ['required', 'regex:/^[6-9][0-9]{9}$/', 'unique:users,mobile'],
                'role'    => ['required', 'in:user,admin,trainer'],
                'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', 'confirmed'],
                'terms'   => ['accepted'],
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
                // 'lname.min'      => 'Last Name must be at least 2 characters',
                'lname.max'      => 'Last Name may not be greater than 50 characters',

                'emp_id.required' => 'Employee ID is required',
                'emp_id.unique'    => 'This Employee ID is already registered',


                'email.required'  => 'Email is required',
                'email.email'     => 'Email must be a valid email address',
                'email.unique'    => 'This Email is already registered',

                'mobile.required' => 'Mobile number is required',
                'mobile.regex'    => 'Mobile number must be 10 digits starting with 6–9',
                'mobile.unique'    => 'This Mobile number is already registered',


                'role.required'   => 'Role is required',
                'role.in'         => 'Role must be either user, admin, or trainer',

                // 'password.required' => 'Password is required',
                'password.regex'      => 'Password must be 8+ characters with uppercase, lowercase, number, and special character.',
                'password.confirmed' => 'Password confirmation does not match',

                'terms.accepted'   => 'You must accept the terms',
            ],


            [
                'fname' => 'First Name',
                'lname' => 'Last Name',
                'emp_id' => 'Employee ID',
                'email' => 'Email Address',
                'mobile' => 'Mobile Number',
                'role'  => 'User Role',
                'terms' => 'Terms & Conditions',
            ]
        );

        $validator->stopOnFirstFailure()->validate();
        $setting = Setting::first();

        $referrer = User::whereaffiliate_id(session()->pull('referrer'))->first();

        if ($request['role'] == 'trainer') {
            $Status = 0;
        } else {
            $Status = 1;
        }
        if ($setting->mobile_enable == 1) {
            $user = User::create([

                'fname' => $request['fname'],
                'lname' => $request['lname'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'role' => $request['role'],
                'emp_id' => $request['emp_id'],
                // 'state_id' => $request['state_id'],
                // 'city_id' => $request['city_id'],
                'password' => Hash::make($request['password']),
                'affiliate_id' => uniqid(),
                'referrer_id' => $referrer ? $referrer->id : null,
                'status' => $Status,

            ]);
        } else {

            $user = User::create([

                'fname' => $request['fname'],
                'lname' => $request['lname'],
                'email' => $request['email'],
                'role' => $request['role'],
                'emp_id' => $request['emp_id'],
                // 'state_id' => $request['state_id'],
                // 'city_id' => $request['city_id'],
                'password' => Hash::make($request['password']),
                'affiliate_id' => uniqid(),
                'referrer_id' => $referrer ? $referrer->id : null,
                'status' => $Status,


            ]);
        }
        $Courses = Course::orderBy('id', 'desc')->get();
        // dd($Course);
        foreach($Courses as $Course)
        {
            
            $chapterId_sta = CourseChapter::where('course_id', $Course->id)
                ->where('status', '1')
                ->orderBy('id', 'asc')
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
            $chapterIds = CourseChapter::where('course_id', $Course->id)
                ->orderBy('id', 'asc')
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
    
    
            CourseProgress::create([
                'course_id'       => $Course->id,
                'user_id'         => $user->id,
                'mark_chapter_id' => ['0'],
                'status'          => json_encode(isset($chapterId_sta[0]) ? [$chapterId_sta[0]] : [0]),
                'all_chapter_id'  => $chapterIds,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // die;
        return redirect()->route('home');








        // if ($setting->w_email_enable == 1) {
        //     try {

        //         Mail::to($request['email'])->send(new WelcomeUser($user, $setting));
        //     } catch (\Swift_TransportException $e) {

        //         header("refresh:5;url=./login");

        //         dd("Your Registration is successfull ! but welcome email is not sent because your webmaster not updated the mail settings in admin dashboard ! Kindly go back and login");
        //     }
        // }


        // return $user;
    }
}
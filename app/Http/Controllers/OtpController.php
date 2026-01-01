<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OtpController extends Controller
{


    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|exists:users,mobile',
        ]);

        $user = \App\User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return back()->withErrors(['mobile' => 'User not found']);
        }

        if ($user->status != 1) {
            return back()->withErrors(['mobile' => 'Account is inactive']);
        }

        $otp = rand(1000, 9999);

        Otp::updateOrCreate(
            ['mobile' => $request->mobile],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        session([
            'otp' => $otp,
            'mobile' => $request->mobile,
            'show_otp' => true
        ]);


        return back()->with('status', 'OTP sent successfully.');
    }
}

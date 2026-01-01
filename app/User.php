<?php

namespace App;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'email',
        'password',
        'lname',
        'dob',
        'doa',
        'mobile',
        'emp_id',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'gender',
        'pin_code',
        'status',
        'verified',
        'role',
        'is_trainer',
        'married_status',
        'user_img',
        'detail',
        'braintree_id',
        'fb_url',
        'twitter_url',
        'youtube_url',
        'linkedin_url',
        'affiliate_id',
        'referrer_id',
        'qualification',
        'school_name',
        'education_city',
        'organization',
        'designation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    protected $appends = ['referral_link'];
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->affiliate_id]);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Allcountry', 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\Allstate', 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Allcity', 'city_id', 'id');
    }
    public function courses()
    {
        return $this->hasMany('App\Course', 'user_id');
    }
    public function answer()
    {
        return $this->hasMany('App\Question', 'user_id');
    }

    public function announsment()
    {
        return $this->hasMany('App\Announcement', 'user_id');
    }

    public function review()
    {
        return $this->hasMany('App\ReviewRating', 'user_id');
    }

    public function reportreview()
    {
        return $this->hasMany('App\ReportReview', 'user_id');
    }

    public function viewprocess()
    {
        return $this->hasMany('App\ViewProcess', 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'user_id');
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog', 'user_id');
    }

    public function relatedcourse()
    {
        return $this->hasMany('App\RelatedCourse', 'user_id');
    }

    public function courseclass()
    {
        return $this->hasMany('App\CourseClass', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'user_id');
    }

    public function pending()
    {
        return $this->hasMany('App\PendingPayout', 'user_id');
    }

    public function liveclass()
    {
        return $this->hasMany('App\LiveCourse', 'user_id');
    }

    public function completed()
    {
        return $this->hasMany('App\CompletedPayout', 'user_id');
    }

    public function bundle()
    {
        return $this->hasMany('App\BundleCourse', 'user_id');
    }

    public function sentComments()
    {
        return $this->hasMany('App\Comment::class', 'sender_id');
    }
    public function receivedComments()
    {
        return $this->hasMany('App\Comment::class', 'receiver_id');
    }
}

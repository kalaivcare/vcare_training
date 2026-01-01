<?php

use App\FaqStudent;
use App\FaqInstructor;
use App\User;
use App\Setting;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CoursechapterController;
use App\Http\Controllers\CourseCompletionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['web'])->group(function () {
  Route::view('/accessdenied', 'accessdenied')->name('inactive');
  Route::get('/offline', 'GuestController@offlineview');
  Route::get('/install/proceed/Eula', 'InstallerController@eula')->name('installer');
  Route::post('/install/proceed/Eula', 'InstallerController@storeeula')->name('store.eula');
  Route::get('/install/proceed/servercheck', 'InstallerController@serverCheck')->name('servercheck');
  Route::post('/install/proceed/servercheck', 'InstallerController@storeserver')->name('store.server');

  Route::get('verifylicense', 'InstallerController@verifylicense')->name('verifylicense');
  Route::get('install/proceed/verifyapp', 'InstallerController@verify')->name('verifyApp');
  Route::post('verifycode', 'InitializeController@verify');

  Route::get('/install/proceed/step1', 'InstallerController@index')->name('installApp');

  Route::post('store/step1', 'InstallerController@step1')->name('store.step1');
  Route::get('get/step2', 'InstallerController@getstep2')->name('get.step2');
  Route::post('store/step2', 'InstallerController@step2')->name('store.step2');
  Route::get('get/step3', 'InstallerController@getstep3')->name('get.step3');
  Route::post('store/step3', 'InstallerController@storeStep3')->name('store.step3');
  Route::get('get/step4', 'InstallerController@getstep4')->name('get.step4');
  Route::post('store/step4', 'InstallerController@storeStep4')->name('store.step4');
  Route::get('get/step5', 'InstallerController@getstep5')->name('get.step5');
  Route::post('store/step5', 'InstallerController@storeStep5')->name('store.step5');

  Route::get('bigblue/api/callback', 'BigBlueController@logout');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::middleware(['web', 'IsInstalled', 'switch_languages'])->group(function () {



  // Auth Routes
  Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
  Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');


  Route::middleware(['is_verified'])->group(function () {
    //Route::group(function () {
    Route::get('/', function () {
      return view('home');
    })->middleware('uservalidity');
    Route::get('/viewppt', function (Illuminate\Http\Request $request) {
      $url = $request->query('url');
      return view('pptviewer', ['url' => $url]);
    })->name('viewppt')->middleware('uservalidity');

    Route::get('/view-pdf', function (Illuminate\Http\Request $request) {
      $url = $request->query('url');
      return view('pdfviewer', compact('url'));
    })->name('viewpdf')->middleware('uservalidity');



    Route::get('/home', 'HomeController@index')->name('home')->middleware('uservalidity');
    Route::get('profile/show/{id}', 'UserProfileController@userprofilepage')->name('profile.show');
  });


  Route::post('/course/completed', 'CourseCompletionController@store')->name('course.completed.store');

  Route::get('/', function () {
    return view('home');
  });
  // Show the edit form
  Route::get('learning/edit/{id}', 'LearningProgressController@edit')->name('learning.edit');

  // Handle the update form submission
  Route::put('learning/update/{id}', 'LearningProgressController@update')->name('learning.update');

  Route::middleware(['auth'])->group(function () {
    Route::get('/learning-progress', 'LearningProgressController@index')->name('learning.index');
    Route::post('/learning-progress', 'LearningProgressController@store')->name('learning.store');
  });
  // Route::get('/home', 'HomeController@index')->name('home');


  Auth::routes(['verify' => true]);


  Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
  // Route::get('email/verify','CourseController@mycoursepage')->name('mycourse.show');
  Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
  Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');



  Route::prefix('admins')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
  });

  Route::middleware(['web', 'is_active', 'auth', 'is_admin', 'switch_languages'])->group(function () {
      Route::get('/course/add', 'CourseController@create')->name('course.add');
      Route::get('/course/store', 'CourseController@store')->name('course.store');
     

      Route::get('/course/showedit/{id}', 'CourseController@showedit')->name('course.showedit');
    Route::put('/course/update/{id}', 'CourseController@courseupdate')->name('courseup.update');
    Route::get('/assigndetail/{id}/edit', 'AssigndetailController@edit')->name('assigndetail.edit');
    Route::put('/assigndetail/{id}', 'AssigndetailController@update')->name('assigndetail.update');
    Route::delete('/assigndetail/{id}', 'AssigndetailController@destroy')->name('assigndetail.destroy');


    // Player Settings
    Route::get('/assignmentindex', 'AssigndetailController@index')->name('assignmentindex');
    Route::post('/assigndetail/store', 'AssigndetailController@store')->name('assigndetail.store');


    Route::post('/post-comment', 'CommentController@store')->name('comment.store');
    Route::get('/all-comment', 'CommentController@index')->name('comment.index');
    Route::prefix('user')->group(function () {
      Route::get('/userinfo', 'UserController@Userinfo')->name('user.info');
      Route::get('edit/{id}', 'UserController@edit')->name('user.edit');
      Route::put('/edit/{id}', 'UserController@update')->name('user.update');
    });
    Route::prefix('assigndetail')->group(function () {
      Route::get('/info', 'AssigndetailController@Userinfo')->name('assigndetail.info');
      Route::get('edit/{id}', 'UserController@edit')->name('user.edit');
      Route::put('/edit/{id}', 'UserController@update')->name('user.update');
    });
    // Route::resource('assigndetail', 'assigndetailController');

    Route::prefix('assignment')->group(function () {
      Route::get('/assignmentinfo', 'UserController@AssigmentInfo')->name('assignment');
    });
    Route::delete('/assignmentdest/{id}', 'UserController@assignmentdest')->name('assignmentdest');


    Route::get('/admin/playersetting', 'PlayerSettingController@get')->name('player.set');
    Route::post('/admin/playersetting/update', 'PlayerSettingController@update')->name('player.update');


    Route::get('admin/ads', 'AdsController@getAds')->name('ads');
    Route::post('admin/ads/insert', 'AdsController@store')->name('ad.store');

    Route::get('admin/ads/setting', 'AdsController@getAdsSettings')->name('ad.setting');

    Route::put('admin/ads/timer', 'AdsController@updateAd')->name('ad.update');

    Route::put('admin/ads/pop', 'AdsController@updatePopAd')->name('ad.pop.update');

    Route::delete('admin/ads/delete/{id}', 'AdsController@delete')->name('ad.delete');

    Route::get('admin/ads/create', 'AdsController@create')->name('ad.create');

    Route::get('admin/ads/edit/{id}', 'AdsController@showEdit')->name('ad.edit');

    Route::put('admin/ads/edit/{id}', 'AdsController@updateADSOLO')->name('ad.update.solo');

    Route::put('admin/ads/video/{id}', 'AdsController@updateVideoAD')->name('ad.update.video');

    Route::post('admin/ads/bulk_delete', 'AdsController@bulk_delete');

    Route::post('/quickupdate/course/{id}', 'QuickUpdateController@courseQuick')->name('course.quick');
    Route::post('/quickupdate/user/{id}', 'QuickUpdateController@userQuick')->name('user.quick');
    Route::post('/quickupdate/slider/{id}', 'QuickUpdateController@sliderQuick')->name('slider.quick');
    Route::post('/quickudate/course/{id}', 'QuickUpdateController@courseabc')->name('course.featured');
    Route::post('/quickupdate/category/{id}', 'QuickUpdateController@categoryQuick')->name('category.quick');
    Route::post('/quickupdate/language/{id}', 'QuickUpdateController@languageQuick')->name('language.quick');
    Route::post('/quickupdate/pag/{id}', 'QuickUpdateController@pageQuick')->name('page.quick');
    Route::post('/quickupdate/what/{id}', 'QuickUpdateController@whatQuick')->name('what.quick');
    Route::post('/quickupdate/ansr/{id}', 'QuickUpdateController@ansrQuick')->name('ansr.quick');
    Route::post('/quickupdate/Chapter/{id}', 'QuickUpdateController@ChapterQuick')->name('Chapter.quick');
    Route::post('/quickupdate/testimonial/{id}', 'QuickUpdateController@testimonialQuick')->name('testimonial.quick');
    Route::post('/quickupdate/subcategory/{id}', 'QuickUpdateController@subcategoryQuick')->name('subcategory.quick');
    Route::post('/quickupdate/childcategory/{id}', 'QuickUpdateController@childcategoryQuick')->name('childcategory.quick');
    Route::post('/quickupdate/y/{id}', 'QuickUpdateController@categoryfQuick')->name('categoryf.quick');
    Route::post('/quickupdate/blog_status/{id}', 'QuickUpdateController@blog_statusQuick')->name('blog.status.quick');
    Route::post('/quickupdate/blog_approved/{id}', 'QuickUpdateController@blog_approvedQuick')->name('blog.approved.quick');
    Route::post('/quickupdate/status/{id}', 'QuickUpdateController@reviewstatusQuick')->name('reviewstatus.quick');
    Route::post('/quickupdate/approved/{id}', 'QuickUpdateController@reviewapprovedQuick')->name('reviewapproved.quick');
    Route::post('/quickupdate/featured/{id}', 'QuickUpdateController@reviewfeaturedQuick')->name('reviewfeatured.quick');
    Route::post('/quickupdate/faq/{id}', 'QuickUpdateController@faqQuick')->name('faq.quick');
    Route::post('/quickupdate/faqinstructor/{id}', 'QuickUpdateController@faqInstructorQuick')->name('faqInstructor.quick');

    Route::post('/quickupdate/order/{id}', 'QuickUpdateController@orderQuick')->name('order.quick');

    Route::prefix('user')->group(function () {
      Route::get('/', 'UserController@viewAllUser')->name('user.index');
      Route::get('/adduser', 'UserController@create')->name('user.add');
      Route::post('/insertuser', 'UserController@store')->name('user.store');
      Route::get('edit/{id}', 'UserController@edit')->name('user.edit');
      Route::put('/edit/{id}', 'UserController@update')->name('user.update');
      Route::delete('delete/{id}', 'UserController@destroy')->name('user.delete');
    });
    Route::prefix('Userprogress')->group(function () {
      Route::get('showdetails/{id}', 'UserController@ShowUserDetails')->name('Userprogress.show');
    });
    Route::get('userprogress/{id}/course', 'UserController@ShowUserCourseProgress')->name('Userprogress.course.show');

    Route::get('courses', 'CourseController@index')->name('courses');

    Route::post('/quiz/import', 'QuizController@import')->name('quiz.import');

    Route::get('QuizQuestion', 'QuizController@index')->name('QuizQuestion');
    Route::post('Storequestion', 'QuizController@store')->name('QuestionsStore');
    Route::PUT('QuestionsEdit/{id}', 'QuizController@update')->name('QuestionsEdit');
    Route::delete('QuestionDelete/{id}', 'QuizController@destroy')->name('QuestionDelete');
    Route::get('chapterindex', 'CoursechapterController@index')->name('chapterindex');
    Route::post('chapter', 'CoursechapterController@store')->name('chapter.store');
    Route::get('chapter/{id}', 'CoursechapterController@show');
    Route::put('updatechapter/{id}', 'CoursechapterController@update');
    Route::delete('chapter.destroy/{id}', 'CoursechapterController@destroy')->name('chapter.destroy');
    Route::get('admin/ajax/{course}/chapters', 'CoursechapterController@getByCourse')->name('admin.ajax.chapters');




    // Route::resource('chapter', 'CoursechapterController');



    Route::resource("admin/country", "CountryController");
    Route::resource("admin/state", "StateController");
    Route::resource("admin/city", "CityController");

    Route::resource('page', 'PageController');
    Route::resource('/testimonial', 'TestimonialController');
    Route::resource('slider', 'SliderController');
    Route::resource('trusted', 'TrustedController');
    Route::resource('accreditation', 'AccreditationController');



    Route::post('mailsetting/update', 'SettingController@updateMailSetting')->name('update.mail.set');
    Route::get('settings', 'SettingController@genreal')->name('gen.set');
    Route::post('setting/store', 'SettingController@store')->name('setting.store');
    Route::post('setting/seo', 'SettingController@updateSeo')->name('seo.set');
    Route::post('setting/addcss', 'SettingController@storeCSS')->name('css.store');
    Route::post('setting/addjs', 'SettingController@storeJS')->name('js.store');
    Route::post('setting/sociallogin/fb', 'SettingController@slfb')->name('sl.fb');
    Route::post('setting/sociallogin/gl', 'SettingController@slgl')->name('sl.gl');
    Route::post('setting/sociallogin/git', 'SettingController@slgit')->name('sl.git');
    Route::post('setting/sociallogin/amazon', 'SettingController@slamazon')->name('sl.amazon');
    Route::post('setting/sociallogin/linkedin', 'SettingController@sllinkedin')->name('sl.linkedin');
    Route::post('setting/sociallogin/twitter', 'SettingController@sltwitter')->name('sl.twitter');

    Route::get('/admin/api', 'ApiController@setApiView')->name('api.setApiView');
    Route::post('admin/api', 'ApiController@changeEnvKeys')->name('api.update');
    Route::put('/review/update/{id}', 'ReviewratingController@update')
      ->name('review.update');

    Route::resource('facts', 'SliderfactsController');
    Route::get('coursetext', 'CoursetextController@show');
    Route::put('coursetext/update', 'CoursetextController@update');
    Route::get('getstarted', 'GetstartedController@show');
    Route::put('getstarted/update', 'GetstartedController@update');
    Route::resource('hometext', 'HomeTextController');
    Route::get('terms', 'TermsController@show')->name('termscondition');
    Route::put('termscondition', 'TermsController@update');
    Route::get('policy', 'TermsController@showpolicy')->name('policy');
    Route::put('privacypolicy', 'TermsController@updatepolicy');

    Route::resource('reports', 'ReportReviewController');

    Route::get('aboutpage', 'AboutController@show')->name('about.page');
    Route::put('aboutupdate', 'AboutController@update');
    Route::get('comingsoon', 'ComingSoonController@show')->name('comingsoon.page');
    Route::put('comingsoonupdate', 'ComingSoonController@update');
    Route::get('careers', 'CareersController@show')->name('careers.page');
    Route::put('careers/update', 'CareersController@update');
    Route::resource('faq', 'FaqController');
    Route::resource('faqinstructor', 'FaqInstructorController');
    Route::resource('carts', 'CartController');

    // Route::get('currency', 'CurrencyController@show');
    // Route::put('currency/update', 'CurrencyController@update');
    Route::resource('currency', 'CurrencyController');


    Route::get('widget', 'WidgetController@edit')->name('widget.setting');
    Route::put('widget/update', 'WidgetController@update');
    Route::post('admin/class/{id}/addsubtitle', 'SubtitleController@post')->name('add.subtitle');
    Route::post('admin/class/{id}/delete/subtitle', 'SubtitleController@delete')->name('del.subtitle');

    Route::get('frontslider', 'CategorySliderController@show')->name('category.slider');
    Route::put('frontslider/update', 'CategorySliderController@update');

    Route::resource('requestinstructor', 'InstructorRequestController');

    Route::resource('coupon', 'CouponController');
    Route::get('all/instructor', 'InstructorRequestController@allinstructor')->name('all.instructor');
    Route::get('view/order/admin/{id}', 'OrderController@vieworder')->name('view.order');

    Route::resource('user/course/report', 'CourseReportController');

    Route::get('banktransfer', 'BankTransferController@show')->name('bank.transfer');
    Route::put('banktransfer/update', 'BankTransferController@update');
    Route::resource('usermessage', 'ContactUsController');
    Route::get('admin/lang', 'LanguageController@showlang')->name('show.lang');

    Route::get('admin/frontstatic/{local}', 'LanguageController@frontstaticword')->name('frontstatic.lang');

    Route::post('/admin/update/{lang}/frontTranslations/content', 'LanguageController@frontupdate')->name('static.trans.update');

    Route::get('admin/adminstatic/{local}', 'LanguageController@adminstaticword')->name('adminstatic.lang');

    Route::post('/admin/update/{lang}/adminTranslations/content', 'LanguageController@adminupdate')->name('admin.static.update');

    Route::get('admin/pwa', 'PwaSettingController@index')->name('show.pwa');

    Route::post('/admin/pwa/update/manifest', 'PwaSettingController@updatemanifest')->name('manifest.update');

    Route::post('/admin/pwa/update/sw', 'PwaSettingController@updatesw')->name('sw.update');

    Route::post('/admin/pwa/update/icons', 'PwaSettingController@updateicons')->name('icons.update');

    Route::post('/admin/manualcity', 'CityController@addcity')->name('city.manual');

    Route::post('/admin/manualstate', 'StateController@addstate')->name('state.manual');

    Route::resource('user/question/report', 'QuestionReportController');

    // adsense routes
    Route::get('/admin/adsensesetting/', 'AdsenseController@index')->name('adsense');
    Route::put('/admin/adsensesetting', 'AdsenseController@update')->name('adsense.update');
  });

  Route::middleware(['web', 'is_active', 'auth', 'admin_instructor', 'switch_languages'])->group(function () {



    if (\DB::connection()->getDatabaseName()) {
      if (env('IS_INSTALLED') == 1) {
        $zoom_enable = Setting::first()->zoom_enable;

        $bbl_enable  = Setting::first()->bbl_enable;

        if (isset($zoom_enable) && $zoom_enable == 1) {

          Route::prefix('zoom')->group(function () {
            Route::get('setting', 'ZoomController@setting')->name('zoom.setting');
            Route::get('dashboard', 'ZoomController@dashboard')->name('zoom.index');
            Route::post('token/update', 'ZoomController@updateToken')->name('updateToken');
            Route::get('create/meeting', 'ZoomController@create')->name('meeting.create');
            Route::delete('delete/meeting/{id}', 'ZoomController@delete')->name('zoom.delete');
            Route::post('store/new/meeting', 'ZoomController@store')->name('zoom.store');
            Route::get('edit/meeting/{meetingid}', 'ZoomController@edit')->name('zoom.edit');
            Route::post('update/meeting/{meetingid}', 'ZoomController@updatemeeting')->name('zoom.update');
            Route::get('show/meeting/{meetingid}', 'ZoomController@show')->name('zoom.show');
          });
        }

        if (isset($bbl_enable) && $bbl_enable == 1) {
          Route::prefix('bigblue')->group(function () {
            Route::view('setting', 'bbl.setting')->name('bbl.setting');
            Route::post('setting', 'BigBlueController@setting')->name('bbl.update.setting');
            Route::get('meetings', 'BigBlueController@index')->name('bbl.all.meeting');
            Route::view('meeting/create', 'bbl.create')->name('bbl.create');
            Route::post('meeting/store', 'BigBlueController@store')->name('bbl.store');
            Route::get('meeting/edit/{meetingid}', 'BigBlueController@edit')->name('bbl.edit');
            Route::post('meeting/update/{meetingid}', 'BigBlueController@update')->name('bbl.update');
            Route::delete('meeting/delete/{id}', 'BigBlueController@delete')->name('bbl.delete');
            Route::get('api/create/meeting/{id}', 'BigBlueController@apiCreate')->name('api.create.meeting');
          });
        }
      }
    }



    Route::resource('category', 'CategoriesController');
    Route::get('/category/{slug}', 'CategoriesController@show')->name('category.show');
    Route::resource('subcategory', 'SubcategoryController');
    Route::resource('childcategory', 'ChildcategoryController');
    Route::resource('course', 'CourseController');
    Route::resource('courseinclude', 'CourseincludeController');
    Route::resource('coursechapter', 'CoursechapterController');
    Route::resource('whatlearns', 'WhatlearnsController');
    Route::resource('relatedcourse', 'RelatedcourseController');
    Route::resource('questionanswer', 'QuestionanswerController');
    Route::resource('courseanswer', 'AnswerController');
    Route::resource('courseclass', 'CourseclassController');
    Route::resource('reviewrating', 'ReviewratingController');
    Route::resource('modulerating', 'ModuleratingController');
    Route::resource('announsment', 'AnnounsmentController');
    Route::get('/course/create/{id}', 'CourseController@showCourse')->name('course.show');
    Route::post('/category/insert', 'CategoriesController@categoryStore')->name('cat.store');
    Route::post('/subcategory/insert', 'SubcategoryController@SubcategoryStore')->name('child.store');
    Route::put('/course/include/{id}', 'CourseController@testup')->name('corinc.update');
    Route::put('/course/whatlearns/{id}', 'CourseController@test')->name('what.update');
    Route::put('/course/coursechapter/{id}', 'CourseController@tes')->name('chapter.update');
    Route::get('send', 'CourseclassController@store')->name('notification');
    Route::resource('courselang', 'CourseLanguageController');
    Route::get("admin/dropdown", "CourseController@upload_info");
    Route::get("admin/gcat", "CourseController@gcato");


    Route::resource('workshop', 'WorkshopContoller');
    Route::get('/workshop/create/{id}', 'WorkshopContoller@showCourse')->name('workshop.show');
    Route::post('/quickudate/workshop/{id}', 'QuickUpdateController@workabc')->name('workshop.featured');
    Route::post('/quickupdate/workshop/{id}', 'QuickUpdateController@workQuick')->name('workshop.quick');
    Route::resource('workshopinclude', 'WorkshopincludeController');
    Route::resource('workwhatlearn', 'WorkwhatlearnController');


    Route::get('instructor', 'InstructorController@index')->name('instructor.index');
    Route::resource('userenroll', 'InstructorEnrollController');
    Route::resource('instructorquestion', 'InstructorQuestionController');
    Route::resource('instructoranswer', 'InstructorAnswerController');
    Route::get('coursereview', 'CourseReviewController@index');

    Route::resource('instructor/announcement', 'InstructorAnnouncementController');
    // Route::resource('usermessage', 'ContactUsController');
    Route::resource('languages', 'LanguageController');

    Route::get('reposition/category', 'CategoriesController@reposition')->name('category_reposition');

    Route::get('reposition/class', 'CourseclassController@sort')->name('class-sort');

    Route::get('reposition/slider', 'SliderController@reposition')->name('slider_reposition');

    Route::resource('admin/quiztopic', 'QuizTopicController');

    Route::resource('/admin/questions', 'QuizController');
    Route::delete('delete_review/{id}', 'CourseReviewController@destroy');

    Route::resource('blog', 'BlogController');

    Route::resource('order', 'OrderController');

    Route::resource('featurecourse', 'FeatureCourseController');

    Route::post('/paywithpaytm', 'FeatureCourseController@order')->name('paywithpaytm');
    Route::post('/featurepayment/status', 'FeatureCourseController@paymentCallback');

    // Route::post('featuredwithpaypal', 'FeatureCourseController@payWithpaypal')->name('featuredWithpaypal');
    Route::get('getfeaturedstatus', 'FeatureCourseController@getPaymentStatus')->name('featured');

    Route::resource('bundle', 'BundleCourseController');
  });



  Route::middleware(['web', 'switch_languages'])->group(function () {

    Route::post('rating/show/{id}', 'ReviewratingController@courserating')->name('course.rating');
    Route::post('ratingcert/show/{id}', 'ReviewratingController@certrating')->name('coursecert.rating');
    Route::post('reports/insert/{id}', 'ReportReviewController@store')->name('report.review');
    Route::get('/course/{id}/{slug}', 'CourseController@CourseDetailPage')->name('user.course.show');
    Route::get('/workshop/{id}/{slug}', 'WorkshopContoller@WorkshopDetailPage')->name('detail.workshop.show');
    Route::get('all/blog', 'BlogController@blogpage')->name('blog.all');
    Route::get('about/show', 'AboutController@aboutpage')->name('about.show');
    Route::get('show/comingsoon', 'ComingSoonController@comingsoonpage')
      ->name('comingsoon.show');
    Route::get('show/careers', 'CareersController@careerpage')->name('careers.show');
    Route::get('detail/blog/{id}', 'BlogController@blogdetailpage')->name('blog.detail');
    Route::get('gotomycourse', 'CourseController@mycoursepage')->name('mycourse.show');

    Route::get('show/help', function () {
      $data = FaqStudent::first();
      $item = FaqInstructor::first();
      return view('front.help.faq', compact('data', 'item'));
    })->name('help.show');

    Route::get('pages/{slug}', 'PageController@showpage')->name('page.show');

    Route::post('show/wishlist/{id}', 'WishlistController@wishlist');
    Route::post('remove/wishlist/{id}', 'WishlistController@removewishlist');

    Route::get('enroll/show/{id}', 'EnrollmentController@enroll')->name('show.enroll');

    Route::get('show/coursecontent/{id}', 'CourseController@CourseContentPage')->middleware('uservalidity', 'active');



    Route::post('addquestion/{id}', 'QuestionanswerController@question');
    Route::post('addanswer/{id}', 'AnswerController@answer');

    Route::get('all/wishlist', 'WishlistController@wishlistpage')->name('wishlist.show');
    Route::post('delete/wishlist/{id}', 'WishlistController@deletewishlist');

    Route::post('addtocart', 'CartController@addtocart')->name('addtocart');
    Route::post('offline_tutor', 'CartController@offline_tutor')->name('offline_tutor');
    Route::post('online_tutor_one', 'CartController@online_tutor_one')->name('online_tutor_one');
    Route::post('online_tutor_two', 'CartController@online_tutor_two')->name('online_tutor_two');
    Route::post('hard_course', 'CartController@hard_course')->name('hard_course');


    Route::post('removefromcart/{id}', 'CartController@removefromcart')
      ->name('remove.item.cart');
    Route::post('removeoffline_tutor/{id}', 'CartController@removeoffline_tutor')
      ->name('removeoffline_tutor');
    Route::post('removeonline_tutor_one/{id}', 'CartController@removeonline_tutor_one')
      ->name('removeonline_tutor_one');
    Route::post('removeonline_tutor_two/{id}', 'CartController@removeonline_tutor_two')
      ->name('removeonline_tutor_two');
    Route::post('removehard_course/{id}', 'CartController@removehard_course')
      ->name('removehard_course');


    Route::get('all/cart', 'CartController@cartpage')->name('cart.show');
    Route::get('cartbefore', 'CartController@cartpagebefore')->name('cartbefore.show');

    Route::post('gotocheckout', 'CheckoutController@checkoutpage');

    Route::get('notifications/{id}', 'NotificationController@markAsRead')
      ->name('markAsRead');
    Route::get('delete/notifications', 'NotificationController@delete')
      ->name('deleteNotification');

    Route::get('/view', 'DownloadController@getDownload');

    Route::get('/download/{id}', 'DownloadController@getDownload')->name('downloadPdf')->middleware('auth');

    Route::post('review/helpful/{id}', 'ReviewHelpfulController@store')->name('helpful');
    Route::post('review/delete/{id}', 'ReviewHelpfulController@destroy')
      ->name('helpful.delete');

    Route::get('gotocategory/page/{id}', 'CategoriesController@categorypage')->name('category.page');
    Route::get('gotosubcategory/page/{id}', 'CategoriesController@subcategorypage')->name('subcategory.page');
    Route::get('gotochildcategory/page/{id}', 'CategoriesController@childcategorypage')->name('childcategory.page');

    Route::post('apply/instructor', 'InstructorRequestController@instructor')
      ->name('apply.instructor');

    Route::get('search', 'SearchController@index')->name('search');

    Route::get('/user/movie/time/{endtime}/{movie_id}/{user_id}', 'TimeHistoryController@movie_time');

    Route::get('all/purchase', 'OrderController@purchasehistory')->name('purchase.show');
    Route::get('invoice/show/{id}', 'OrderController@invoice')->name('invoice.show');



    Route::post('/edit/{id}', 'UserProfileController@userprofile')->name('user.profile');
    Route::get('rewards/show/{id}', 'UserProfileController@rewards')->name('rewards.show');


    Route::post('course/reports/{id}', 'CourseReportController@store')->name('course.report');

    Route::get('watch/course/{id}', 'WatchController@watch')->name('watchcourse');
    Route::get('watch/courseclass/{id}', 'WatchController@watchclass')->name('watchcourseclass');
    Route::get('audio/courseclass/{id}', 'WatchController@audioclass')->name('audiocourseclass');
    Route::get('watchpreview/course/{id}', 'WatchController@watchpreview')->name('watchcoursepreview');
    Route::get('testaudio/courseclass/{id}', 'WatchController@testaudioclass');


    Route::get('language-switch/{local}', 'LanguageSwitchController@languageSwitch')->name('languageSwitch');

    Route::get("country/dropdown", "CountryController@upload_info");
    Route::get("country/gcity", "CountryController@gcity");

    Route::view('terms_condition', 'terms_condition');
    Route::view('privacy_policy', 'privacy_policy');

    Route::get('detail/faq/{id}', 'HelpController@faqstudentpage')->name('faq.detail');
    Route::get('faqinstructor/detail/{id}', 'HelpController@faqinstructorpage')->name('faqinstructor.detail');

    Route::view('user_contact', 'front.contact');
    Route::post('contact/user', 'ContactUsController@usermessage')
      ->name('contact.user');

    Route::get('tabcontent/{id}', 'TabController@show');

    // Route::post('paywithpaypal', 'PaypalController@payWithpaypal')->name('payWithpaypal');
    // Route::get('getpaymentstatus', 'PaypalController@getPaymentStatus')->name('status');

    Route::get('event', 'InstaMojoController@index');
    Route::post('pay', 'InstaMojoController@pay');
    Route::get('pay-success', 'InstaMojoController@success');

    Route::get('stripe', 'StripePaymentController@stripe');
    Route::post('paytostripe', 'StripePaymentController@payStripe')->name('stripe.pay');

    Route::get('payment/braintree', 'BraintreeController@get_bt');
    Route::post('payment/braintree', 'BraintreeController@payment');

    Route::get('razorpay', 'RazorpayController@pay')->name('pay');
    Route::post('dopayment', 'RazorpayController@dopayment')->name('dopayment');

    Route::post('/paywithpaystack', 'PayStackController@redirectToGateway')->name('paywithpaystack');
    Route::get('callback', 'PayStackController@handleGatewayCallback');

    Route::post('apply/coupon', 'ApplyCouponController@applycoupon');

    Route::post('removecoupon/{id}', 'ApplyCouponController@remove')
      ->name('remove.coupon');

    Route::post('/paywithpayment', 'PaytmController@order')->name('paywithpayment');
    Route::post('/payment/status', 'PaytmController@paymentCallback');

    Route::post('process/banktransfer', 'BankTransferController@banktransfer');

    Route::get('watchcourse/in/frame/{url}/{course_id}', 'WatchController@view')->name('watchinframe');

    // Route::get('start_quiz/{type}/{id}', 'QuizStartController@quizstart')->name('start_quiz');
Route::get('start_quiz/{course}/{type}', 'QuizStartController@quizstart')
    ->name('start_quiz');
    Route::post('/start_quiz/store/{type}', 'QuizStartController@store')->name('start.quiz.store');

    // Route::get('finish/{id}/{type}', 'QuizStartController@show')->name('start.quiz.show');
    Route::get('finish/{id}/{type}', 'QuizStartController@show')->name('start.quiz.show');
    Route::get('show_report/{id}/{type}', 'QuizStartController@show_report')->name('start.quiz.show_report');




    Route::get('invoice/download/{id}', 'OrderController@pdfdownload')->name('invoice.download');

    Route::get('watch/lightbox/{id}', 'WatchController@lightbox')->name('lightbox');

    Route::post('question/reports/{id}', 'QuestionReportController@store')->name('question.report');

    Route::get('cirtificate/{id}', 'CertificateController@show')->name('cirtificate.show');
    Route::post('originalcertificate/{id}', 'CertificateController@originalcertificate')->name('originalcertificate');


    Route::get('cirtificate/download/{id}', 'CertificateController@pdfdownload')->name('cirtificate.download');

    Route::get('answersheet/{id}', 'QuizTopicController@delete')->name('answersheet');

    Route::get('tryagain/{id}', 'QuizStartController@tryagain')->name('tryagain');

    Route::get('admin/instructor/settings', 'InstructorSettingController@view')->name('instructor.settings');

    Route::post('admin/instructor/update', 'InstructorSettingController@update')->name('instructor.update');

    Route::get('instructor/details', 'InstructorSettingController@instructor')->name('instructor.pay');

    Route::post('instructor/payout/{id}', 'InstructorSettingController@settings')->name('instructor.payout');

    Route::get('pending/payout', 'PayoutController@pending')->name('pending.payout');

    Route::get('admin/instructor', 'AdminPayoutController@index')->name('admin.instructor');

    Route::get('admin/pending/{id}', 'AdminPayoutController@pending')->name('admin.pending');
    Route::get('admin/paid/{id}', 'AdminPayoutController@paid')->name('admin.paid');

    Route::post('admin/payout/bulk_payout/{id}', 'AdminPayoutController@bulk_payout');

    // Route::post('admin/paypal/{id}', 'PaymentController@paypal')->name('admin.paypal');
    Route::post('admin/banktransfer/{id}', 'PaymentController@banktransfer')->name('admin.banktransfer');
    Route::post('admin/paytm/{id}', 'PaymentController@paytm')->name('admin.paytm');

    Route::get('admin/completed/payout', 'CompletedPayoutController@show')->name('admin.completed');
    Route::get('payout/completed/view/{id}', 'CompletedPayoutController@view')->name('completed.view');

    Route::get('admin/meeting/show', 'MeetingController@index')->name('meeting.show');

    Route::post('course/checked/{id}', 'CourseProgressController@checked');
    Route::post('classprogress', 'CourseProgressController@classprogress');


    Route::post('bundle/cart/{id}', 'BundleCourseController@addtocart')->name('bundlecart');
    Route::get('bundle/detail/{id}', 'BundleCourseController@detailpage')->name('bundle.detail');
    Route::get('bundle/enroll/{id}', 'BundleCourseController@enroll')->name('bundle.enroll');

    Route::get('bbl/detail/{id}', 'BigBlueController@detailpage')->name('bbl.detail');

    Route::get('join/meeting/{meetingid}', 'BigBlueController@joinview')->name('bbluserjoin');
    Route::post('api/join/meeting', 'BigBlueController@apiJoin')->name('bbl.api.join');
  });
});


Route::get("allcountry/dropdown", "AllCountryController@upload_info");
Route::get("allcountry/gcity", "AllCountryController@gcity");


Route::post('course/assignment/{id}', 'AssignmentController@submit')->name('assignment.submit');
Route::post('assignment/delete/{id}', 'AssignmentController@delete');

Route::resource('assignment', 'AssignmentController');


Route::get('instructor/{id}', 'InstructorSettingController@instructorprofile')->name('instructor.profile');

Route::post('course/appointment/{id}', 'AppointmentController@request')->name('appointment.request');

Route::resource('appointment', 'AppointmentController');
Route::post('appointment/delete/{id}', 'AppointmentController@delete');


Route::post('chimpcurl', 'CourseController@chimpcurl');

Route::post('payorder', 'RazorpayController@payorder')->name('payorder');


Route::post('emigenerate', 'EarlysalaryController@index');
Route::post('esstatuscheck', 'EarlysalaryController@esgetcheck');

Route::get('thankyou', 'RazorpayController@thankyou')->name('thankyou');

Route::get('cert', 'ReviewratingController@cert')->name('cert');

Route::post('modulerating/show/{id}', 'ReviewratingController@modulerating')->name('module.rating');

Route::get('navigation-guide', 'PageController@navigation');

Route::get('exchangerate', 'CurrencyController@eurexchange');
Route::get('currencySchedule', 'CurrencyController@currencySchedule')->name('currencySchedule');


Route::post('get_currency', 'CurrencyController@get_currency')->name('get_currency');


Route::get("sitemap.xml", function () {
  return \Illuminate\Support\Facades\Redirect::to('sitemap.xml');
});

Route::get('/download/assignment/{file}', 'AssignmentController@downloadAssignment')->name('download.assignment');


Route::post('/upload-image', 'CourseController@upload')->name('profile.upload');
Route::post('/uploadingImage', 'CourseController@uploadingImage')->name('profileImage.upload');
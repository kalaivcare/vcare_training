@extends('theme.master')
@section('title', "Navigation Guide")
@section('content')


<div class="container-fluid " style="    background-color: #e3e6eb;">
    <div class="text-center">
         <h3 style="color:#6f0f11;padding-top:25px;">NAVIGATION GUIDE</h3>
         <h6>Please kindly follow the below steps to access the course on our website.</h6>
    </div>
    
    <div class="container">
        <div class="m-3 p-4">
             <button class="btn mb-2" style="background-color:#0284A2;color:#ffffff;pointer-events:none;">STEP 1</button>
             <h6>Click on Login</h6>
             <img src="{{ asset('images/navigation/1 login page.PNG') }}" class="img-fluid">
        </div>
         <div class="m-3 p-4">
            <button class="btn mb-2" style="background-color:#0284A2;color:#ffffff">STEP 2</button>
             <h6>Click on Login</h6>
             <h6>Enter your login Credentials</h6>
            <img src="{{ asset('images/navigation/2 login credentials.PNG') }}"  class="img-fluid">
             <h6 class="pt-3">For Example:</h6>
            <img src="{{ asset('images/navigation/3 login password.PNG') }}"  class="img-fluid">
        </div>
         <div class="m-3 p-4">
             <button class="btn mb-2" style="background-color:#0284A2;color:#ffffff">STEP 3</button>
             <h6>Click on Bell Icon as shown below</h6>
             <img src="{{ asset('images/navigation/4 notification.PNG') }}"  class="img-fluid">
             <img src="{{ asset('images/navigation/5 course selection.PNG') }}" class="img-fluid mt-5">
        </div>
         <div class="m-3 p-4">
             <button class="btn mb-2" style="background-color:#0284A2;color:#ffffff">STEP 4</button>
             <h6>It will open My Courses page, where you can see enrolled courses.</h6>
             <h6>Please click on the start course to view contents.</h6>
             <img src="{{ asset('images/navigation/6.PNG') }}"  class="img-fluid">
             <img src="{{ asset('images/navigation/7 course content.PNG') }}"  class="img-fluid mt-5">
             
        </div>
         <div class="m-3 p-4">
             <button class="btn mb-2" style="background-color:#0284A2;color:#ffffff">STEP 5</button>
             <h6>Please click on section 1 of the course to view the content file and the assessment quiz.</h6>
             <h6>Click on the view option to open as PDF and download option to download the Module.</h6>
             <img src="{{ asset('images/navigation/8 content view and download option.PNG') }}" class="img-fluid">
             <img src="{{ asset('images/navigation/9 downloaded material.PNG') }}"  class="img-fluid mt-5">
             <h6 class="pt-4">All chapters will have an Assessment Module to be completed at the end of each section.</h6>
             <h6>Once all chapters are completed <span style="color:#0284A2;">“FINAL ASSESSMENT”</span> can be attempted.</h6>
             <img src="{{ asset('images/navigation/10 final assessment.PNG') }}"  class="img-fluid">
             <h6 class="pt-3">After the final assessment is successfully completed with pass criteria, it will open a link to view and download the certificate of completion.</h6>
        </div>
       
     <div class="mt-3 pb-5 ">
           <p>Please let us know if you need any further information or any queries regarding navigation on your website</p>
       
       <p>You can reach us at <a href="mailto:info@nihaws.com">info@nihaws.com</a> or call <span style="color:#0284A2;">+91 – 9500 186 186</span></p>
     </div>
       
    </div>
   
</div>




@endsection
<html>
    <head>
        <style>
            /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
            @page {
                margin: 0cm 0cm;
            }

            /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
            body {
                margin-top:    3.5cm;
                margin-bottom: 1cm;
                margin-left:   1cm;
                margin-right:  1cm;
                     /*font-family: Georgia, 'Times New Roman', Times, serif;*/
                     color:#424141;
                     padding:20px;

            }

            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                bottom:   0px;
                left:     0px;
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    21.8cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
        </style>
    </head>
    <body>
        <div id="watermark">
            <img src="{{ asset("images/certificate/JPEG 1.1.jpg")}}" height="100%" width="100%" />
        </div>

        <main> 
            <!-- The content of your PDF here -->
     <center>
           <img src="{{ asset('images/certificate/Logo.jpg')}}" class="img-fluid" alt="Nihaws"  width="35%" height="50%"> 
     </center> 
      <br>
      @php
      $cert_date = App\CourseProgress::where('user_id',Auth::user()->id)->where('course_id',$course['id'])->first();
      $titlesplit = explode(" ",$course['title']);
      $title_str = substr($course['title'], stripos($course['title'], 'in')+0);
      $accreditation = App\Accreditation::all();
       $accre =  explode(',',$course['certified']);
    // print_r($accre);
      
      @endphp
           
                     <h3 style="color:#641016;font-size:30px;font-weight: bolder;text-align:center;" class="text-center">CERTIFICATE OF COMPLETION</h3>
                     <p class="text-center text-bold" style="font-size: 25px;text-align:center;">This certificate is awarded in recoginition that</p><br>
                   <div class="section" >
                    <h3 class="text-center" style="color:#641016;font-weight: bold;  font-family: 'Satisfy';font-size:34px;text-align:center;"><i>{{ Auth::User()['fname'] }}{{ Auth::User()['lname'] }}</i></h3><br>
                    
                          <p class="text-justify text-center container" style="font-size: 22px;text-align:justify;padding:20px 60px;">Has satisfactorily completed the mandatory requirements of study as prescribed by the National Institute of Health and Wellness, thereby presented with this certification as display of their Continuous Professional Development in the field of
 </p>
                          
                          <h2 style="color:#641016;font-weight:bold;text-align:center;font-size:34px;" class="text-center">{{ $title_str }}</h2>
                           <p class="text-center" style="font-size:22px;text-align:center;">With all rights and privileges ensuring there from : </p>
                            
                            <table class="table" style="width: 100%; padding:35px;">
                                <tr style="text-align:center;width: 50%;">
                                     <td style="font-size:17px; ">{{ date('jS F Y', strtotime($cert_date['updated_at'])) }}</td>
                                     <td style="font-size:17px;"> Dr E.CAROLIN PRABA REDDY</td>
                                </tr>
                                 <tr style="text-align:center;width: 50%;">
                                     <td  style="font-size:20px;font-weight:bold; "> DATE</td>
                                     <td style="font-size:20px;font-weight:bold;">DIRECTOR</td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%;">
                                  <tr style="text-align:center;">
                                     <td >
                                          @foreach($accreditation as $accred)
                                            @if($accred->status == 1) 
                                              @if(in_array($accred->name,$accre)) 
                                                <!--<img src="{{ asset('images/accreditation/'.$accred->image) }}" width="80px" height="80px" alt="patners-1" style="padding-right:15px;">-->
                                              @endif
                                            @endif
                                        @endforeach
                                     </td>
                                 </tr>
                            </table>
                            
                 
        </main>
    </body>
</html>
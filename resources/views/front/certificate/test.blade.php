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
                     font-family: Georgia, 'Times New Roman', Times, serif;
                   background:url('https://nihaws.com/images/certificate/certtificatebg.jpg');   
background-size: 1024px 722px;
background-repeat: no-repeat;
            }

            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                bottom:   0px;
                left:     0px;
                /*background-size:500px 500px;*/
                /* height:1000px;*/
                /*width:100%;*/
                /*background-repeat: no-repeat, repeat;*/
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    21.8cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
               
                   /*background: url("https://nihaws.com/images/certificate/certtificatebg.jpg"); background-size: 1024px 722px; background-repeat: no-repeat;*/

                /*background:url('{{ asset("images/certificate/certtificatebg.jpg")}}');*/
               /*background: url("https://nihaws.com/images/certificate/Asset2.png");*/
               /*background: url("https://nihaws.com/images/certificate/certtificatebg.jpg");*/
                
            }
        </style>
    </head>
    <body>
        
        <div id="watermark">
            <!--<img src="https://nihaws.com/images/certificate/Asset2.png" height="100%" width="100%" />-->
       
</div>
        <main> 
            <!-- The content of your PDF here -->
     <center>
           <img src="{{ asset('images/certificate/Logo.jpg')}}" class="img-fluid" alt="Nihaws" style="margin-top: 10px;" width="20%" height="25%"> 
     </center> 
      <br>
             <!--<div class="" style="text-align:justify;">-->
                     <h3 style="color:#641016;font-size:25px;font-weight: bolder;text-align:center;" class="text-center">CERTIFICATE OF COMPLETION</h3>
                     <p class="text-center text-bold" style="font-size: 20px;text-align:center;">This certificate is awarded in recoginition that</p><br>
                   <div class="section" >
                    <h3 class="text-center" style="color:#641016;font-weight: bold;  font-family: 'Satisfy';font-size:25px;text-align:center;"><i>{{ Auth::User()['fname'] }}{{ Auth::User()['lname'] }}</i></h3><br>
                    
                          <p class="text-justify text-center container" style="font-size: 22px;text-align:justify;">Has satisfactorily completed the mandatory requirements of study as prescribed by the National Institute of Health and Wellness and is thereby presented with this certification as display of their expertise in {{ $course['title'] }}</p>
                          
                          <h2 style="color:#641016;font-weight:bold;text-align:center;" class="text-center">{{ $course['title'] }}</h2>
                           <p class="text-center" style="font-size:20px;text-align:center;">With all rights and privileges ensuring there from : </p>
                            
                            <table class="table" style="width: 100%; padding:25px;">
                                <tr style="text-align:center;width: 50%;">
                                     <td style="font-size:20px; ">11-10-2021</td>
                                     <td style="font-size:20px;">dg</td>
                                </tr>
                                 <tr style="text-align:center;width: 50%;">
                                     <td  style="font-size:20px;font-weight:bold; "> DATE</td>
                                     <td style="font-size:20px;font-weight:bold;">DIRECTOR</td>
                                </tr>
                            </table>
                            <!--</div>-->
                 
        </main>
         
    </body>
</html>



<!DOCTYPE html>

<html lang="en">

<head></head>
</head>



<body>

<section id="purchase-block" class="Invoice-main-block" style="background-color:#f5f7fa; padding:12px;">
    <div class="container-fluid">
        <div class="panel-body">
      
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="page-header">
             
              <div class="download-logo" style="text-align:center;">
                
                   <a href="https://nihaws.com/" > <img src="https://nihaws.com/images/logo/logo_1625129576nihaws.png" width="100px"  height="40px" class="img-fluid" alt="logo"></a>
               
              </div> 
              </div>

              <br>

              <div class="check"  style="background-color:#fff; PADDING:10PX;">

             
              <br>
              <h2>Hi {{ $order->user->fname }} !!<h2>

              <p>{{$x}} </p>
                
              <p>Thanks for joining us.</p>


             <p>You can see invoice below.</p>

             @component('mail::button', ['url' => route('invoice.show', $order['id'])])
                    Invoice
             @endcomponent

            
                <br>
                
              </div><br>


            

        

        <p style="font-size:12px;">Copyright © 2021 NIHAWS | 15, New Giri Road T.Nagar, Chennai - 600017, Tamil Nadu, India </p>

          </div>
          <!-- /.col -->
</div>
       
       
      

    </div>
    </div>
</section>

</body>
</html> 






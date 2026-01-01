<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Attempt Failed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px;">

  <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <h2 style="color: #d9534f;">Assessment Failed</h2>

    <p><strong>Name:</strong> {{ $user->fname.  $user->lname}}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <hr style="border: 1px solid #ddd; margin: 20px 0;">

    
  

   <p style="margin-top: 20px;">
          This is to notify you that <strong>{{ $user->fname }}</strong> has 
          <span style="color: #d9534f;"><strong>failed</strong></span> in the 
          <strong>{{ $type == 'hair' ? 'Hair' : 'Skin' }} module</strong> 
          even after three attempts in {{ $course->title }}.
        </p>


</p>



    <br>
    <p>Thanks & Regards,<br><strong>{{ $course->title}}</strong></p>
  </div>

</body>
</html>

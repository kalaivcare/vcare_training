<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Your Password - VcareTraining</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #0a183d;
            margin-bottom: 30px;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #0a183d;
            color: #fff !important;
            padding: 12px 25px;
            margin: 20px 0;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Integrated Development Program 
        </div>

        <div class="content">
            <p><strong>Hello!</strong></p>

            <p>You are receiving this email because we received a password reset request for your <strong>Integrated Development Program </strong> account.</p>

            <p style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </p>

            <p>If you did not request a password reset, no further action is required.</p>

            <p>Thanks,<br><strong>Integrated Development Program Team</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Integrated Development Program. All rights reserved.
        </div>
    </div>
</body>
</html>

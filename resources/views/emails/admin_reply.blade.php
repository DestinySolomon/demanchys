<!DOCTYPE html>
<html>
<head>
    <title>Reply from {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background: white; padding: 20px; border-radius: 5px; border: 1px solid #dee2e6; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 12px; }
        .original-message { background: #f8f9fa; padding: 15px; border-left: 4px solid #6c757d; margin: 15px 0; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ config('app.name') }}</h2>
            <p>Response to your inquiry</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $customer_name }},</p>
            
            <p>Thank you for contacting us. Here is our response to your message:</p>
            
            <div style="background: #f8fafc; padding: 15px; border-radius: 5px; margin: 20px 0;">
                {!! nl2br(e($admin_message)) !!}
            </div>
            
            <div class="original-message">
                <p><strong>Your original message:</strong></p>
                <p><em>Subject: {{ $original_subject }}</em></p>
                <p>{!! nl2br(e($original_message)) !!}</p>
            </div>
            
            <p>If you have any further questions, please don't hesitate to contact us again.</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email from {{ config('app.name') }}.</p>
            <p>Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
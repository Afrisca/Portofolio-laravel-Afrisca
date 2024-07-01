<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;

class ContactController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $messageBody = "New contact form submission:\n\n";
        $messageBody .= "Name: {$validated['name']}\n";
        $messageBody .= "Email: {$validated['email']}\n";
        $messageBody .= "Subject: {$validated['subject']}\n";
        $messageBody .= "Message: {$validated['message']}";

        $this->twilio->sendWhatsAppMessage(env('WHATSAPP_TO'), $messageBody);

        return response()->json(['message' => 'Message sent successfully!']);
    }
    

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    //
    use Email;

    public function send(Request $request) {

        $validator = Validator::make($request->toArray(), [
            'email' => 'required|email',
            'feedback' => 'required'
        ]);

        // If Request Validation Fails
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation Error'
            ], 422);
        }

        $subject = 'Feedback';
        $template = 'emails.feedback';
        $templateData = [
            'email' => $validator->validated()['email'],
            'feedback' => $validator->validated()['feedback']
        ];

        $this->sendEmail($template, $templateData, $subject);

        return response('Email Sent');
}
}

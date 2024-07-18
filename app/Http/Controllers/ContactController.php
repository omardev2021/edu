<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return inertia()->render('Contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->user_id = auth()->id(); // Assuming you have authentication
        $contact->save();

        return Inertia::render('ContactUs', [
            'status' => 'Success',
        ]);
    }



    public function feedback(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $feedback = new Feedback();
        $feedback->message = $request->message;
        $feedback->user_id = auth()->id(); // Assuming you have authentication
        $feedback->save();

        return Inertia::render('Feedback', [
            'flash' => [
                'success' => 'تم الإرسال بنجاح',
            ],
        ]);
    }

}

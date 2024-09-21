<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Feedback;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('user')->get()->toArray();
        $feedbacks = Feedback::with('user')->get();

        return inertia('Admin/Contacts/Index',[
            'contacts' => $contacts,
            'feedbacks' => $feedbacks
        ]);
    }


}

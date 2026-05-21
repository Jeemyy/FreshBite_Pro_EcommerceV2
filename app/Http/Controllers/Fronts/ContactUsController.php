<?php

namespace App\Http\Controllers\Fronts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContactUsRequest;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function store(StoreContactUsRequest $request)
    {
        $data = $request->validated();
        $contact = new ContactUs;
        $contact->name = $data['name'];
        $contact->email = $data['email'];
        $contact->phone = $data['phone'];
        $contact->subject = $data['subject'];
        $contact->message = $data['message'];

        // $contact->event_date = time();
        $contact->event_date = now();

        $contact->save();

        return to_route('fronts.index')->with('Success', 'Your Problem Send Successfully');
    }
}

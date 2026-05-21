<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = ContactUs::all();

        return view('admin.contacts.index', get_defined_vars());
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contact)
    {
        return view('admin.contacts.show', get_defined_vars());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        // $contactUs->delete();

        $contactUs->delete();

        return to_route('admin.contacts.index')->with('success', 'Contact Deleted Successfully');
    }
}

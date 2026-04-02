@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Contact Us</strong>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact Name">Name</label>
                            <input type="text" id="contact Name" name="name" class="form-control"
                                placeholder="Name" value="{{ $contact->name }}" disabled>
                                {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact Email">Email</label>
                            <input type="email" id="contact Email" name="email" class="form-control"
                                placeholder="Email" value="{{ $contact->email }}" disabled>
                                {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact Phone">Phone</label>
                            <input type="text" id="contact Phone" name="phone" class="form-control"
                                placeholder="Phone" value="{{ $contact->phone }}" disabled>
                                {{-- <x-input-error :messages="$errors->get('phone')" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact Subject">Subject</label>
                            <input type="text" id="contact Subject" name="subject" class="form-control"
                                placeholder="Subject" value="{{ $contact->subject }}" disabled>
                                {{-- <x-input-error :messages="$errors->get('subject')" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="contact description">Message</label>
                            <textarea type="text" id="contact description" name="message" class="form-control"
                            placeholder="Message" value="{{ $contact->message }}" disabled>{{ $contact->message }}</textarea>
                            {{-- <x-input-error :messages="$errors->get('message" class="mt-2" /> --}}
                            </div>
                        </div> <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="contact Date">Date</label>
                                <input type="text" id="contact Date" name="event_date" class="form-control"
                                    placeholder="Date" value="{{ $contact->event_date }}" disabled>
                                    {{-- <x-input-error :messages="$errors->get('event_date')" class="mt-2" /> --}}
                            </div>
                        </div> <!-- /.col -->
                    </div>

            </div>

        </div>
    </main> <!-- main -->
@endsection

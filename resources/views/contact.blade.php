@extends('layouts.app')

@section('content')
<section class="py-5 bg-light">
    <div class="container">

        <h1 class="fw-bold mb-4 text-center text-black">Contact Us</h1>
        <p class="text-center mb-5">
            We’re here to serve you. For inquiries, reservations, event bookings, 
            or general questions, please reach out to us using the form below or
            through any of our contact channels.
        </p>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            {{-- CONTACT INFO --}}
            <div class="col-md-5 mb-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <h4 class="fw-bold mb-3">Our Contact Details</h4>

                    <p><strong>Address:</strong><br>
                        De Manchys Lounge,<br>
                        No. 21 Ekpo Abasi Street,<br>
                        Calabar South,<br>
                        Cross River State, Nigeria.
                    </p>

                    <p><strong>Phone:</strong><br>
                        +234 813 450 7788<br>
                        +234 905 152 7790
                    </p>

                    <p><strong>Email:</strong><br>
                        demanchyslounge@gmail.com
                    </p>

                    <p><strong>Opening Hours:</strong><br>
                        Mon - Sun: 10:00 AM – 10:00 PM
                    </p>
                </div>
            </div>

            {{-- CONTACT FORM --}}
            <div class="col-md-7">
                <div class="p-4 bg-white shadow-sm rounded">

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name"
                                   value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Subject</label>
                            <input type="text" name="subject"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="What is your message about?"
                                   value="{{ old('subject') }}">
                            @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Message</label>
                            <textarea name="message" rows="5"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            Send Message
                        </button>

                    </form>

                </div>
            </div>
        </div>

        {{-- GOOGLE MAP --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-3 text-center">Find Us on the Map</h4>

            <div class="rounded shadow-sm overflow-hidden" style="height: 350px;">
                {{-- 👉 Paste your Google map iframe here --}}
                <iframe src="YOUR_GOOGLE_MAP_IFRAME_HERE"
                        width="100%" height="350" style="border:0;" allowfullscreen=""
                        loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection

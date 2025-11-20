@extends('layouts.app')

@section('content')
<section class="py-5 bg-light">
    <div class="container">

        <h1 class="fw-bold mb-4 text-center text-black">Contact Us</h1>
        <p class="text-center text-dark mb-5">
            We’re here to serve you. For inquiries, reservations, event bookings, <br>
            or general questions, please reach out to us using the form below or <br>
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
                    <h4 class="fw-bold mb-3 text-dark">Our Contact Details</h4>

                    <p class="text-dark"><strong>Address:</strong><br>
                        De Manchys Lounge,<br>
                       Edet Akpan Avenue (4 Lanes), <br> Beside New Birth Church <br> Junction,
                        Uyo, Akwa Ibom State.
                    </p>

                    <p class="text-dark"><strong>Phone:</strong><br>
                        +234 813 450 7788<br>
                        +234 905 152 7790
                    </p>

                    <p class="text-dark"><strong>Email:</strong><br>
                        demanchyslounge@gmail.com
                    </p>

                    <p class="text-dark"><strong>Opening Hours:</strong><br>
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
                            <label class="form-label fw-bold text-dark">Full Name</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name"
                                   value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Email Address</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Subject</label>
                            <input type="text" name="subject"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="What is your message about?"
                                   value="{{ old('subject') }}">
                            @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Message</label>
                            <textarea name="message" rows="5"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">
                            Send Message
                        </button>

                    </form>

                </div>
            </div>
        </div>

        {{-- GOOGLE MAP --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-3 text-center text-dark">Find Us on the Map</h4>

            <div class="rounded shadow-sm overflow-hidden" style="height: 350px;">
                {{-- 👉 Paste your Google map iframe here --}}
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d75623.55979393767!2d7.889169438783667!3d5.026635836275934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1067f801481c7377%3A0x690b016fc5f0dcdd!2sNew%20Birth%20Bible%20Church%2C%20New%20Avenue%2C!5e0!3m2!1sen!2sng!4v1763282019488!5m2!1sen!2sng" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection

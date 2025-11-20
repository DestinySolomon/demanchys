@extends('layouts.app')

@section('content')

<section class="py-5" style="background: #f8f9fa;">
    <div class="container">

        <h1 class="fw-bold text-center mb-4 text-dark">Book Your Table</h1>
        <p class="text-center mb-5 text-muted">
            Reserve your perfect dining spot at De Manchys Lounge. <br>  
            Fill in the details below and our team will confirm your reservation.
        </p>

        <div class="row justify-content-center">
            <div class="col-md-7">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('book.table.store') }}" method="POST" class="p-4 bg-white rounded shadow">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Number of Guests</label>
                        <input type="number" name="guests" class="form-control" min="1" required>
                        @error('guests') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Date</label>
                        <input type="date" name="date" class="form-control" required>
                        @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Time</label>
                        <input type="time" name="time" class="form-control" required>
                        @error('time') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Additional Note (optional)</label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>

                    <button class="btn btn-warning w-100 fw-bold py-2">
                        Confirm Booking
                    </button>

                </form>

            </div>
        </div>

    </div>
</section>

@endsection

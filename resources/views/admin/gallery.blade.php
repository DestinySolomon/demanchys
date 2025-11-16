@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4">Gallery Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
       



      <div class="mb-3">
    <label class="fw-bold">Select Category</label>
    <select name="category" class="form-control">
        <option value="Lounge">Lounge</option>
        <option value="Food">Food</option>
        <option value="Events">Events</option>
        <option value="Drinks">Drinks</option>
    </select>
</div>



    <!-- Upload Form -->
    <form action="{{ route('admin.gallery.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf

        <input type="file" name="image" class="form-control mb-2">
        <button class="btn btn-warning">Upload Image</button>
    </form>

    <!-- Show all images -->
    <div class="row g-4">
        @foreach ($images as $img)
            <div class="col-md-3">
                <img src="{{ asset('storage/'.$img->image_path) }}" class="img-fluid rounded">
            </div>
        @endforeach
    </div>

</div>

@endsection

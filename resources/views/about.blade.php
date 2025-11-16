@extends('layouts.app')

@section('content')

<!-- ABOUT HERO -->
<section class="about-hero d-flex align-items-center text-center text-light"
    style="background: url('{{ asset('assets/lounge_outside.jpg') }}') center/cover no-repeat; height: 60vh;">
    <div class="container">
        <h1 class="display-4 fw-bold text-warning">About De Manchys Lounge</h1>
        <p class="lead mt-3">
            De manchys lounge where nature meets your taste buds. Luxury of nature with the true <br> experience of pure organic meals.
        </p>
    </div>
</section>

<!-- ABOUT STORY -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center gy-4">

            <div class="col-md-6">
                <h2 class="fw-bold text-black">Our Story</h2>
                <p class="mt-3 text-dark">
                    De Manchys Lounge was founded from a vision to redefine hospitality in Uyo by creating a space
                    where elegance, comfort, and world-class service work hand-in-hand. From the moment you step inside,
                    every detail, from the atmosphere to the service - is curated to deliver a superior lifestyle experience.
                </p>
                <p class="text-dark">
                    Over the years, we have grown into a preferred destination for individuals seeking refined dining,
                    premium entertainment, and a serene yet luxurious environment. Our menu, décor, and entire ambience
                    are crafted to appeal to those who appreciate sophistication in its finest form.
                </p>
                <p class="text-dark">
                    Whether you're here for a quiet evening meal, a celebration, a corporate hangout, or late - night fun,
                    De Manchys Lounge guarantees an experience that stays with you long after your visit. We are more
                    than a lounge - we are a lifestyle, a culture, and a home for lovers of quality living.
                </p>
            </div>

            <div class="col-md-6">
                <img src="{{ asset('assets/staff.jpg') }}" alt="Our Team"
                    class="img-fluid rounded-4 shadow">
            </div>

        </div>
    </div>
</section>

<!-- OUR VALUES -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">What Defines Us</h2>
        <div class="row gy-4">

            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow">
                    <i class="bi bi-star-fill text-warning display-5 mb-3"></i>
                    <h5 class="fw-bold text-dark">Premium Experience</h5>
                    <p class="text-dark">
                        Every aspect of our lounge - from lighting to seating and music - is designed to create a luxurious
                        environment where guests instantly feel elevated, relaxed, and deeply valued.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow">
                    <i class="bi bi-shield-check text-warning display-5 mb-3"></i>
                    <h5 class="fw-bold text-dark">Unmatched Security</h5>
                    <p class="text-dark">
                        We understand the importance of comfort and peace of mind, which is why our guests enjoy
                        top-level security provided by highly trained professionals dedicated to safety and privacy.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow">
                    <i class="bi bi-people-fill text-warning display-5 mb-3"></i>
                    <h5 class="fw-bold text-dark">Exceptional Service</h5>
                    <p class="text-dark">
                        Our staff is carefully selected and trained to provide warm, attentive, and professional service.
                        We prioritize customer satisfaction and create experiences that exceed expectations.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- TEAM SECTION -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class=" text-dark fw-bold mb-5 ">Meet Our Leadership & Team</h2>

        <div class="row gy-5 justify-content-center">

            <!-- Founder -->
            <div class="col-md-4">
                <img src="{{ asset('assets/emem.jpg') }}" 
                     class="img-fluid rounded-4 shadow-sm mb-3"
                     alt="Founder, Emem Udomesiet">
                <h5 class="fw-bold text-dark">Emem Udomesiet</h5>
                <p class="text-muted fw-semibold text-muted">Founder & Visionary Leader</p>
                <p class="small text-muted">
                    Emem Udomesiet is a dynamic entrepreneur whose passion for hospitality and excellence led to the
                    creation of De Manchys Lounge. With a deep understanding of luxury service and customer experience,
                    she envisioned a space in Uyo that reflects elegance, class, and world-standard dining culture.
                </p>
                <p class="small text-muted">
                    Her leadership is driven by creativity, innovation, and a commitment to raising the standard of
                    hospitality in Akwa Ibom State. Emem continues to lead the brand with vision and grace, inspiring
                    a team dedicated to delivering unforgettable experiences.
                </p>
            </div>

            <!-- Chef -->
            <div class="col-md-4">
                <img src="{{ asset('assets/chef.jpg') }}"
                    class="img-fluid rounded-4 shadow-sm mb-3" alt="Chef">
                <h5 class="fw-bold text-dark">Executive Chef</h5>
                <p class="small text-muted">
                    A master of flavors, our Executive Chef brings creativity and expertise to every dish.
                    With years of international culinary experience, he combines African richness with global
                    techniques to create meals that leave lasting impressions.
                </p>
            </div>

            <!-- Mixologist -->
            <div class="col-md-4">
                <img src="{{ asset('assets/mixologist.jpg') }}"
                    class="img-fluid rounded-4 shadow-sm mb-3" alt="Bartender">
                <h5 class="fw-bold text-dark">Lead Mixologist</h5>
                <p class="small text-muted">
                    Our mixologist crafts signature cocktails using premium ingredients and artistic precision.
                    Every drink tells a story—vibrant, balanced, and beautifully presented to elevate your experience.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- 🔥 NEW GALLERY CTA SECTION -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold text-dark mb-3">Explore Our Gallery</h2>
        <p class="text-muted mb-4">
            Dive into a visual experience of our ambience, premium dishes, events, and unforgettable moments.
            Our gallery showcases the beauty, elegance, and vibrant lifestyle that defines De Manchys Lounge.
        </p>

        <a href="{{ route('gallery') }}" class="btn btn-warning px-4 py-2 fw-semibold rounded-3">
            View Full Gallery
        </a>
    </div>
</section>

@endsection

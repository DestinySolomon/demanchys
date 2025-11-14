<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>De Manchys Lounge</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&family=Rouge+Script&family=Tangerine:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Pacifico&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./assets/style.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container-fluid">
        <!-- ✅ Image logo -->
        <a class="navbar-brand" href="#">
          <img src="assets/logo.png" alt="De Manchys Lounge Logo" />
        </a>

        <button
          class="navbar-toggler bg-light"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          title="Toggle navigation menu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div
          class="collapse navbar-collapse justify-content-center"
          id="navbarNav"
        >
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
            <li class="nav-item">
              <a class="nav-link" href="menu.html">Menu</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Events</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
          </ul>
        </div>

           <!-- 🔵 REPLACED BOOK TABLE WITH USER ICON -->
                    <button class="btn btn-warning rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 45px; height: 45px;"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal">
                        <i class="bi bi-person fs-4"></i>
                    </button>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero d-flex">
      <div class="hero-content">
        <h1>Experience Luxury at<br /><span>De Manchys Lounge</span></h1>
        <p>
          Where exceptional cuisine meets world-class entertainment.<br />
          Featuring the best DJs, state-of-the-art security, and professionally
          trained staff.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="#" class="btn btn-orange px-4 py-2">Book Your Table</a>
          <a href="menu.html" class="btn btn-outline-light px-4 py-2"
            >View Menu</a
          >
        </div>
      </div>
    </section>

    <!-- Our Gallery Section -->
    <section id="gallery" class="py-5 bg-light text-center">
      <div class="container">
        <h2 class="fw-bold text-black mb-2">Gallery</h2>
        <p class="text-warning mb-4">
          Take a glimpse into our luxurious atmosphere
        </p>

        <div
          id="loungeCarousel"
          class="carousel slide carousel-fade"
          data-bs-ride="carousel"
        >
          <!-- Indicators -->
          <div class="carousel-indicators">
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="0"
              class="active"
              aria-current="true"
              title="Go to slide 1"
            ></button>
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="1"
              title="Go to slide 2"
            ></button>
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="2"
              title="Go to slide 3"
            ></button>
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="3"
              title="Go to slide 4"
            ></button>
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="4"
              title="Go to slide 5"
            ></button>
            <button
              type="button"
              data-bs-target="#loungeCarousel"
              data-bs-slide-to="5"
              title="Go to slide 6"
            ></button>
          </div>

          <!-- Carousel Images -->
          <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">
            <div class="carousel-item active">
              <img
                src="assets/security.jpg"
                class="d-block w-100"
                alt="Lounge view 1"
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/grilled_meat.jpg"
                class="d-block w-100"
                alt="Lounge view 2"
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/lounge_outside.jpg"
                class="d-block w-100"
                alt="Lounge view 3"
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/staff.jpg"
                class="d-block w-100"
                alt="Lounge view 4"
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/barbecue.jpg"
                class="d-block w-100"
                alt="Lounge view 5"
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/drinks.jpg"
                class="d-block w-100"
                alt="Lounge view 6"
              />
            </div>
          </div>

          <!-- Controls -->
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#loungeCarousel"
            data-bs-slide="prev"
          >
            <span
              class="carousel-control-prev-icon bg-dark rounded-circle p-3"
              aria-hidden="true"
            ></span>
            <span class="visually-hidden">Previous</span>
          </button>

          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#loungeCarousel"
            data-bs-slide="next"
          >
            <span
              class="carousel-control-next-icon bg-dark rounded-circle p-3"
              aria-hidden="true"
            ></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="choose-us" class="py-5 bg-white">
      <div class="container">
        <div class="row align-items-center">
          <!-- Left Text Section -->
          <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="fw-bold text-black mb-3">
              Why Choose De Manchys Lounge?
            </h2>
            <p class="text-muted mb-3">
              At De Manchys Lounge, we've created more than just a dining
              destination – we've crafted an experience. Our commitment to
              excellence shines through every aspect of our service, from our
              carefully curated menu featuring both local and international
              cuisine to our world-class entertainment and unparalleled
              hospitality.
            </p>
            <p class="text-muted">
              Whether you're looking for an intimate dinner, a night out with
              friends, or a special celebration, our luxurious atmosphere and
              professional service ensure every visit is memorable.
            </p>
          </div>

          <!-- Right Feature Cards -->
          <div class="col-lg-6">
            <!-- Card 1 -->
            <div
              class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3"
            >
              <div
                class="icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 icon-circle"
              >
                <i class="bi bi-music-note-beamed fs-4"></i>
              </div>
              <div>
                <h5 class="fw-semibold">Best DJs in Town</h5>
                <p class="mb-0 text-muted">
                  Experience electrifying performances from top-tier DJs who
                  know how to keep the energy flowing all night long.
                </p>
              </div>
            </div>

            <!-- Card 2 -->
            <div
              class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3"
            >
              <div
                class="icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 icon-circle"
              >
                <i class="bi bi-shield-lock fs-4"></i>
              </div>
              <div>
                <h5 class="fw-semibold">State-of-the-Art Security</h5>
                <p class="mb-0 text-muted">
                  Your safety is our priority. Our advanced security systems and
                  trained personnel ensure a secure environment.
                </p>
              </div>
            </div>

            <!-- Card 3 -->
            <div
              class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm"
            >
              <div
                class="icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 icon-circle"
              >
                <i class="bi bi-person-check fs-4"></i>
              </div>
              <div>
                <h5 class="fw-semibold">Professional Staff</h5>
                <p class="mb-0 text-muted">
                  Our well-trained team delivers exceptional service with
                  attention to detail that exceeds expectations.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Menu section -->
    <section class="py-5 bg-light">
      <div class="container">
        <!-- Section Title -->
        <div class="text-center mb-4">
          <h2 class="fw-bold text-black">Our Exquisite Menu</h2>
          <p class="text-muted">
            Discover a culinary journey that spans continents, featuring the
            finest local delicacies <br />
            and international favorites, all prepared by our expert chefs.
          </p>
        </div>

        <!-- Dine In / Delivery Box -->
        <div class="d-flex justify-content-center mb-5">
          <div
            class="p-4 bg-white shadow rounded d-flex align-items-center gap-4"
          >
            <!-- Dine In -->
            <div class="text-center">
              <div
                class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle"
              >
                <i class="fa-solid fa-utensils"></i>
              </div>
              <h6 class="fw-bold mb-1">Dine In</h6>
              <small class="text-muted">Experience luxury in our lounge</small>
            </div>

            <div class="fw-bold text-muted">or</div>

            <!-- Delivery -->
            <div class="text-center">
              <div
                class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle"
              >
                <i class="bi bi-truck fs-4"></i>
              </div>
              <h6 class="fw-bold mb-1">Delivery</h6>
              <small class="text-muted">Enjoy our food at your doorstep</small>
            </div>
          </div>
        </div>

        <!-- Menu Cards -->
        <div class="row g-4">
          <!-- Card 1 -->
          <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
              <img src="assets/afang.jpg" class="card-img-top" alt="Cuisine" />
              <div class="card-body d-flex flex-column">
                <h5 class="fw-bold">Local & International Cuisine</h5>
                <p class="text-muted small">
                  Savor authentic Nigerian specialties alongside carefully
                  crafted international dishes. Each story begins with flavor.
                </p>

                <!-- One Button -->
                <div class="mt-auto">
                  <a href="menu.html" class="btn btn-warning w-100">
                    Order Now
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
              <img src="assets/drinks.jpg" class="card-img-top" alt="Drinks" />
              <div class="card-body d-flex flex-column">
                <h5 class="fw-bold">Premium Drinks & Beverages</h5>
                <p class="text-muted small">
                  From cocktails to fine wines, our drink selection brings
                  refreshing stories to every meal.
                </p>

                <!-- One Button -->
                <div class="mt-auto">
                  <a href="#" class="btn btn-warning w-100"> Order Now </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
              <img
                src="assets/grilled_meat.jpg"
                class="card-img-top"
                alt="Grilled Food"
              />
              <div class="card-body d-flex flex-column">
                <h5 class="fw-bold">Grilled Specialties & Snacks</h5>
                <p class="text-muted small">
                  Enjoy expertly grilled meats, fish, and traditional
                  snacks—rich in flavor and perfectly prepared.
                </p>

                <!-- One Button -->
                <div class="mt-auto">
                  <a href="#" class="btn btn-warning w-100"> Order Now </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Events Section -->
    <section class="py-5 bg-white">
      <div class="container">
        <!-- TITLE -->
        <div class="text-center mb-4">
          <h2 class="fw-bold text-black">Events & Entertainment</h2>
          <p class="text-muted">
            Experience unforgettable nights with our world-class entertainment
            and exclusive <br />
            events. From DJ nights to private celebrations, we make every moment
            special.
          </p>
        </div>

        <div class="row align-items-center g-4">
          <!-- LEFT: Upcoming Events -->
          <div class="col-md-6">
            <div class="p-4 rounded shadow-sm bg-light-custom">
              <h5 class="fw-bold mb-3 text-black">Upcoming Events</h5>

              <!-- Event Item -->
              <div
                class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 rounded shadow-sm"
              >
                <div>
                  <h6 class="fw-bold mb-1 text-muted">Friday Night Live</h6>
                  <small class="text-muted">DJ Marcus & Live Band</small>
                </div>
                <div class="text-end">
                  <div class="fw-bold text-warning">Nov 14</div>
                  <small class="text-muted">9:00 PM</small>
                </div>
              </div>

              <!-- Event Item -->
              <div
                class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 rounded shadow-sm"
              >
                <div>
                  <h6 class="fw-bold mb-1 text-muted">Saturday Vibes</h6>
                  <small class="text-muted">Bush Meat Night</small>
                </div>
                <div class="text-end">
                  <div class="fw-bold text-warning">Nov 15</div>
                  <small class="text-muted">8:30 PM</small>
                </div>
              </div>

              <!-- Event Item -->
              <div
                class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 rounded shadow-sm"
              >
                <div>
                  <h6 class="fw-bold mb-1 text-muted">Wine Tasting Night</h6>
                  <small class="text-muted">Premium Wine Selection</small>
                </div>
                <div class="text-end">
                  <div class="fw-bold text-warning">Nov 22</div>
                  <small class="text-muted">7:00 PM</small>
                </div>
              </div>

              <!-- View All Button -->
              <a href="events.html" class="btn btn-warning w-100 fw-bold">
                View All Events
              </a>
            </div>
          </div>

          <!-- RIGHT: Image -->
          <div class="col-md-6">
            <img
              src="assets/partying.jpg"
              class="img-fluid rounded shadow-sm"
              alt="Events & Entertainment"
            />
          </div>
        </div>

        <!-- BOTTOM FEATURES -->
        <div class="row text-center mt-5 g-4">
          <!-- Private Events -->
          <div class="col-md-6">
            <div class="p-4 rounded shadow-sm bg-light-custom">
              <div
                class="rounded-circle bg-warning text-white mx-auto mb-3 d-flex justify-content-center align-items-center icon-circle"
              >
                <i class="bi bi-calendar-event fs-4"></i>
              </div>
              <h6 class="fw-bold text-black">Private Events</h6>
              <p class="text-muted small">
                Host your special occasions with us
              </p>
            </div>
          </div>

          <!-- Live Entertainment -->
          <div class="col-md-6">
            <div class="p-4 rounded shadow-sm bg-light-custom">
              <div
                class="rounded-circle bg-warning text-white mx-auto mb-3 d-flex justify-content-center align-items-center icon-circle"
              >
                <i class="bi bi-mic-fill fs-4"></i>
              </div>
              <h6 class="fw-bold text-black">Live Entertainment</h6>
              <p class="text-muted small">Weekly performances by top artists</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Visit Us Section -->
    <!-- Visit Us Section -->
    <section class="visit-us py-5">
      <div class="container">
        <div class="text-center mb-4">
          <h2 class="fw-bold text-black">Visit Us Today</h2>
          <p class="text-muted">
            Ready to experience luxury dining and entertainment? Find us,
            contact us, or make a reservation. <br />
            We’re here to make your visit unforgettable.
          </p>
        </div>

        <div class="row g-4 align-items-center">
          <!-- Contact Info -->
          <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
              <h5 class="fw-semibold mb-3">Contact Information</h5>

              <div class="d-flex align-items-start mb-3 contact-item">
                <div class="icon bg-warning text-white rounded-circle">
                  <i class="bi bi-geo-alt-fill fs-5" aria-hidden="true"></i>
                </div>
                <div>
                  <strong>Address</strong><br />
                  Edet Akpan Avenue,(4 Lanes) Beside New Birth Church <br />
                  Junction, Uyo, Akwa Ibom State.
                </div>
              </div>

              <div class="d-flex align-items-start mb-3 contact-item">
                <div class="icon bg-warning text-white rounded-circle">
                  <i class="bi bi-telephone-fill fs-5" aria-hidden="true"></i>
                </div>
                <div class="phone">
                  <strong>Phone</strong><br />
                  +234 801 277 4355<br />
                  +234 901 265 0100
                </div>
              </div>

              <div class="d-flex align-items-start mb-3 contact-item">
                <div class="icon bg-warning text-white rounded-circle">
                  <i class="bi bi-envelope-fill fs-5" aria-hidden="true"></i>
                </div>
                <div>
                  <strong>Email</strong><br />
                  info@demanchyslounge.com<br />
                  reservations@demanchyslounge.com
                </div>
              </div>

              <div class="d-flex align-items-start mb-4 contact-item">
                <div class="icon bg-warning text-white rounded-circle">
                  <i class="bi bi-clock-fill fs-5" aria-hidden="true"></i>
                </div>
                <div>
                  <strong>Operating Hours</strong><br />
                  Monday - Thursday: 5:00 PM – 2:00 AM<br />
                  Friday - Sunday: 4:00 PM – 3:00 AM
                </div>
              </div>

              <!-- Social Icons -->
              <div class="d-flex gap-3 mt-3 social-icons">
                <a
                  href="https://web.facebook.com/profile.php?id=61563811326818"
                  class="text-decoration-none text-white bg-warning social-icon"
                  title="Facebook"
                >
                  <i class="bi bi-facebook" aria-hidden="true"></i>
                </a>
                <a
                  href="#"
                  class="text-decoration-none text-white bg-warning social-icon"
                  title="Instagram"
                >
                  <i class="bi bi-instagram" aria-hidden="true"></i>
                </a>
                <a
                  href="#"
                  class="text-decoration-none text-white bg-warning social-icon"
                  title="X"
                >
                  <i class="bi bi-x" aria-hidden="true"></i>
                </a>
                <a
                  href="#"
                  class="text-decoration-none text-white bg-warning social-icon"
                  title="WhatsApp"
                >
                  <i class="bi bi-whatsapp" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Live Google Map -->
          <div class="col-lg-6">
            <div class="map-container shadow-sm rounded-4 overflow-hidden">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1987.2950390635838!2d7.952548110821581!3d5.007537250145982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1067f801481c7377%3A0x690b016fc5f0dcdd!2sNew%20Birth%20Bible%20Church%2C%20New%20Avenue%2C!5e0!3m2!1sen!2sng!4v1762973538901!5m2!1sen!2sng"
                width="100%"
                height="400"
                allowfullscreen=""
                loading="lazy"
                title="De Manchys Lounge location on Google Maps"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
      <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
          <h2 class="fw-bold text-black">What Our Guests Say</h2>
          <p class="text-muted">
            Hear from our valued guests who’ve experienced the taste, ambiance,
            and luxury we bring to every moment. <br />
            Their stories make ours truly unforgettable.
          </p>
        </div>

        <!-- Testimonial Cards -->
        <div class="row g-4">
          <!-- Testimonial 1 -->
          <div class="col-md-4">
            <div
              class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center"
            >
              <div class="mb-3">
                <img
                  src="assets/woman_1.jpg"
                  alt="Customer 1"
                  class="rounded-circle"
                  width="80"
                  height="80"
                />
              </div>
              <h6 class="fw-bold mb-0">Amaka O.</h6>
              <small class="text-muted d-block mb-3">Food Enthusiast</small>
              <p class="text-muted fst-italic">
                “Absolutely loved the jollof rice and grilled fish! The
                atmosphere was relaxing, and the service was top-notch.”
              </p>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
              </div>
            </div>
          </div>

          <!-- Testimonial 2 -->
          <div class="col-md-4">
            <div
              class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center"
            >
              <div class="mb-3">
                <img
                  src="assets/man1.jpg"
                  alt="Customer 2"
                  class="rounded-circle"
                  width="80"
                  height="80"
                />
              </div>
              <h6 class="fw-bold mb-0">Tunde B.</h6>
              <small class="text-muted d-block mb-3">Event Host</small>
              <p class="text-muted fst-italic">
                “Hosted a private event here and everything was flawless. The
                drinks, food, and ambiance exceeded my expectations.”
              </p>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div class="col-md-4">
            <div
              class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center"
            >
              <div class="mb-3">
                <img
                  src="assets/woman_2.jpg"
                  alt="Customer 3"
                  class="rounded-circle"
                  width="80"
                  height="80"
                />
              </div>
              <h6 class="fw-bold mb-0">Lara S.</h6>
              <small class="text-muted d-block mb-3">Lifestyle Blogger</small>
              <p class="text-muted fst-italic">
                “A hidden gem in Lagos! I’d recommend this lounge to anyone who
                wants a perfect blend of fine dining and entertainment.”
              </p>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== Footer Section ===== -->
    <footer class="footer-section text-light">
      <!-- Top Section -->
      <div
        class="footer-top container py-5 d-lg-flex justify-content-between align-items-center"
      >
        <div class="mb-4 mb-lg-0">
          <h3 class="fw-bold">Ready for an Unforgettable Experience?</h3>
          <p class="mt-3">
            Join us at De Manchys Lounge where luxury meets entertainment. Book
            your table now and discover why we're the premier destination for
            fine dining and nightlife.
          </p>
          <div class="mt-4 d-flex gap-3">
            <a href="#" class="btn btn-warning px-4 text-dark fw-semibold"
              >Make Reservation</a
            >
            <a href="#" class="btn btn-outline-light px-4 fw-semibold"
              >Call Now</a
            >
          </div>
        </div>

        <div class="newsletter-box p-4 rounded">
          <h5 class="fw-bold mb-3">Stay Updated</h5>
          <p class="small mb-3">
            Get the latest updates on events, special offers, and new menu
            items.
          </p>
          <form class="d-flex">
            <input
              type="email"
              class="form-control me-2"
              placeholder="Enter your email"
            />
            <button class="btn btn-warning fw-semibold">Subscribe</button>
          </form>
        </div>
      </div>

      <!-- Bottom Section -->
      <div class="footer-bottom py-5">
        <div class="container">
          <div class="row gy-4">
            <div class="col-md-3">
              <a class="navbar-brand" href="#">
                <img src="assets/logo.png" alt="De Manchys Lounge Logo" />
              </a>
              <p class="small mb-4">
                Experience luxury dining and entertainment at Uyo's premier
                lounge destination.
              </p>
              <div class="d-flex gap-3">
                <a href="https://web.facebook.com/profile.php?id=61563811326818" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social"><i class="fab fa-x-twitter"></i></a>
              </div>
            </div>

            <div class="col-md-3">
              <h6 class="fw-bold mb-3">Quick Links</h6>
              <ul class="list-unstyled small">
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>

            <div class="col-md-3">
              <h6 class="fw-bold mb-3">Services</h6>
              <ul class="list-unstyled small">
                <li><a href="#">Table Reservations</a></li>
                <li><a href="#">Private Events</a></li>
                <li><a href="#">Catering</a></li>
                <li><a href="#">VIP Packages</a></li>
                <li><a href="#">Corporate Events</a></li>
              </ul>
            </div>

            <div class="col-md-3">
              <h6 class="fw-bold mb-3">Contact Info</h6>
              <ul class="list-unstyled small">
                <li>
                  Edet Akpan Avenue,(4 Lanes) Beside New Birth Church <br />
                  Junction, Uyo, Akwa Ibom State.
                </li>
                <li><a href="tel:+2348012774355">+234 801 277 4355</a></li>
                <li>
                  <a href="mailto:info@demanchyslounge.com"
                    >info@demanchyslounge.com</a
                  >
                </li>
                <li>Mon-Thu: 5PM–2AM</li>
                <li>Fri-Sun: 4PM–3AM</li>
              </ul>
            </div>
          </div>

          <hr class="my-4 border-secondary" />
          <p class="small text-center mb-0">
            © 2025 De Manchys Lounge. All rights reserved. |
            <a href="#" class="text-decoration-none text-light"
              >Privacy Policy</a
            >
            |
            <a href="#" class="text-decoration-none text-light"
              >Terms of Service</a
            >
          </p>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/script.js"></script>
  </body>
</html>

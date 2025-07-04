@extends('component.main')
@section('content')
    <div class="container-fluid bg-white p-0">

        <!-- Page Header Start -->
        <div class="container-fluid custom-color  my-lg-5 py-md-4 py-sm-3 py-2">
            <div class="container text-center py-5">
                <h1 class="display-2 text-white mb-4 animated slideInDown">Our Service</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>

                        <li class="breadcrumb-item" aria-current="page"><a href="#">service</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->




            <!-- Service Start -->
<div class="container-fluid lg:py-5 md:py-4 sm:py-3 py-2 bg-light">
    <div class="container py-5 px-lg-5">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <p class="section-title text-dark justify-content-center"><span></span>Our Services<span></span></p>
            <h1 class="display-6">What Solutions We Provide</h1>
            <p class="text-muted">Discover the wide range of digital, creative, and strategic solutions we offer to elevate your business.</p>
        </div>

        <div class="row g-4">
            @forelse ($serviceCategories as $category)
                @foreach ($category->serviceDetails as $detail)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-white shadow rounded-4 text-center h-100 p-4 service-card transition-scale">
                            <div class="service-icon mb-3 text-secondary fs-1">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                            <p class="text-muted mb-4">{{ \Illuminate\Support\Str::limit($detail->sort_description, 120) }}</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('servicedetail', $category->slug) }}" class="btn btn-success btn-sm px-4">Read More</a>
                                <a href="{{ url('contact') }}" class="btn btn-custom btn-sm px-4">Contact Us</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No services available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Service End -->

        <!-- Projects Start -->
        <div class="container-flued py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title justify-content-center"><span></span>Our Projects<span></span></p>
                    <h1 class="text-center mb-5">Recently Completed Projects</h1>
                </div>

                <!-- Dynamic Filter Buttons -->
                <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="mx-2 active" data-filter="*">All</li>
                            @foreach ($categories as $category)
                                <li class="mx-2" data-filter=".{{ Str::slug($category) }}">{{ $category }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Dynamic Projects -->
                <div class="row g-4 portfolio-container">
                    @foreach ($projects as $project)
                        @php
                            $images = json_decode($project->project_images, true) ?? [];
                            $firstImage = $images[0] ?? $project->thumb_image;
                        @endphp
                        <div class="col-lg-4 col-md-6 portfolio-item {{ Str::slug($project->project_category_name) }} wow fadeInUp"
                            data-wow-delay="0.1s">
                            <div class="rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $firstImage) }}"
                                        alt="{{ $project->title }}">
                                    <div class="portfolio-overlay">
                                        @if (count($images))
                                            <!-- First visible button to open lightbox -->
                                            <a class="btn btn-square btn-outline-light mx-1"
                                                href="{{ asset('storage/' . $images[0]) }}"
                                                data-lightbox="portfolio-{{ $project->id }}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <!-- Hidden links for rest of the images (for lightbox group) -->
                                            @foreach ($images as $index => $img)
                                                @if ($index > 0)
                                                    <a href="{{ asset('storage/' . $img) }}"
                                                        data-lightbox="portfolio-{{ $project->id }}" class="d-none"></a>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if ($project->project_url)
                                            <a class="btn btn-square btn-outline-light mx-1"
                                                href="{{ $project->project_url }}"><i class="fa fa-link"></i></a>
                                        @endif
                                    </div>

                                </div>
                                <div class="bg-custom p-4">
                                    <p class="text-danger fw-medium mb-2">{{ $project->project_category_name }}</p>
                                    <h5 class="lh-base mb-0">{{ $project->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Projects End -->

              <!-- Testimonials Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h5 class="text-dark">Testimonials</h5>
            <h1 class="display-6 mb-4">What Our Clients Say!</h1>
            <p class="text-muted">Real stories from real people. See how our service is making an impact.</p>
        </div>

        @if ($testimonials->count())
            <div class="owl-carousel testimonial-carousel">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-item bg-white rounded-4 shadow-sm p-4 border border-light">
                        <div class="d-flex align-items-center mb-3">
                            <img class="img-fluid rounded-circle border border-3 border-dark"
                                 src="{{ asset('storage/' . $testimonial->image) }}"
                                 alt="{{ $testimonial->name }}"
                                 style="width: 65px; height: 65px; object-fit: cover;">
                            <div class="ps-3">
                                <h5 class="mb-1">{{ $testimonial->name }}</h5>
                                <span class="text-muted small">{{ $testimonial->designation }}</span><br>
                                <span class="text-muted small">{{ $testimonial->company }}</span>
                            </div>
                        </div>
                        <p class="fst-italic text-dark mb-0">
                            <i class="fas fa-quote-left me-2 text-dark"></i>{{ $testimonial->message }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">No testimonials found.</p>
        @endif
    </div>
</div>
<!-- Testimonials End -->


{{-- services table --}}
<div class="container-fluid">
    <div class="py-5 bg-white shadow px-3 px-sm-4 px-md-5">

      <!-- Heading -->
      <div class="list-unstyled mb-4">
        <h1 class=" fw-bold text-dark text-center mb-3">
           Graphic, IT And Promotion Service for Jewellery Business
        </h1>
    </div>

      <!-- Services table -->
      <div class="table-responsive  d-none d-md-block d-lg-block">
        <table class="table table-bordered align-middle text-nowrap">
          <thead class="table-light text-center">
            <tr>
              <th>Graphic Services</th>
              <th>IT Services</th>
              <th>Promotion And Search</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Logo Design</td>
              <td>Website Development &amp; Design</td>
              <td>Social Media Handling <small>(Monthly Package)</small></td>
            </tr>
            <tr>
              <td>Yearly Jewellery Post Package</td>
              <td>Gold Silver Live Rate App / Website</td>
              <td>Google Business Verification <small>(Improve local search)</small></td>
            </tr>
            <tr>
              <td>Custom Jewellery Package</td>
              <td>E‑commerce Website <small>(Buy/Sell Jewellery Online)</small></td>
              <td>Facebook &amp; Instagram Ads</td>
            </tr>
            <tr>
              <td>Custom Images &amp; LED Videos for Shop TV</td>
              <td>Mobile App Development</td>
              <td>SEO Optimisation <small>(Improve search ranking)</small></td>
            </tr>
            <tr>
              <td>Video Reels Package for Social Media</td>
              <td>Billing Software</td>
              <td>Bulk SMS / Voice Call Package</td>
            </tr>
            <tr>
              <td>Birthday / Anniversary Post Package</td>
              <td>Employee Attendance &amp; Salary Management</td>
              <td>Bulk WhatsApp Package</td>
            </tr>
            <tr>
              <td>Daily Gold/Silver Rate Posters</td>
              <td>Inventory Software <small>(Stock Tracking)</small></td>
              <td>Official WhatsApp Verified Service</td>
            </tr>
            <tr>
              <td>Custom Post for Print / Web / Packaging / Ads</td>
              <td>Online Booking / Virtual Try‑On</td>
              <td>Google Review &amp; Rating Management</td>
            </tr>
            <tr>
              <td>Voice‑over Video Creation <small>(with voice)</small></td>
              <td>Custom CRM for Jewellery <small>(Customer tracking)</small></td>
              <td>Content Writing for Website</td>
            </tr>
            <tr>
              <td>Jewellery Catalog Design <small>(PDF / Print)</small></td>
              <td>Cloud Backup &amp; Storage</td>
              <td>Influencer Marketing <small>(Local + Bridal)</small></td>
            </tr>
            <tr>
              <td>Festival &amp; Campaign Branding Pack</td>
              <td></td>
              <td>YouTube Setup + Reels Editing</td>
            </tr>
            <tr>
              <td>3D Jewellery Mockups / Renders</td>
              <td></td>
              <td>Pinterest Marketing for Bridal Jewellery</td>
            </tr>
            <tr>
              <td>Instagram Highlight Cover Design</td>
              <td></td>
              <td>Online Reputation &amp; Response Management</td>
            </tr>
          </tbody>
        </table>
      </div><!-- /table-responsive -->


      {{-- for mobile view --}}

      <div class="container-fluid py-4 d-sm-block d-md-none d-lg-none">
        <div class="row g-4">

          <!-- Graphic Services -->
          <div class="col-12">
            <div class="bg-light border border-danger shadow-sm h-100">
              <div class="p-3 border-bottom border-danger">
                <h5 class="fw-bold text-danger mb-0">Graphic Services</h5>
              </div>
              <div class="px-0">
                <div class="border-bottom  border-danger px-2 py-2">Logo Design</div>
                <div class="border-bottom  border-danger px-2 py-2">Yearly Jewellery Post Package</div>
                <div class="border-bottom  border-danger px-2 py-2">Custom Jewellery Package</div>
                <div class="border-bottom  border-danger px-2 py-2">Custom Images & LED Videos for Shop TV</div>
                <div class="border-bottom  border-danger px-2 py-2">Video Reels Package for Social Media</div>
                <div class="border-bottom  border-danger px-2 py-2">Birthday / Anniversary Post Package</div>
                <div class="border-bottom  border-danger px-2 py-2">Daily Gold/Silver Rate Posters</div>
                <div class="border-bottom  border-danger px-2 py-2">Custom Post for Print / Web / Packaging / Ads</div>
                <div class="border-bottom  border-danger px-2 py-2">Voice‑over Video Creation <small>(with voice)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Jewellery Catalog Design <small>(PDF / Print)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Festival & Campaign Branding Pack</div>
                <div class="border-bottom  border-danger px-2 py-2">3D Jewellery Mockups / Renders</div>
                <div class="py-2 px-2">Instagram Highlight Cover Design</div>
              </div>
            </div>
          </div>

          <!-- IT Services -->
          <div class="col-12">
            <div class="bg-light border border-danger shadow-sm h-100">
              <div class="p-3 border-bottom border-danger">
                <h5 class="fw-bold text-danger mb-0">IT Services</h5>
              </div>
              <div class="px-0">
                <div class="border-bottom  border-danger px-2 py-2">Website Development & Design</div>
                <div class="border-bottom  border-danger px-2 py-2">Gold Silver Live Rate App / Website</div>
                <div class="border-bottom  border-danger px-2 py-2">E‑commerce Website <small>(Buy/Sell Jewellery Online)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Mobile App Development</div>
                <div class="border-bottom  border-danger px-2 py-2">Billing Software</div>
                <div class="border-bottom  border-danger px-2 py-2">Employee Attendance & Salary Management</div>
                <div class="border-bottom  border-danger px-2 py-2">Inventory Software <small>(Stock Tracking)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Online Booking / Virtual Try‑On</div>
                <div class="border-bottom  border-danger px-2 py-2">Custom CRM for Jewellery <small>(Customer tracking)</small></div>
                <div class="py-2 px-2">Cloud Backup & Storage</div>
              </div>
            </div>
          </div>

          <!-- Promotion & Search -->
          <div class="col-12">
            <div class="bg-light border border-danger shadow-sm h-100">
              <div class="p-3 border-bottom border-danger">
                <h5 class="fw-bold text-danger mb-0">Promotion & Search</h5>
              </div>
              <div class="px-0">
                <div class="border-bottom  border-danger px-2 py-2">Social Media Handling <small>(Monthly Package)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Google Business Verification <small>(Improve local search)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Facebook & Instagram Ads</div>
                <div class="border-bottom  border-danger px-2 py-2">SEO Optimisation <small>(Improve search ranking)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">Bulk SMS / Voice Call Package</div>
                <div class="border-bottom  border-danger px-2 py-2">Bulk WhatsApp Package</div>
                <div class="border-bottom  border-danger px-2 py-2">Official WhatsApp Verified Service</div>
                <div class="border-bottom  border-danger px-2 py-2">Google Review & Rating Management</div>
                <div class="border-bottom  border-danger px-2 py-2">Content Writing for Website</div>
                <div class="border-bottom  border-danger px-2 py-2">Influencer Marketing <small>(Local + Bridal)</small></div>
                <div class="border-bottom  border-danger px-2 py-2">YouTube Setup + Reels Editing</div>
                <div class="border-bottom  border-danger px-2 py-2">Pinterest Marketing for Bridal Jewellery</div>
                <div class="py-2 px-2">Online Reputation & Response Management</div>
              </div>
            </div>
          </div>

        </div>
      </div>


      {{-- mobile view end --}}
      <!-- Contact Section -->
      <div class="row text-center text-md-start g-4 mt-lg-5 mt-md-4">

        <!-- Email -->
        <div class="col-12 col-md-6 col-lg-4">
          <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
            <span class="contact-badge text-white fs-4">
              <i class="fas fa-envelope"></i>
            </span>
            <div>
              <div class="fw-semibold text-uppercase small text-muted">Email</div>
              <a href="mailto:realvictorygroups@gmail.com" class="text-decoration-none text-dark">
                realvictorygroups@gmail.com
              </a>
            </div>
          </div>
        </div>

        <!-- Phone -->
        <div class="col-12 col-md-6 col-lg-4">
          <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
            <span class="contact-badge text-white fs-4">
              <i class="fas fa-phone-alt"></i>
            </span>
            <div>
              <div class="fw-semibold text-uppercase small text-muted">Phone</div>
              <a href="tel:+918299012292" class="text-decoration-none text-dark">
                +91 82990 12292
              </a>
            </div>
          </div>
        </div>

        <!-- Address -->
        <div class="col-12 col-md-6 col-lg-4">
          <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
            <span class="contact-badge text-white fs-4">
              <i class="fas fa-map-marker-alt"></i>
            </span>
            <div>
              <div class="fw-semibold text-uppercase small text-muted">Address</div>
              <address class="mb-0 small lh-sm">
                73 Basement, Ekta Enclave Society,<br>
                Lakhnapur, Kanpur, Uttar Pradesh 208024
              </address>
            </div>
          </div>
        </div>

      </div><!-- /row -->
    </div><!-- /inner container -->
  </div><!-- /container-fluid -->


{{-- service table end --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Initialize Isotope -->
<script>
    $(window).on('load', function () {
        var $grid = $('.portfolio-container').isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });

        $('#portfolio-flters').on('click', 'button', function () {
            $('#portfolio-flters button').removeClass('active');
            $(this).addClass('active');
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
    });
</script>


    </div>

@endsection

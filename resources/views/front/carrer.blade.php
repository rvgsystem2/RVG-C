@extends('component.main', ['seos' => $seos])

@section('content')

@foreach ($jobs as $job)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "JobPosting",
  "title": "{{ $job->title }}",
  "description": "{{ strip_tags($job->description) }}",
  "datePosted": "{{ \Carbon\Carbon::parse($job->created_at)->toDateString() }}",
  "employmentType": "{{ strtoupper(str_replace(' ', '_', $job->type)) }}",
  "validThrough": "{{ \Carbon\Carbon::parse($job->valid_through ?? now()->addMonths(1))->endOfDay()->toIso8601String() }}",
  "hiringOrganization": {
    "@type": "Organization",
    "name": "Real Victory Groups",
    "sameAs": "https://www.realvictorygroups.com",
    "logo": "https://www.realvictorygroups.com/images/logo.png"
  },
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "{{ $job->location ?? 'Kanpur' }}",
      "addressRegion": "Uttar Pradesh",
      "postalCode": "208024",
      "addressCountry": "IN"
    }
  }
}
</script>
@endforeach

<!-- Page Header Start -->
<div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
  <div class="container text-center py-5">
    <h1 class="display-2 text-white mb-4 animated slideInDown">Join Our Team</h1>
    <nav aria-label="breadcrumb animated slideInDown">
      <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#careers">Careers</a></li>
      </ol>
    </nav>
  </div>
</div>
<!-- Page Header End -->

<!-- Job Openings Section -->
<div class="container my-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold display-6 text-dark">🚀 Current Job Openings</h2>
    <p class="text-muted">Join our dynamic team and shape the future with us.</p>
  </div>

  <div class="row g-4">
    @forelse($jobs as $job)
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100 rounded-4 job-card position-relative overflow-hidden">
        <div class="card-body d-flex flex-column p-4">
          <div class="mb-3">
            <h5 class="card-title text-primary fw-semibold mb-1">{{ $job->title }}</h5>
            <span class="badge bg-light text-dark fw-normal">{{ $job->type ?? 'Full Time' }}</span>
          </div>

          <div class="job-description-preview text-muted small">
            {!! \Illuminate\Support\Str::limit(strip_tags($job->description), 100) !!}
            @if(strlen(strip_tags($job->description)) > 100)
            <a href="javascript:void(0);" class="read-more-link text-primary text-decoration-underline d-inline-block mt-1" onclick="toggleDescription(this)">Read More</a>
            @endif
          </div>

          <div class="job-description-full text-muted small d-none mt-2">
            {!! $job->description !!}
            <a href="javascript:void(0);" class="read-less-link text-primary text-decoration-underline d-inline-block mt-1" onclick="toggleDescription(this)">Show Less</a>
          </div>

          <ul class="list-unstyled small text-muted mt-3">
            <li><i class="bi bi-geo-alt-fill me-2 text-danger"></i> <strong>Location:</strong> {{ $job->location ?? 'Kanpur' }}</li>
            <li><i class="bi bi-briefcase-fill me-2 text-info"></i> <strong>Experience:</strong> {{ $job->experience ?? '0' }}</li>
            @if($job->valid_through)
            <li><i class="bi bi-calendar2-event-fill me-2 text-warning"></i> <strong>Apply By:</strong> {{ \Carbon\Carbon::parse($job->valid_through)->format('M d, Y') }}</li>
            @endif
          </ul>

          <a href="#applyForm" class="btn btn-custom rounded-pill mt-auto w-100 apply-btn" data-career-id="{{ $job->id }}" data-position="{{ $job->title }}">
            Apply Now
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12 text-center">
      <p class="text-muted">No job openings currently. Please check back soon!</p>
    </div>
    @endforelse
  </div>
</div>

<!-- Application Form -->
<div class="container my-5" id="applyForm">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header custom-color text-white">
          <h4 class="mb-0 text-light">Apply Now</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('application.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
              </div>
              <input type="hidden" name="career_id" id="career_id">
              <div class="col-md-6" id="positionField">
                <label for="position" class="form-label">Position Applied For *</label>
                <select name="position" id="position" class="form-select">
                  <option selected disabled value="">Choose a position</option>
                  <option value="telecaller">Telecaller</option>
                  <option value="Web Developer">Web Developer</option>
                  <option value="Graphic Designer">Graphic Designer</option>
                  <option value="Digital Marketing Executive">Digital Marketing Executive</option>
                  <option value="Content Writer">Content Writer</option>
                  <option value="SEO Specialist">SEO Specialist</option>
                  <option value="Business Analyst">Business Analyst</option>
                  <option value="Project Manager">Project Manager</option>
                  <option value="UI/UX Designer">UI/UX Designer</option>
                  <option value="Software Engineer">Software Engineer</option>
                  <option value="Others">Others</option>
                </select>
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Message (Optional)</label>
                <textarea name="message" id="message" rows="4" class="form-control"></textarea>
              </div>
              <div class="col-12">
                <label for="resume" class="form-label">Upload Resume *</label>
                <input type="file" name="resume" id="resume" class="form-control" accept=".pdf,.doc,.docx" required>
              </div>
              <div class="col-12 text-end">
                <button type="submit" class="btn btn-dark w-100">Submit Application</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleDescription(link) {
    const cardBody = link.closest('.card-body');
    const preview = cardBody.querySelector('.job-description-preview');
    const full = cardBody.querySelector('.job-description-full');

    if (preview.classList.contains('d-none')) {
      preview.classList.remove('d-none');
      full.classList.add('d-none');
    } else {
      preview.classList.add('d-none');
      full.classList.remove('d-none');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const applyButtons = document.querySelectorAll('.apply-btn');

    applyButtons.forEach(button => {
      button.addEventListener('click', function () {
        const careerId = this.getAttribute('data-career-id');
        const position = this.getAttribute('data-position');

        document.getElementById('career_id').value = careerId;
        document.getElementById('position').value = position;
        document.getElementById('positionField').style.display = 'none';
      });
    });
  });
</script>

<style>
  .transition-scale {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .transition-scale:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
  }
</style>
@endsection
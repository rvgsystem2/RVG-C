@extends('component.main', ['seos' => $seos])

@section('content')

@foreach ($jobs as $job)
@php
  $isRemote = !empty($job->is_remote);

  // helper: remove खाली values ("" / null)
  $clean = function(array $a){
    return array_filter($a, fn($v) => !is_null($v) && $v !== '' && $v !== []);
  };

  $address = $clean([
    '@type'            => 'PostalAddress',
    'streetAddress'    => $job->street_address ?: '73 Basement, Ekta Enclave Society, Lakhanpur, Khyora',
    'addressLocality'  => $job->location       ?: 'Kanpur',
    'addressRegion'    => $job->region         ?: 'Uttar Pradesh',
    'postalCode'       => $job->postal_code    ?: '208024',
    // हमेशा Country object दें (Text के बजाय)
    'addressCountry'   => $clean(['@type' => 'Country', 'name' => ($job->country ?: 'India')]),
  ]);

  $payload = $clean([
    '@context'        => 'https://schema.org',
    '@type'           => 'JobPosting',
    'title'           => $job->title,
    'description'     => strip_tags($job->description ?? ''),
    'datePosted'      => \Carbon\Carbon::parse($job->created_at ?? now())->toDateString(),
    'employmentType'  => strtoupper(str_replace(' ', '_', $job->type ?? 'Full Time')), // FULL_TIME etc.
    'validThrough'    => \Carbon\Carbon::parse($job->valid_through ?? now()->addMonth())->endOfDay()->toAtomString(),
    'hiringOrganization' => [
      '@type' => 'Organization',
      'name'  => 'Real Victory Groups',
      'sameAs'=> 'https://www.realvictorygroups.com',
      'logo'  => 'https://www.realvictorygroups.com/images/logo.png',
    ],
  ]);

  // Remote vs Onsite
  if ($isRemote) {
      $payload['jobLocationType'] = 'TELECOMMUTE';
  } else {
      $payload['jobLocation'] = [
          '@type' => 'Place',
          'address' => $address,
      ];
  }

  // baseSalary केवल तभी जोड़ें जब कोई वैल्यू हो
  if (!is_null($job->salary_min) || !is_null($job->salary_max)) {
      $payload['baseSalary'] = [
          '@type' => 'MonetaryAmount',
          'currency' => $job->salary_currency ?: 'INR',
          'value' => $clean([
              '@type'    => 'QuantitativeValue',
              'minValue' => $job->salary_min,
              'maxValue' => $job->salary_max,
              'unitText' => strtoupper($job->salary_unit ?: 'MONTH'),
          ]),
      ];
  }
@endphp

<script type="application/ld+json">
{!! json_encode($payload, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
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
<!-- Job Openings Section -->
<style>
  .job-card{
    border-radius: 1.25rem;
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .job-card:hover{ transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.08); }
  .chip{ display:inline-flex; align-items:center; gap:.35rem; padding:.25rem .6rem; border-radius:999px; background:#f6f7fb; font-size:.8rem; }
  .meta-list li{ margin-bottom:.4rem; }
  .salary{ font-weight:700; font-size:1.05rem; }
  .btn-apply{ background:linear-gradient(90deg,#2563eb,#0ea5e9); color:#fff; }
  .btn-apply:hover{ filter:brightness(.95); color:#fff; }
  .read-more-link,.read-less-link{ font-weight:600; }
</style>

<div class="container my-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold display-6 text-dark">🚀 Current Job Openings</h2>
    <p class="text-muted mb-0">Join our dynamic team and shape the future with us.</p>
  </div>

  <div class="row g-4">
    @forelse($jobs as $job)
      @php
        $isRemote = isset($job->is_remote) && (bool)$job->is_remote;
        $salaryMin = $job->salary_min ?? null;
        $salaryMax = $job->salary_max ?? null;
        $cur       = strtoupper($job->salary_currency ?? 'INR');
        $unit      = strtoupper($job->salary_unit ?? 'MONTH');
        $unitLabel = [
          'HOUR'=>'/hr','DAY'=>'/day','WEEK'=>'/wk','MONTH'=>'/mo','YEAR'=>'/yr'
        ][$unit] ?? '/mo';
        $hasSalary = !is_null($salaryMin) || !is_null($salaryMax);
      @endphp

      <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 job-card position-relative overflow-hidden">
          <div class="card-body d-flex flex-column p-4">
            <!-- Header -->
            <div class="d-flex align-items-start justify-content-between mb-3">
              <div>
                <h5 class="card-title fw-semibold mb-1 text-dark">{{ $job->title }}</h5>
                <div class="d-flex flex-wrap gap-2">
                  <span class="chip"><i class="bi bi-briefcase"></i>{{ $job->type ?? 'Full Time' }}</span>
                  @if($isRemote)
                    <span class="chip"><i class="bi bi-wifi"></i>Remote</span>
                  @endif
                  <span class="chip"><i class="bi bi-geo-alt"></i>{{ $job->location ?? 'Kanpur' }}</span>
                  @if(!empty($job->experience))
                    <span class="chip"><i class="bi bi-mortarboard"></i>{{ $job->experience }}</span>
                  @endif
                </div>
              </div>
              @if($job->valid_through)
                <span class="chip text-danger" title="Apply By">
                  <i class="bi bi-calendar2-event"></i>
                  {{ \Carbon\Carbon::parse($job->valid_through)->format('d M Y') }}
                </span>
              @endif
            </div>

            <!-- Salary -->
            @if($hasSalary)
              <div class="mb-2">
                <span class="text-muted small d-block">Compensation</span>
                <div class="salary">
                  @if(!is_null($salaryMin) && !is_null($salaryMax))
                    {{ $cur }} {{ number_format($salaryMin) }} – {{ number_format($salaryMax) }} <span class="text-muted fw-normal">{{ $unitLabel }}</span>
                  @elseif(!is_null($salaryMin))
                    From {{ $cur }} {{ number_format($salaryMin) }} <span class="text-muted fw-normal">{{ $unitLabel }}</span>
                  @else
                    Up to {{ $cur }} {{ number_format($salaryMax) }} <span class="text-muted fw-normal">{{ $unitLabel }}</span>
                  @endif
                </div>
              </div>
            @endif

            <!-- Description -->
            <div class="job-description-preview text-muted small">
              {!! \Illuminate\Support\Str::limit(strip_tags($job->description), 140) !!}
              @if(strlen(strip_tags($job->description)) > 140)
                <a href="javascript:void(0);" class="read-more-link text-primary d-inline-block mt-1" onclick="toggleDescription(this)">Read more</a>
              @endif
            </div>
            <div class="job-description-full text-muted small d-none mt-2">
              {!! $job->description !!}
              <a href="javascript:void(0);" class="read-less-link text-primary d-inline-block mt-1" onclick="toggleDescription(this)">Show less</a>
            </div>

            <!-- Meta -->
            <ul class="list-unstyled small text-muted mt-3 meta-list">
              @if(!$isRemote && !empty($job->street_address))
                <li><i class="bi bi-signpost-2 me-2 text-secondary"></i>
                  <strong>Address:</strong> {{ $job->street_address }},
                  {{ $job->location ?? '' }} {{ $job->region ?? '' }} {{ $job->postal_code ?? '' }}
                </li>
              @endif
              <li class="@if($job->status !== 'active') text-danger @endif">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Status:</strong> {{ ucfirst($job->status) }}
              </li>
            </ul>

            <!-- Apply -->
            <div class="d-grid mt-auto pt-2">
              <a href="#applyForm"
                 class="btn btn-apply rounded-pill py-2 apply-btn"
                 data-career-id="{{ $job->id }}"
                 data-position="{{ $job->title }}">
                Apply Now
              </a>
            </div>
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

<script>
  function toggleDescription(el){
    const card = el.closest('.card-body');
    const preview = card.querySelector('.job-description-preview');
    const full = card.querySelector('.job-description-full');
    preview.classList.toggle('d-none');
    full.classList.toggle('d-none');
  }
</script>

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

{{-- <script>
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
</script> --}}

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
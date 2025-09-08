@extends('component.main', ['seos' => $seos])

@section('content')
    <!-- Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        .pricing-card {
            transition: .25s;
            border-radius: 18px;
        }

        .pricing-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
        }

        .price-badge {
            font-weight: 700;
            font-size: 1.75rem
        }

        .pkg-chip {
            background: #f4f6f8;
            color: #334155;
            font-size: .8rem;
            padding: .25rem .6rem;
            border-radius: 999px
        }

        .btn-buy {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            border: none
        }

        .btn-buy:hover {
            filter: brightness(.95)
        }
    </style>

    <!-- Header -->
    <div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4 animated slideInDown">Our Packages</h1>
            <nav aria-label="breadcrumb" class="animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Packages</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Packages Grid -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6 text-dark">Choose the plan that fits your growth</h2>
            <p class="text-muted mb-0">Simple pricing. No hidden fees. Start today.</p>
        </div>

        <div class="row g-4">
            @forelse($packages as $pkg)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 pricing-card">
                        @if ($pkg->image)
                            <img src="{{ asset('storage/' . $pkg->image) }}" alt="{{ $pkg->image_alt ?? $pkg->name }}"
                                class="card-img-top" style="height:190px;object-fit:cover">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-semibold mb-0">{{ $pkg->name }}</h5>
                                <span class="pkg-chip text-uppercase">{{ $pkg->status }}</span>
                            </div>

                            <div class="mb-2 text-dark price-badge">
                                ₹ {{ number_format((float) $pkg->price, 2) }}
                            </div>

                            <div class="text-muted small mb-3">
                                {!! \Illuminate\Support\Str::limit(strip_tags($pkg->description), 140) !!}
                            </div>

                            <div class="mt-auto d-grid">
                                {{-- packages grid ke andar button replace karein --}}
                                <a href="{{ route('packages.buy', $pkg->id) }}"
                                    class="btn btn-buy text-white rounded-pill py-2">
                                    Buy Now
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No packages available right now.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

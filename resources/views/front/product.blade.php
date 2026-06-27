<!-- PRODUCT Start -->
<div class="container-fluid lg:py-5 md:py-4 sm:-py-3 py-2 bg-light">
    <div class="container py-5 px-lg-5">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-6">Our Products</h1>
            <p class="text-muted">Explore our wide range of innovative and high-quality offerings.</p>
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-12 col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card border-0 shadow h-100 product-card p-3 rounded-4">

                        <div class="product-img-box position-relative overflow-hidden rounded-3">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="product-img">
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">{{ $product->name }}</h5>

                            <p class="card-text text-muted small">
                                {{ Str::limit(strip_tags($product->description), 100) }}
                            </p>

                            <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                                @if ($product->number)
                                    <a href="tel:+91{{ $product->number }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-phone-alt me-1"></i> Inquiry Now
                                    </a>
                                @endif

                                @if ($product->url)
                                    <a href="{{ $product->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-dark btn-sm">
                                        <i class="fas fa-globe me-1"></i> Visit Website
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No products found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- PRODUCT End -->

<style>
    .product-card {
        transition: all 0.3s ease;
        background: #fff;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-img-box {
        width: 100%;
        height: 220px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    @media (max-width: 575px) {
        .product-img-box {
            height: 200px;
        }
    }
</style>
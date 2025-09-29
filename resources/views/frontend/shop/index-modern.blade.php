@extends('layouts.app')

@section('content')
<!-- Modern Hero Section -->
<div class="bg-gray-50 py-8">
    <div class="container">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="heading-2 text-gray-900 mb-2">Produk Segar Pilihan</h1>
                <nav class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-700">Belanja</span>
                    @if(isset($selected_category))
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-primary font-medium">{{$selected_category}}</span>
                    @endif
                </nav>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">
                    <i class="fas fa-leaf mr-2"></i>
                    {{$produk->total()}} Produk Tersedia
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container py-8">
    <div class="grid mobile-stack lg:grid-cols-4 gap-8">
        <!-- Modern Sidebar Filter -->
        <div class="lg:col-span-1 mobile-sidebar">
            <div class="sticky top-8 tablet-sidebar">
                <!-- Category Filter -->
                <div class="card mb-6">
                    <div class="card-body">
                        <h3 class="heading-5 mb-4 flex items-center gap-2">
                            <i class="fas fa-filter text-primary"></i>
                            Filter Kategori
                        </h3>
                        <div class="space-y-3">
                            <a href="{{route('shop')}}"
                               class="flex items-center justify-between p-3 rounded-lg border-2 transition-all {{ !isset($selected_category) ? 'border-primary bg-primary/5 text-primary' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-th-large"></i>
                                    <span class="font-medium">Semua Produk</span>
                                </div>
                                @if(!isset($selected_category))
                                    <i class="fas fa-check text-primary"></i>
                                @endif
                            </a>
                            @foreach ($kategori as $kat)
                                <a href="{{route('shop').'/'.$kat->slug}}"
                                   class="flex items-center justify-between p-3 rounded-lg border-2 transition-all {{ (isset($selected_category) && $selected_category == $kat->nama) ? 'border-primary bg-primary/5 text-primary' : 'border-gray-200 hover:border-gray-300' }}">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-tag"></i>
                                        <span class="font-medium">{{$kat->nama}}</span>
                                    </div>
                                    @if(isset($selected_category) && $selected_category == $kat->nama)
                                        <i class="fas fa-check text-primary"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Price Range Filter (Placeholder for future implementation) -->
                <div class="card mb-6">
                    <div class="card-body">
                        <h3 class="heading-5 mb-4 flex items-center gap-2">
                            <i class="fas fa-tags text-primary"></i>
                            Rentang Harga
                        </h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm">Di bawah Rp 25.000</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm">Rp 25.000 - Rp 50.000</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm">Rp 50.000 - Rp 100.000</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm">Di atas Rp 100.000</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-leaf text-2xl text-primary"></i>
                            </div>
                            <h4 class="heading-6 mb-2">100% Segar</h4>
                            <p class="text-sm text-gray-600">Langsung dari petani, dijamin segar dan berkualitas tinggi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 p-6 bg-white rounded-xl shadow-sm mobile-toolbar">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4 sm:mb-0">
                    <div class="flex items-center gap-2">
                        <button class="p-2 rounded-lg bg-primary text-white" title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 desktop-only" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <span class="text-sm text-gray-600 desktop-only">
                        Menampilkan {{$produk->firstItem()}}-{{$produk->lastItem()}} dari {{$produk->total()}} produk
                    </span>
                    <span class="text-xs text-gray-500 mobile-only">
                        {{$produk->total()}} produk
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label class="text-sm font-medium text-gray-700 mobile-only">Urutkan:</label>
                    <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary w-full sm:w-auto">
                        <option>Terpopuler</option>
                        <option>Harga: Rendah ke Tinggi</option>
                        <option>Harga: Tinggi ke Rendah</option>
                        <option>Terbaru</option>
                        <option>Nama A-Z</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid product-grid-mobile sm:grid-cols-2 tablet-grid-3 lg:grid-cols-3 lg-grid-4 gap-6 mb-8">
                @foreach ($produk as $value)
                    <div class="product-card product-card-compact animate-fade-in">
                        <div class="product-card-image">
                            <img src="{{asset('frontend/'.$value->image)}}" alt="{{$value->nama}}" loading="lazy">

                            @if ($value->harga_diskon > 0)
                                @php
                                    $discount_percent = round((($value->harga - $value->harga_diskon) / $value->harga) * 100);
                                @endphp
                                <div class="product-card-badge">
                                    -{{$discount_percent}}%
                                </div>
                            @endif

                            <!-- Product Actions -->
                            <div class="absolute inset-0 bg-black/20 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <div class="flex gap-3">
                                    <button class="w-12 h-12 bg-white text-gray-700 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors shadow-lg add-cart"
                                            data-id="{{$value->id}}"
                                            title="Tambah ke Keranjang">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <button class="w-12 h-12 bg-white text-gray-700 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors shadow-lg wish"
                                            data-id="{{$value->id}}"
                                            title="Tambah ke Wishlist">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="w-12 h-12 bg-white text-gray-700 rounded-full flex items-center justify-center hover:bg-blue-500 hover:text-white transition-colors shadow-lg"
                                            title="Quick View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="product-card-body">
                            <!-- Category Badge -->
                            @if(isset($value->category))
                                <div class="product-card-category">{{$value->category}}</div>
                            @endif

                            <h3 class="product-card-title">
                                <a href="javascript:void(0)" title="{{$value->nama}}">{{$value->nama}}</a>
                            </h3>

                            <div class="product-card-price">
                                @if ($value->harga_diskon > 0)
                                    <span class="product-card-price-current">Rp {{number_format($value->harga_diskon, 0, ',', '.')}}</span>
                                    <span class="product-card-price-original">Rp {{number_format($value->harga, 0, ',', '.')}}</span>
                                @else
                                    <span class="product-card-price-current">Rp {{number_format($value->harga, 0, ',', '.')}}</span>
                                @endif
                            </div>

                            @if ($value->info)
                                <p class="text-xs text-gray-500 mb-4">{{$value->info}}</p>
                            @endif

                            <div class="product-card-actions">
                                <button class="btn btn-primary flex-1 add-cart" data-id="{{$value->id}}">
                                    <i class="fas fa-cart-plus"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modern Pagination -->
            <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-6 rounded-xl shadow-sm">
                <div class="text-sm text-gray-600 mb-4 sm:mb-0 desktop-only">
                    Menampilkan {{$produk->firstItem()}}-{{$produk->lastItem()}} dari {{$produk->total()}} produk
                </div>

                <div class="flex items-center gap-2 mobile-pagination">
                    @if ($produk->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $produk->previousPageUrl() }}" class="px-3 py-2 text-gray-600 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($produk->getUrlRange(1, $produk->lastPage()) as $page => $url)
                        @if ($page == $produk->currentPage())
                            <span class="px-4 py-2 bg-primary text-white rounded-lg font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($produk->hasMorePages())
                        <a href="{{ $produk->nextPageUrl() }}" class="px-3 py-2 text-gray-600 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 bg-primary text-white rounded-full shadow-lg hover:bg-primary-hover transition-all transform translate-y-20 opacity-0">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Custom Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top functionality
    const backToTop = document.getElementById('back-to-top');

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('translate-y-20', 'opacity-0');
            backToTop.classList.add('translate-y-0', 'opacity-100');
        } else {
            backToTop.classList.add('translate-y-20', 'opacity-0');
            backToTop.classList.remove('translate-y-0', 'opacity-100');
        }
    });

    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Add to cart functionality
    document.querySelectorAll('.add-cart').forEach(function(button) {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');

            // Add loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';
            this.disabled = true;

            // Simulate add to cart (replace with actual AJAX call)
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check mr-2"></i>Berhasil Ditambah';
                this.classList.add('bg-success-color');

                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('bg-success-color');
                    this.disabled = false;
                }, 2000);
            }, 1000);
        });
    });

    // Wishlist functionality
    document.querySelectorAll('.wish').forEach(function(button) {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');

            // Toggle wishlist state
            const icon = this.querySelector('i');
            if (icon.classList.contains('fas')) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('hover:bg-red-500');
                this.classList.add('hover:bg-gray-100');
            } else {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.remove('hover:bg-gray-100');
                this.classList.add('hover:bg-red-500');
            }
        });
    });

    // Animate products on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card').forEach(function(card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
});
</script>

@endsection

@section('scriptjs')
<script src="{{asset('frontend/js/js/home.js')}}"></script>
<style>
    /* Additional custom styles for the modern shop page */
    .product-card {
        transition: all var(--transition-normal);
    }

    .product-card:hover {
        transform: translateY(-8px);
    }

    .product-card-image {
        position: relative;
        overflow: hidden;
    }

    .product-card-image img {
        transition: transform var(--transition-slow);
    }

    .product-card:hover .product-card-image img {
        transform: scale(1.1);
    }

    /* Loading animation for add to cart */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .loading {
        animation: pulse 1s infinite;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-100);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-hover);
    }
</style>
@endsection

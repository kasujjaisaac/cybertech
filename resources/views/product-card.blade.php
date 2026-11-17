@php
    [$image, $category, $label, $title, $subtitle, $service, $badge] = $product;
@endphp
<article class="product-card reveal {{ request()->routeIs('home') ? '' : 'product-card-text' }}" data-category="{{ $category }}">
    @if(request()->routeIs('home'))
    <div class="product-image {{ $category === 'access' ? 'image-photo' : '' }}">
        <span class="product-badge">{{ $badge }}</span>
        <img src="{{ asset('images/'.$image) }}" @if($category !== 'access') data-light-src="{{ asset('images/'.$image) }}" data-dark-src="{{ asset('images/'.pathinfo($image, PATHINFO_FILENAME).($image === 'hikvision-colorvu.jpg' ? '-transparent.svg' : '-transparent.png')) }}" @endif alt="{{ $title }}" width="600" height="600" loading="lazy">
        <a class="product-view-overlay" href="{{ route('products.show', $product['slug']) }}" aria-label="View {{ $title }}"></a>
        <a href="{{ route('contact', ['service' => $service, 'product' => $title]) }}" class="product-add" aria-label="Ask about {{ $title }}"><x-icon name="plus" :size="21" /></a>
    </div>
    @endif
    <div class="product-info">
        <span>{{ $label }}</span>
        <h3><a href="{{ route('products.show', $product['slug']) }}">{{ $title }}</a></h3>
        <p>{{ $subtitle }}</p>
        <a href="{{ route('products.show', $product['slug']) }}" class="product-enquire">View product details</a>
        @unless(request()->routeIs('home'))
        <a class="product-quick-enquiry" href="{{ route('contact', ['service' => $service, 'product' => $title]) }}">Enquire about this system</a>
        @endunless
    </div>
</article>

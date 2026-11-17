@extends('layout')

@section('content')
@php
    [$image, $category, $label, $title, $subtitle, $service, $badge] = $product;
@endphp
<section class="section container product-detail">
    <nav class="product-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('products') }}">Products</a><span aria-hidden="true">/</span><span aria-current="page">{{ $title }}</span></nav>
    <div class="product-detail-grid">
        @if($detailPhoto)
        <figure class="product-detail-image {{ $product['slug'] === 'dual-lens-solar-camera' ? '' : 'product-detail-photo' }}">
            <img src="{{ asset('images/'.$detailPhoto[0]) }}" @if($product['slug'] === 'dual-lens-solar-camera') data-light-src="{{ asset('images/solar-dual-lens.jpg') }}" data-dark-src="{{ asset('images/solar-dual-lens-transparent.png') }}" @endif alt="{{ $detailPhoto[1] }}" width="800" height="800" fetchpriority="high">
            <figcaption>{{ $detailPhoto[2] }}</figcaption>
        </figure>
        @else
        <div class="product-detail-illustration">
            <x-icon :name="$category === 'solar' ? 'sun' : 'fingerprint'" :size="72" />
            <span class="eyebrow">{{ $label }}</span>
            <h2>{{ $title }}</h2>
            <p>Find the configuration that fits your space.</p>
            <a class="text-link" href="{{ route('home') }}#collection">See the product collection</a>
        </div>
        @endif
        <div class="product-detail-copy">
            <div class="eyebrow red">{{ $label }}</div>
            <h2>At a glance.</h2>
            <p>{{ $subtitle }}</p>
            <dl class="product-specifications">
                @foreach($product['specifications'] as $attribute => $value)
                <div><dt>{{ $attribute }}</dt><dd>{{ $value }}</dd></div>
                @endforeach
            </dl>
            <p class="product-model-note">Exact model, connectivity, storage options and installation scope are confirmed with our team before purchase.</p>
            <div class="product-detail-actions">
                <a class="button" href="{{ route('contact', ['service' => $service, 'product' => $title]) }}">Ask about this product</a>
                <a class="button button-outline" href="https://wa.me/{{ $company['whatsapp'] }}?text={{ rawurlencode('Hello Cyber Tech! I would like to know more about the '.$title.'.') }}" target="_blank" rel="noopener">Chat on WhatsApp</a>
            </div>
            <span class="product-availability">Contact us for price and availability.</span>
        </div>
    </div>
</section>
@if($productPhotos)
<section class="section container product-context-section">
    <div class="section-heading"><div><div class="eyebrow red">A CLOSER LOOK</div><h2>From our showroom<br><span class="serif">to the real world.</span></h2></div><p>Examples of product demonstrations and installations. Equipment shown may differ from your selected configuration.</p></div>
    <div class="product-context-grid">
        @foreach($productPhotos as [$photo, $caption, $alt])
        <a class="context-photo" href="{{ asset('images/'.$photo) }}" data-gallery="{{ asset('images/'.$photo) }}" data-caption="{{ $caption }}" aria-label="View photo: {{ $caption }}"><img src="{{ asset('images/'.$photo) }}" alt="{{ $alt }}" width="1080" height="810" loading="lazy" decoding="async"><span>{{ $caption }}</span></a>
        @endforeach
    </div>
</section>
@endif
<section class="section container product-collection related-products">
    <div class="section-heading"><div><div class="eyebrow red">EXPLORE YOUR OPTIONS</div><h2>You may also like.</h2></div><a class="text-link" href="{{ route('products') }}">Browse all products</a></div>
    <div class="products-grid">
        @foreach($relatedProducts as $relatedProduct)
            @include('product-card', ['product' => $relatedProduct])
        @endforeach
    </div>
</section>
@endsection

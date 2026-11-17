    <section id="collection" class="section container product-collection">
        <div class="section-heading reveal"><div><div class="eyebrow red">THE TECHNOLOGY BEHIND YOUR PEACE OF MIND</div><h2>Our products.<br><span class="serif">Protection for your space.</span></h2></div><p>Browse our full collection of security systems.<br>Find your setup, then talk to our local team.</p></div>
        <div class="collection-toolbar"><div class="filter-tabs" role="group" aria-label="Filter products"><button class="is-active" data-filter="all" aria-pressed="true">All products <span>{{ count(config('products')) }}</span></button><button data-filter="solar" aria-pressed="false">Solar cameras</button><button data-filter="cctv" aria-pressed="false">CCTV systems</button><button data-filter="access" aria-pressed="false">Access & control</button></div><span class="collection-note">SELECTED FOR YOUR SPACE</span></div>
        <p class="sr-only" id="filter-status" aria-live="polite"></p>
        <div class="products-grid" id="products-grid">
            @foreach(config('products') as $product)
                @include('product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="collection-footer"><x-icon name="shield" :size="21" /><p>The right system starts with the right advice. <a href="{{ route('contact') }}">Let’s find your fit </a></p></div>
    </section>

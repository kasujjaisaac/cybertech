<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_have_valid_metadata_assets_and_internal_links(): void
    {
        $links = [];
        foreach (['home', 'solutions', 'products', 'work', 'about', 'contact', 'privacy'] as $page) {
            $response = $this->get(route($page))->assertOk();
            $document = new DOMDocument;
            @$document->loadHTML($response->getContent());
            $xpath = new DOMXPath($document);
            $this->assertSame(1, $xpath->query('//h1')->length, $page);
            $this->assertSame(1, $xpath->query('//main')->length, $page);
            $this->assertSame(route($page), $xpath->query('//link[@rel="canonical"]')->item(0)->getAttribute('href'));
            $this->assertNotEmpty($xpath->query('//meta[@name="description"]')->item(0)->getAttribute('content'));
            $schema = json_decode($xpath->query('//script[@type="application/ld+json"]')->item(0)->textContent, true, flags: JSON_THROW_ON_ERROR);
            $this->assertSame(config('company.name'), $schema['name']);
            $this->assertSame('https://schema.org', $schema['@context']);

            foreach ($xpath->query('//img[@src] | //script[@src] | //link[@rel="stylesheet"] | //link[@rel="icon"]') as $node) {
                foreach (['src', 'href', 'data-light-src', 'data-dark-src'] as $attribute) {
                    $url = $node->getAttribute($attribute);
                    if ($url === '' || parse_url($url, PHP_URL_HOST) !== parse_url(route('home'), PHP_URL_HOST)) {
                        continue;
                    }
                    $file = public_path(ltrim(parse_url($url, PHP_URL_PATH), '/'));
                    $this->assertFileExists($file, $url);
                    $this->assertGreaterThan(0, filesize($file), $url);
                }
            }
            foreach ($xpath->query('//a[@href]') as $link) {
                $url = $link->getAttribute('href');
                if (str_starts_with($url, route('home').'/') || $url === route('home')) {
                    if (str_starts_with(parse_url($url, PHP_URL_PATH) ?? '', '/images/')) {
                        continue;
                    }
                    $links[$url] = true;
                }
            }
        }
        foreach (array_keys($links) as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_sitemap_and_robots_reference_all_public_pages(): void
    {
        $response = $this->get(route('sitemap'))->assertOk();
        $document = new DOMDocument;
        $this->assertTrue($document->loadXML($response->getContent()));
        $this->assertSame(7 + count(config('products')), $document->getElementsByTagName('loc')->length);
        foreach (['home', 'solutions', 'products', 'work', 'about', 'contact', 'privacy'] as $page) {
            $response->assertSee(route($page), false);
        }
        $this->get(route('robots'))->assertOk()->assertSee('Sitemap: '.route('sitemap'), false);
    }

    public function test_missing_pages_show_the_branded_recovery_page(): void
    {
        $this->get('/this-page-does-not-exist')->assertNotFound()
            ->assertSee('Page not found')
            ->assertSee('Back to home')
            ->assertSee(route('products'));
    }

    public function test_contact_product_selection_is_rendered_without_javascript(): void
    {
        $this->get(route('contact', ['service' => 'Solar security', 'product' => 'Four-lens solar camera']))
            ->assertOk()
            ->assertSee('<option selected>Solar security</option>', false)
            ->assertSee('I would like to know more about the four-lens solar camera. My location is');
        $this->get(route('contact', ['service' => ['unexpected'], 'product' => ['unexpected']]))->assertOk();
        $this->get(route('contact', ['service' => 'Solar security', 'product' => '<script>alert(1)</script>']))
            ->assertOk()->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_catalog_count_and_names_come_from_the_same_config(): void
    {
        $products = config('products');
        $product = $products[0];
        $product[3] = 'Additional configured camera';
        $product['slug'] = 'additional-configured-camera';
        config(['products' => [...$products, $product]]);
        foreach (['home', 'products'] as $page) {
            $this->get(route($page))->assertOk()
                ->assertSee('All products <span>7</span>', false)
                ->assertSee('Additional configured camera');
        }
    }

    public function test_each_product_has_a_complete_detail_page_and_enquiry_handoff(): void
    {
        $slugs = [];
        foreach (config('products') as $product) {
            $slugs[] = $product['slug'];
            $response = $this->get(route('products.show', $product['slug']))->assertOk()
                ->assertSee('<h1>'.$product[3].'</h1>', false)
                ->assertSee($product['description'])
                ->assertSee('Ask about this product')
                ->assertSee(route('contact', ['service' => $product[5], 'product' => $product[3]]));
            foreach ($product['specifications'] as $attribute => $value) {
                $response->assertSee($attribute)->assertSee($value);
            }
            $document = new DOMDocument;
            @$document->loadHTML($response->getContent());
            $xpath = new DOMXPath($document);
            $this->assertSame(1, $xpath->query('//h1')->length);
            $this->assertSame(route('products'), $xpath->query('//nav[@id="main-nav"]/a[@aria-current="page"]')->item(0)->getAttribute('href'));
            $this->assertSame(3, $xpath->query('//section[contains(@class,"related-products")]//article')->length);
            $this->get(route('sitemap'))->assertSee(route('products.show', $product['slug']), false);
        }
        $this->assertSame(count($slugs), count(array_unique($slugs)));
    }

    public function test_missing_product_uses_the_branded_not_found_page(): void
    {
        $this->get(route('products.show', 'unknown-product'))->assertNotFound()->assertSee('Back to home');
    }

    public function test_about_page_shows_the_real_showroom_and_contact_links(): void
    {
        $this->get(route('about'))->assertOk()
            ->assertSee(asset('images/showroom.jpg'))
            ->assertSee(config('company.address'))
            ->assertSee('Contact us before travelling');
    }

    public function test_project_and_product_photo_galleries_use_existing_original_images(): void
    {
        $photos = config('gallery');
        $response = $this->get(route('work'))->assertOk();
        $document = new DOMDocument;
        @$document->loadHTML($response->getContent());
        $xpath = new DOMXPath($document);
        $this->assertSame(count($photos), $xpath->query('//a[@data-gallery]')->length);
        foreach ($photos as [$image, $category, $caption]) {
            $this->assertFileExists(public_path('images/'.$image));
            $response->assertSee($caption);
        }
        foreach (config('product-photos') as $slug => $gallery) {
            $response = $this->get(route('products.show', $slug))->assertOk();
            foreach ($gallery as [$image, $caption, $alt]) {
                $this->assertFileExists(public_path('images/'.$image));
                $this->assertNotEmpty($alt);
                $response->assertSee($caption)->assertSee('data-gallery="'.asset('images/'.$image).'"', false);
            }
            $response->assertSee('id="gallery-dialog"', false);
        }
        $this->get(route('home'))->assertDontSee('project-preview-grid', false);
        $this->get(route('about'))->assertSee('team-photo-grid', false);
        $this->get(route('contact'))->assertSee('contact-showroom', false);
    }

    public function test_every_supplied_photo_has_one_unique_website_placement(): void
    {
        $placements = config('photo-placements');
        $all = array_merge(...array_values($placements));
        $this->assertCount(30, $all);
        $this->assertCount(30, array_unique($all));
        $this->assertCount(30, array_unique(array_map(fn (string $photo): string => hash_file('sha256', public_path('images/'.$photo)), $all)));
        $pages = [...$placements, 'products' => [], 'privacy' => [], 'products.show:smarter-access-solutions' => []];
        $actual = [];
        foreach ($pages as $destination => $expected) {
            $parts = explode(':', $destination, 2);
            $url = isset($parts[1]) ? route($parts[0], $parts[1]) : route($parts[0]);
            $response = $this->get($url)->assertOk();
            $document = new DOMDocument;
            @$document->loadHTML($response->getContent());
            $found = [];
            foreach ($document->getElementsByTagName('img') as $image) {
                $file = basename(parse_url($image->getAttribute('src'), PHP_URL_PATH) ?? '');
                if ($file === '' || str_starts_with($file, 'logo-')) {
                    continue;
                }
                $found[] = $file;
            }
            sort($found);
            sort($expected);
            $this->assertSame($expected, $found, $destination);
            array_push($actual, ...$found);
        }
        $this->assertCount(30, $actual);
        $this->assertCount(30, array_unique($actual));
    }

    public function test_fonts_are_self_hosted_and_available(): void
    {
        $css = file_get_contents(public_path('css/fonts.css'));
        $this->assertStringNotContainsString('fonts.googleapis.com', $css);
        preg_match_all("/url\\('([^']+)'\\)/", $css, $matches);
        $this->assertCount(6, $matches[1]);
        foreach ($matches[1] as $font) {
            $file = public_path('css/'.$font);
            $this->assertFileExists($file);
            $this->assertGreaterThan(0, filesize($file));
        }
        $this->assertFileExists(public_path('fonts/poppins-LICENSE.txt'));
    }

    public function test_phone_number_requires_between_seven_and_fifteen_digits(): void
    {
        foreach (['-------', '+++++++', '123456', '+2561234567890123456'] as $phone) {
            $this->postJson(route('inquiries.store'), [
                'name' => 'Audit test', 'phone' => $phone, 'service' => 'Solar security',
                'property_type' => 'Home', 'message' => 'Please advise on a suitable camera.', 'consent' => '1',
            ])->assertUnprocessable()->assertJsonValidationErrors('phone');
        }
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_enquiry_validation_is_escaped_and_exposed_to_assistive_technology(): void
    {
        $this->withSession(['_old_input' => ['name' => '<script>alert(1)</script>']])
            ->get(route('contact'))->assertOk()
            ->assertDontSee('value="<script>alert(1)</script>"', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
        $this->post(route('inquiries.store'), [])->assertRedirect(route('contact'));
        $this->get(route('contact'))->assertOk()
            ->assertSee('id="inquiry-errors"', false)
            ->assertSee('aria-describedby="inquiry-errors"', false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_company_details_and_links_to_dedicated_pages(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('A safer space.')
            ->assertSee('Explore solutions')
            ->assertSee('Four-lens solar camera')
            ->assertSee('Dual-lens solar camera')
            ->assertSee('Hikvision ColorVu CCTV')
            ->assertSee('Three-lens solar camera')
            ->assertSee('Complete CCTV systems')
            ->assertSee('Smarter access solutions')
            ->assertSee(route('solutions'))
            ->assertSee(route('products'))
            ->assertDontSee('id="inquiry-form"', false)
            ->assertSee('info@cybertech.com')
            ->assertSee('https://wa.me/256759988380')
            ->assertSee('City View Building');
    }

    public function test_dedicated_pages_render_their_own_content_and_shared_navigation(): void
    {
        foreach ([
            'solutions' => ['Security solutions', 'CCTV surveillance'],
            'products' => ['Our products', 'id="products-grid"'],
            'work' => ['Our work', 'data-gallery='],
            'about' => ['About Cyber Tech', 'Closer to home.'],
            'contact' => ['Contact our team', 'id="inquiry-form"'],
        ] as $page => [$heading, $content]) {
            $response = $this->get(route($page));
            $response->assertOk()
                ->assertSee('<h1>'.$heading.'</h1>', false)
                ->assertSee($content, false)
                ->assertSee('aria-current="page"', false)
                ->assertSee('data-theme-option="system"', false)
                ->assertDontSee('href="#solutions"', false)
                ->assertDontSee('href="#collection"', false)
                ->assertDontSee('href="#contact"', false);

            if ($page !== 'contact') {
                $response->assertDontSee('id="inquiry-form"', false);
            }
        }
    }

    public function test_product_enquiry_links_include_product_and_service(): void
    {
        $this->get(route('products'))
            ->assertOk()
            ->assertSee(route('contact', ['service' => 'Solar security', 'product' => 'Four-lens solar camera']));
    }

    public function test_contact_validation_returns_to_contact_and_preserves_input(): void
    {
        $this->from(route('contact'))
            ->post(route('inquiries.store'), [...$this->enquiry(), 'phone' => 'invalid'])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors('phone')
            ->assertSessionHasInput('service', 'Solar security');
    }

    public function test_valid_enquiry_is_saved_and_confirmation_is_shown(): void
    {
        $this->post(route('inquiries.store'), $this->enquiry())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('inquiry_sent', true);

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Website Test',
            'phone' => '+256700000000',
            'service' => 'Solar security',
        ]);

        $this->get(route('contact'))->assertOk()->assertSee('REQUEST RECEIVED');
    }

    public function test_invalid_submission_cannot_be_saved(): void
    {
        $this->post(route('inquiries.store'), [
            ...$this->enquiry(),
            'phone' => 'not-a-phone',
            'service' => 'unknown service',
            'message' => 'short',
            'consent' => '0',
        ])->assertSessionHasErrors(['phone', 'service', 'message', 'consent']);

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_email_is_optional_and_an_invalid_email_is_rejected(): void
    {
        $this->post(route('inquiries.store'), [...$this->enquiry(), 'email' => null])
            ->assertSessionHasNoErrors();

        $this->post(route('inquiries.store'), [...$this->enquiry(), 'email' => 'invalid'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('inquiries', 1);
    }

    public function test_honeypot_rejects_automated_submissions(): void
    {
        $this->post(route('inquiries.store'), [...$this->enquiry(), 'website' => 'https://spam.example'])
            ->assertSessionHasErrors('website');

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_enquiries_are_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('inquiries.store'), $this->enquiry())->assertRedirect();
        }

        $this->post(route('inquiries.store'), $this->enquiry())->assertStatus(429)->assertSee('Please try again shortly');
        $this->assertDatabaseCount('inquiries', 5);
    }

    /** @return array<string, string> */
    private function enquiry(): array
    {
        return [
            'name' => 'Website Test',
            'phone' => '+256700000000',
            'email' => 'website-test@example.com',
            'service' => 'Solar security',
            'property_type' => 'Home',
            'message' => 'Please advise on solar camera coverage for a home in Masaka.',
            'consent' => '1',
            'website' => '',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'company' => config('company'),
            'pageTitle' => 'Proactive security for your space',
            'pageDescription' => 'CCTV, solar security cameras, access control, alarms and vehicle tracking. Professional installation and support in Masaka City, Uganda.',
        ]);
    }

    public function page(string $page): View
    {
        $pages = [
            'solutions' => ['Security solutions', 'Protection for your home, business, farm and vehicles. Find a security solution that fits your space.'],
            'products' => ['Our products', 'Explore solar cameras, CCTV systems and access control equipment. Ask our local team for help choosing your setup.'],
            'work' => ['Our work', 'Explore security installations and monitoring systems, with a closer look at our team at work.'],
            'about' => ['About Cyber Tech', 'Meet your local security technology team in Masaka City. Thoughtful advice, professional installation and ongoing support.'],
            'privacy' => ['Privacy', 'How Cyber Tech handles enquiry information, browser preferences and third-party links.'],
            'contact' => ['Contact our team', 'Tell us about your space, ask a question or request advice on your next security installation.'],
        ];

        abort_unless(isset($pages[$page]), 404);

        $selectedService = request()->query('service');
        if (! is_string($selectedService) || ! in_array($selectedService, config('company.services'), true)) {
            $selectedService = '';
        }
        $selectedProduct = request()->query('product');
        $prefilledMessage = '';
        foreach (config('products') as $product) {
            if ($product[3] === $selectedProduct && $product[5] === $selectedService) {
                $prefilledMessage = 'I would like to know more about the '.strtolower($selectedProduct).'. My location is ';
                break;
            }
        }

        return view($page, [
            'company' => config('company'),
            'selectedService' => $selectedService,
            'prefilledMessage' => $prefilledMessage,
            'pageTitle' => $pages[$page][0],
            'pageDescription' => $pages[$page][1],
        ]);
    }

    public function product(string $slug): View
    {
        $products = collect(config('products'));
        $product = $products->firstWhere('slug', $slug);
        abort_unless($product, 404);

        $detailPhotos = [
            'four-lens-solar-camera' => ['solar-assembly-detail.jpg', 'Solar camera equipment prepared for installation', 'Installation example'],
            'dual-lens-solar-camera' => ['solar-dual-lens.jpg', 'A white dual-lens solar camera with its packaging', 'Dual-lens camera option'],
            'hikvision-colorvu-cctv' => ['hikvision-installed.jpg', 'An installed Hikvision security camera', 'Installation example'],
            'complete-cctv-systems' => ['monitoring-installation-wide.jpg', 'An installed multi-camera monitoring screen', 'Monitoring example'],
        ];

        return view('product', [
            'company' => config('company'),
            'product' => $product,
            'detailPhoto' => $detailPhotos[$slug] ?? null,
            'productPhotos' => config('product-photos.'.$slug, []),
            'pageTitle' => $product[3],
            'pageDescription' => $product['description'],
            'pageImage' => asset('images/'.$product[0]),
            'relatedProducts' => $products->filter(fn (array $item): bool => $item['slug'] !== $slug)->sortBy(fn (array $item): int => $item[1] === $product[1] ? 0 : 1)->take(3),
        ]);
    }

    public function sitemap(): Response
    {
        return response()->view('sitemap', [
            'urls' => [
                ...array_map(fn (string $page): string => route($page), ['home', 'solutions', 'products', 'work', 'about', 'contact', 'privacy']),
                ...array_map(fn (array $product): string => route('products.show', $product['slug']), config('products')),
            ],
        ])->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\nSitemap: ".route('sitemap')."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'phone', 'email', 'service', 'property_type', 'message']);

        DB::table('inquiries')->insert([
            ...$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('contact'))->with('inquiry_sent', true);
    }
}

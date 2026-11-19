<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::firstOrCreate(
            ['email' => 'team@digiprosoft.local'],
            ['name' => 'DigiProSoft Team', 'password' => Str::password(40)],
        );

        $cat = fn (string $slug) => Category::where('type', Category::TYPE_POST)->where('slug', $slug)->value('id');

        $posts = [
            [
                'category' => 'pharmacy',
                'title' => 'How Pharmacy Management Software Helps Reduce Inventory Problems',
                'slug' => 'pharmacy-management-software-reduce-inventory-problems',
                'excerpt' => 'Expired stock, stock-outs and unreliable profit figures are structural problems in pharmacies. Here is how batch-level software solves them in practice.',
                'featured_image' => '/images/illustrations/blog-pharmacy.svg',
                'featured_image_alt' => 'Illustration of pharmacy shelves with medicine boxes and an expiry calendar',
                'seo_title' => 'How Pharmacy Management Software Reduces Inventory Problems',
                'seo_description' => 'Learn how pharmacy management software tackles expiry losses, stock-outs, unit conversion and supplier dues — and what to look for when choosing a system for your medicine shop.',
                'tags' => ['Pharmacy', 'Inventory', 'Business Software'],
                'products' => ['pharmacy-management-system'],
                'services' => ['custom-software-development'],
                'published_at' => now()->subDays(6),
                'is_featured' => true,
            ],
            [
                'category' => 'hospitality',
                'title' => 'Hotel Management Software: Features Every Modern Hotel Needs',
                'slug' => 'hotel-management-software-features-every-modern-hotel-needs',
                'excerpt' => 'From the reservation calendar to direct website bookings — the core features an independent hotel or guest house actually needs, and the ones that can wait.',
                'featured_image' => '/images/illustrations/blog-hotel.svg',
                'featured_image_alt' => 'Illustration of a hotel front desk with a reservation calendar on screen',
                'seo_title' => 'Hotel Management Software: Features Every Modern Hotel Needs',
                'seo_description' => 'A practical guide to the hotel management software features independent hotels, guest houses and resorts need: reservations, folios, housekeeping, reports and direct bookings.',
                'tags' => ['Hotel', 'Hospitality', 'Business Software'],
                'products' => ['hotel-management-system'],
                'services' => ['web-development'],
                'published_at' => now()->subDays(13),
                'is_featured' => false,
            ],
            [
                'category' => 'retail-pos',
                'title' => 'How POS Software Can Improve Retail Business Operations',
                'slug' => 'how-pos-software-improves-retail-operations',
                'excerpt' => 'A POS is bought for faster billing, but its real value is accurate stock, real profit figures, supplier control and customer history. Here is what changes.',
                'featured_image' => '/images/illustrations/blog-pos.svg',
                'featured_image_alt' => 'Illustration of a retail counter with a barcode scanner and receipt printer',
                'seo_title' => 'How POS Software Improves Retail Business Operations',
                'seo_description' => 'Beyond faster billing: how POS software improves inventory accuracy, profit visibility, supplier control, customer retention and multi-outlet management for shops in Bangladesh.',
                'tags' => ['POS', 'Retail', 'Inventory'],
                'products' => ['pos-system', 'ecommerce-platform'],
                'services' => ['business-automation'],
                'published_at' => now()->subDays(20),
                'is_featured' => false,
            ],
            [
                'category' => 'business-software',
                'title' => 'Custom Software vs Ready-Made Software: What Should a Business Choose?',
                'slug' => 'custom-software-vs-ready-made-software',
                'excerpt' => 'Buy or build? A practical framework for deciding between off-the-shelf products and custom development — and why the best answer is often both.',
                'featured_image' => '/images/illustrations/blog-custom-vs-ready.svg',
                'featured_image_alt' => 'Illustration comparing a boxed software product with a custom-built system blueprint',
                'seo_title' => 'Custom Software vs Ready-Made Software: What Should a Business Choose?',
                'seo_description' => 'Compare custom software and ready-made products on cost, speed, fit and ownership. A decision framework and vendor questions for businesses in Bangladesh.',
                'tags' => ['Custom Software', 'Business Software', 'Strategy'],
                'products' => ['custom-business-software'],
                'services' => ['custom-software-development', 'software-maintenance'],
                'published_at' => now()->subDays(27),
                'is_featured' => false,
            ],
            [
                'category' => 'digital-transformation',
                'title' => 'How Customer Data Helps Businesses Improve Retention',
                'slug' => 'how-customer-data-helps-businesses-improve-retention',
                'excerpt' => 'The data needed to keep customers is usually already in your POS or online store. Here is which data matters, how to collect it responsibly and what to do with it.',
                'featured_image' => '/images/illustrations/blog-customer-data.svg',
                'featured_image_alt' => 'Illustration of customer profiles connected to purchase history charts',
                'seo_title' => 'How Customer Data Helps Businesses Improve Retention',
                'seo_description' => 'Use purchase history and customer records from your POS, store or booking system to spot best customers, win back lapsed ones and communicate with relevance.',
                'tags' => ['Customer Retention', 'Data', 'Digital Transformation'],
                'products' => ['pos-system', 'ecommerce-platform', 'hotel-management-system'],
                'services' => ['business-automation', 'api-development'],
                'published_at' => now()->subDays(34),
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $data) {
            $content = file_get_contents(__DIR__.'/content/posts/'.$data['slug'].'.html');

            $tags = $data['tags'];
            $productSlugs = $data['products'];
            $serviceSlugs = $data['services'];
            $categorySlug = $data['category'];
            unset($data['tags'], $data['products'], $data['services'], $data['category']);

            $post = Post::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    ...$data,
                    'content' => $content,
                    'category_id' => $cat($categorySlug),
                    'user_id' => $author->id,
                    'is_active' => true,
                ],
            );

            $tagIds = collect($tags)->map(fn ($name) => Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id);
            $post->tags()->sync($tagIds);
            $post->products()->sync(Product::whereIn('slug', $productSlugs)->pluck('id'));
            $post->services()->sync(Service::whereIn('slug', $serviceSlugs)->pluck('id'));
        }
    }
}

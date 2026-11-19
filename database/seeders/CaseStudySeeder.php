<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Portfolio entries are product-based project showcases. They describe the
 * problem space, the solution DigiProSoft built and the technology used.
 * Client names and measured outcomes are intentionally omitted unless the
 * client has approved publication (set `outcome` / `client_type` then).
 */
class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $slug) => Category::where('type', Category::TYPE_CASE_STUDY)->where('slug', $slug)->value('id');
        $product = fn (string $slug) => Product::where('slug', $slug)->value('id');

        $studies = [
            [
                'category_id' => $cat('product-implementation'),
                'product_id' => $product('pharmacy-management-system'),
                'title' => 'SoftoPharma: Pharmacy Management for Retail Medicine Shops',
                'slug' => 'pharmacy-management-system-for-retail-pharmacies',
                'client_type' => 'Retail pharmacies',
                'industry' => 'Pharmacy',
                'summary' => 'Building SoftoPharma — DigiProSoft’s batch-aware pharmacy platform that keeps the counter fast while tracking expiry, supplier dues and real profit.',
                'problem' => "Independent pharmacies in Bangladesh typically manage several thousand SKUs with multiple batches and expiry dates each, sold in boxes, strips and single units. Existing tools were either generic shop software with no batch concept, or spreadsheets maintained after closing time.\n\nThe core challenges were speed at the counter, accurate expiry visibility and a trustworthy daily profit figure.",
                'solution' => "We designed SoftoPharma around a keyboard-first pharmacy POS with search by brand and generic name and unit conversion built in, so a sale takes seconds. Behind it, inventory is stored at batch level; the system helps surface earlier-expiring stock first and keeps expiry status visible.\n\nPurchases, returns and supplier payments feed a dues ledger, and reports show sales, stock, purchases and performance. Roles separate owner, manager and counter staff, with multi-branch support on eligible plans. The live product is at softopharma.digiprosoft.com.",
                'features' => [
                    'Keyboard-first billing with brand/generic search',
                    'Box → strip → unit conversion with per-unit pricing',
                    'Batch-level inventory with FEFO suggestion',
                    'Expiry alerts and return-to-supplier workflow',
                    'Supplier dues ledger and customer credit sales',
                    'Item-wise profit, stock valuation and slow-mover reports',
                    'Owner, manager and counter roles with audit trail',
                    'Local-server or cloud deployment options',
                ],
                'technologies' => ['Laravel', 'MySQL', 'Vue.js', 'Tailwind CSS', 'Thermal receipt printing'],
                'screenshots' => [
                    ['src' => '/images/illustrations/dashboard-pharmacy.svg', 'alt' => 'Illustration of the pharmacy dashboard with expiry and low-stock alerts', 'caption' => 'Owner dashboard'],
                    ['src' => '/images/illustrations/screen-pos.svg', 'alt' => 'Illustration of the counter billing screen', 'caption' => 'Counter billing'],
                ],
                'featured_image' => '/images/illustrations/dashboard-pharmacy.svg',
                'featured_image_alt' => 'Illustration of the pharmacy management dashboard',
                'is_featured' => true,
                'sort_order' => 1,
                'seo_title' => 'Case Study: SoftoPharma Pharmacy Management Software | DigiProSoft',
                'seo_description' => 'How DigiProSoft built SoftoPharma — pharmacy POS, batch and expiry tracking, supplier dues and reporting for medicine shops in Bangladesh.',
                'services' => ['custom-software-development', 'business-automation'],
            ],
            [
                'category_id' => $cat('product-implementation'),
                'product_id' => $product('hotel-management-system'),
                'title' => 'Hotel Management System for Independent Hotels',
                'slug' => 'hotel-management-system-for-independent-hotels',
                'client_type' => 'Hotels and guest houses',
                'industry' => 'Hospitality',
                'summary' => 'A front-desk, housekeeping and billing system that gives small and mid-sized properties one live view of rooms and revenue.',
                'problem' => 'Independent hotels often coordinate reservations from phone, walk-ins and online agents through a paper register. Housekeeping status is communicated verbally, extra services are added to bills from memory and management reporting is compiled at month end.',
                'solution' => 'The system centres on a drag-and-drop room calendar that prevents double bookings and shows availability by room type and rate plan. Each stay has a folio where room charges, restaurant orders and services post automatically. Housekeeping staff update room status from a phone, and the front desk sees clean/dirty/inspected states live. Management dashboards show occupancy, revenue by source and outstanding balances.',
                'features' => [
                    'Visual reservation calendar with rate plans and advances',
                    'Check-in/out with guest ID capture and printed invoices',
                    'Guest folios with restaurant, laundry and service posting',
                    'Mobile housekeeping status updates',
                    'Night audit and occupancy/ADR reporting',
                    'Website booking form integration',
                    'Role-based access for reception, housekeeping and accounts',
                ],
                'technologies' => ['Laravel', 'MySQL', 'Vue.js', 'Tailwind CSS', 'REST APIs'],
                'screenshots' => [
                    ['src' => '/images/illustrations/dashboard-hotel.svg', 'alt' => 'Illustration of the hotel reservation calendar', 'caption' => 'Reservation calendar'],
                ],
                'featured_image' => '/images/illustrations/dashboard-hotel.svg',
                'featured_image_alt' => 'Illustration of the hotel reservation calendar',
                'is_featured' => true,
                'sort_order' => 2,
                'seo_title' => 'Case Study: Hotel Management System for Independent Hotels | DigiProSoft',
                'seo_description' => 'How DigiProSoft built a hotel management system with a live reservation calendar, guest folios, housekeeping updates and occupancy reporting for hotels in Bangladesh.',
                'services' => ['custom-software-development', 'web-development'],
            ],
            [
                'category_id' => $cat('product-implementation'),
                'product_id' => $product('ecommerce-platform'),
                'title' => 'Mobile-First E-commerce Platform with Local Payments',
                'slug' => 'mobile-first-ecommerce-platform-bangladesh',
                'client_type' => 'Online retailers and brands',
                'industry' => 'E-commerce',
                'summary' => 'An online store platform built around how customers in Bangladesh actually shop: on mobile, with cash on delivery and mobile financial services.',
                'problem' => 'Retailers moving beyond social-media selling needed a store that loads fast on mid-range phones, supports cash on delivery alongside bKash, Nagad and cards, and manages the courier workflow that follows every order. Generic platforms required heavy customisation to fit these realities.',
                'solution' => 'We built a storefront optimised for mobile browsing and a short checkout, integrated local payment gateways and courier services, and designed an admin panel that follows the real order lifecycle: confirm → pack → book courier → deliver → reconcile payment. Product pages emit structured data and clean URLs so they can rank in search.',
                'features' => [
                    'Mobile-first storefront with fast search and filters',
                    'Cash on delivery, bKash, Nagad, Rocket and card payments',
                    'Courier booking and delivery status tracking',
                    'Order confirmation workflow to reduce failed deliveries',
                    'Product variants, bundles and bulk import',
                    'Coupons, flash sales and campaign pages',
                    'SEO structure with product schema and sitemaps',
                    'Optional POS inventory synchronisation',
                ],
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'SSLCommerz', 'Meilisearch', 'Cloudflare'],
                'screenshots' => [
                    ['src' => '/images/illustrations/screen-ecommerce.svg', 'alt' => 'Illustration of the e-commerce storefront on mobile and desktop', 'caption' => 'Storefront'],
                ],
                'featured_image' => '/images/illustrations/screen-ecommerce.svg',
                'featured_image_alt' => 'Illustration of the e-commerce storefront',
                'is_featured' => true,
                'sort_order' => 3,
                'seo_title' => 'Case Study: Mobile-First E-commerce Platform for Bangladesh | DigiProSoft',
                'seo_description' => 'How DigiProSoft designed a mobile-first e-commerce platform with local payments, courier workflow and SEO-ready product pages for online retailers in Bangladesh.',
                'services' => ['ecommerce-development', 'api-development'],
            ],
            [
                'category_id' => $cat('product-implementation'),
                'product_id' => $product('school-management-system'),
                'title' => 'School Management System with Parent SMS Communication',
                'slug' => 'school-management-system-with-parent-sms',
                'client_type' => 'Schools and colleges',
                'industry' => 'Education',
                'summary' => 'Digitising admissions, attendance, fees and results for schools, with automatic SMS to keep parents informed.',
                'problem' => 'School offices handled admissions, fee receipts, attendance registers and result sheets on paper. Fee dues were hard to track, result processing took weeks, and parents were rarely informed proactively.',
                'solution' => 'A single student profile connects admission data, guardians, fees, attendance and results. Fee structures generate invoices with receipts and due lists; teachers enter marks once and report cards are produced automatically according to configurable grading rules. Event-based SMS informs parents about absences, dues and published results.',
                'features' => [
                    'Admissions with student IDs and guardian details',
                    'Class routines and daily attendance with absence SMS',
                    'Fee structures, invoices, partial payments and due lists',
                    'Exam setup, mark entry, grading and report cards',
                    'Bulk and event-based SMS to parents',
                    'Bangla and English documents',
                    'Multi-campus and shift support',
                ],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'SMS gateway integration', 'PDF generation'],
                'screenshots' => [
                    ['src' => '/images/illustrations/dashboard-school.svg', 'alt' => 'Illustration of the school administration dashboard', 'caption' => 'Administration dashboard'],
                ],
                'featured_image' => '/images/illustrations/dashboard-school.svg',
                'featured_image_alt' => 'Illustration of the school administration dashboard',
                'is_featured' => false,
                'sort_order' => 4,
                'seo_title' => 'Case Study: School Management System with Parent SMS | DigiProSoft',
                'seo_description' => 'How DigiProSoft built a school management system covering admissions, attendance, fees, exams and parent SMS communication for schools in Bangladesh.',
                'services' => ['custom-software-development', 'business-automation'],
            ],
        ];

        foreach ($studies as $data) {
            $serviceSlugs = $data['services'];
            unset($data['services']);

            $study = CaseStudy::updateOrCreate(
                ['slug' => $data['slug']],
                [...$data, 'is_active' => true, 'published_at' => now()->subDays(20)],
            );

            $study->services()->sync(Service::whereIn('slug', $serviceSlugs)->pluck('id'));
        }
    }
}

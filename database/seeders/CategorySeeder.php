<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Products
            [Category::TYPE_PRODUCT, 'Business Management', 'business-management', 'Ready-to-deploy systems that run day-to-day operations for a specific type of business.', 1],
            [Category::TYPE_PRODUCT, 'Retail & Commerce', 'retail-commerce', 'Selling tools for physical shops and online stores.', 2],
            [Category::TYPE_PRODUCT, 'Custom Solutions', 'custom-solutions', 'Software designed around a specific organisation.', 3],

            // Services
            [Category::TYPE_SERVICE, 'Development', 'development', 'Design and build of new software.', 1],
            [Category::TYPE_SERVICE, 'Integration & Automation', 'integration-automation', 'Connecting systems and removing manual work.', 2],
            [Category::TYPE_SERVICE, 'Support', 'support', 'Keeping software secure, fast and up to date.', 3],

            // Case studies
            [Category::TYPE_CASE_STUDY, 'Product Implementation', 'product-implementation', null, 1],
            [Category::TYPE_CASE_STUDY, 'Custom Development', 'custom-development', null, 2],

            // Blog
            [Category::TYPE_POST, 'Business Software', 'business-software', 'Guides on choosing and using software to run a business.', 1],
            [Category::TYPE_POST, 'Pharmacy', 'pharmacy', null, 2],
            [Category::TYPE_POST, 'Hospitality', 'hospitality', null, 3],
            [Category::TYPE_POST, 'Retail & POS', 'retail-pos', null, 4],
            [Category::TYPE_POST, 'Digital Transformation', 'digital-transformation', null, 5],
        ];

        foreach ($categories as [$type, $name, $slug, $description, $order]) {
            Category::updateOrCreate(
                ['type' => $type, 'slug' => $slug],
                ['name' => $name, 'description' => $description, 'sort_order' => $order],
            );
        }
    }
}

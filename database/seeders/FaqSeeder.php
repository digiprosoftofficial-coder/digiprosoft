<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            ['general', 'What does DigiProSoft do?', 'DigiProSoft is a software development company in Dhaka, Bangladesh. We build ready-to-deploy business management products — pharmacy, hotel, school, POS and e-commerce systems — and develop custom software, websites, APIs, SaaS products and business automation for organisations that need something tailored.'],
            ['general', 'Who are your typical clients?', 'Small and medium businesses in Bangladesh: pharmacies, hotels and guest houses, schools, retail shops and restaurants, online brands, distributors and service companies. We also work with organisations abroad that need a reliable development partner.'],
            ['general', 'Where are you located and do you work remotely?', 'We are based in Dhaka. We meet clients in person in Dhaka and work with clients across Bangladesh and internationally through video calls, email and WhatsApp.'],
            ['general', 'How do I get started?', 'Use the [contact form](/contact) or WhatsApp to tell us about your business and what you want to improve. We arrange a free consultation, then send a written proposal with scope, timeline and pricing.'],
            ['general', 'Do you sign NDAs and contracts?', 'Yes. We sign non-disclosure agreements on request and every project has a written agreement covering scope, deliverables, payment schedule and ownership.'],
            ['general', 'Which technologies do you use?', 'Primarily Laravel and PHP on the backend, MySQL or PostgreSQL databases, and Vue.js or lightweight JavaScript with Tailwind CSS on the frontend. We choose tools that are well supported and easy to maintain, and we explain our choices.'],

            // Products
            ['products', 'Are your products ready to use or built from scratch each time?', 'Our products are ready-to-deploy systems that we configure for your business: your items, rates, users, receipt formats and reports. Customisation beyond configuration is available when needed.'],
            ['products', 'Can a product be customised for my business?', 'Yes. Most clients only need configuration, but we can add modules, reports or integrations specific to your operation as a scoped enhancement.'],
            ['products', 'Do the products run offline?', 'Products such as the POS and Pharmacy systems can be deployed on a local computer or server so billing continues during internet outages, with optional cloud sync. Cloud-only deployment is also available.'],
            ['products', 'Is training included?', 'Yes. Every deployment includes hands-on training for your team and written guides. Additional sessions can be arranged when staff change.'],

            // Services
            ['services', 'How long does a custom software project take?', 'A focused first version usually takes a few weeks to a few months depending on scope. We deliver in stages so you can start using core features early rather than waiting for everything at once.'],
            ['services', 'Will I own the source code?', 'Yes. For custom development you receive the complete source code, database and documentation. You can host the software on your own server or cloud account.'],
            ['services', 'Can you take over software built by someone else?', 'Often, yes. We review the existing Laravel/PHP codebase, hosting and security, then recommend whether to maintain, refactor or rebuild. See [software maintenance](/services/software-maintenance).'],
            ['services', 'Do you build mobile apps?', 'We build mobile-friendly web applications for most needs and native or cross-platform mobile apps together with secure API backends when a dedicated app is justified.'],

            // Pricing
            ['pricing', 'How is pricing calculated?', 'Products are priced per deployment with optional annual support. Custom development is quoted after a requirement discussion — either a fixed price for a defined scope or a phased plan for larger systems. You always receive a written quote before work starts.'],
            ['pricing', 'Do you require advance payment?', 'Projects follow a milestone-based payment schedule agreed in the contract, typically starting with an advance to begin work. Product deployments are usually paid on delivery and training.'],
            ['pricing', 'Are there hidden or recurring charges?', 'No hidden charges. Recurring costs are limited to optional support plans and third-party services you use directly, such as hosting, SMS credits or payment gateway fees.'],
            ['pricing', 'Do you offer a free consultation?', 'Yes. The initial consultation and proposal are free and without obligation.'],

            // Support
            ['support', 'What support do you provide after launch?', 'Every project includes a warranty period for fixes. After that, support plans cover updates, monitoring, backups, bug fixes and a monthly allocation of improvement hours with defined response times.'],
            ['support', 'How do I report a problem?', 'Support clients reach us by phone, WhatsApp and email during business hours, with an agreed escalation path for critical issues.'],
            ['support', 'Do you handle hosting and backups?', 'Yes. We set up hosting on your own account, configure SSL, monitoring and automated backups, and manage them under a maintenance plan if you prefer not to.'],
        ];

        foreach ($faqs as $i => [$group, $question, $answer]) {
            Faq::updateOrCreate(
                ['group' => $group, 'question' => $question],
                ['answer' => $answer, 'sort_order' => $i + 1, 'is_active' => true],
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $slug) => Category::where('type', Category::TYPE_SERVICE)->where('slug', $slug)->value('id');

        $process = [
            ['step' => 1, 'title' => 'Discovery', 'description' => 'We learn how your business works, what problem needs solving and what success looks like.'],
            ['step' => 2, 'title' => 'Scope & proposal', 'description' => 'You receive a clear scope, timeline and fixed or phased pricing before any work begins.'],
            ['step' => 3, 'title' => 'Design', 'description' => 'Screens and data flows are designed and reviewed with you so there are no surprises.'],
            ['step' => 4, 'title' => 'Build in stages', 'description' => 'Working software is delivered in increments; you test and give feedback early.'],
            ['step' => 5, 'title' => 'Launch & training', 'description' => 'Deployment, data migration, staff training and documentation.'],
            ['step' => 6, 'title' => 'Support', 'description' => 'Ongoing maintenance, monitoring and improvements under a support plan.'],
        ];

        $services = [
            [
                'category_id' => $cat('development'),
                'name' => 'Custom Software Development',
                'slug' => 'custom-software-development',
                'tagline' => 'Systems built around your processes',
                'icon' => 'code',
                'sort_order' => 1,
                'is_featured' => true,
                'short_description' => 'Design and development of management systems, ERPs, portals and internal tools tailored to your organisation, with full source code ownership.',
                'description' => "DigiProSoft is a custom software development company based in Dhaka, Bangladesh. We build software for organisations whose needs are not met by ready-made products — from inventory and distribution systems to HR, CRM, accounting and industry-specific management platforms.\n\nOur approach is practical: understand the real workflow, deliver working software in stages, and hand over a system your team actually uses.",
                'problem' => 'Generic software forces workarounds. Data lives in disconnected spreadsheets, approvals happen over phone calls and management reports are compiled by hand. As the business grows, the gaps grow with it.',
                'solution' => 'We design software around your operations: the right data model, roles, workflows and reports. The system is built on a modern, maintainable stack, integrated with the tools you already use, and delivered with documentation and training.',
                'features' => [
                    ['icon' => 'compass', 'title' => 'Requirement analysis & process mapping', 'description' => 'Workshops with your team to capture how work really happens.'],
                    ['icon' => 'layers', 'title' => 'ERP & management systems', 'description' => 'Inventory, sales, purchase, accounts, HR and production modules.'],
                    ['icon' => 'users', 'title' => 'Portals & CRMs', 'description' => 'Customer, dealer, vendor and employee portals with role-based access.'],
                    ['icon' => 'chart', 'title' => 'Dashboards & reporting', 'description' => 'KPI dashboards and exportable reports for management.'],
                    ['icon' => 'plug', 'title' => 'Integration', 'description' => 'Payment gateways, SMS, accounting software, devices and third-party APIs.'],
                    ['icon' => 'code', 'title' => 'Source code ownership', 'description' => 'You receive the complete codebase and documentation.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'Software that matches your business', 'description' => 'No compromises to fit a generic tool.'],
                    ['title' => 'Clear scope and pricing', 'description' => 'Fixed quotes or phased plans agreed up front.'],
                    ['title' => 'Local team, real conversations', 'description' => 'Meet in Dhaka or online, in Bangla or English.'],
                    ['title' => 'Long-term partnership', 'description' => 'Maintenance and improvement plans after launch.'],
                ],
                'technologies' => ['Laravel', 'PHP 8', 'MySQL', 'PostgreSQL', 'Vue.js', 'Tailwind CSS', 'REST APIs', 'Redis', 'Docker'],
                'faqs' => [
                    ['question' => 'How much does custom software cost in Bangladesh?', 'answer' => 'Cost depends on scope. A focused internal tool is very different from a multi-module ERP. After a free consultation we provide a written quote with clear deliverables. We do not publish generic price lists because they would be misleading.'],
                    ['question' => 'Can you improve or extend our existing software?', 'answer' => 'Often, yes. We review the existing codebase and advise whether to extend, refactor or rebuild. See our software maintenance service.'],
                    ['question' => 'Will we depend on DigiProSoft forever?', 'answer' => 'No. You own the source code and documentation, and the stack we use is widely known, so any competent team can maintain it.'],
                ],
                'seo_title' => 'Custom Software Development Company in Bangladesh | DigiProSoft',
                'seo_description' => 'DigiProSoft builds custom software, ERPs, portals and internal tools for businesses in Bangladesh. Clear scope, staged delivery and full source code ownership. Get a free consultation.',
                'products' => ['custom-business-software', 'pharmacy-management-system', 'hotel-management-system', 'school-management-system'],
            ],
            [
                'category_id' => $cat('development'),
                'name' => 'Web Development',
                'slug' => 'web-development',
                'tagline' => 'Fast, secure, search-friendly websites',
                'icon' => 'globe',
                'sort_order' => 2,
                'is_featured' => true,
                'short_description' => 'Corporate websites, landing pages and web applications that load fast, rank well on Google and are easy for your team to update.',
                'description' => "A website is often the first serious impression a customer has of your business. DigiProSoft designs and develops websites that are fast, mobile-friendly, secure and structured for search engines — not just visually attractive.\n\nWe build corporate websites, product and campaign landing pages, and full web applications with content management, on a stack your team can maintain.",
                'problem' => 'Many business websites are slow template installs with outdated plugins, poor mobile experience and no SEO foundation. They do not generate enquiries and are expensive to change.',
                'solution' => "We design around your customers' questions and build with performance and technical SEO in mind: clean structure, fast loading, accessible markup, structured data and an admin panel for updating content without a developer.",
                'features' => [
                    ['icon' => 'pen', 'title' => 'Custom design', 'description' => 'A design that reflects your brand rather than a recycled template.'],
                    ['icon' => 'smartphone', 'title' => 'Mobile-first & responsive', 'description' => 'Tested across phones, tablets and desktops.'],
                    ['icon' => 'zap', 'title' => 'Performance optimised', 'description' => 'Optimised images, minimal scripts and caching for strong Core Web Vitals.'],
                    ['icon' => 'search', 'title' => 'Technical SEO built in', 'description' => 'Clean URLs, metadata, structured data, sitemaps and accessible headings.'],
                    ['icon' => 'file-text', 'title' => 'Content management', 'description' => 'Edit pages, blog posts and products yourself.'],
                    ['icon' => 'lock', 'title' => 'Security & hosting setup', 'description' => 'HTTPS, hardened configuration, backups and monitoring.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'More enquiries', 'description' => 'Clear messaging and calls to action turn visitors into leads.'],
                    ['title' => 'Better search visibility', 'description' => 'A technically sound foundation for organic growth.'],
                    ['title' => 'Lower running cost', 'description' => 'No plugin sprawl, fewer breakages, easy updates.'],
                    ['title' => 'Professional credibility', 'description' => 'A site that reflects the quality of your business.'],
                ],
                'technologies' => ['Laravel', 'Tailwind CSS', 'Vite', 'Alpine.js', 'Vue.js', 'MySQL', 'Cloudflare', 'Nginx'],
                'faqs' => [
                    ['question' => 'Do you build WordPress websites?', 'answer' => 'We can when it is the right fit, but for most business websites we recommend a lightweight custom build on Laravel for performance, security and long-term maintainability.'],
                    ['question' => 'Will I be able to update the website myself?', 'answer' => 'Yes. Websites include an admin panel for pages, posts, products and media, plus training for your team.'],
                    ['question' => 'Do you provide hosting and domain setup?', 'answer' => 'We set up hosting, domain, DNS, SSL and email on your own accounts so you retain ownership, and we can manage them under a maintenance plan.'],
                ],
                'seo_title' => 'Web Development Company in Dhaka, Bangladesh | DigiProSoft',
                'seo_description' => 'Professional website development in Dhaka, Bangladesh: fast, mobile-friendly, secure and SEO-ready corporate websites, landing pages and web applications by DigiProSoft.',
                'products' => ['ecommerce-platform', 'custom-business-software'],
            ],
            [
                'category_id' => $cat('development'),
                'name' => 'E-commerce Development',
                'slug' => 'ecommerce-development',
                'tagline' => 'Online stores built for Bangladesh',
                'icon' => 'cart',
                'sort_order' => 3,
                'is_featured' => true,
                'short_description' => 'Custom online stores and marketplaces with local payment gateways, courier integration, inventory sync and a conversion-focused shopping experience.',
                'description' => 'DigiProSoft develops e-commerce websites and marketplaces for brands, retailers and distributors in Bangladesh. Whether you need a ready-to-launch store on our E-commerce Platform or a fully custom marketplace with vendors, wallets and complex logistics, we build it around how your customers actually buy.',
                'problem' => 'Off-the-shelf stores often struggle with local realities: mobile-first shoppers, cash on delivery, bKash and Nagad payments, courier workflows and Bangla content. Customisation becomes expensive and fragile.',
                'solution' => 'We build stores with local payment and courier integrations, fast mobile checkout, inventory and POS synchronisation, and admin tools that match your operation — plus the SEO structure that helps products rank.',
                'features' => [
                    ['icon' => 'cart', 'title' => 'Custom storefronts', 'description' => 'Branded shopping experiences optimised for conversion on mobile.'],
                    ['icon' => 'receipt', 'title' => 'Payment gateway integration', 'description' => 'SSLCommerz, bKash, Nagad, Rocket, cards and cash on delivery.'],
                    ['icon' => 'package', 'title' => 'Courier & logistics', 'description' => 'Integration with local courier APIs and delivery tracking.'],
                    ['icon' => 'users', 'title' => 'Multi-vendor marketplaces', 'description' => 'Vendor onboarding, commissions, payouts and vendor dashboards.'],
                    ['icon' => 'refresh', 'title' => 'Inventory & POS sync', 'description' => 'Shared stock between online and physical outlets.'],
                    ['icon' => 'search', 'title' => 'E-commerce SEO', 'description' => 'Product structured data, category architecture and fast pages.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'Higher conversion', 'description' => 'Checkout built for local buyers and mobile screens.'],
                    ['title' => 'Operational efficiency', 'description' => 'Orders, payments and deliveries managed in one place.'],
                    ['title' => 'Own your channel', 'description' => 'No marketplace commission, full customer data.'],
                    ['title' => 'Scalable', 'description' => 'From first sale to thousands of orders a day.'],
                ],
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'SSLCommerz', 'bKash API', 'Meilisearch', 'Cloudflare'],
                'faqs' => [
                    ['question' => 'Should I use your E-commerce Platform or a custom build?', 'answer' => 'For most retailers the platform is faster and more economical. Custom builds make sense for marketplaces, B2B ordering, subscriptions or unusual logistics. We advise honestly after understanding your needs.'],
                    ['question' => 'Can you integrate bKash and Nagad?', 'answer' => 'Yes, through official gateways such as SSLCommerz or direct merchant APIs where you hold a merchant account.'],
                ],
                'seo_title' => 'E-commerce Development Company in Bangladesh | DigiProSoft',
                'seo_description' => 'E-commerce website and marketplace development in Bangladesh with bKash/Nagad/card payments, courier integration and inventory sync. Build your online store with DigiProSoft.',
                'products' => ['ecommerce-platform', 'pos-system'],
            ],
            [
                'category_id' => $cat('integration-automation'),
                'name' => 'Business Automation',
                'slug' => 'business-automation',
                'tagline' => 'Remove manual, repetitive work',
                'icon' => 'zap',
                'sort_order' => 4,
                'is_featured' => true,
                'short_description' => 'Automate approvals, reporting, notifications, data entry and inter-system workflows so your team spends time on work that matters.',
                'description' => "Many businesses lose hours every day to tasks a computer should do: re-typing data between systems, chasing approvals, compiling reports, sending reminders. DigiProSoft designs and implements business automation that removes this friction.\n\nWe start with the processes that cost you the most time, then automate them using your existing systems where possible and custom tools where needed.",
                'problem' => "Manual processes are slow, inconsistent and hard to audit. Errors creep in during re-entry, decisions wait on someone's inbox and nobody has real-time visibility.",
                'solution' => 'We map the workflow, define rules and exceptions, and build automation: approval flows with notifications, scheduled reports, automatic SMS/email, data sync between systems and dashboards that update themselves.',
                'features' => [
                    ['icon' => 'compass', 'title' => 'Process audit', 'description' => 'Identify the manual steps that cost the most time and money.'],
                    ['icon' => 'check-circle', 'title' => 'Approval workflows', 'description' => 'Multi-level approvals with notifications, escalation and audit trail.'],
                    ['icon' => 'message', 'title' => 'Automated notifications', 'description' => 'SMS, email and WhatsApp messages triggered by business events.'],
                    ['icon' => 'chart', 'title' => 'Scheduled reporting', 'description' => 'Daily, weekly and monthly reports delivered automatically.'],
                    ['icon' => 'refresh', 'title' => 'System-to-system sync', 'description' => 'Keep accounting, inventory, CRM and e-commerce data consistent.'],
                    ['icon' => 'file-text', 'title' => 'Document generation', 'description' => 'Invoices, contracts and certificates generated from data.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'Save staff hours every week', 'description' => 'Repetitive tasks run without human effort.'],
                    ['title' => 'Fewer errors', 'description' => 'Data moves without re-typing.'],
                    ['title' => 'Faster decisions', 'description' => 'Approvals and information reach the right person instantly.'],
                    ['title' => 'Full traceability', 'description' => 'Every automated action is logged.'],
                ],
                'technologies' => ['Laravel Queues', 'Scheduled Jobs', 'Webhooks', 'REST APIs', 'SMS Gateways', 'Email APIs', 'Google Workspace APIs'],
                'faqs' => [
                    ['question' => 'Do we need new software to automate?', 'answer' => 'Not always. Many automations connect systems you already use. Where a gap exists we build a small, focused tool rather than replacing everything.'],
                    ['question' => 'Which processes are best to automate first?', 'answer' => 'High-volume, rule-based tasks: order confirmations, payment reminders, daily reports, approval routing and data entry between systems.'],
                ],
                'seo_title' => 'Business Process Automation Services in Bangladesh | DigiProSoft',
                'seo_description' => 'Automate approvals, reports, notifications and data flows between systems. DigiProSoft business automation services help companies in Bangladesh save time and reduce errors.',
                'products' => ['custom-business-software', 'pos-system', 'pharmacy-management-system', 'hotel-management-system', 'school-management-system'],
            ],
            [
                'category_id' => $cat('integration-automation'),
                'name' => 'API Development & Integration',
                'slug' => 'api-development',
                'tagline' => 'Connect your systems reliably',
                'icon' => 'plug',
                'sort_order' => 5,
                'is_featured' => false,
                'short_description' => 'Design and build secure REST APIs, and integrate payment gateways, SMS, courier, accounting and third-party platforms with your software.',
                'description' => 'Modern businesses run on connected systems. DigiProSoft develops APIs that let your applications, partners and mobile apps exchange data securely, and integrates third-party services — payment gateways, SMS providers, courier companies, ERPs and more — into your software.',
                'problem' => 'Disconnected systems mean duplicate data entry, delayed information and integration hacks that break silently. Poorly designed APIs create security risks and slow down partners and developers.',
                'solution' => 'We design APIs with clear contracts, authentication, versioning, rate limiting and documentation. For integrations, we handle the edge cases — retries, failures, reconciliation — so data stays consistent.',
                'features' => [
                    ['icon' => 'code', 'title' => 'REST API design & development', 'description' => 'Versioned, documented APIs with OpenAPI specifications.'],
                    ['icon' => 'lock', 'title' => 'Authentication & security', 'description' => 'OAuth2, API keys, scopes, rate limiting and audit logging.'],
                    ['icon' => 'receipt', 'title' => 'Payment gateway integration', 'description' => 'SSLCommerz, bKash, Nagad, Stripe and bank APIs.'],
                    ['icon' => 'message', 'title' => 'SMS, email & messaging', 'description' => 'Local SMS gateways, transactional email and WhatsApp Business APIs.'],
                    ['icon' => 'package', 'title' => 'Courier & logistics APIs', 'description' => 'Shipment booking and tracking with delivery providers.'],
                    ['icon' => 'database', 'title' => 'ERP & accounting sync', 'description' => 'Two-way sync with accounting and ERP systems.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'One source of truth', 'description' => 'Data flows automatically between systems.'],
                    ['title' => 'Faster partner onboarding', 'description' => 'Clear, documented APIs for partners and developers.'],
                    ['title' => 'Reliable operations', 'description' => 'Failures are handled and reconciled, not ignored.'],
                    ['title' => 'Secure by default', 'description' => 'Access control and logging built in.'],
                ],
                'technologies' => ['Laravel', 'REST', 'OpenAPI', 'OAuth 2.0', 'Laravel Sanctum', 'Webhooks', 'Redis Queues', 'Postman'],
                'faqs' => [
                    ['question' => 'Can you build a mobile app backend?', 'answer' => 'Yes. We build secure API backends for iOS and Android apps, including authentication, push notifications and admin panels.'],
                    ['question' => 'Do you provide API documentation?', 'answer' => 'Every API is delivered with OpenAPI documentation and example requests.'],
                ],
                'seo_title' => 'API Development & System Integration Services | DigiProSoft',
                'seo_description' => 'Secure REST API development and third-party integration — payment gateways, SMS, courier, ERP and accounting systems — by DigiProSoft, Bangladesh.',
                'products' => ['ecommerce-platform', 'custom-business-software'],
            ],
            [
                'category_id' => $cat('development'),
                'name' => 'SaaS Development',
                'slug' => 'saas-development',
                'tagline' => 'Turn your idea into a subscription product',
                'icon' => 'cloud',
                'sort_order' => 6,
                'is_featured' => false,
                'short_description' => 'End-to-end development of multi-tenant SaaS products: architecture, subscription billing, onboarding, admin tooling and scalable cloud deployment.',
                'description' => "DigiProSoft helps founders and companies build software-as-a-service products from concept to launch. We handle multi-tenant architecture, subscription billing, user onboarding, role management, usage analytics and the cloud infrastructure required to run reliably as you grow.\n\nOur own products are built on the same foundations, so we bring real operating experience rather than theory.",
                'problem' => 'SaaS products fail on architecture decisions made early: tenant data leaks, billing edge cases, slow onboarding and infrastructure that cannot scale or costs too much. Founders need a partner who has solved these before.',
                'solution' => 'We design the tenancy model, billing and plans, onboarding flows and admin tools up front, build an MVP that can be extended, and set up deployment, monitoring and backups so the product runs reliably from day one.',
                'features' => [
                    ['icon' => 'layers', 'title' => 'Multi-tenant architecture', 'description' => 'Secure tenant isolation with shared or dedicated databases as appropriate.'],
                    ['icon' => 'receipt', 'title' => 'Subscription billing', 'description' => 'Plans, trials, invoices and payment gateway integration.'],
                    ['icon' => 'rocket', 'title' => 'Onboarding & self-service', 'description' => 'Sign-up, workspace setup and in-app guidance.'],
                    ['icon' => 'shield', 'title' => 'Roles, teams & permissions', 'description' => 'Organisation-level users, invitations and access control.'],
                    ['icon' => 'chart', 'title' => 'Analytics & admin tools', 'description' => 'Usage metrics, customer management and support tooling.'],
                    ['icon' => 'cloud', 'title' => 'Cloud deployment & DevOps', 'description' => 'CI/CD, monitoring, backups and scaling on AWS, DigitalOcean or local providers.'],
                ],
                'process' => $process,
                'benefits' => [
                    ['title' => 'Faster time to market', 'description' => 'Proven foundations mean less time reinventing basics.'],
                    ['title' => 'Built to scale', 'description' => 'Architecture that grows with your customer base.'],
                    ['title' => 'Predictable costs', 'description' => 'Infrastructure sized to real usage.'],
                    ['title' => 'Investor-ready quality', 'description' => 'Clean code, documentation and security practices.'],
                ],
                'technologies' => ['Laravel', 'Vue.js / Inertia', 'PostgreSQL', 'Redis', 'Docker', 'AWS', 'Stripe', 'SSLCommerz', 'GitHub Actions'],
                'faqs' => [
                    ['question' => 'Can you help validate the idea before building?', 'answer' => 'Yes. We offer a short discovery phase that produces a scoped MVP definition, architecture outline and cost estimate before full development.'],
                    ['question' => 'Do you take equity?', 'answer' => 'We work on a service basis. Commercial arrangements are discussed case by case.'],
                ],
                'seo_title' => 'SaaS Product Development Company in Bangladesh | DigiProSoft',
                'seo_description' => 'Build your SaaS product with DigiProSoft: multi-tenant architecture, subscription billing, onboarding and scalable cloud deployment, from MVP to growth.',
                'products' => ['custom-business-software'],
            ],
            [
                'category_id' => $cat('support'),
                'name' => 'Software Maintenance & Support',
                'slug' => 'software-maintenance',
                'tagline' => 'Keep your software secure, fast and improving',
                'icon' => 'wrench',
                'sort_order' => 7,
                'is_featured' => false,
                'short_description' => 'Ongoing maintenance for Laravel and PHP applications: security updates, bug fixes, performance tuning, monitoring, backups and feature improvements.',
                'description' => 'Software is never finished. Frameworks release security patches, servers need updates, businesses change and users find edge cases. DigiProSoft provides maintenance and support plans that keep your applications secure, fast and aligned with your business — whether we built them or not.',
                'problem' => 'Unmaintained applications accumulate security vulnerabilities, slow down, and eventually break when a server or dependency changes. Without a responsible team, small issues become emergencies.',
                'solution' => 'A support plan with defined response times covers monitoring, updates, backups, bug fixes and a monthly allocation for improvements. We take over existing Laravel/PHP codebases after a technical review.',
                'features' => [
                    ['icon' => 'shield', 'title' => 'Security updates', 'description' => 'Framework, dependency and server patches applied promptly.'],
                    ['icon' => 'zap', 'title' => 'Performance monitoring & tuning', 'description' => 'Uptime monitoring, slow-query analysis and caching improvements.'],
                    ['icon' => 'database', 'title' => 'Backups & recovery', 'description' => 'Automated, tested backups with documented restore procedures.'],
                    ['icon' => 'wrench', 'title' => 'Bug fixes & small changes', 'description' => 'Issues resolved within agreed response times.'],
                    ['icon' => 'trending', 'title' => 'Feature improvements', 'description' => 'Monthly development hours for enhancements.'],
                    ['icon' => 'file-text', 'title' => 'Code review & takeover', 'description' => 'Assessment and documentation of applications built by others.'],
                ],
                'process' => [
                    ['step' => 1, 'title' => 'Technical review', 'description' => 'We assess the codebase, hosting, security and backups.'],
                    ['step' => 2, 'title' => 'Stabilise', 'description' => 'Critical issues, updates and monitoring are addressed first.'],
                    ['step' => 3, 'title' => 'Support plan', 'description' => 'Agreed scope, response times and monthly hours.'],
                    ['step' => 4, 'title' => 'Continuous improvement', 'description' => 'Regular reporting and planned enhancements.'],
                ],
                'benefits' => [
                    ['title' => 'Peace of mind', 'description' => 'A responsible team watching your systems.'],
                    ['title' => 'Lower risk', 'description' => 'Vulnerabilities patched before they are exploited.'],
                    ['title' => 'Predictable budget', 'description' => 'Fixed monthly cost instead of emergency bills.'],
                    ['title' => 'Software that keeps up', 'description' => 'Regular improvements as your business changes.'],
                ],
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Nginx', 'Ubuntu', 'Cloudflare', 'Uptime monitoring', 'Automated backups'],
                'faqs' => [
                    ['question' => 'Do you maintain software built by another company?', 'answer' => 'Yes, after a technical review. We work primarily with Laravel and PHP applications and will tell you honestly if a codebase is better rebuilt than maintained.'],
                    ['question' => 'What response times do you offer?', 'answer' => 'Plans include defined response times for critical, high and normal priority issues. Details are agreed in the support contract.'],
                ],
                'seo_title' => 'Laravel & PHP Software Maintenance Services | DigiProSoft',
                'seo_description' => 'Software maintenance and support plans for Laravel and PHP applications: security updates, monitoring, backups, bug fixes and improvements. DigiProSoft, Bangladesh.',
                'products' => ['custom-business-software', 'ecommerce-platform', 'pharmacy-management-system', 'hotel-management-system', 'school-management-system', 'pos-system'],
            ],
        ];

        foreach ($services as $data) {
            $productSlugs = $data['products'];
            unset($data['products']);

            $service = Service::updateOrCreate(
                ['slug' => $data['slug']],
                [...$data, 'is_active' => true, 'published_at' => now()->subDays(30)],
            );

            $service->products()->sync(Product::whereIn('slug', $productSlugs)->pluck('id'));
        }
    }
}

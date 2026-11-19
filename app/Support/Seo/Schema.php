<?php

declare(strict_types=1);

namespace App\Support\Seo;

use App\Models\CaseStudy;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Support\Site;

/**
 * Schema.org JSON-LD node builders. Every node uses stable @id values so
 * pages can reference the Organization / WebSite without duplication.
 *
 * Only verified data is emitted: address, social profiles, contact points
 * and similar fields are included solely when configured.
 */
final class Schema
{
    public static function organizationId(): string
    {
        return Site::url('#organization');
    }

    public static function websiteId(): string
    {
        return Site::url('#website');
    }

    /** @return array<string, mixed> */
    public static function organization(): array
    {
        $node = [
            '@type' => 'Organization',
            '@id' => self::organizationId(),
            'name' => Site::name(),
            'legalName' => Site::legalName(),
            'alternateName' => Site::tagline(),
            'url' => Site::url(),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => Site::absolute(config('site.branding.logo')),
            ],
            'description' => config('site.seo.default_description'),
            'knowsAbout' => [
                'Custom software development', 'Business management software', 'Web development',
                'E-commerce development', 'SaaS development', 'API development', 'Business automation',
            ],
            'areaServed' => ['@type' => 'Country', 'name' => 'Bangladesh'],
        ];

        if ($socials = array_values(Site::socials())) {
            $node['sameAs'] = $socials;
        }

        $contact = array_filter([
            '@type' => 'ContactPoint',
            'contactType' => 'sales',
            'email' => Site::email(),
            'telephone' => Site::phone(),
            'availableLanguage' => ['English', 'Bengali'],
            'areaServed' => 'BD',
        ]);
        if (Site::email() || Site::phone()) {
            $node['contactPoint'] = [$contact];
        }

        $address = Site::address();
        if (Site::hasStreetAddress() && $address !== []) {
            $node['address'] = array_filter([
                '@type' => 'PostalAddress',
                'streetAddress' => $address['street'] ?? null,
                'addressLocality' => $address['city'] ?? null,
                'addressRegion' => $address['region'] ?? null,
                'postalCode' => $address['postal_code'] ?? null,
                'addressCountry' => $address['country'] ?? null,
            ]);
        }

        return $node;
    }

    /** @return array<string, mixed> */
    public static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => self::websiteId(),
            'url' => Site::url(),
            'name' => Site::name(),
            'description' => config('site.seo.default_description'),
            'publisher' => ['@id' => self::organizationId()],
            'inLanguage' => 'en',
        ];
    }

    /** @return array<string, mixed> */
    public static function webPage(string $url, string $name, string $description, string $type = 'WebPage'): array
    {
        return [
            '@type' => $type,
            '@id' => $url.'#webpage',
            'url' => $url,
            'name' => $name,
            'description' => $description,
            'isPartOf' => ['@id' => self::websiteId()],
            'about' => ['@id' => self::organizationId()],
            'inLanguage' => 'en',
        ];
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    public static function breadcrumbList(array $items): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn (array $item, int $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    /** @return array<string, mixed> */
    public static function service(Service $service): array
    {
        return [
            '@type' => 'Service',
            '@id' => $service->url().'#service',
            'name' => $service->name,
            'description' => $service->seoDescription(),
            'url' => $service->url(),
            'serviceType' => $service->name,
            'provider' => ['@id' => self::organizationId()],
            'areaServed' => ['@type' => 'Country', 'name' => 'Bangladesh'],
        ];
    }

    /** @return array<string, mixed> */
    public static function softwareApplication(Product $product): array
    {
        $productPage = $product->url();
        $liveUrl = filled($product->website_url) ? (string) $product->website_url : null;

        $node = [
            '@type' => 'SoftwareApplication',
            '@id' => $productPage.'#software',
            'name' => $product->name,
            'description' => $product->seoDescription(),
            'url' => $liveUrl ?? $productPage,
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'publisher' => ['@id' => self::organizationId()],
        ];

        if ($liveUrl) {
            $node['sameAs'] = [$productPage];
        }

        if ($product->featured_image) {
            $node['image'] = Site::absolute($product->featured_image);
        }

        if (! empty($product->features)) {
            $node['featureList'] = collect($product->features)->pluck('title')->filter()->values()->all();
        }

        return $node;
    }

    /** @return array<string, mixed> */
    public static function blogPosting(Post $post): array
    {
        $node = [
            '@type' => 'BlogPosting',
            '@id' => $post->url().'#article',
            'mainEntityOfPage' => $post->url(),
            'headline' => $post->title,
            'description' => $post->seoDescription(),
            'url' => $post->url(),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => ($post->updated_at ?? $post->published_at)?->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                '@id' => self::organizationId(),
                'name' => $post->author?->name ?? Site::name(),
            ],
            'publisher' => ['@id' => self::organizationId()],
            'inLanguage' => 'en',
            'wordCount' => str_word_count(strip_tags($post->content)),
        ];

        if ($post->author && $post->author->name !== Site::name()) {
            $node['author'] = ['@type' => 'Person', 'name' => $post->author->name];
        }

        if ($image = $post->ogImage()) {
            $node['image'] = Site::absolute($image);
        }

        if ($post->relationLoaded('tags') && $post->tags->isNotEmpty()) {
            $node['keywords'] = $post->tags->pluck('name')->implode(', ');
        }

        if ($post->category) {
            $node['articleSection'] = $post->category->name;
        }

        return $node;
    }

    /** @return array<string, mixed> */
    public static function creativeWork(CaseStudy $study): array
    {
        $node = [
            '@type' => 'CreativeWork',
            '@id' => $study->url().'#casestudy',
            'name' => $study->title,
            'description' => $study->seoDescription(),
            'url' => $study->url(),
            'creator' => ['@id' => self::organizationId()],
            'genre' => 'Case study',
        ];

        if ($study->featured_image) {
            $node['image'] = Site::absolute($study->featured_image);
        }

        return $node;
    }

    /**
     * FAQPage — only call this when the same Q&A pairs are visibly rendered.
     *
     * @param  iterable<int, array{question: string, answer: string}|object>  $faqs
     * @return array<string, mixed>
     */
    public static function faqPage(iterable $faqs, string $url): array
    {
        $entities = collect($faqs)->map(function ($faq) {
            $question = is_array($faq) ? ($faq['question'] ?? null) : ($faq->question ?? null);
            $answer = is_array($faq) ? ($faq['answer'] ?? null) : ($faq->answer ?? null);

            if (! $question || ! $answer) {
                return null;
            }

            return [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($answer)],
            ];
        })->filter()->values();

        if ($entities->isEmpty()) {
            return [];
        }

        return [
            '@type' => 'FAQPage',
            '@id' => $url.'#faq',
            'mainEntity' => $entities->all(),
        ];
    }

    /**
     * @param  iterable<int, array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    public static function itemList(string $name, iterable $items): array
    {
        return [
            '@type' => 'ItemList',
            'name' => $name,
            'itemListElement' => collect($items)->values()->map(fn (array $item, int $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'url' => $item['url'],
            ])->all(),
        ];
    }
}

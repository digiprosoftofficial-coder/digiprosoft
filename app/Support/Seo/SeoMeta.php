<?php

declare(strict_types=1);

namespace App\Support\Seo;

use App\Support\Site;
use Illuminate\Support\Str;

/**
 * Immutable-ish value object describing everything the <head> needs for
 * one page: title, description, canonical, social cards and JSON-LD graph.
 */
final class SeoMeta
{
    /** @var array<int, array<string, mixed>> */
    private array $schema = [];

    /** @var array<int, array{name: string, url: string}> */
    private array $breadcrumbs = [];

    private function __construct(
        private string $title,
        private string $description,
        private ?string $canonical = null,
        private ?string $image = null,
        private string $type = 'website',
        private string $robots = 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
        private ?string $publishedTime = null,
        private ?string $modifiedTime = null,
        private bool $appendSuffix = true,
    ) {}

    public static function make(string $title, string $description): self
    {
        return new self(title: $title, description: $description);
    }

    /** Use the full title verbatim (e.g. the homepage brand title). */
    public function rawTitle(): self
    {
        $this->appendSuffix = false;

        return $this;
    }

    public function canonical(?string $url): self
    {
        $this->canonical = $url;

        return $this;
    }

    public function image(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function noindex(): self
    {
        $this->robots = 'noindex,follow';

        return $this;
    }

    public function article(?string $published, ?string $modified = null): self
    {
        $this->type = 'article';
        $this->publishedTime = $published;
        $this->modifiedTime = $modified;

        return $this;
    }

    /** @param array<string, mixed> $schema */
    public function withSchema(array $schema): self
    {
        if ($schema !== []) {
            $this->schema[] = $schema;
        }

        return $this;
    }

    /** @param array<int, array{name: string, url: string}> $items */
    public function breadcrumbs(array $items): self
    {
        $this->breadcrumbs = $items;

        return $this;
    }

    // ---------------------------------------------------------------
    // Getters used by the <x-seo.meta> component
    // ---------------------------------------------------------------

    public function fullTitle(): string
    {
        $title = trim($this->title);
        $suffix = (string) config('site.seo.title_suffix');

        if (! $this->appendSuffix || Str::contains($title, Site::name())) {
            return $title;
        }

        return $title.$suffix;
    }

    public function pageTitle(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return Str::limit(trim(preg_replace('/\s+/', ' ', $this->description) ?? ''), 160, '');
    }

    public function canonicalUrl(): string
    {
        return $this->canonical ?? Site::absolute(request()->getPathInfo());
    }

    public function imageUrl(): string
    {
        return $this->image ? Site::absolute($this->image) : Site::defaultOgImage();
    }

    public function ogType(): string
    {
        return $this->type;
    }

    public function robots(): string
    {
        return $this->robots;
    }

    public function isIndexable(): bool
    {
        return ! Str::contains($this->robots, 'noindex');
    }

    public function publishedTime(): ?string
    {
        return $this->publishedTime;
    }

    public function modifiedTime(): ?string
    {
        return $this->modifiedTime;
    }

    /** @return array<int, array{name: string, url: string}> */
    public function breadcrumbItems(): array
    {
        return $this->breadcrumbs;
    }

    /**
     * Full JSON-LD graph: Organization + WebSite are always present, then
     * the page-specific nodes and a BreadcrumbList when breadcrumbs exist.
     *
     * @return array<string, mixed>
     */
    public function jsonLd(): array
    {
        $graph = [
            Schema::organization(),
            Schema::website(),
            ...$this->schema,
        ];

        if ($this->breadcrumbs !== []) {
            $graph[] = Schema::breadcrumbList($this->breadcrumbs);
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => array_values(array_filter($graph)),
        ];
    }
}

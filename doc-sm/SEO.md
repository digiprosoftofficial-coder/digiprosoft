# DigiProSoft SEO Guide

এই ডকুমেন্টে লেখা আছে: সাইটে **SEO-এর জন্য কী কী করা হয়েছে**, **কোন ফাইল/URL গুরুত্বপূর্ণ**, আর **production-এ ranking পেতে তোমার কী কী করতে হবে**।

লক্ষ্য: কেউ Google বা AI-তে “software development Bangladesh / pharmacy software / DigiProSoft” সার্চ করলে DigiProSoft আর product links (যেমন SoftoPharma) সহজে পাওয়া যায়।

---

## 1. ইতিমধ্যে যা করা হয়েছে (Done)

### 1.1 Technical SEO foundation (আগে থেকেই ছিল + improve করা হয়েছে)

| Feature | কোথায় / কী |
|--------|------------|
| Title, description, robots, canonical | `resources/views/components/seo/meta.blade.php` + `app/Support/Seo/SeoMeta.php` |
| Open Graph + Twitter cards | একই meta component |
| JSON-LD schema | `app/Support/Seo/Schema.php` — Organization, WebSite, WebPage, FAQ, SoftwareApplication, BlogPosting, Breadcrumb |
| Sitemap | `/sitemap.xml` → `SitemapController` |
| Robots | `/robots.txt` → `RobotsController` (production-এ Allow; local-এ Disallow) |
| Canonical host redirect | `RedirectToCanonicalUrl` + `SITE_FORCE_CANONICAL_HOST` |
| Softopharma live URL schema | Product-এ `website_url` থাকলে SoftwareApplication `url` = live site, DigiProSoft page = `sameAs` |

### 1.2 SoftoPharma product SEO

- Product name: **SoftoPharma** (slug একই: `pharmacy-management-system`)
- Live site: `https://softopharma.digiprosoft.com/`
- DigiProSoft page: `/products/pharmacy-management-system`
- Product page-এ **Visit SoftoPharma** CTA + **Live product website** block
- Admin-এ `website_url` field (`ProductResource`)
- Case study / blog copy-তে SoftoPharma mention

### 1.3 AI / LLM discoverability

| URL | কাজ |
|-----|-----|
| `/llms.txt` | Company summary, contact, সব product/service URL, SoftoPharma live link — AI agents-এর জন্য |
| Production robots comment | `/llms.txt` mention |

Controller: `app/Http/Controllers/LlmsTxtController.php`

### 1.4 Keyword SEO landing pages (Google search intent)

Config: `config/seo-landings.php`  
Controller: `SeoLandingController`  
View: `resources/views/pages/seo-landing.blade.php`

| URL | Target keyword / intent |
|-----|-------------------------|
| `/software-development-company-bangladesh` | Software development company in Bangladesh |
| `/custom-software-development-bangladesh` | Custom software development Bangladesh |
| `/pharmacy-management-software-bangladesh` | Pharmacy management software → SoftoPharma |

এগুলো sitemap-এ আছে, footer Company মেনুতে link আছে, about page-এ Softopharma cross-link আছে।

### 1.5 Branding / contact (SEO + trust signals)

- Logo / favicon / OG image update
- Contact: email, phone, WhatsApp
- Facebook official page → Organization `sameAs`
- Tagline: Digital Product & Software Solution

### 1.6 Tests

- `tests/Feature/SeoInfrastructureTest.php` — sitemap, robots, JSON-LD, canonical
- `tests/Feature/SeoDiscoverabilityTest.php` — llms.txt, landing pages, Softopharma schema
- `tests/Feature/ProductShowTest.php` — SoftoPharma live CTA

---

## 2. গুরুত্বপূর্ণ URL checklist (live-এ verify করবে)

Production domain ধরে (উদাহরণ: `https://www.digiprosoft.com`):

```
/
/about
/products
/products/pharmacy-management-system
/services
/blog
/contact
/faq
/software-development-company-bangladesh
/custom-software-development-bangladesh
/pharmacy-management-software-bangladesh
/sitemap.xml
/robots.txt
/llms.txt
```

SoftoPharma (subdomain, আলাদা app):

```
https://softopharma.digiprosoft.com/
```

---

## 3. Production-এ যা করতে হবে (তোমার TODO — এখনো বাকি)

এগুলো **কোডে automatic হয় না**; deploy + Google setup লাগে।

### 3.1 Environment (অবশ্যই)

`.env` production-এ:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.digiprosoft.com
SITE_FORCE_CANONICAL_HOST=true
```

নোট:

- `www` আর non-www **একটাই** বেছে নাও; `APP_URL` সেই canonical host হবে।
- Local-এ `APP_ENV=local` রাখলে robots `Disallow: /` দেয় — এটা ঠিক; Google local crawl করবে না।

### 3.2 Deploy এর পর

1. `php artisan config:cache` (বা Cloud-এর সমতুল্য)
2. `npm run build` (assets)
3. Browser-এ চেক করো:
   - `https://www.digiprosoft.com/robots.txt` → `Allow: /` + Sitemap line
   - `https://www.digiprosoft.com/sitemap.xml` → সব public URL
   - `https://www.digiprosoft.com/llms.txt` → DigiProSoft + SoftoPharma links
4. Softopharma site থেকে DigiProSoft-এ “Built by DigiProSoft” link রাখো (cross-link) — Softopharma codebase-এ আলাদা কাজ

### 3.3 Google Search Console

1. Property add করো: `https://www.digiprosoft.com`
2. Domain/URL verify করো (`GOOGLE_SITE_VERIFICATION` env দিয়েও meta লাগানো যায় — `config/site.php` analytics)
3. Sitemaps → submit: `https://www.digiprosoft.com/sitemap.xml`
4. Softopharma subdomain চাইলে আলাদা property: `https://softopharma.digiprosoft.com`
5. URL Inspection দিয়ে important pages index request করো

### 3.4 Bing (optional কিন্তু ভালো)

- Bing Webmaster Tools-এ site add + sitemap
- `BING_SITE_VERIFICATION` env set করা যায়

---

## 4. Content / ranking-এর জন্য পরের কাজ (Suggestions)

Technical SEO foundation এখন ভালো। **Google-এ উপরে আসতে** আরও লাগবে:

### 4.1 Content (সবচেয়ে গুরুত্বপূর্ণ)

- আরও blog posts যেগুলো real search করে:
  - “software development company in Bangladesh”
  - “custom software development cost Bangladesh”
  - “pharmacy management software Bangladesh”
  - Bangla posts: “সফটওয়্যার ডেভেলপমেন্ট কোম্পানি বাংলাদেশ”
- প্রতিটি product-এর জন্য short case study / FAQ update রাখো
- Softopharma pricing/demo থেকে DigiProSoft brand mention

### 4.2 আরও landing pages (প্রয়োজন হলে)

`config/seo-landings.php`-এ নতুন entry যোগ করলেই নতুন URL পাবে। উদাহরণ ideas:

- `hotel-management-software-bangladesh`
- `school-management-software-bangladesh`
- `pos-software-bangladesh`
- `ecommerce-website-development-bangladesh`

**সতর্কতা:** thin duplicate content বানাবে না — প্রতি পেজে unique copy + product/service links।

### 4.3 Backlinks / authority

পুরনো static HTML যদি Google-এ উপরে থাকত, তার বড় কারণ ছিল **domain history + links**। এখন:

- Facebook / LinkedIn / directories-এ digiprosoft.com link
- Softopharma ↔ DigiProSoft দুইদিকে link
- Client websites / partner mentions
- Google Business Profile (Dhaka) — local search-এর জন্য

### 4.4 Softopharma site SEO (আলাদা project)

DigiProSoft site done; Softopharma app-এও চেক করো:

- Canonical `https://softopharma.digiprosoft.com`
- Own sitemap/robots
- Footer/about: “Proudly developed by DigiProSoft” → digiprosoft.com
- Structured data (SoftwareApplication / Organization)

### 4.5 Monitoring

- Search Console → Performance (queries, clicks, index coverage)
- মাসে ১বার sitemap errors / “Excluded” pages দেখো
- Core Web Vitals (speed) — LCP খারাপ হলে ranking কমে

---

## 5. কোডে কোথায় কী edit করবে

| কাজ | ফাইল |
|-----|------|
| নতুন SEO landing page | `config/seo-landings.php` (+ চাইলে tests) |
| llms.txt text | `app/Http/Controllers/LlmsTxtController.php` |
| Product live URL | Admin → Products → Product website, বা seeder `website_url` |
| Default titles / tagline | `config/site.php` + `.env` (`SITE_*`, `SEO_*`) |
| Sitemap entries | `app/Http/Controllers/SitemapController.php` |
| Schema nodes | `app/Support/Seo/Schema.php` |
| Robots rules | `app/Http/Controllers/RobotsController.php` |

Landing pages route pattern `routes/web.php`-এ `SeoLandingController::slugs()` থেকে auto হয়।

---

## 6. Local vs Production — মনে রাখো

| | Local (`APP_ENV=local`) | Production |
|--|-------------------------|------------|
| robots.txt | `Disallow: /` | `Allow: /` + Sitemap |
| Canonical URLs | `APP_URL` (এখন প্রায়ই localhost) | `https://www.digiprosoft.com` |
| Google index | হবে না (ইচ্ছাকৃত) | Search Console submit লাগবে |

Local test:

```bash
php artisan serve
# open:
# http://127.0.0.1:8000/llms.txt
# http://127.0.0.1:8000/sitemap.xml
# http://127.0.0.1:8000/software-development-company-bangladesh
# http://127.0.0.1:8000/products/pharmacy-management-system
```

Tests:

```bash
php artisan test --compact tests/Feature/SeoDiscoverabilityTest.php tests/Feature/SeoInfrastructureTest.php
```

---

## 7. সংক্ষেপ — Done vs Todo

### Done (codebase)
- [x] Meta / canonical / OG / Twitter
- [x] JSON-LD schema (org, products, FAQ, etc.)
- [x] Sitemap + robots
- [x] `/llms.txt` for AI agents
- [x] Keyword landing pages (software / custom / pharmacy)
- [x] SoftoPharma branding + live URL + CTAs + schema
- [x] Footer / about cross-links
- [x] Feature tests

### Todo (তোমার / ops / content)
- [ ] Production `.env` (`APP_URL`, `SITE_FORCE_CANONICAL_HOST`, `APP_ENV=production`)
- [ ] Deploy + verify robots/sitemap/llms live
- [ ] Google Search Console verify + sitemap submit
- [ ] Softopharma site-এ DigiProSoft backlink
- [ ] আরও keyword blog / landing content
- [ ] Backlinks + Google Business (optional)
- [ ] Bing Webmaster (optional)
- [ ] Search Console monitoring চালু রাখা

---

*Last updated: SEO landing pages + llms.txt + SoftoPharma discoverability work.*  
*Related notes folder: `doc-sm/`*

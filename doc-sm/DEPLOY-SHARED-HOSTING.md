# DigiProSoft — Shared Hosting Deploy & Performance

শেয়ার্ড হোস্টিং (cPanel / HostSeba ইত্যাদি) এ Laravel কীভাবে রাখবেন, `public_html` কীভাবে সেট করবেন, আর সাইট ধীর হলে কী করবেন — এই ডক।

প্রাইমারি ডোমেইনের Document Root সাধারণত **লক** (`/public_html`) — তাই পুরো প্রজেক্ট `public_html`-এ রাখা যাবে না।

---

## 1. সঠিক ফোল্ডার স্ট্রাকচার

```text
/home/USERNAME/
├── digiprosoft/              ← git clone / git pull এখানে
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   ├── artisan
│   └── public/               ← বিল্ড এখানেও থাকতে হবে (PHP Vite পড়ে)
│       ├── build/
│       │   ├── manifest.json
│       │   └── assets/
│       ├── images/
│       ├── index.php
│       └── .htaccess
│
└── public_html/              ← শুধু ওয়েব রুট (Document Root)
    ├── index.php             ← পাথ এডিট করা (নিচে)
    ├── .htaccess             ← Laravel public/.htaccess
    ├── build/                ← digiprosoft/public/build কপি বা symlink
    ├── images/
    ├── favicon.ico
    ├── favicon.svg
    ├── apple-touch-icon.png
    └── site.webmanifest
```

| রাখবেন | রাখবেন না (`public_html`-এ) |
|--------|------------------------------|
| `index.php`, `.htaccess`, `build/`, `images/`, favicon | `app/`, `vendor/`, `.env`, `storage/`, পুরো Laravel |

---

## 2. প্রথমবার সেটআপ

### ২.১ প্রজেক্ট ক্লোন

```bash
cd ~
mkdir -p digiprosoft
cd digiprosoft
git clone <YOUR_REPO_URL> .
```

### ২.২ Composer + .env

```bash
cd ~/digiprosoft
composer install --no-dev --optimize-autoloader
cp .env.example .env   # প্রথমবার
nano .env              # বা cPanel File Manager
php artisan key:generate
```

প্রোডাকশন `.env` (গুরুত্বপূর্ণ):

```env
APP_NAME=DigiProSoft
APP_ENV=production
APP_DEBUG=false
APP_URL=https://digiprosoft.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=database
LOG_LEVEL=error

# Redis থাকলে (ভালো):
# CACHE_STORE=redis
# SESSION_DRIVER=redis
```

`APP_DEBUG=true` প্রোডাকশনে রাখবেন না — ধীর + অসুরক্ষিত + Ignition এরর পেজ দেখায়।

### ২.৩ Migrate + cache

```bash
php artisan migrate --force
php artisan storage:link   # লাগলে
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### ২.৪ Vite build

সার্ভারে Node না থাকলে **লোকালে**:

```bash
npm ci
npm run build
```

তারপর `public/build/` আপলোড করুন **দু জায়গায়** (বা সিমলিংক — নিচে)।

`.gitignore`-এ `/public/build` আছে — `git pull` এ বিল্ড আসে না।

---

## 3. `public` → `public_html`

### ৩.১ ফাইল কপি

`~/digiprosoft/public/` এর **ভেতরের কনটেন্ট** কপি করুন `~/public_html/` এ  
(`public` নামের ফোল্ডার নয় — ভেতরের ফাইলগুলো রুটে)।

### ৩.২ `public_html/index.php` এডিট

ডিফল্ট `../` পাথ ভুল হবে। প্রজেক্ট `~/digiprosoft` এ থাকলে:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../digiprosoft/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../digiprosoft/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../digiprosoft/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

`public_html/.htaccess` = প্রজেক্টের `public/.htaccess` (চেঞ্জ লাগে না)।

### ৩.৩ Build দু জায়গায় কেন?

| পাথ | কে ব্যবহার করে |
|-----|----------------|
| `~/digiprosoft/public/build/manifest.json` | Laravel `@vite` (PHP) |
| `~/public_html/build/assets/...` | ব্রাউজার (`/build/assets/...`) |

শুধু `public_html`-এ রাখলে: `ViteManifestNotFoundException`।  
শুধু `digiprosoft/public`-এ রাখলে: CSS/JS **404**।

**সিমলিংক (SSH, এক কপি):**

```bash
# বিল্ড রাখুন digiprosoft এ
mkdir -p ~/digiprosoft/public/build

# public_html থেকে লিংক
rm -rf ~/public_html/build
ln -s ~/digiprosoft/public/build ~/public_html/build

# images-ও চাইলে:
rm -rf ~/public_html/images
ln -s ~/digiprosoft/public/images ~/public_html/images
```

Zip আনজিপ করলে যেন `public/build/build/` না হয় — `manifest.json` সরাসরি `build/` এ থাকতে হবে। `__MACOSX` মুছে দিন।

---

## 4. পরে আপডেট (`git pull`)

```bash
cd ~/digiprosoft
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

নতুন frontend থাকলে:

1. লোকালে `npm run build`
2. `public/build` → `digiprosoft/public/build` (+ symlink হলে `public_html` অটো)
3. symlink না থাকলে `public_html/build` আবার কপি

`index.php` একবার ঠিক করলে বারবার এডিট লাগে না।

---

## 5. পারফরম্যান্স চেকলিস্ট (সাইট ধীর হলে)

ছোট মার্কেটিং সাইট হলেও শেয়ার্ড হোস্টিং + Laravel কোল্ড স্টার্টে ২–৫ সেকেন্ড লাগতে পারে।

### এখনই করুন

| # | কাজ | কেন |
|---|-----|-----|
| 1 | `APP_DEBUG=false`, `APP_ENV=production` | ডিবাগ ওভারহেড বন্ধ |
| 2 | `SESSION_DRIVER=file`, `CACHE_STORE=file` | MySQL সেশন/ক্যাশ হিট কমে |
| 3 | `php artisan optimize` + config/route/view cache | প্রতি রিকোয়েস্টে কম কাজ |
| 4 | Cloudflare (ফ্রি) + ক্যাশিং | TTFB/স্ট্যাটিক অ্যাসেট দ্রুত |
| 5 | `storage` ও `bootstrap/cache` writable (`775`) | ক্যাশ লিখতে পারে |

### ব্রাউজারে চেক

1. Hard refresh (`Cmd+Shift+R`)
2. DevTools → Network → হোমপেজ **TTFB**
3. `/build/assets/*.css` ও `*.js` **200** কিনা
4. `/build/manifest.json` ওয়েবে না খুললেও PHP পাথে (`digiprosoft/public/build/`) থাকতে হবে

### সাধারণ ভুল → সিম্পটম

| সমস্যা | দেখায় |
|--------|--------|
| Document Root = `public_html`, অ্যাসেট শুধু `public_html/public/build` | `/build/...` 404; `/public/build/...` 200 |
| Build শুধু `public_html`-এ | `ViteManifestNotFoundException` |
| Zip → `build/build/manifest.json` | Vite/অ্যাসেট পাথ ভাঙে |
| `APP_DEBUG=true` | Ignition পেজ, ধীর লোড |
| `CACHE_STORE=database` + শেয়ার্ড MySQL | প্রতি পেজে অতিরিক্ত DB লেটেন্সি |

---

## 6. দ্রুত হেলথ চেক (SSH)

```bash
cd ~/digiprosoft
php -v
php artisan about
php artisan config:show app.debug
php artisan config:show app.env
ls -la public/build/manifest.json
ls -la ~/public_html/build/manifest.json   # বা symlink টার্গেট
```

ওয়েব:

- `https://digiprosoft.com/` → 200, স্টাইলসহ
- `https://digiprosoft.com/build/assets/` এর CSS/JS → 200
- `https://digiprosoft.com/images/brand/digiprosoft-logo.png` → 200

---

## 7. সম্পর্কিত ডক

- SEO / AI discoverability: `doc-sm/SEO.md`
- লোকাল ডেভ: `composer run dev` বা `npm run dev` + `php artisan serve`

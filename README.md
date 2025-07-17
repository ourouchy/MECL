---

## Laravel E‑Commerce starter kit

> E-commerce platform built with **Laravel 11**, featuring a **Blade + Alpine.js** customer-facing frontend and a **Vue.js** SPA admin dashboard. Discounts are already implemented, but I plan to improve them this week. The platform is production-ready overall, with a complete UI — you can check it live at [friandos.fr](https://friandos.fr) and [admin.friandos.fr/login](https://admin.friandos.fr/login) (email: `moad.clash@gmail.com`, password: `Admin123`).
>
> The UI is already done, and honestly, it’s easier for beginners to start by customizing a finished interface, so I’m keeping it that way for now.

---

## Tech Stack

| Layer       | Technology                             |
|-------------|----------------------------------------|
| Backend     | Laravel 10 (PHP 8+)                    |
| Frontend    | Blade + Alpine.js + Tailwind CSS       |
| Admin Panel | Vue.js 3 + Vue Router + Vite + Pinia   |
| Database    | MySQL                                  |
| Auth        | Laravel Sanctum                        |
| Storage     | Laravel Filesystem (Public Disk)       |

---

## Project Structure

```bash
.
├── app/                 # Laravel backend logic
├── resources/views/     # Blade templates (Alpine + Tailwind)
├── public/              # Public assets (entry point for Blade)
├── storage/app/public/  # Image uploads (symlinked to /public/storage)
├── backend/             # Vue.js SPA for admin (runs independently)
├── routes/              # Web + API routes
├── database/            # Migrations, seeders, factories
└── README.md            # This file
````


## App Architecture

* **Customer Site (`/`)**

  * Blade-rendered pages using Alpine.js for interactivity
  * Server-rendered product views, filtering, cart
  * Tailwind-powered responsive UI

* **Admin Panel (`/app`)**

  * Vue SPA running separately (during development)
  * Manages products, categories, images, orders, users, carousel
  * Communicates with Laravel API via Axios (`/api/...`)

---

## Backend-Frontend Communication

```text
Vue (backend/)
 └── Axios API Calls
     → Laravel API (root)
        → DB, Storage, Auth

Blade (root)
 └── Blade + Alpine.js
     → Fetch() API or inline PHP
        → Laravel Logic
```

* Both frontends share the same **Laravel API layer**
* All image uploads are stored in `storage/app/public`, accessible via `public/storage` (symlinked)
* APIs return **full image URLs** via `url(Storage::url(...))` to support both frontends

---

## Development Setup

### Prerequisites

* PHP 8.1+
* Composer
* Node.js (LTS)
* MySQL or MariaDB

### 1. Install dependencies

```bash
composer install
npm install
cd backend/
npm install
```

### 2. Configure environment

Copy `.env` and set DB, mail, and storage settings:

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Set up database

```bash
php artisan migrate --seed
```

### 4. Create storage link

```bash
php artisan storage:link
```

### 5. Run servers (DEV)

```bash
# In root terminal:
php artisan serve
npm run dev

# In backend/ folder (Vue admin):
npm run dev
```

---

## Production Build

```bash
# Build Blade assets (Alpine + Tailwind)
npm run build

# Build Vue admin panel
cd backend/
npm run build
```

* Outputs Vue build to `backend/dist`
* In production, Vue files can be copied/mounted behind `/app` route or served from a subdomain

---

## Auth & Security

* Laravel Sanctum for API authentication
* Admin routes protected by middleware
* File uploads use `public` disk with filename hashing

---

## Image & File Handling

* Images (products, carousel, etc.) are uploaded via Vue admin or Blade forms
* Stored in `storage/app/public/...`
* Accessed via `/storage/...` (after `php artisan storage:link`)
* API returns full URLs to support both Blade and Vue

---

## Architectural Summary

* Laravel serves as **unified backend** for both UIs
* **Blade + Alpine.js:** customer frontend, fast and SSR-friendly
* **Vue SPA:** modern admin dashboard with async API calls
* Seamless sharing of models, APIs, and storage

---

## Developer Notes

> During development, **you’ll need three terminals** running:
>
> 1. `php artisan serve` (Laravel backend)
> 2. `npm run dev` (Blade/Alpine in root)
> 3. `npm run dev` (in `backend/` for Vue SPA)
>
> In production, run `npm run build` in both the root and backend folders. The Laravel app handles both UIs depending on routing.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

```

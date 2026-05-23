# 🛒 Fruitkha — Organic Grocery E-Commerce Platform

A full-featured e-commerce application for organic fruits and groceries, built with **Laravel 12**, featuring a dual-authentication system (customers + admin panel), complete order lifecycle management, role-based access control, and a service-oriented architecture.

---

## 📋 Table of Contents

- [Architecture Overview](#architecture-overview)
- [Tech Stack](#tech-stack)
- [Service Layer](#service-layer)
- [Feature Modules](#feature-modules)
- [Database Schema](#database-schema)
- [Authentication & Authorization](#authentication--authorization)
- [API Routes](#api-routes)
- [Admin Panel](#admin-panel)
- [Frontend Pages](#frontend-pages)
- [Getting Started](#getting-started)
- [Testing](#testing)

---

## 🏗 Architecture Overview

Fruitkha follows a **monolithic architecture with a service-oriented layer** — a standard Laravel 12 application where business logic is organized into dedicated service classes, controllers, and models. The architecture separates concerns into three main areas:

| Layer | Responsibility |
|---|---|
| **Presentation** | Blade views (Frontend + Admin), layouts, components |
| **Application** | Controllers, Form Requests, Middleware |
| **Domain** | Models, Services, Traits, Policies |

The application operates two separate authentication guards:

| Guard | Audience | Middleware |
|---|---|---|
| `web` | End customers / shoppers | `auth` |
| `admin` | Store administrators / employees | `admin`, `permission:{slug}` |

---

## ⚙️ Tech Stack

### Backend

| Technology | Version | Purpose |
|---|---|---|
| PHP | ^8.2 | Runtime |
| Laravel Framework | ^12.0 | Core framework |
| Laravel Breeze | ^2.4 | Authentication scaffolding |
| MySQL | — | Primary database |
| Pest PHP | ^3.8 | Testing |
| Laravel Pint | ^1.24 | Code style enforcement |

### Frontend

| Technology | Version | Purpose |
|---|---|---|
| Bootstrap | 4.x (Shop) / 5.3 (Admin) | CSS framework |
| Tailwind CSS | ^3.1 | Utility CSS (auth pages) |
| AlpineJS | ^3.4.2 | Reactive UI |
| Vite | ^7.0.7 | Build tool & asset bundling |
| jQuery | — | Legacy frontend interactions |
| Owl Carousel | — | Carousels & sliders |
| FontAwesome | — | Icons |

---

## 🧩 Service Layer

The application employs domain service classes to encapsulate complex business operations, keeping controllers lean and logic reusable. These are **not microservices** but rather **service-layer modules** within the monolith that handle specific business domains.

### Core Services

| Service | File | Responsibilities |
|---|---|---|
| **PaymentService** | `app/Services/PaymentService.php` | Processes payments through multiple methods, handles confirmation/failure/refund workflows, records transaction history, triggers invoice generation |
| **InvoiceService** | `app/Services/InvoiceService.php` | Generates invoice numbers (`INV-YYYYMMDD-XXXXX`), manages invoice lifecycle statuses (pending/paid/cancelled/refunded) |
| **DeliveryService** | `app/Services/DeliveryService.php` | Assigns delivery employees to orders, tracks delivery status progression (preparing → out_for_delivery → delivered), records delivery tracking history |

### Service Interactions

```
Order ──> PaymentService ──> InvoiceService
  │                            │
  └──> DeliveryService ────────┘
          │
          └──> DeliveryTracking (history log)
```

### Cross-Cutting Concerns

| Component | File | Purpose |
|---|---|---|
| **LogsAdminActivity** | `app/Traits/LogsAdminActivity.php` | Trait that automatically logs all admin CRUD actions (model, action type, old/new values, IP, user agent) to `admin_activity_logs` |
| **FooterServiceProvider** | `app/Providers/FooterServiceProvider.php` | Shares `$testimonials` globally across all frontend views via a service provider |
| **CheckPermission** | `app/Http/Middleware/CheckPermission.php` | Middleware that checks permission slugs before allowing access to admin routes |

---

## 📦 Feature Modules

### E-Commerce Core

| Module | Controllers | Models | Description |
|---|---|---|---|
| **Products** | `Admin\ProductController` | `Product` | Full CRUD with image upload, category association, shop display |
| **Categories** | `Admin\CategoryController` | `Category` | CRUD with image, organizes products into groups |
| **Cart** | `Fronts\CartController` | `Cart`, `CartItem` | Authenticated per-user cart; add/remove items with quantity management |
| **Checkout** | `Fronts\CheckoutController` | `Address`, `Payment`, `Order`, `OrderItem` | Address collection, payment method selection (Cash/Card), order placement in a DB transaction with cart cleanup |
| **Orders** | `Admin\OrderController` | `Order` | Full lifecycle: `pending → confirmed → preparing → shipping → delivered / cancelled`; status timestamps tracked |
| **Payments** | `Admin\PaymentManagerController` | `Payment`, `TransactionHistory` | Multi-method (Card/Cash/Stripe/PayPal), approve/fail/refund workflows, full transaction audit trail |

### Content Management

| Module | Controllers | Models | Description |
|---|---|---|---|
| **News/Blog** | `Admin\NewsController` | `News` | CRUD with image, published date, frontend listing + single article view |
| **About** | `Admin\AboutController` | `About` | CRUD with icon, displayed on the frontend About page |
| **Testimonials** | `Admin\TestimonialController` | `Testimonial` | Create/delete with image, shared globally via `FooterServiceProvider` |
| **Contact Us** | `Fronts\ContactUsController`, `Admin\ContactUsController` | `ContactUs` | Frontend form submission; admin read/delete of incoming messages |
| **Settings** | `Admin\SettingController` | `Setting` | Site-wide settings: contact info (address/email/phone), about text, page configuration |
| **Sales** | `Admin\SaleController` | `Sale` | Monthly promotion/discount management |

### Administration

| Module | Controllers | Models | Description |
|---|---|---|---|
| **Roles & Permissions** | `Admin\RoleController` | `Role`, `Permission` | 7 predefined roles, 28 permissions across 8 groups, custom role creation with permission assignment |
| **Admin Users** | `Admin\AdminUserController` | `Admin` | CRUD for admin staff with role assignment |
| **Deliveries** | `Admin\DeliveryController` | `DeliveryTracking` | Assign delivery employees, track delivery status with notes |
| **Invoices** | `Admin\InvoiceController` | `Invoice` | Auto-generated invoices on payment confirmation, view-only |
| **Reports** | `Admin\ReportController` | — | Revenue/order charts (weekly/monthly/yearly), order status distribution, KPI dashboard |
| **Activity Logs** | — | `AdminActivityLog` | Automatic audit trail of all admin actions via trait |

### Authentication

| Module | Controllers | Description |
|---|---|---|
| **User Auth** | `Auth\*` | Registration, login, email verification, password reset, profile management (Laravel Breeze) |
| **Admin Auth** | `AuthAdmin\*` | Separate admin guard with independent registration, login, email verification, password reset |

---

## 🗄 Database Schema

### Core E-Commerce Tables

| Table | Key Columns | Relationships |
|---|---|---|
| `users` | id, name, email, password | hasMany(Order), hasOne(Cart) |
| `admins` | id, name, email, password | belongsToMany(Role), hasMany(AdminActivityLog) |
| `categories` | id, title, image | hasMany(Product) |
| `products` | id, title, description, price, quantity, image, category_id | belongsTo(Category) |
| `carts` | id, user_id | belongsTo(User), hasMany(CartItem) |
| `cart_items` | id, cart_id, product_id, quantity, price | belongsTo(Cart), belongsTo(Product) |
| `addresses` | id, user_id, city, street, building, notes | belongsTo(User) |
| `orders` | id, user_id, total_price, status, payment_id, address_id, assigned_delivery_admin_id | belongsTo(User/Payment/Address/Admin), hasMany(OrderItem/Invoice/DeliveryTracking) |
| `order_items` | id, order_id, product_id, quantity, price | belongsTo(Order/Product) |
| `payments` | id, user_id, amount, method, status, transaction_id | belongsTo(User), hasMany(Order/TransactionHistory) |
| `invoices` | id, order_id, invoice_number, invoice_date, total_amount, status, pdf_path | belongsTo(Order) |
| `delivery_trackings` | id, order_id, admin_id, status, note, tracked_at | belongsTo(Order/Admin) |
| `transaction_histories` | id, payment_id, action, amount, gateway_response, ip_address, user_agent | belongsTo(Payment) |

### RBAC Tables

| Table | Columns |
|---|---|
| `roles` | id, name, slug (unique), description, guard_name |
| `permissions` | id, name, slug (unique), group |
| `admin_role` | admin_id, role_id (pivot) |
| `permission_role` | permission_id, role_id (pivot) |

### Content & Settings Tables

| Table | Key Columns |
|---|---|
| `abouts` | id, title, description, icon |
| `news` | id, title, description, image, published_at |
| `testimonials` | id, title, image |
| `contact_us` | id, name, email, phone, subject, message, event_date |
| `settings` | id, about, contact (JSON), pages (JSON) |
| `sales` | id, sale (JSON: month + discount) |
| `admin_activity_logs` | id, admin_id, action, model_type, model_id, old_values (JSON), new_values (JSON), ip_address, user_agent |

---

## 🔐 Authentication & Authorization

### Guards

```
web guard ───> User model ───> Customer frontend (Cart, Checkout, Dashboard)
admin guard ──> Admin model ──> Admin panel (/admin/*)
```

### Predefined Roles & Permissions

| Role | Slug | Key Permissions |
|---|---|---|
| **Super Admin** | `super-admin` | All permissions |
| **Product Manager** | `product-manager` | view-products, create-products, edit-products, delete-products |
| **Order Manager** | `order-manager` | view-orders, update-order-status, delete-orders |
| **Payment Manager** | `payment-manager` | view-payments, approve-payments, refund-payments |
| **Delivery Manager** | `delivery-manager` | view-deliveries, assign-deliveries, update-delivery-status |
| **Delivery Employee** | `delivery-employee` | view-deliveries, update-delivery-status |
| **Customer Support** | `customer-support` | view-orders, view-contacts |

Permissions are checked via the `CheckPermission` middleware: `->middleware('permission:view-orders')`.

---

## 🛣 API Routes

### Frontend Routes

| Method | URI | Auth | Name |
|---|---|---|---|
| GET | `/` | — | `fronts.index` |
| GET | `/shop` | — | `fronts.shop` |
| GET | `/shop/{product}` | — | `fronts.single-product` |
| GET | `/news` | — | `fronts.news` |
| GET | `/news/{news}` | — | `fronts.single-news` |
| GET | `/about` | — | `fronts.about` |
| GET/POST | `/contact` | — | `fronts.contact` / `fronts.contact.store` |
| GET | `/cart` | `auth` | `fronts.cart.index` |
| POST | `/cart` | `auth` | `fronts.cart.store` |
| DELETE | `/cart/{item}` | `auth` | `fronts.cart.destroy` |
| GET | `/checkout` | `auth` | `fronts.cart.checkout` |
| POST | `/checkout` | `auth` | `fronts.cart.checkout.store` |
| GET | `/order-success` | `auth` | `fronts.cart.success` |

### User Dashboard Routes

| Method | URI | Name |
|---|---|---|
| GET | `/dashboard` | `dashboard` |
| GET/PATCH | `/profile` | `profile.edit` / `profile.update` |
| DELETE | `/profile` | `profile.destroy` |

### Admin Routes (prefix: `/admin`)

| Method | URI | Permission |
|---|---|---|
| GET | `/admin` | — |
| CRUD | `/admin/products` | `view-products` |
| CRUD | `/admin/categories` | `view-categories` |
| CRUD | `/admin/news` | — |
| CRUD | `/admin/abouts` | — |
| CRUD | `/admin/roles` | `view-roles` |
| CRUD | `/admin/admins` | `manage-admins` |
| GET/PUT | `/admin/orders/{order}/status` | `update-order-status` |
| POST | `/admin/payments/{payment}/approve` | `approve-payments` |
| POST | `/admin/payments/{payment}/refund` | `refund-payments` |
| POST | `/admin/orders/{order}/assign-delivery` | `assign-deliveries` |
| GET | `/admin/reports` | `view-reports` |

Full route list: `php artisan route:list`

---

## 🖥 Admin Panel

| Page | Route | Key Features |
|---|---|---|
| **Dashboard** | `GET /admin` | Revenue KPIs, 30-day revenue chart, orders by status chart, recent orders list |
| **Products** | `/admin/products` | CRUD with image upload, category filter |
| **Categories** | `/admin/categories` | CRUD with image |
| **Orders** | `/admin/orders` | Filter by status/date, status updates, delivery assignment |
| **Payments** | `/admin/payments` | Filter, approve, fail, refund |
| **Invoices** | `/admin/invoices` | View-only with filters |
| **Deliveries** | `/admin/deliveries` | Assign employees, update tracking status |
| **News** | `/admin/news` | CRUD with image |
| **About** | `/admin/abouts` | CRUD with icon |
| **Testimonials** | `/admin/testimonials` | Create/delete with image |
| **Contact Us** | `/admin/contacts` | View/delete incoming messages |
| **Roles** | `/admin/roles` | CRUD with permission assignment |
| **Admins** | `/admin/admins` | CRUD with role assignment |
| **Settings** | `/admin/settings` | Contact info, about text, page config |
| **Sales** | `/admin/sales` | Monthly discount management |
| **Reports** | `/admin/reports` | Charts, KPIs, period filtering |

---

## 🌐 Frontend Pages

| Page | Route | Description |
|---|---|---|
| **Home** | `/` | Hero banner, featured categories, deal of the month, testimonials, latest news |
| **Shop** | `/shop` | All products with category filter |
| **Single Product** | `/shop/{product}` | Product detail with add-to-cart |
| **Cart** | `/cart` | Cart items with totals and checkout button |
| **Checkout** | `/checkout` | Address form + payment method selection |
| **Order Success** | `/order-success` | Post-purchase confirmation |
| **About** | `/about` | Company info, team, testimonials |
| **News** | `/news` | Blog article listing |
| **Single News** | `/news/{news}` | Full article view |
| **Contact** | `/contact` | Contact form |
| **Login / Register** | `/login` / `/register` | User authentication |
| **Dashboard** | `/dashboard` | User home after login |

---

## 🚀 Getting Started

### Prerequisites

- PHP ^8.2
- Composer
- MySQL
- Node.js & NPM

### Installation

```bash
# Clone & install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure .env with your database credentials
# DB_DATABASE=fruitkha_maintain_v2
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations & seeders
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start the server
php artisan serve
```

### Default Admin Credentials

| Email | Password | Role |
|---|---|---|
| `super@admin.com` | `password` | Super Admin |
| `product@admin.com` | `password` | Product Manager |
| `orders@admin.com` | `password` | Order Manager |
| `payment@admin.com` | `password` | Payment Manager |
| `delivery@admin.com` | `password` | Delivery Manager |
| `deliveryemp@admin.com` | `password` | Delivery Employee |
| `support@admin.com` | `password` | Customer Support |

Admin login: `http://localhost:8000/admin/login`

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with compact output
php artisan test --compact

# Run specific test file
php artisan test --filter=test_name
```

The test suite includes **25 feature tests** covering authentication, registration, password reset, email verification, and profile management.

---

## 📁 Project Structure

```
app/
├── Console/Commands/          # Custom Artisan commands
├── Exceptions/                # Exception handlers
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # 15 admin panel controllers
│   │   ├── Auth/             # 9 user auth controllers
│   │   ├── AuthAdmin/        # 9 admin auth controllers
│   │   └── Fronts/           # 4 frontend controllers
│   ├── Middleware/            # Admin + CheckPermission middleware
│   └── Requests/             # 15 form request validators
├── Models/                    # 20 Eloquent models
├── Notifications/             # 4 notification classes
├── Policies/                  # 8 authorization policies
├── Providers/                 # AppServiceProvider, FooterServiceProvider
├── Services/                  # PaymentService, InvoiceService, DeliveryService
├── Traits/                    # LogsAdminActivity
└── View/Components/           # AppLayout, GuestLayout, Sidebar

database/
├── factories/                 # 9 model factories
├── migrations/                # 28 migration files
└── seeders/                   # 11 seeders

resources/views/
├── admin/                     # All admin panel views
├── fronts/                    # All frontend customer views
├── layouts/                   # Layout templates
├── components/                # Blade components
└── profile/                   # User profile views

routes/
├── web.php                    # Main route definitions
├── auth.php                   # User auth routes
└── authAdmin.php              # Admin auth routes
```

---

## 📄 License

This project is open-sourced under the MIT license.

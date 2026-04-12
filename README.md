<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="340" alt="Laravel Logo"/>
</p>

<h1 align="center">💸 Finance Management API</h1>

<p align="center">
  A personal financial management REST API built as a portfolio project — track income, expenses, installments, and recurring charges with clean DDD architecture.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/PostgreSQL-16-4169E1?style=for-the-badge&logo=postgresql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Sanctum-Auth-orange?style=for-the-badge&logo=laravel&logoColor=white"/>
</p>

---

## 📋 About

This API was built as a backend portfolio project focused on clean architecture and real-world financial domain modeling. It allows users to manage their personal finances by registering income and expenses, filtering transactions, and tracking installment and recurring payments.

The project applies **Domain-Driven Design (DDD)** concepts in a pragmatic and non-over-engineered way — just enough structure to keep the codebase maintainable and well-organized without falling into unnecessary complexity.

---

## ✨ Features

- 🔐 Authentication via Laravel Sanctum (register, login, logout)
- 💰 Expense management with three types:
    - **Unique** — one-time expenses
    - **Installment** — auto-generates installment records on creation
    - **Recurring** — monthly charges tracked via transaction history
- 📊 Financial transactions log (income & outcome)
- 🔍 Advanced filtering on expenses (type, category, date range, amount range)
- 📄 Paginated responses
- 🛡️ Policy-based authorization (users can only manage their own data)
- 🗑️ Soft deletes across all entities

---

## 🏗️ Architecture

The project follows a pragmatic DDD structure, organized around the Finance domain:

```
app/
├── Domain/
│   └── Finance/
│       ├── Expense/
│       │   ├── DTOs/
│       │   ├── Models/
│       │   ├── Repositories/
│       │   │   ├── Contracts/
│       │   │   └── Eloquent/
│       │   └── Services/
│       └── Transaction/
│           ├── DTOs/
│           ├── Models/
│           ├── Repositories/
│           │   ├── Contracts/
│           │   └── Eloquent/
│           └── Services/
├── Http/
│   ├── Controllers/
│   │   └── Finance/
│   │       ├── Expense/
│   │       └── Transaction/
│   ├── Requests/
│   │   └── Finance/
│   │       ├── Expense/
│   │       └── Transaction/
│   └── Resources/
│       └── Finance/
├── Models/
│   └── User.php
├── Policies/
└── Services/
    └── UserService.php
```

**Key patterns applied:**

- Repository pattern with Interface contracts and Eloquent implementations
- DTOs with `readonly` properties and `fromRequest` static factory methods
- Service layer encapsulating all business logic
- Form Requests for validation (including conditional rules)
- API Resources for consistent response shaping
- AppServiceProvider for interface-to-implementation bindings

---

## 🗄️ Data Model

```
users
  └── expenses (unique | installment | recurring)
        ├── expenses_installments  (for installment type)
        └── transactions           (income / outcome log)
```

**Business rules:**

- Paying an installment creates a `transaction` record and marks the installment with `paid_at`
- Paying a recurring expense creates a `transaction` linked to the expense — queried by month to determine current period payment status
- A manual income entry is a `transaction` with `expense_id = null`
- Soft deletes are used across all entities; cascade deletes are handled at the application layer

---

## 🚀 Getting Started

### Requirements

- PHP 8.2+
- Composer
- PostgreSQL
- Laravel 11

### Installation

```bash
# Clone the repository
git clone https://github.com/your-username/api-finances.git
cd api-finances

# Install dependencies
composer install

# Copy and configure environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate
```

### Running

```bash
php artisan serve
```

---

## 🔑 Authentication

All protected routes require a Bearer token obtained via `/api/v1/login`.

```
POST /api/v1/register
POST /api/v1/login
DELETE /api/v1/logout  ← requires auth
```

---

## 📡 API Endpoints

All routes below require `Authorization: Bearer {token}`.

### Expenses

| Method | Endpoint                         | Description                |
| ------ | -------------------------------- | -------------------------- |
| GET    | `/api/v1/finances/expenses`      | List expenses with filters |
| POST   | `/api/v1/finances/expenses`      | Create a new expense       |
| GET    | `/api/v1/finances/expenses/{id}` | Get a specific expense     |
| PUT    | `/api/v1/finances/expenses/{id}` | Update an expense          |
| DELETE | `/api/v1/finances/expenses/{id}` | Soft delete an expense     |

**Available filters (query params):**

| Param              | Type    | Description                            |
| ------------------ | ------- | -------------------------------------- |
| `type`             | string  | `unique`, `installment` or `recurring` |
| `category`         | string  | Filter by category                     |
| `min_value`        | numeric | Minimum total amount                   |
| `max_value`        | numeric | Maximum total amount                   |
| `has_installments` | boolean | Filter by installment existence        |
| `start_date`       | date    | From first due date                    |
| `end_date`         | date    | To first due date                      |

---

## 🛡️ Authorization

Users can only view, update, and delete their own expenses. Unauthorized access returns `403 Forbidden`.

---

## 📦 Tech Stack

| Layer          | Technology                 |
| -------------- | -------------------------- |
| Language       | PHP 8.4+                   |
| Framework      | Laravel 13                 |
| Database       | PostgreSQL                 |
| Authentication | Laravel Sanctum            |
| Architecture   | Domain-Driven Design (DDD) |

---

## 📝 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

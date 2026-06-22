# Mini Issue Tracker

A simple issue tracking application built with Laravel 13 and Blade. The application allows a small team to manage projects, issues, tags, and comments.

## Features

* Authentication (Laravel Breeze)
* Create, edit, view and delete projects
* Create, edit, view and delete issues
* Filter issues by status, priority and tags
* Create and manage tags
* Attach and detach tags from issues via AJAX
* Add and load comments via AJAX with pagination
* Form Request validation
* Eloquent relationships with eager loading
* Factories and seeders for demo data

## Tech Stack

* Laravel 13
* Blade
* MySQL
* JavaScript (AJAX)
* Tailwind CSS

## Installation

Clone the repository:

```bash
git clone https://github.com/enisabazi2005/pritechproject.git
cd mini-issue-tracker
```

Install dependencies:

```bash
composer install
npm install
npm run build
```

Create your environment file:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database inside `.env`, then run:

```bash
php artisan migrate --seed
```

Start the application:

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Demo User

You can register a new account or use the seeded data after running the seeders.

---

This project was built as part of the PRITECH Laravel Technical Task.

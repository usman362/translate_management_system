# Translation Management System

## Project Overview
This Laravel-based Translation Management System allows storing and managing translations for multiple locales (e.g., `en`, `fr`, `es`). It supports adding new languages dynamically, tagging translations for context (`mobile`, `desktop`, `web`), and exposing APIs for creating, updating, searching, and exporting translations. The JSON export endpoint ensures updated translations are always returned, making it ideal for frontend applications like Vue.js.

## Features
- **Multi-locale Support**: Easily add new languages.
- **Tag-Based Searching**: Search translations by tags, keys, or content.
- **Optimized JSON Export**: Fast retrieval of translations (< 500ms for large datasets).
- **Token-Based Authentication**: Secure API access.
- **PSR-12 & SOLID Compliance**: Clean and maintainable codebase.
- **Optimized SQL Queries**: High performance and scalability.
- **Docker Support**: Simplified deployment.
- **CDN Support**: Faster content delivery.
- **Swagger Documentation**: OpenAPI specification for API documentation.
- **95%+ Test Coverage**: Unit and feature tests, including performance testing.

## Tech Stack
- **Backend**: Laravel (PHP 8+)
- **Database**: MySQL 8.0
- **Caching**: Redis
- **Authentication**: Laravel Sanctum (Token-based Auth)
- **Containerization**: Docker
- **API Documentation**: Swagger (L5-Swagger)

## Installation
### Clone the Repository
```sh
git clone https://github.com/usman362/translate_management_system
cd translate_management_system
```

### Set Up Environment Variables
Copy `.env.example` to `.env` and update the database credentials:
```sh
cp .env.example .env
```
Modify `.env`:
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=translation
DB_USERNAME=root
DB_PASSWORD=root
```

### Install Dependencies
```sh
composer install
npm install
```

### Generate Application Key
```sh
php artisan key:generate
```

### Run Migrations & Seed Database
```sh
php artisan migrate

php artisan db:seed --class=DatabaseSeeder #for Create User [name=Test User, email=test@example.com, password=password]

```
### Insert Language 100k+

```sh
php artisan seed:translations {number} #example: php artisan seed:translations 1000

### Start the Development Server
```sh
php artisan serve
```

## Docker Setup
### Build and Start Containers
```sh
docker-compose up --build -d
```
### Run Migrations Inside the Container
```sh
docker exec -it laravel_app php artisan migrate --seed
```

## API Documentation
Swagger documentation is available at:
```
http://localhost:8000/api/documentation
```
To regenerate docs:
```sh
php artisan l5-swagger:generate
```

## JSON Endpoint

## Retrieve all translations:
```http 
GET /api/translations
```
## Store translations:
```http 
POST /api/translations
```
## Update translations:
```http 
POST /api/translations/{translation}
```
## Delete translations:
```http 
DELETE /api/translations/{translation}
```
## Search translations:
```http 
GET /api/translations/search?key=&value=&tag=
```
## Retrieve all translations mapping:
```http
GET /api/translations/export
```

## Authentication
Use Laravel Sanctum for API authentication:
### Register
```http
POST /api/register
```
**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret",
}
```

### Login
```http
POST /api/login
```
**Response:**
```json
{
  "token": "your-access-token"
}
```

### Logout
```http
POST /api/logout
```
**Header:**
```http
Authorization: Bearer {token}
```

## Testing
Run unit and feature tests with:
```sh
php artisan test
```



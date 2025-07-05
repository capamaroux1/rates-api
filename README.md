# Assignment - Exchange Rate API

---

## Tech Stack

- **Backend:** Laravel 12 (PHP)
- **Database:** MySQL

---

## Requirements
- PHP 8.2+
- Composer


---

## Setup Instructions

### Backend (Laravel)

#### 1. Clone the repo
```bash
git clone https://github.com/capamaroux1/rates-api
cd assignment
```
#### 2. Install PHP dependencies
```bash
composer install
```

#### 3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Configure MySql in .env file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=exchange_api_db
DB_USERNAME=
DB_PASSWORD=
```

#### 5. Run migrations
```bash
php artisan migrate
```

#### 6. Run the development server
```bash
php artisan serve
```

#### 7. Fetch exchange rates from ECB
```bash
php artisan app:fetch-exchange-rates
```
---


## API Endpoints

- **List all exchange rates (with pagination and filters):**
API filter parameters:
currency_from, currency_to, rate_date, retrieved_at, page

  ```
  GET http://localhost:8000/api/exchange-rates
  GET http://localhost:8000/api/exchange-rates?currency_to=USD&rate_date=2025-07-03
  ```
- **Example response:**
  ```json
    {
      "current_page": 2,
      "data": [
        {
          "id": 16,
          "currency_from": "EUR",
          "currency_to": "BRL",
          "rate": 6.3992,
          "rate_date": "2025-07-03",
          "retrieved_at": 1751573793,
          "created_at": "2025-07-03T20:16:33.000000Z",
          "updated_at": "2025-07-03T20:16:33.000000Z"
        },
        {
          "id": 17,
          "currency_from": "EUR",
          "currency_to": "CAD",
          "rate": 1.601,
          "rate_date": "2025-07-03",
          "retrieved_at": 1751573793,
          "created_at": "2025-07-03T20:16:33.000000Z",
          "updated_at": "2025-07-03T20:16:33.000000Z"
        },
      { "...": "more rates" }
      ],
      "first_page_url": "...",
      "from": 16,
      "last_page": 2,
      "last_page_url": "...",
      "links": [
        {
          "url": "...",
          "label": "...",
          "active": false
        },
        {
          "url": "...",
          "label": "1",
          "active": false
        },
        {
          "url": "...",
          "label": "2",
          "active": true
        },
        {
          "url": null,
          "label": "...",
          "active": false
        }
      ],
      "next_page_url": null,
      "path": "...",
      "per_page": 15,
      "prev_page_url":  "...",
      "to": 30,
      "total": 30
    }
    ```


- **Get a specific exchange rate:**
  ```
  GET http://localhost:8000/api/exchange-rates/{id}
  ```
- **Example response:**
  ```json
  {
  "id": 1,
  "currency_from": "EUR",
  "currency_to": "USD",
  "rate": 1.1782,
  "rate_date": "2025-07-03",
  "retrieved_at": 1751573793,
  "created_at": "2025-07-03T20:16:33.000000Z",
  "updated_at": "2025-07-03T20:16:33.000000Z"
  }
 ```


---

## Running Automated Tests

To run all feature and unit tests:
```bash
php artisan test
```
or
```bash
./vendor/bin/phpunit
```

# Restaurant reservation

Reservation Restaurant is a simple Laravel 10 project that allows users to make reservations at a restaurant. The project is built using MySQL.


## Run Locally

Requirements
```bash
  PHP 8.1 or higher
  Composer
  MySQL or MariaDB
```

Clone the project

```bash
  git clone https://github.com/haqiti16/laravel-restaurant-reservation.git
```

Go to the project directory

```bash
  cd laravel-restaurant-reservation
```

Install dependencies

```bash
  composer install
```

Create a MySQL or MariaDB database named reservation_restaurant


Run the following command to create the .env file from the .env.example file:

```bash
  cp .env.example .env
```

Open the .env file and set the following values:

```bash
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=reservation_restaurant
DB_USERNAME=root
DB_PASSWORD=
```

Run the following command to create the database tables:

```bash
php artisan migrate
```

Run the following command to fill the demo data:

```bash
php artisan db:seed
```

Run the following command to start the server:

```bash
php artisan serve
```

The project will now be accessible at http://localhost:8000/


API Reference :

```bash
docs/reservation-api.json
```

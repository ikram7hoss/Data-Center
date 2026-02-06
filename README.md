Data Center Resource Reservation Web Application

A web application built with Laravel that allows internal users to reserve data center resources efficiently and securely.

Features :

1.User authentication 

2.Browse available resources

3.Submit reservation requests

4.Track reservation status

5.Admin management of resources and requests

Tech Stack : 

. Backend: Laravel & PHP

. Database: MySQL

. Frontend:  HTML / CSS

. Auth & Sessions: Laravel built-in authentication

Installation : 

Follow these steps to set up and run the project locally:

# 1. Clone the repository
git clone https://github.com/ikram7hoss/Data-Center.git
cd Data-Center

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database
 Open .env and set your DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Run database migrations
php artisan migrate

# 7. Start the built-in server
php artisan serve

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

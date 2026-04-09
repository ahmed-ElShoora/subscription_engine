# Subscription Engine API
Laravel RESTful API for managing subscription plans, trials, and payments.

# Architecture Decisions
1. **MVC + Service Layer**: Controllers handle requests only, business logic moved to Services for clean and scalable code
2. **Form Requests** : Used for validation to keep controllers clean.
3. **API Resources**: Used for consistent API responses.
4. **Console Commands**: Used for background tasks like expiring subscriptions.
5. **Simulated Payment Provider**: simulate payment getawy .
6. **Currency Helper** : to Convert from currency to other for Supports multi-currency pricing (USD, EGP, AED).

## Set Up Project :
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan migrate
5. php artisan db:seed

## run project
1. in terminal 1 : php artisan serve --port=8000
2. in terminal 2 : php artisan serve --port=9000 
3. in terminal 3 : php artisan schedule:run

note : in production run command 3 in cron jop : [* * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1]

## user for test
1. email = test@test.com
2. password = password

## i create route for test if you in plan or not , this route is [TestUserHavePlan] in Postman Colliction
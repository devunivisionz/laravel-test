# Laravel Test


## Instructions
1. Read this documentation.
2. Clone this repository to your local.
3. create .env file using .env.example
4. create database in your local and modify .env configiration
3. Run {composer install}
4. Run {php artisan migrate}
5. Run {php artisan db:seed --class=UserTableSeeder} to generate fake users 
6. Run {php artisan serve} to run the project

## URLs
1. For Crud
    - http://127.0.0.1:8000
2. For API
    - http://127.0.0.1:8000/api
    
## Postman Collection

- Here is the link of postman collection you can import in postman and access the Restful API
- https://www.getpostman.com/collections/08c79229eda4f36a83ab
- You can create envirement for {HOST} variable in postman


## Notification Instructions

- You can use below instruction for enable notification 
- You can see in .env file
- Variables
    - SMS_NOTIFICATION_ENABLE=false
    - EMAIL_NOTIFICATION_ENABLE=false

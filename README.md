# Getting started

## Installation Laravel Banckend



Clone the repository

Switch to the repo folder

    cd project-management-app/backend

Install all the dependencies using composer

    composer update

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
    php artisan db:seed
    
    php artisan passport:install

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Installation Frontend Nuxt 

cd project-management-app/frontend

     npm install

     npm run dev
     
You can now access the frontend server at http://localhost:3000



### BLOG APPLICATION INSTALLATION 
    1: Install of new application - Done
    2: Setup Database Connection  - Done
    3: Add Database Creditential  - Done

## INSTALLING LARAVEL BREEZE
    1. Installing the Authentication system with Laravel Breeze .
            composer require laravel/breeze --dev
            php artisan breeze:install
            npm install 
            npm run dev
            php artisan migrate
    2: Open projectt by type valet link

## DEFINING MIGRATIONS
    1. Defining the Article Migration via CLI
            php artisan make:model Tag -r -f -m
            php artisan make:model Category -r -f -m
            php artisan make:model Post  -r -f -m   

    2: Define all the migratiion attributes/column to each table

    3: Define the relationship inside the migrations .
        Exampple:
            USER -------> POST 
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            CATEGORY -------> POST 
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

    4: Create the PIVOT table between Tags and Article Model via CLI 
        php artisan make:migration create_article_tag_table

        . Open the article-tag migration add the constraints key
                    $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
                    $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
    5: Migrate CLI
        php artisan migrate
    

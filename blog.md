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


## DEFINING MODELS / RELATIONSHIP
    1: Add the Mass Assigment to all Models
            Article
            Category
            Tag
            User 
    2: Define the relation between two models
         . one-to-many relationship (User and Article)

                . Article Model 

                        public  function  user() : BelongsTo
                        {
                            return $this->belongsTo(User:: class); //FK user_id
                        }

                        public  function  category() : BelongsTo
                        {
                            return $this->belongsTo(Category:: class); //FK category_id
                        }

                . The above is an inverse of one to many relationship

    3: Another relationship is between Article and Tag
        . Open Article
                public  function  tags():BelongsToMany
                {
                    return $this->belongsToMany(Tag::class);
                }

    4: Open the Category Model   and  add hasMany
        1:M
    
           public  function  articles(): HasMany
            {
                return $this->hasMany(Article::class);
            } 
    5: Open the User Model   and  add hasMany
        1:M
    
           public  function  articles(): HasMany
            {
                return $this->hasMany(Article::class);
            } 

    6: Open the Tag Models 




    

### BLOG APPLICATION INSTALLATION 
    1: Install of new application - Done
    2: Setup Database Connection  - Done
    3: Add Database Creditential  - Done
    4:  Pa$$w0rd!

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

    6: Open the Tag Models  M:M
         public  function  articles():BelongsToMany
        {
            return $this->belongsToMany(Article::class);
        }

## CREATING MODELS , CONTROLLERS , FACTORIES AND MIGRATIONS
    1: Setup the application structure before we continue on .
             php artisan make:model Tag -r -f -m
             php artisan make:model Category -r -f -m
             php artisan make:model Post  -r -f -m  

## INSERTING DATA USING FACTORIES AND SEEDERS
    1: Insert data will real data
    2: Open the CLI command 
        php artisan make:seeder CategorySeeder
    3: We gonna create a Json File 
            database/data/categories.json
    4: Open the Category Seeder File and call the json
            $json = File::get('database/data/categories.json');

            /**Decode into ana array*/
    
            $categories = collect(json_decode($json,true));
    
            $categories->each(function ($category){
                Category::create([
                    'name'          => $category['name'],
                    'description'   => $category['description'],
                    'slug'          => $category['slug'],
                ]);
            });
    5: Open the Database Seeder and call Category
        
        $this->call(CategorySeeder::class);

    6: Genereate the rest of model via Factories
        . Article Faatories

                $title = fake()->unique()->sentence;
                $slug  = Str::slug($title);

                public function definition(): array
                {
                    $title = fake()->unique()->sentence;
                    $slug  = Str::slug($title);
            
                    return [
                        'title'         => $title,
                        'slug'          => $slug,
                        'excerpt'       => fake()->paragraphs(2, true),
                        'description'   => fake()->paragraphs(8, true),
                        'status'        => true,
                        'user_id'       => User::inRandomOrder()->value('id'),
                        'category_id'   => Category::inRandomOrder()->value('id')
                    ];
                }

        . Tag  Faatories

            public function definition(): array
            {
                $name = fake()->unique()->word;
                $slug = Str::slug($name);
        
                return [
                    'name' => $name,
                    'slug' => $slug
                ];
            }
    
    
    7: Open the Database Seeder
        public function run(): void
        {
            //Order does matter
            $this->call(CategorySeeder::class);
    
            User::factory()->count(10)->create();
    
            Article::factory()
                ->has(Tag::factory()->count(2))
                ->count(50)
                ->create();
        }
    8: Run DB SEED CLI
            php artisan db:seed
    9: VIEW ON DATABASE - PASSED

## SETTING UP ARTICLE ROUTES
    - Open the web file
        Route::resource('articles', ArticleController::class)->except(['index','show']);
    - Whe the user has been registered will redirected to the dashboard
        http://blogpost-application.test/dashboard
    - Front view route
        Route::resource('/articles', ArticleController::class)->only(['index','show']);
    - Backend route 
        Route::resource('/dashboard/articles', ArticleController::class)->except(['index','show']);

## SETTING UP THE FRONTEND PAGES
    https://gist.github.com/codewithdary/2071f43fc171ebe00be4b9f523fb5998
    - create a new directory inside the views and call articles
        .articles
            resources/views/articles/index.blade.php
            resources/views/articles/create.blade.php
            resources/views/articles/edit.blade.php
            resources/views/articles/show.blade.php
                    layouts
                        resources/views/articles/layouts/app.blade.php
                        resources/views/articles/layouts/navbar.blade.php

## THE INDEX() METHOD
    - Add the logic inside the index method in ArticleController
         public function index()
            {
               $articles = Article::with(['user', 'tags'])->get();
        
               return view('articles.index', compact('articles'));
            }
    - Open the index.blade.php annd loop over
        1: 
            @forelse($articles as $article)
            @empty
                  <h2 class="hover:text-red-700 sm:w-3/5 transition-all text-white sm:pt-0 pt-10 text-3xl sm:text-4xl font-bold sm:pb-2 w-full block">
                        Unfortunately, we have not found any articles .
                    </h2>
             @endforelse

        2:   @foreach(($articles as $article)

             @endforeach

        3: Display the  Date 
            {{ $article->created_at->format("M jS Y") }},

        4: Access the Relationship in blade , we can add the dot notation to chain the relationship .
            to the variable representing the model 
            . Sinnce we have the Article Model , we have send the relationship using user().
            . Example code
                {{ $article->user->name  }}

        5: To show a speciific article  based on the slug
            .example code 
                    <a href="{{ route('articles.show', $article->slug) }}">

        6: To Access the tags via relationship via the Article Model
            . Tags are coming from Pivot table , we need to loop them .
            .example of the code to dispay the tags in fron ennd

             @foreach($article->tags as $tag)
                {{$tag->name}}
             @endforeach
        7: To implement the Pagination  in Article Controller
             public function index()
            {
                //$articles = Article::with(['user', 'tags'])->latest()->paginate();
                $articles = Article::with(['user', 'tags'])->latest()->simplePaginate();
        
               return view('articles.index', compact('articles'));
            }
        8 : Add the method in blade to show the paggination 
            . code example
                <div class="py-20">
                {{ $articles->links() }}
                </div>
                    
          

    

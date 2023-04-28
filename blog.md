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

## THE SHOW() METHOD
    - Add logic to display the content via show method in ArticleController VIA model binding
             public function show(Article $article)
            {
                return view('articles.show', compact('article'));
            }
    - 401 not found - Page doesnt exist .By defalut binding works with id column .PK
    - As we're want to use the slug  instead of id column ,we should add another logic in the Article Model 
            public  function  getRouteKeyName()
            {
                return 'slug';
            }
        . return the string as above
    - Open the show.blade.php 
        . Access the name via Article Model
            {{$article->user->name }} 
        . Display the date 
            {{ $article->created_at->format("M jS Y") }}
        . Access the  Category name via Article Model relationship
            {{ $article->category->name }}
        . Display all the tags , as we're working on many to many relationship .
            . Article can have many tags .
                    @foreach($article->tags as $tag)
                        {{ $tag->name }}
                    @endforeach
    - To show an article for specific user
        . open the web file and add the logic in dashbord
                Route::get('/dashboard', function () {
                 $articles = \App\Models\Article::where('user_id', auth()->id())->paginate();

                return view('dashboard' ,compact('articles'));

                })->middleware(['auth', 'verified'])->name('dashboard');
        . Open the Dashboard.blade file display tthe innformation

## THE CREATE() & STORE() METHODS
    - Open the span of article button in index.blade.php file 
        . paste the span inside the dashboard
    - Open the ArticleController inside the create() method we gonna return view
            .pluck() - retrive a specific column insteed of return all column

            public function create() :View
                {
                    $categories = Category::pluck('name','id');
                    
                    $tags = Tag::pluck('name','id');
                        
                    return view('articles.create', compact('categories', 'tags'));
                }
    - Open the create.blade file , we should add the categories and tags within the loop .
        . dd categories
                {{ dd($categories) }}
            
            #items: array:3 [▼
                1 => "Laravel"
                2 => "Symfony"
                3 => "Tailwind CSS"
            ]
                KEY => "VALUE
        . Add the id's into the database VIA loop
            @foreach($categories as $key =>$value)
                <option value="x">
                    x
                </option>
            @endforeach

        .  example      value="x" = x: key of our category equivalent to id
            <option value="x">
                   {{value}}
            </option>
    - The complete code for our categories 
            @foreach($categories as $key =>$value)
                <option value="{{$key}}">
                    {{ $value }}
                </option>
            @endforeach

    - Let us do to our Tags, same a aboove
             @foreach($tags as $key => $value)
                <option value="{{$key}}">
                    {{ $value }}
                </option>
             @endforeach

    - Open the ArticleController in store() method
        . dd() our request
            dd($request);
             [▼
                  "_token" => "0vATdtJAKokSP9BkKuJESgXFafPC5jr8UtLnnls4"
                  "status" => "on"
                  "title" => "Test"
                  "excerpt" => "teteteete"
                  "description" => "tdtdtdttdtd"
                  "category" => "2"
                  "tags" => "84"
            ]
        . There's some issue on tags , we have selected multiple tags but we can see the string value 
                "tags" => "84"
        . Solution we need to add the bracket oon name
            name="tags[]" is the part of group input
            it used for multiple select fields.
            When the user can select multiplee options
        . Test again
            [▼
              "_token" => "0vATdtJAKokSP9BkKuJESgXFafPC5jr8UtLnnls4"
              "status" => "on"
              "title" => "Teest"
              "excerpt" => "Teest"
              "description" => "Teest"
              "category" => "2"
              "tags" => array:4 [▼
                0 => "61"
                1 => "14"
                2 => "84"
                3 => "85"
              ]
            ]
    - Create a StoreArticleRequest CLI
        php artisan make:request StoreArticleRequest
        . Add the logic inside the StoreArticleRequest
    - Continue with logic inside store() method
                    article = Article::create([
                        'title'         => $request->title,
                        'slug'          => Str::slug($request->title),
                        'excerpt'       => $request->excerpt,
                        'description'   => $request->description,
                        'status'        => $request->status === 'on'  ,
                        'user_id'       => auth()->id(),
                        'category_id'   => $request->category_id,
                    ]);
            
                    /** Handle Pivot Table */
            
                    $article->tags()->attach($request->tags);
            
                    return redirect(route('articles.index'))->with('message', 'Article has been created Successfully');
                }

    - Add the flush Messsage on index
                @if(session('message'))
                    <div class="p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">
                            Success alert
                        </span>
                        {{ session('message') }}
                    </div>
                @endif

    - We can Optimize better our store() controller
            public function store(StoreArticleRequest $request)
                {
                    $article = Article::create([
                        'slug'          => Str::slug($request->title),
                        'status'        => $request->status === 'on'  ,
                        'user_id'       => auth()->id(),
                    ]+$request->validated());
            
                    /** Handle Pivot Table */
            
                    $article->tags()->attach($request->tags);
            
                    return redirect(route('articles.index'))->with('message', 'Article has been created Successfully');
                }
                    
## THE EDIT() & UPDATE() METHODS
    - Open the dashboard  and add the Edit button
    - Focus on edit() functionality in ArticleController
    - Create a private method to access the categories and tags ,to reduce code duplication.
            private  function getFormData() : array
                {
                    $categories = Category::pluck('name','id');
            
                    $tags = Tag::pluck('name','id');
                    
                    return compact('categories', 'tags');
                }
    - Access the getFormData() in create()
        . $this->getFormData()
    - Display the categories by looping 
          <option value="x">
            x
         </option>
            TO
            @foreach($categories as $key=>$value)
                <option value="{{ $key }}" {{ $article->category_id === $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
    
    - Display the tags by looping  , check if the value are in array 
          <option value="x">
            x
         </option>
            TO
            @foreach($tags as $key => $value)
                <option value="{{ $key }}" {{ in_array($key , $article->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach

    - Navigate to update() and dump
    - Create UpdateArticleReques via CLI
        php artisan make:request UpdateArticleRequest
        .Add the logic inside the UpdateArticleRequest
    - You can import the UpdateArticleRequest inside the update() method and add the logic to update

                public function update(UpdateArticleRequest $request, Article $article)
                    {
                       $article->update($request->validated()+ [
                            'slug' => Str::slug($request->title)
                           ]);
                
                            /**Dettach tag*/
                        $article->tags()->sync($request->tags);
                
                        return redirect(route('dashboard'))->with('message', 'Article has been updated Successfully');
                    }
    - Add the error messagge using laravel components

## THE DESTROY() METHOD
    - Open the ArticleController in destroy and add the logic
            public function destroy(Article $article):RedirectResponse
            {
                $article->delete();
        
                return redirect(route('dashboard'))->with('message', 'Article has been deleted Successfully');
            }
        
    - Have the delete button next to Edit in Dashbaord.blade.php
        <form action="{{ route('articles.destroy', $article->slug) }}" method="post">
            @csrf
            @method('DELETE')
            <button
                class="
            inline-flex
            text-md
            pb-6 pt-8
            pr-3
            py-2
            leading-4
            font-medium

            text-red-400
            hover:text-red-300
            focus:outline
            transition
            ease-in-out duration-150
            float-right">
                Delete
            </button>
        </form>

            
## USING POLICIES FOR UNAUTHORIZED USERS
    - The only authenticated user can delete and update the Post
        . Middleware 
        . Policy
    - Allow to Perfom particular action  CRUD.
    - Create a ArtiiclePolicy via CLI , W/C model should policy associated with
        php artisan make:policy ArticlePolicy --model=Article
    - Register our policy AuthServiceProvider directory . (app/Providers/AuthServiceProvider.php)
                protected $policies = [
                Article::class =>'App\Policies\ArticlePolicy'
            ];
                    
    - Open the ArticleController   , tell the controller to use AuthorizesRequests;
        . Tell the Laravel to use the incoming request .
                use AuthorizesRequests;

        . define the constructor
                
                public  function __construct()
                {
                    $this->authorizeResource(CLASS NAME OF THE MODEL WHICH THE POLICY IS ASSOCIATED WITH , NAME OF ROUTE PARAMETER CONTAIN THE MODEL ID);
                }

        . authorizeResource accept to parameter
                . Class name of the model that the policy is associated with . (ARTICLE CLASS)
                . Name of route parameter which contains the model ID .

        . Code example
            public  function __construct()
            {
                $this->authorizeResource(Article::class, 'article');
            }
    - Laravel will automatically authorized any incoming request by using the Article Policy .

    

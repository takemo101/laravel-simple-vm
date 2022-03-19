# The Simple VM For Laravel
This package is a wrap of Simple VM for Laravel.  
You can also create a ViewModel class with a command.  
Enjoy!

## Installation
Execute the following composer command.
```
composer require takemo101/laravel-simple-vm
```

## How to use
Please use as follows

### Create a ViewModel class
Execute the artisan command as below.
```
# php artisan make:svm TestViewModel
```
### Basic
#### 1. Create a ViewModel class
First, create a ViewModel class to output the data to View.
```php
<?php

namespace App\Http\ViewModel;

use Takemo101\LaravelSimpleVM\ViewModel;
use Takemo101\SimpleVM\Attribute\{
    Ignore,
    ChangeName,
};
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * You need to extend and create the ViewModel class.
 * Only the public properties and methods defined in the ViewModel class will be the output target values.
 */
class TestViewModel extends ViewModel
{
    /**
     * ignores property or method names
     *
     * @var string[]
     */
    protected array $__ignores = [
        //
    ];

    /**
     * The data to be output to View is passed to the ViewModel class in the constructor.
     */
    public function __construct(
        public string $description,
        private User $user,
    ) {
        //
    }

    /**
     * Method injection is available for each published method
     */
    public function users(User $user): Collection
    {
        return $user->all();
    }

    /**
     * You can also process the model object and output it like the JsonResponse class.
     */
    public function user(): array
    {
        return [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ];
    }

    /**
     * You can ignore the output to the View by setting the Ignore Attribute class
     */
    #[Ignore]
    public function other(): string
    {
        return 'other';
    }

    /**
     * You can change the output name to the View by setting the ChangeName Attribute class.
     */
    #[ChangeName('modification')]
    public function change(): string
    {
        return 'change';
    }
}
```
#### 2. Use ViewModel class in Controller class
Next, use the created ViewModel class object as a response in the controller.
```php
<?php

namespace App\Http\Controllers;

use App\Http\ViewModel\TestViewModel;
use App\Models\User;

class HomeController
{
    /**
     * Output Json by making the return value of the controller method an object of ViewModel
     */
    public function json()
    {
        $user = new User();
        $user->name = 'name';
        $user->email = 'xxx@xxx.com';

        return new TestViewModel(
            'description',
            $user,
        );
    }

    /**
     * You can use the output data on the template by passing a ViewModel object as the template data
     */
    public function view()
    {
        $user = new User();
        $user->name = 'name';
        $user->email = 'xxx@xxx.com';

        // By using the toAccessArray method, you can treat the output data like an object on the template.
        
        return view('home.view', (new TestViewModel(
            'description',
            $user,
        ))->toAccessArray());

        // You can create an object from the of method of the ViewModel class
    }
}
```
Below is the output result in Json.
```json
{
	"description": "description",
	"users": [],
	"user": {
		"name": "name",
		"email": "xxx@xxx.com"
	},
	"modification": "change"
}
```

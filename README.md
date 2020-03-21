see https://github.com/danielrussob/laravel-modular

## Usage

composer require dnafactory/laravel-modular-package


### Make Module

`php artisan dna:make:module {moduleName}`

it will create all etc files


### Make Command

`php artisan dna:make:command {moduleName} {className}`

it will create a Command


### Make Controller

`php artisan dna:make:controller {moduleName} {className}`

it will create a Controller


### Make Provider

`php artisan dna:make:provider {moduleName} {className}`

it will create a Service Provider


### Make Seeder

`php artisan dna:make:seeder {moduleName} {className}`

it will create a Seeder


### Make Triad

`php artisan dna:make:triad {moduleName} {className} {tableName}`

To create:

Migration + Model + Repository + Factory

*Be careful*: remember to add in etc/di.php all class suggested by command

For example:

`php artisan dna:make:triad Module1 Book book`

it will create:

Book migration
Book Model
Book Repository
Book Factory

see https://github.com/danielrussob/laravel-modular

## Usage

composer require dnafactory/laravel-modular-package

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

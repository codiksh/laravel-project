# laravel-project

## Steps
1. Clone this repository 
2. Run `composer install`.
3. Create Database.
4. Update following in `.env`
    1. Name
    2. URL
    3. DB credentials
    4. Email Credentials
    5. Update `MY_SQL_VERSION`, if it is below `8`. **this is mandatory, otherwise, it would result in error while migrating.**
5. Copy `version.yml` file from `\resources\` directory to `\config\` directory.
6. Run `php artisan codiksh:install-template`.
7. Configure `medialibrary` config for `LocalStore`.


## Breaking changes as compare to L7
1. Routes action now supports direct callable classes, and hence, we as well are now using that in here.
2. Change in namespace of seeder classes. Earlier, there was no namespace. 

## Side note
1. To work with tailwind, you may need to run `npm install`.
    


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
5. Run `npm install` & `npm dev`, if wanted to use scaffolded Tailwind CSS. (Make sure you have Node v12 at least installed)
6. Run `php artisan migrate`.
7. Run `php artisan codiksh:deploy`.
8. Run `php artisan ide-helper:meta`.
9. Run `php artisan ide-helper:generate`.
10. Run `php artisan db:seed --class=RolesSeeder`
11. Run `php artisan db:seed --class=AdminSeeder`
12. Configure `medialibrary` config for `LocalStore`.


##Breaking changes as compare to L7
1. Routes action now supports direct callable classes, and hence, we as well are now using that in here.
2. Change in namespace of seeder classes. Earlier, there was no namespace. 

    


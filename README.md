# laravel-project

A ready to use Laravel 8 based Admin panel, using various in-house helpers and well known packages like, 
1. [Spatie's Media Library](https://github.com/spatie/laravel-medialibrary)
2. [Spatie's Laravel Permissions](https://github.com/spatie/laravel-permission)
3. [Yajra DataTables](https://github.com/yajra/laravel-datatables)
4. [InfyOm's CRUD Generator, with customized layout using AdminLTEv3](https://github.com/InfyOmLabs/laravel-generator)
5. [Pragmarx's Versioning](https://packagist.org/packages/pragmarx/version)
6. [Arcanedev's Log viewer](https://github.com/ARCANEDEV/LogViewer)
7. [Barryvdh's Debugbar](https://github.com/barryvdh/laravel-debugbar)
8. [Barryvdh's IDE Helper](https://github.com/barryvdh/laravel-ide-helper)

## Glimpses
Login Page as default in Laravel 8
![Login Page as default in Laravel 8](https://user-images.githubusercontent.com/12022338/114061016-91f12500-98b3-11eb-95cd-7668ec696642.png)

Landing Page
![Landing Page](https://user-images.githubusercontent.com/12022338/114061118-b0efb700-98b3-11eb-9855-cc6288b5dc17.png)

Ready to use users manager
![Ready to use users manager](https://user-images.githubusercontent.com/12022338/114061147-b9e08880-98b3-11eb-963a-4bf99b0f5e15.png)



## Steps to setup
1. Run `composer create-project --prefer-dist codiksh/laravel-project {project-name}`.
2. Create Database.
3. Copy `.env.example` as `.env` and Update following in `.env`
    1. Name
    2. URL
    3. DB credentials
    4. Email Credentials
    5. Update `MY_SQL_VERSION`, if it is below `8`. **this is mandatory, otherwise, it would result in error while migrating.**
4. Run `php artisan codiksh:install-template`.
5. Configure `medialibrary` config for `LocalStore`.


## Breaking changes as compare to L7
1. Routes action now supports direct callable classes, and hence, we as well are now using that in here.
2. Change in namespace of seeder classes. Earlier, there was no namespace. 

## Side note
1. To work with tailwind, you may need to run `npm install`.
2. To manage versioning within the app, Copy `version.yml` file from `\resources\assets\` directory to `\config\` directory.    


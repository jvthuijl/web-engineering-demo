# Laravel + Bootstrap + Vue Demo

## Installation instructions
**Prerequisites:**
- PHP 7.1.3 or higher
- composer
- npm/yarn

When using yarn you can change all npm commands into their corresponding yarn commands.

**Steps**

1. Clone the repo
2. Install the required PHP libraries `composer install`
3. Install the required JS libraries `npm install`
4. `cp .env.example .env`
5. Generate an application key: `php artisan key:generate`
6. Modify the .env file and make sure a suitable database driver is setup. 
When you do not have a running database server, you can use the sqlite driver. [For details see the Laravel documentation](https://laravel.com/docs/5.8/database#configuration)
7. Modify the env file and setup `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET`. [How to get these keys?](https://developer.github.com/apps/building-oauth-apps/creating-an-oauth-app/)
8. Apply changes to the database: `php artisan migrate`
9. Generate the front end code (compiling SCSS files, bundeling up js files): `npm run dev`
10. Serve the application. `php artisan serve`, [Valet](https://laravel.com/docs/5.8/valet) or [Homestead](https://laravel.com/docs/5.8/homestead)

## How to modify
When modifying the front end code (resources/js/... or resources/css/...) you have to make sure that you are recompiling your code.

You can do this by running one of the following commands: 

- `npm run hot`: Enables hot reloading (see changes without refreshing the page)
- `npm run watch`: Does the same as `npm run dev` but listens for changes on the filesystem. A refresh of the page is still required before the changes take effect.
- `npm run dev`: Compile the js and css files for development environment
- `npm run prod`: Compile the js and css files for production

## More info
**For more information about Laravel [click here](https://laravel.com/docs/5.8)**
- [Models (database)](https://laravel.com/docs/5.8/eloquent)
- [Controllers](https://laravel.com/docs/5.8/controllers)
- [Requests](https://laravel.com/docs/5.8/requests)
- [API Resources](https://laravel.com/docs/5.8/eloquent-resources)

**For more information about Vue [click here](https://vuejs.org/v2/guide/)**
- [Components](https://vuejs.org/v2/guide/components-registration.html)
- [Events](https://vuejs.org/v2/guide/components-custom-events.html)

**For more information about Bootstrap Vue [click here](https://bootstrap-vue.js.org/docs)**

# Laravel Starter

Laravel Starter project with useful laravel packages needed for most apps.

## Installation ##

- Clone or download the repository
- Run `composer install`
- Run `npm install`
- Run `php artisan telescope:install`
- Run `php artisan vendor:publish --all`
- Run `php artisan module:publish`
- Run `php artisan module:publish-migration`
- Run `php artisan storage:link`
- Update `.env` file with database details
- Run `php artisan migrate`
- Run `npm run dev`
- You are done.

## Custom Packages Included ###

```bash

"require": {
        "akaunting/setting": "^1.0", # to save any settings for the app
        "anahkiasen/former": "^4.1", # to create forms
        "arrilot/laravel-widgets": "^3.12", # to create any standalone widgets
        "balping/laravel-hashslug": "^2.1", # to obfuscate ids in urls
        "bensampo/laravel-enum": "^1.16", # to use enums for the app
        "bepsvpt/secure-headers": "^5.3", # to use security headers in app
        "davejamesmiller/laravel-breadcrumbs": "^5.1", # for breadcrumbs
        "dompdf/dompdf": "^0.8.2", # for pdf generation, also needed by datatable package
        "eusonlito/laravel-meta": "^3.1", # for seo stuff
        "eusonlito/laravel-packer": "^2.1", # for asset minification and merging
        "garygreen/pretty-routes": "^1.0", # for pretty routes
        "jenssegers/agent": "^2.6", # to detect user agent 
        "laracasts/flash": "^3.0", # for flash messages
        "mews/purifier": "^2.1", # for xss cleanup
        "olssonm/l5-very-basic-auth": "^5.3", # for basic http auth
        "qcod/laravel-imageup": "^1.0", # for uploading files
        "sarfraznawaz2005/applog": "^1.0", # for app logs
        "sarfraznawaz2005/noty": "^1.0", # for noty notifications
        "sarfraznawaz2005/visitlog": "^1.1", # for user visit logs
        "spatie/laravel-permission": "^2.23", # for roles and permissions
        "vakata/websocket": "^1.0", # for websockets
        "watson/active": "^3.0", # for activating menu links
        "watson/validating": "^3.1", # for model validations
        "yajra/laravel-datatables-oracle": "^8.9" # for datatables
    },
    "require-dev": {
        "beyondcode/laravel-er-diagram-generator": "^1.2", # for generating erd of app database
        "beyondcode/laravel-query-detector": "^0.6.0", # for detecting n+1 problem queries
        "imanghafoori/laravel-anypass": "^1.0", # to login into local env with any password
        "recca0120/terminal": "^1.6", # for in-browser console/termincal
        "roave/security-advisories": "dev-master", # for composer package security
        "themsaid/laravel-mail-preview": "^2.0" # to preview emails in browser
    },

```

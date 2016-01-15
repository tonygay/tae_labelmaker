# Amigos Label Maker

## Purpose
The Amigos Label Maker is intended to be a "one stop shop" for label creation when sending packages from one institution to another. It will create appropriate labels based on the courier that is required for shipment. Users can log in to create a shipping label from their home library (or any other TAE library) to any institution supported by the contracted couriers.

After logging in, users must fill out a quick 4-step form. After this, the labels are created in PDF format which the user can then print or download for future use.

## App Requirements
The following is required to run the Amigos Label Maker application:

* PHP >= 5.4
* MySQL >= 14.14
* IIS or Apache (preferred)
* git
* npm (https://www.npmjs.com/)
* Composer (https://getcomposer.org/)
* wkhtmltopdf (http://wkhtmltopdf.org/)

## Installation
Assuming the requirements above are met, the following steps should result in a working version of the application:

* Clone the git repository `git clone https://github.com/tonygay/tae_labelmaker.git`
* Navigate to the `tae_labelmaker` directory `cd tae_labelmaker`
* Install required node modules `npm install`
* Install required composer modules `php composer install`
* Update 'APP_KEY' and database credentials (everything that begins with 'DB') in the `.env.example` file.
* Rename `.env.example` to just `.env`.
* Ensure the database referenced in the `.env` file has been created and permissions are correct.
* Create the database using Artisan `php artisan migrate`
* Seed the database tables using Artisan `php artisan db:seed`
* Run gulp to generate the asset files `gulp`

After this, you should be able to navigate to the appropriate URL (based on server settings and the location of the repository on the server itself) and you should see the login page.

From here, log in as administrator (username: Admin password: TAEadmin) to begin the setup process.

## Setup
After installation, the application will be functional, but it will be missing some key data. So, some setup is required to get the app ready for use.

### Institutions

* Couriers are added using the seeders, but institutions will have to be manually added using the UI. To do this, an admin user can either add each institution manually, or import using the institution import feature.

### Users

* Importing institutions for the TAE courier will automatically trigger user creation for each new institution. This only happens for TAE couriers.
* Default password for auto-generated TAE users is 'TAE2016!#oclc#' where '#oclc#' will be the actual OCLC code of the institution that user is tied to. (so for A. H. Meadows Library, the default password would be 'TAE2016!TXAHM')
* Creating an admin user is a 2 step process, the user must first be added manually by an existing administrator. After that, the same admin user must edit the new user and check the "Administrator" checkbox, then save the changes.

## Permissions
There are only 2 roles for this application: 1) general user and 2) administrative user.

General users can only log in, create labels, change their password and log out of the system.

Administrative users can execute the same functions as a general user plus they can manage couriers, institutions and users.

## Password Management
Users can reset their own password when logged in using the dropdown in the top right-hand corner.

Administrators can reset any user's password by editing the user from the users page and typing in a new password twice.

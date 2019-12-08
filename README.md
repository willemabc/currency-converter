# Currency Converter
As part of an interview process I was asked to do a technical assessment assignment, see resources/assignment.pdf. This is my end result, which took me about 7-8 hours.

Built with Laravel 6.5.2.
Tested on Mac (10.15 / Catalina) with PHP 7.3, MariaDB 10.4.6, Apache 2.4.41.

## Basic installation
1. Clone the repository.
2. From the terminal, please run `composer install` and `npm install`. This will take care of all the dependencies.
3. Check your .env file (look at .env.example for reference). You'll need to set your database and e-mail configuration correctly. If e-mail configuration problems are to be expected, please ask me for temporary access to my Mailgun account.
4. From the terminal, please run `php artisan migrate --seed` to run the database migrations and seed the database.
5. From the terminal, please run `php artisan import-feed` to update the rates for the first time. This will take a while.

## Setup virtual host
Your virtual host should have its document root set to "[installation directory]/public".

## Setup cronjob
Although you could manually run the currency feed cronjob which updates the rates, the ideal solution would be to add a cronjob for the app. Everything will then take care of its own. Simply add this to your crontab: `* * * * * cd /[full path to installation directory] && php artisan schedule:run >> /dev/null 2>&1`.

## IP Configuration, user registration
By default, registration of new users will fail because allowed IP addresses or IP ranges need to be setup first. To do so, from the terminal please run `php artisan add-ip "[ip address or ip range]"`. You can only enter IP addresses (192.168.0.1) or IP ranges (192.168.0.*).

Please note that if your server is running on your computer, your ip address will always 127.0.0.1.

Now you may visit your virtual host. Click "register" and follow the instructions.

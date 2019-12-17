# Damain availability checker

Uses Transip API to check word combinations domain availability.

## Installation

1. Download the private key from TransIP dashboard and save it as `./transip.private`
1. Whitelist your IP in Transip dashboard
1. Run `composer install`
1. Edit `./vendor/transip/transip-api-php/Transip/ApiSettings.php`. You need to change the username and copy the contents of the private key.
1. Edit the two arrays in `./index.php`
1. Change extension in `./index.php` if needed
1. Run `./index.php` with `php -S localhost:80`
1. Visit `http://localhost` and enjoy.

## Slim Blog

A simple blog using the Slim framework

### Requirements

PHP >= 7.4 MySQL >= 5.7

### Instalation

In the project folder open a terminal and install the dependencies by typing:

```
composer install
```

Edit the database credentials in `settings.php` and `phinx.php` and create the database by running:

```
vendor/bin/phinx migrate
```

Run the application with the PHP built-in server:

```
php -S localhost:8080 -t public
```

where 8080 is the port number. If this one is in use you can pick another free port.

Visit `http://localhost:8080` in a browser



The default built-in blog user is:  
username: **admin**  
password: **admin**


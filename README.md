## Lufia 2 Terrorwave Randomizer Web GUI

### Requirements
- [LAMP stack](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-22-04)\
or [DDEV](https://ddev.readthedocs.io/en/latest/users/install/docker-installation/) (for local development)
- [Composer](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart)
- [Python-is-Python3](https://linuxhint.com/install-python-ubuntu-22-04/#:~:text=an%20Arduino%20Core-,How%20to%20Install%20python%2Dis%2Dpython3%3F,-The%20%E2%80%9Cpython)

This project does not utilize a database so the migration for Laravel can be skipped.

### Installation
Clone this repository\
Open a CLI and navigate to the root of the project folder\
Create a .env file and generate a new App Key:\
Run `cp .env.example .env && php artisan key:generate`\
Adjust the `APP_URL` in `.env` **to your domain** or in case of DDEV:
```dotenv
APP_URL="https://terrorwave-web.ddev.site"
```
Change the permissions for the project:\
Run `sudo chown www-data:www-data . -R`\
Create a symlink from the `/public` folder to `/storage/app/public` using artisan:\
`php artisan storage:link`\
Alternatively
`sudo ln -sfn ../storage/app/public ./public/storage`

#### When using DDEV:
Run `ddev start`

#### Install dependencies with Composer:
Run `composer update`\
or in DDEV run `ddev exec composer update`

#### Increase Upload Limits in php.ini (skip this when using DDEV)

Open the php.ini in [Vim](https://www.freecodecamp.org/news/vim-beginners-guide/), [Nano](https://www.howtogeek.com/42980/the-beginners-guide-to-nano-the-linux-command-line-text-editor/) or an editor of your choice:\
`sudo vim /etc/php/8.1/apache2/php.ini`\
`sudo nano /etc/php/8.1/apache2/php.ini`\
Change / increase these values:
```apache
post_max_size = 5M
upload_max_filesize = 5M
```

#### Set up Virtual Host (skip this when using DDEV)

Create a new virtual host\
`sudo vim /etc/apache2/sites-available/terrorwave-web.conf`\
with content 
```apache
<VirtualHost *:80>
    DocumentRoot "/path/to/terrorwave/public"
    ServerName yourdomain.com
    <Directory "/path/to/terrorwave/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Enable site `sudo a2ensite terrorwave-web.conf`\
Restart apache `sudo service apache2 reload`

#### Set up SSL certificate (optional, skip this when using DDEV)

Install [Certbot](https://www.digitalocean.com/community/tutorials/how-to-use-certbot-standalone-mode-to-retrieve-let-s-encrypt-ssl-certificates-on-ubuntu-22-04) if not done yet\
Run `certbot certonly --webroot -d yourdomain.com -w /path/to/terrorwave/public/`

#### Opening in your browser

Go to http<area>://yourdomain.com or https<area>://yourdomain.com (if SSL enabled)\
or in ddev https://terrorwave-web.ddev.site

## Credits

abyssonym's terrorwave Randomizer\
https://github.com/abyssonym/terrorwave

Meats\
https://github.com/tethtoril

Ancient Cave Discord\
https://discord.gg/96Uswexh9q




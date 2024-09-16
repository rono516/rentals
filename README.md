# Neet rentals

## Virtual Host

```text
<VirtualHost *:80>
    ServerName rentals.drash.co.ke
    ServerAlias www.rentals.drash.co.ke
    ServerAdmin ndiranguwaweru@gmail.com
    DocumentRoot /var/www/drash-rentals/current/public

    <Directory /var/www/drash-rentals/current/public>
        Options Includes FollowSymLinks MultiViews
        AllowOverride all
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

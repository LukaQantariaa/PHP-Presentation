# PHP-Presentation

.htaccess -> 


RewriteEngine On
RewriteRule ^/?$ ./public/index.php
RewriteRule ^register?$ ./public/register.php
RewriteRule ^main?$ ./public/main.php
RewriteRule ^logout?$ ./public/logout.php
RewriteRule ^profile?$ ./public/profile.php


ErrorDocument 404 "404"

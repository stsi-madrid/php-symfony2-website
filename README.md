website
=======

Código fuente de nuestra página web.

Para correr la aplicación en producción es recomendable realizar los siguientes pasos:

1. Mover los siguentes ficheros a la carpeta public_html/Symfony:

    - public_html/Symfony/web/app.php
    - public_html/Symfony/web/favicon.ico
    - public_html/Symfony/web/apple-touch-icon.png

2. Sustituir el contenido de del fichero public_html/Symfony/app.php por el siguiente:

<?php

require_once __DIR__.'/app/bootstrap.php.cache';
require_once __DIR__.'/app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);
$kernel->handle(Request::createFromGlobals())->send();

3. Sustituir el contenido del fichero public_html/Symfony/.htaccess por el siguiente:

RewriteEngine on
RewriteBase /
RewriteRule ^bundles/(.*) web/bundles/$1
RewriteRule ^css/(.*) web/css/$1
RewriteRule ^js/(.*) web/js/$1
RewriteRule ^imagenes/(.*) web/imagenes/$1
RewriteRule ^robots.txt web/robots.txt
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ app.php [QSA,L]
</IfModule>
# Activa la compresion en el servidor
ExpiresActive On
ExpiresDefault "access plus 1 year"

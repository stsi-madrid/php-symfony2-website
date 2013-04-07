Nuestra página web.
=======

Overview

Este es el código fuente de nuestra página web, cualquier sindicato puede aprovecharlo para construir su propia página. Para cualquier cuestión no dudéis en poneros en contacto con nosotros.

Para su construcción se ha utilizado el framework Symfony2.0.x (http://symfony.com/), posiblemente el framework PHP más potente y moderno a día de hoy. Hay que tener en cuenta que versiones mayores de este framework aún no estań soportadas en los servidores confederales.

Tanto para la instalación del framework como para la gestión de dependencias se ha utilizado Composer (http://getcomposer.org/). De todas formas, para facilitar la instalación ninguna de las librerías de la carpeta vendors ha sido excluida del repositorio.

Getting Started

    installation & prerequisites
    
    1. En el fichero estructura.sql se encuentra la estructura de todas las tablas de la base de datos.
    
    2. Hay que crear el fichero public_html/Symfony/app/config/parameters.ini con el siguiente contenido:
    
        [parameters]
        database_driver="pdo_mysql"
        database_host="servidor_base_datos"
        database_port="puerto_base_datos"
        database_name="nombre_base_datos"
        database_user="usuario_base_datos"
        database_password="contraseña_base_datos"
        mailer_transport="smtp"
        mailer_host="servidor_email"
        mailer_user="usuario_email"
        mailer_password="contraseña_email"
        locale="es"
        secret="a6133434a562aef53641e96fa4981b65ba096b2e"

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

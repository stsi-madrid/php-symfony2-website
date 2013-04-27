<h1>Nuestra página web<h1>

<h2>License</h2>

This application is licenced under Creative Commons Attribution 3.0 Unported License.

<h2>Overview</h2>

Este es el código fuente de nuestra página web, cualquier sindicato puede aprovecharlo para construir su propia página. Para cualquier cuestión no dudéis poneros en contacto con nosotros.

Para su construcción se ha utilizado el framework Symfony2.0.x (http://symfony.com/), posiblemente el framework PHP más potente y moderno a día de hoy. Hay que tener en cuenta que versiones mayores de este framework aún no estań soportadas en los servidores confederales.

Tanto para la instalación del framework como para la gestión de dependencias se ha utilizado Composer (http://getcomposer.org/). De todas formas, para facilitar la instalación ninguna de las librerías de la carpeta vendors ha sido excluida del repositorio.

<h2>Getting Started</h2>

<h3>installation & prerequisites</h3>
<ol>
<li>En el fichero estructura.sql se encuentra la estructura de todas las tablas de la base de datos.</li>

<li>Hay que crear el fichero public_html/Symfony/app/config/parameters.ini con el siguiente contenido:

<pre>
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
secret=""
</pre>
</li>
</ol>

Para correr la aplicación en producción es recomendable realizar los siguientes pasos:

<ol>
<li>Mover los siguentes ficheros a la carpeta public_html/Symfony:

<ul>
    <li>public_html/Symfony/web/app.php</li>
    <li>public_html/Symfony/web/favicon.ico</li>
    <li>public_html/Symfony/web/apple-touch-icon.png</li>
</ul>

</li>

<li>Modificar la ruta de los ficheros incluidos en el fichero public_html/Symfony/web/app.php</li>

<li>Sustituir el contenido del fichero public_html/Symfony/.htaccess por el siguiente:

<pre>
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
</pre>
</li>
</ol>

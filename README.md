# TasksApp

Apache settings

/etc/apache2/extra/httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "/Users/Alex/Sites/TasksApp/public"
    ServerName tasks.local
    ServerAlias www.tasks.local
    <Directory "/Users/Alex/Sites/TasksApp/public">
        #Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>

/ect/hosts
127.0.0.1       tasks.local www.tasks.local

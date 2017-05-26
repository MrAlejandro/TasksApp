# TasksApp

**Requirements**
1. Apache + mod_rewrite

**Apache settings**

```
/etc/apache2/extra/httpd-vhosts.conf:
```
```
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
```

```
/ect/hosts:
```
```
127.0.0.1       tasks.local www.tasks.local
```

**Installation**
1. run ```php composer.phar update```
2. run ```cp config.php.dist config.php``` and add settings
3. run ```vendor/bin/phinx init``` and add DB settings to the ```phinx.yml``` created in the root folder
4. run ```chmod -R 777 var```
5. apply migration ```vendor/bin/phinx migrate```

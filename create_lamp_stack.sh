apt-get update
apt-get install apache2 -y
apt-get install php -y
apt install php libapache2-mod-php -y
apt install php7.0-mbstring -y
apt install php-gd -y
apt install php-dom -y
apt-get install php-mysql -y
a2enmod rewrite
a2enmod headers
service apache2 restart
ufw allow http
ufw allow https
apt install zip -y
echo "<?php phpinfo();" > /var/www/html/phpinfo.php

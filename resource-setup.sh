# Server setup commands
sudo amazon-linux-extras install php8.1 -y
sudo yum install httpd -y
sudo yum install mariadb-server -y
sudo yum install php-dom -y
sudo systemctl start httpd
sudo systemctl enable httpd
sudo systemctl start mariadb
sudo systemctl enable mariadb

sudo yum install php-cli php-json php-common php-mbstring wget -y
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"

sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

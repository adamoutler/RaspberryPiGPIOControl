# RaspberryPiGPIOControl
Website to control GPIOs hosted on Raspbery Pi


installation on Raspbian:
`sudo su`

`apt-get update; sudo apt-get upgrade;
apt-get install git apache2 php5 libapache2-mod-php5;`

`git clone https://github.com/adamoutler/RaspberryPiGPIOControl.git;
cp -R ./RaspberryPiGPIOControl/* /var/www/html;
chown -R www-data:www-data /var/www/html;
echo "mesg y">/home/pi/.profile;
chmod 755 /home/pi/profile;
chown pi:pi /home/pi/profile;
echo 'curl localhost/reset.php >/dev/null 2>&1' >>/etc/profile;
mesg on;`




Follow directions in Settings.ini to configure your system

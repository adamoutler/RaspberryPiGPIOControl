# RaspberryPiGPIOControl
Website to control GPIOs hosted on Raspbery Pi


installation on Raspbian:
`sudo su`

`apt-get update; sudo apt-get upgrade;
apt-get install git apache2 php5 libapache2-mod-php5 gnustep-gui-runtime;`

`git clone https://github.com/adamoutler/RaspberryPiGPIOControl.git;
cp -R ./RaspberryPiGPIOControl/* /var/www/html;
chown -R www-data:www-data /var/www/html;
modprobe snd-bcm2835;
usermod -a -G audio www-data;
echo "msg y">/home/pi/.profile;
chmod 755 /home/pi/profile;
chown pi:pi /home/pi/profile;
echo snd-bcm2835 >>/etc/modules;
echo 'curl localhost/reset.php >/dev/null 2>&1' >>/etc/profile;

mesg on;`

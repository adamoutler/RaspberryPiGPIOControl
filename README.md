# RaspberryPiGPIOControl
Website to control GPIOs hosted on Raspbery Pi


installation on Raspbian:

sudo apt-get update; sudo apt-get upgrade;

sudo apt-get install git apache2 php5 libapache2-mod-php5;

git clone https://github.com/adamoutler/RaspberryPiGPIOControl.git;

sudo cp -R ./RaspberryPiGPIOControl/* /var/www/html;

sudo chown -R www-data:www-data /var/www/html;

mesg on

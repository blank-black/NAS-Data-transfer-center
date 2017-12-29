#!/bin/bash

cp dbconnect.php /var/www/html/
cp home.php /var/www/html/
cp index.php /var/www/html/
cp logout.php /var/www/html/
cp register.php /var/www/html/

cd Forwarding/

make

./server
./nas_client
./client
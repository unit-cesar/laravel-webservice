#!/bin/bash

echo "Run all scripts local tests"
echo

cd /home/devesa/www/Projetos/x-DicasAtalhos/PHP-RESTful-APIs/Laravel/laravel-webservice/ && php artisan serve --host=127.0.0.1 --port=8000
echo "Laravel: php artisan serve --host=127.0.0.1 --port=8000"
sleep 8 && x-www-browser -new-tab http://127.0.0.1:8000 &>/dev/null


json-server --host 10.0.0.7 --port 3000 --watch /home/devesa/www/Projetos/x-DicasAtalhos/Ionic/appBase/db.json
echo "IONIC:   json-server --host 10.0.0.7 --port 3000 --watch db.json"
sleep 10 && x-www-browser -new-tab http://10.0.0.7:3000/cursos &>/dev/null

cd /home/devesa/www/Projetos/x-DicasAtalhos/Ionic/appBase/ && ionic serve
echo "IONIC:   ionic serve"

echo
echo "To exit: Ctrl+C"

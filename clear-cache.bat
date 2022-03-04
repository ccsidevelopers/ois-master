@echo off

php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan config:cache

pause
exit
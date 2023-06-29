%systemDrive%\xampp\mysql\bin\mysql -uroot -e "CREATE DATABASE IF NOT EXISTS blog_app;"

if %errorlevel% neq 0 msg %username% "Nie udalo sie utworzyc bazy danych." && exit /b %errorlevel%

call composer install

call php artisan migrate:fresh --seed

call php artisan key:generate

xcopy "%~dp0temp_photos" "%~dp0\storage\app\public" /E /I /Q /Y

rmdir "%~dp0temp_photos" /S /Q

call php artisan storage:link

call php artisan serve

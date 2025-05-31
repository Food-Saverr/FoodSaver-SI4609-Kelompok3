@echo off
echo Starting expired food removal process...
cd /d %~dp0
php artisan food:remove-expired
echo Process completed. Check storage/logs/expired-removal.log for details.
pause 
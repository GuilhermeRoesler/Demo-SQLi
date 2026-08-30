@echo off
setlocal
cd /d "%~dp0"

where php >nul 2>&1
if errorlevel 1 (
  echo PHP nao encontrado no PATH.
  echo Instale o PHP ^(com PDO SQLite^) e tente novamente:
  echo   https://www.php.net/downloads
  pause
  exit /b 1
)

echo.
echo Laboratorio SQLi — http://localhost:8000
echo Se for a primeira vez, abra tambem: http://localhost:8000/setup.php
echo Pressione Ctrl+C para parar o servidor.
echo.

start "" "http://localhost:8000/index.html"
php -S localhost:8000

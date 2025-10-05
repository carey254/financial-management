@echo off
REM Obadiah local starter (SQLite)
REM - Starts Laravel dev server and scheduler
REM - Optional: Cloudflare Tunnel (commented)
REM Data persists in database\database.sqlite

setlocal enableextensions enabledelayedexpansion

REM Change to project directory (this file is placed in project root)
cd /d %~dp0

REM Detect PHP (prefer bundled tools\php\php.exe if present)
set "BUNDLED_PHP=%~dp0tools\php\php.exe"
if exist "%BUNDLED_PHP%" (
    set "PHP_BIN=%BUNDLED_PHP%"
    goto :foundphp
)

where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [info] System PHP not found in PATH. Trying XAMPP paths...
    if exist "C:\xampp\php\php.exe" set "PHP_BIN=C:\xampp\php\php.exe"
    if exist "D:\xampp\php\php.exe" set "PHP_BIN=D:\xampp\php\php.exe"
) else (
    for /f "usebackq tokens=*" %%P in (`where php`) do set "PHP_BIN=%%P" & goto :foundphp
)
:foundphp
if not defined PHP_BIN (
    echo [error] Could not find php.exe. Please install PHP or XAMPP and add it to PATH.
    pause
    exit /b 1
)

echo Using PHP: %PHP_BIN%

REM Ensure SQLite file exists so first run doesn't fail
if not exist "database\database.sqlite" (
    echo [info] Creating database\database.sqlite
    type nul > "database\database.sqlite"
)

REM Ensure logs folder exists
if not exist "logs" mkdir logs

REM Start Laravel dev server on 127.0.0.1:8000 and log output
start "OBADIAH: server" cmd /k "%PHP_BIN% artisan serve --host=127.0.0.1 --port=8000 1>> logs\server.log 2>>&1"

REM Start Laravel scheduler worker (verbose) and log output
start "OBADIAH: scheduler" cmd /k "%PHP_BIN% artisan schedule:work -v 1>> logs\scheduler.log 2>>&1"

REM Optional: start Cloudflare Tunnel to share publicly
REM Uncomment the line below if cloudflared is installed and in PATH
REM start "OBADIAH: tunnel" cmd /k "cloudflared tunnel --url http://127.0.0.1:8000 1>> logs\tunnel.log 2>>&1"

REM Done
echo [ok] OBADIAH started. Open http://127.0.0.1:8000
echo [hint] If the windows look blank, check logs in the 'logs' folder.
exit /b 0

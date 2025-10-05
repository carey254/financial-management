# OBADIAH – Simple Setup Guide (No Coding)

This guide lets anyone run the app on Windows without knowing code.

## What you need
- Windows 10 or 11
- One of the following:
  - Option A: XAMPP (includes PHP). Download: https://www.apachefriends.org
  - Option B: PHP for Windows (if you don’t want XAMPP): https://windows.php.net/download

Tip: If you install XAMPP, you don’t need to add PHP to PATH. The start script detects XAMPP automatically.

## Files in this folder
- `start_obadiah.bat` – Double‑click to start the app.
- `database/database.sqlite` – Your data lives here. Keep this file safe to preserve your data.
- `.env` – App settings. We include an example for SQLite.

## First‑time setup (only once)
1) If you don’t have PHP:
   - Install XAMPP (recommended) OR install PHP for Windows.
2) Ensure the database file exists:
   - If missing, the start script will create `database/database.sqlite` automatically.
3) Set environment to SQLite (already prepared):
   - Make sure your `.env` contains:
     ```env
     APP_ENV=local
     APP_DEBUG=true
     APP_URL=http://127.0.0.1:8000

     DB_CONNECTION=sqlite

     SESSION_DRIVER=database
     SESSION_LIFETIME=10080
     ```
   - Create the session table once:
     - Open Command Prompt in this folder and run:
       ```bat
       php artisan session:table
       php artisan migrate
       ```
     - If you double‑click the start script first, you can also run these in another window later.

## How to start the app (every time)
- Double‑click `start_obadiah.bat`.
- Wait a few seconds, then open your browser to:
  - http://127.0.0.1:8000

That’s it. The script starts:
- The web server (so you can use the app)
- The background scheduler (so deadline reminders run)

## Staying logged in
- On the login page, tick “Remember me”.
- Your session persists across restarts as long as `.env` keeps the same `APP_KEY` (don’t change it).

## Backing up your data
- Copy the file `database/database.sqlite` to a safe place (USB, OneDrive, Google Drive) periodically.
- To restore on another computer, replace their `database/database.sqlite` with your backup.

## Optional: Auto‑start when you sign in
- Press Win+R, type `shell:startup`, press Enter.
- Put a shortcut to `start_obadiah.bat` in that Startup folder.
- Now it launches automatically when you log in.

## Optional: Share your app online temporarily (free)
- Install Cloudflare Tunnel (“cloudflared”).
- Edit `start_obadiah.bat` and remove `REM` (uncomment) from the cloudflared line.
- When you start, you’ll get a public https:// link to share.

## Troubleshooting
- If a window shows “php not found”, install XAMPP or PHP. The script tries `C:\xampp\php\php.exe` and `D:\xampp\php\php.exe` automatically.
- If the app opens but data is gone, make sure you didn’t delete `database/database.sqlite`.
- If reminders don’t run, keep the `start_obadiah.bat` window(s) open or place the shortcut in the Startup folder.

## Moving to another computer
1) Copy the entire project folder to the other PC.
2) Install XAMPP (or PHP).
3) Double‑click `start_obadiah.bat`.
4) If you have a backup of `database/database.sqlite`, replace the new one with your backup.

Enjoy!

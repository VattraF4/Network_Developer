@echo off
setlocal enabledelayedexpansion

:: ===== CONFIGURE THESE PATHS =====
set "PKT_FILE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
set "GIT_REPO=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer"
set "GIT_REMOTE=origin"  :: Change if using different remote name
set "GIT_BRANCH=main"    :: Change your branch name
:: ================================

title PKT Git Sync - Press CTRL+C to Exit
color 0A

:INIT
:: Get initial file state
for %%F in ("%PKT_FILE%") do set "LAST_TS=%%~tF"
set "LAST_HASH="

:: Initialize Git
cd /d "%GIT_REPO%"
git fetch %GIT_REMOTE%

:LOOP
cls
echo [%time%] Monitoring: %PKT_FILE%
echo Your last save: !LAST_TS!
echo.
echo Press CTRL+C to exit
echo.

:: Check for LOCAL changes (you saved in PT)
for %%F in ("%PKT_FILE%") do (
    if not "%%~tF"=="!LAST_TS!" (
        echo.
        echo Detected LOCAL changes! Committing...
        git add "%PKT_FILE%"
        git commit -m "Saved Change %date% %time%"
        git push %GIT_REMOTE% %GIT_BRANCH%
        set "LAST_TS=%%~tF"
        echo ✓ Pushed your changes
    )
)

:: Check for REMOTE changes (collaborators' updates)
git fetch %GIT_REMOTE%
set "CURRENT_HASH="
for /f "delims=" %%H in ('git rev-parse HEAD') do set "CURRENT_HASH=%%H"
for /f "delims=" %%H in ('git rev-parse %GIT_REMOTE%/%GIT_BRANCH%') do set "REMOTE_HASH=%%H"

if not "!LAST_HASH!"=="!REMOTE_HASH!" (
    if not "!CURRENT_HASH!"=="!REMOTE_HASH!" (
        echo.
        echo Detected REMOTE updates! Pulling...
        git pull %GIT_REMOTE% %GIT_BRANCH%
        set "LAST_HASH=!REMOTE_HASH!"
        echo ✓ Synced remote changes
        echo.
        echo 〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰
        echo   Open in Packet Tracer manually:
        echo   1. Click [File] 
        echo   2. Select [Open Recent] 
        echo   3. Choose "Topology.pkt"
        echo 〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰〰
    )
)

timeout /t 3 >nul
goto LOOP
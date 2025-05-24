@echo off
setlocal enabledelayedexpansion

:: Configure these paths
set "PKT_FILE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
set "GIT_REPO=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer"
set "COMMIT_MSG=Auto-update: %date% %time%"

:INIT
for %%F in ("%PKT_FILE%") do set "LAST_TS=%%~tF"

:LOOP
cls
echo [%time%] Watching: %PKT_FILE%
echo Last saved: !LAST_TS!
echo.
echo Press CTRL+C to exit
echo.

for %%F in ("%PKT_FILE%") do (
    if not "%%~tF"=="!LAST_TS!" (
        echo Change detected! Committing to Git...
        cd /d "%GIT_REPO%"
        git add .
        git commit -m "!COMMIT_MSG!"
        git push
        set "LAST_TS=%%~tF"
        echo ✓ Pushed to Git at %time%
    )
)
timeout /t 3 >nul
goto LOOP

:: Develop by Vattra ,, Original Idea
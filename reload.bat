@echo off
setlocal enabledelayedexpansion

:: ===== CONFIGURE THESE PATHS =====
set "PKT_FILE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
set "GIT_REPO=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer"
set "GIT_REMOTE=origin"
set "GIT_BRANCH=main"
set "PKT_EXE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
::set "PKT_EXE=C:\Program Files\Cisco Packet Tracer 8.2.2\bin\PacketTracer.exe"
::
:: ================================

title PKT Git Auto-Commit (10s) - Press CTRL+C to Exit
color 0A

:: Change to repository directory
cd /d "%GIT_REPO%" || (
    echo Error: Cannot access repository directory
    pause
    exit /b 1
)

:: Initialize Git if needed
if not exist ".git" (
    echo Initializing new Git repository...
    git init
    echo ✓ Repository initialized
    echo Please set up remote repository manually first
    pause
    exit /b 1
)

:: Configure Git settings
git config --local user.name "VattraF4"
git config --local user.email "vattraramo13@gmail.com"
git config --local pull.rebase false

:INIT
:: Get initial file state
for %%F in ("%PKT_FILE%") do set "LAST_TS=%%~tF"
set "FIRST_RUN=1"

:LOOP
cls
echo [%time%] Monitoring for changes (every 10 seconds)
echo Watching: %PKT_FILE%
echo Last modified: !LAST_TS!
echo.
echo Press CTRL+C to exit
echo.

:: Check for file changes
for %%F in ("%PKT_FILE%") do (
    if not "%%~tF"=="!LAST_TS!" (
        echo.
        echo [%time%] Detected file changes!
        
        :: Git add and commit
        echo Staging and committing changes...
        git add "%PKT_FILE%"
        git commit -m "Auto-commit: %date% %time%" --quiet
        
        :: Push changes
        echo Pushing to remote repository...
        git push %GIT_REMOTE% %GIT_BRANCH% --quiet
        
        :: Update last timestamp
        for %%F in ("%PKT_FILE%") do set "LAST_TS=%%~tF"
        
        echo ✓ Changes committed and pushed at %time%
        
        :: Refresh Packet Tracer if running
        tasklist | find /i "PacketTracer.exe" >nul && (
            echo.
            echo Refreshing Packet Tracer...
            taskkill /im PacketTracer.exe /f >nul
            timeout /t 2 >nul
            start "" "%PKT_EXE%" "%PKT_FILE%"
            echo ✓ Packet Tracer reloaded
        )
    )
)

:: Display status on first run
if defined FIRST_RUN (
    echo.
    echo Initialized. Watching for changes...
    set "FIRST_RUN="
)

:: Wait 10 seconds before next check
timeout /t 10 >nul
goto LOOP
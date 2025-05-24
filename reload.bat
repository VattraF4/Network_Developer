@echo off
:: Configure paths - UPDATE THESE TO MATCH YOUR SYSTEM
set "PKT_FILE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
set "PT_EXE=C:\Program Files\Cisco Packet Tracer 8.2.2\bin\PacketTracer.exe"

title PKT Auto-Reload Monitor - Press CTRL+C to exit
color 0A

:INIT
:: Get initial file timestamp
for %%F in ("%PKT_FILE%") do set "LAST_TS=%%~tF"

:LOOP
cls
echo [%time%] Monitoring: %PKT_FILE%
echo Last modified: %LAST_TS%
echo.
echo Press CTRL+C to stop monitoring

:: Check for file changes
for %%F in ("%PKT_FILE%") do (
    if not "%%~tF"=="%LAST_TS%" (
        echo.
        echo Change detected! Reloading Packet Tracer...
        taskkill /f /im PacketTracer.exe >nul 2>&1
        start "" "%PT_EXE%" "%PKT_FILE%"
        set "LAST_TS=%%~tF"
    )
)

:: Wait 2 seconds before checking again
timeout /t 2 >nul
goto LOOP
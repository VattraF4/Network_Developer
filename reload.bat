@echo off
set "PKT_FILE=D:\RUPP\Y3\Semester II\Network\Packet Tracker Activity\Network_Developer\Topology.pkt"
set "PT_EXE=C:\Program Files\Cisco Packet Tracer 8.2.2\bin\PacketTracer.exe"

:loop
echo Waiting for changes to %PKT_FILE%...
robocopy "%~dpPKT_FILE%" "%~dpPKT_FILE%.tmp" "%~nxPKT_FILE%" /L /NJH /NJS /NP /NS /NC
if %errorlevel% equ 1 (
    echo Change detected! Reloading Packet Tracer...
    taskkill /f /im PacketTracer.exe >nul
    start "" "%PT_EXE%" "%PKT_FILE%"
)
timeout /t 5 >nul
goto loop
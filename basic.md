! Create VLANs
vlan 10
 name Management
exit

vlan 20
 name LAN
exit

vlan 50
 name WLAN
exit



! Configure trunk ports (Fa0/1 to Fa0/2)
interface range fastEthernet0/1 - 2
 switchport mode trunk
exit

! Configure access ports for VLAN 20 (Fa0/3 to Fa0/20)
interface range fastEthernet0/3 - 20
 switchport mode access
 switchport access vlan 20
exit

! Configure access ports for VLAN 50 (Fa0/21 to Fa0/24)
interface range fastEthernet0/21 - 24
 switchport mode access
 switchport access vlan 50
exit

! Configure access ports for VLAN 199 and shut them down (Gi0/1 to Gi0/2)
interface range gigabitEthernet0/1 - 2
 switchport mode access
 switchport access vlan 199
 shutdown
exit

! Save configuration
do write
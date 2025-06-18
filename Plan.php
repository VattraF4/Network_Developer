<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Networking Project Guide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .code-block:hover .copy-btn { opacity: 1; }
        .copy-btn-copied { background-color: #10B981; }
        .task-checkbox:checked + label .task-icon { background-color: #10B981; }
        .task-checkbox:checked + label .task-icon svg { stroke: white; }
        .nav-link.active { background-color: #D1D5DB; color: #1F2937; font-weight: 600; }
    </style>
</head>
<body class="bg-stone-100 text-stone-800">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar Navigation -->
        <nav class="w-full md:w-64 bg-stone-200 p-4 md:p-6 shrink-0">
            <h1 class="text-2xl font-bold text-stone-900 mb-8">Project Guide</h1>
            <ul class="space-y-2" id="navigation">
                <?php
                $navItems = [
                    'dashboard' => ['Dashboard', 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    'core' => ['Core Networking', 'M8 9l4-4 4 4m0 6l-4 4-4-4'],
                    'routing' => ['Routing', 'M13 10V3L4 14h7v7l9-11h-7z'],
                    'wireless' => ['Wireless & Redundancy', 'M8.128 19.825A1.5 1.5 0 0110 18h4a1.5 1.5 0 011.872 1.825l-.001.002c-.408.82-.993 1.51-1.74 2.032a1.5 1.5 0 01-2.264 0c-.747-.522-1.332-1.212-1.74-2.032l-.001-.002zM12 2c3.866 0 7 3.134 7 7 0 2.653-2.11 5.49-7 9.5-4.89-4.01-7-6.847-7-9.5 0-3.866 3.134-7 7-7z'],
                    'security' => ['LAN Security', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                    'finalization' => ['Finalization', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
                ];
                
                foreach ($navItems as $id => [$title, $path]) {
                    echo "<li><a href='#$id' class='nav-link flex items-center p-3 rounded-lg hover:bg-stone-300 transition-colors duration-200" . 
                         ($id === 'dashboard' ? ' active' : '') . "'>
                        <svg class='w-5 h-5 mr-3' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='$path'/>
                        </svg>$title</a></li>";
                }
                ?>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10 bg-white">
            <?php
            $sections = [
                'dashboard' => [
                    'title' => 'Project Dashboard',
                    'desc' => 'Welcome to your interactive project guide. This dashboard provides an overview of the project\'s structure and your progress.',
                    'content' => function() {
                        echo '<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-stone-50 rounded-xl p-6">
                                <h3 class="text-2xl font-semibold mb-4 text-stone-800">Task Progress</h3>
                                <div class="chart-container" style="position:relative;width:100%;max-width:420px;height:420px;margin:0 auto">
                                    <canvas id="progressChart"></canvas>
                                </div>
                            </div>
                            <div class="bg-stone-50 rounded-xl p-6">
                                <h3 class="text-2xl font-semibold mb-4 text-stone-800">Task Checklist</h3>
                                <div id="taskList" class="space-y-4"></div>
                            </div>
                        </div>';
                    }
                ],
                'core' => [
                    'title' => 'Core Networking',
                    'desc' => 'This section covers the foundational Layer 2 and Layer 3 configurations.',
                    'content' => function() {
                        renderTask('Day 1-2: VLANs & Inter-VLAN Routing', 'Set up 4 VLANs with Router-on-a-Stick.', [
                            'Create VLANs on a Layer 2 Switch' => 'Switch(config)# vlan 10\nSwitch(config-vlan)# name StudyOffice',
                            'Assign Access Ports' => 'Switch(config)# interface fa0/1\nSwitch(config-if)# switchport mode access',
                            'Configure Trunk to Router' => 'Switch(config)# interface fa0/24\nSwitch(config-if)# switchport mode trunk',
                            'Router-on-a-Stick' => 'Router(config)# interface g0/0.10\nRouter(config-subif)# encapsulation dot1Q 10'
                        ]);
                        
                        renderTask('Day 3-4: DHCP Configuration', 'Configure DHCP for all VLANs.', [
                            'Set up DHCP on Router' => 'Router(config)# ip dhcp excluded-address 192.168.10.1\nRouter(config)# ip dhcp pool VLAN10_Pool',
                            'Verify PCs get IPs' => 'Use `ipconfig` on client PCs'
                        ]);
                    }
                ],
                'routing' => [
                    'title' => 'Routing',
                    'desc' => 'This section focuses on how data is forwarded between different networks.',
                    'content' => function() {
                        renderTask('Day 3-4: Static Routing', 'Configure static routing between the main campus and a remote site.', [
                            'Configure Static Route' => 'Router1(config)# ip route 192.168.20.0 255.255.255.0 10.0.0.2'
                        ]);
                        
                        renderTask('Day 5-6: OSPF Routing', 'Replace static routes with OSPF for scalability.', [
                            'Enable OSPF on Routers' => 'Router(config)# router ospf 1\nRouter(config-router)# network 192.168.10.0 0.0.0.255 area 0',
                            'Verify OSPF Neighbors' => 'Use `show ip ospf neighbor`'
                        ]);
                    }
                ],
                'wireless' => [
                    'title' => 'Wireless & Redundancy',
                    'desc' => 'Here, you\'ll expand the network to include secure wireless access and build in fault tolerance.',
                    'content' => function() {
                        renderTask('Day 7-8: Wireless LAN (WPA2 + MAC Filtering)', 'Secure Wi-Fi for students/staff.', [
                            'Configure a WLC 3504' => 'In Packet Tracer',
                            'Set up a WPA2-Enterprise SSID' => 'Requires a RADIUS server',
                            'Enable MAC Address Filtering' => 'Whitelist allowed devices'
                        ]);
                        
                        renderTask('Day 9-10: HSRP (First Hop Redundancy)', 'Ensure gateway redundancy.', [
                            'Configure HSRP on R1 (Primary) & R2 (Backup)' => 'R1(config-if)# standby 1 ip 192.168.10.254\nR1(config-if)# standby 1 priority 150',
                            'Test failover' => 'By shutting down the primary router\'s interface'
                        ]);
                    }
                ],
                'security' => [
                    'title' => 'LAN Security',
                    'desc' => 'Securing the wired network is critical.',
                    'content' => function() {
                        renderTask('Day 11-12: Port Security, ACLs, 802.1X', 'Prevent unauthorized access.', [
                            'Configure Port Security' => 'Switch(config-if)# switchport port-security\nSwitch(config-if)# switchport port-security maximum 2',
                            'Configure 802.1X' => 'Switch(config)# aaa new-model\nSwitch(config)# dot1x system-auth-control',
                            'Set up an ACL' => 'Router(config)# access-list 100 deny ip 192.168.10.0 0.0.0.255 192.168.30.0 0.0.0.255'
                        ]);
                    }
                ],
                'finalization' => [
                    'title' => 'Finalization',
                    'desc' => 'The final phase involves comprehensive testing of the entire network.',
                    'content' => function() {
                        echo '<div class="bg-stone-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-2xl mb-4">Day 13-14: Testing & Documentation</h3>
                            <h4 class="font-semibold text-xl mb-3">Final Report Structure:</h4>
                            <ul class="list-disc list-inside space-y-2 text-stone-700">
                                <li><b>Introduction:</b> Project Scope, Objectives, Team Members, and Tools Used.</li>
                                <li><b>Configuration Steps:</b> Detailed explanations with screenshots.</li>
                                <li><b>Challenges Faced & Solutions:</b> A log of any issues encountered.</li>
                                <li><b>Verification:</b> Evidence of functionality.</li>
                                <li><b>Conclusion:</b> A summary of the project outcome.</li>
                            </ul>
                        </div>';
                    }
                ]
            ];

            function renderTask($title, $goal, $steps) {
                echo "<details class='group bg-stone-50 p-4 rounded-lg'>
                    <summary class='font-semibold text-lg cursor-pointer flex justify-between items-center'>
                        $title
                        <svg class='w-5 h-5 transform group-open:rotate-180 transition-transform' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                        </svg>
                    </summary>
                    <div class='mt-4 text-stone-700 space-y-3'>
                        <h4 class='font-semibold'>Goal: $goal</h4>";
                
                foreach ($steps as $step => $code) {
                    echo "<p>$step:</p>";
                    if (strpos($code, "\n") !== false) {
                        echo "<div class='code-block relative'><pre class='bg-stone-900 text-white p-4 rounded-md overflow-x-auto'><code>$code</code></pre>
                            <button class='copy-btn absolute top-2 right-2 bg-stone-600 text-white px-2 py-1 rounded text-xs cursor-pointer opacity-50 transition-opacity'>Copy</button></div>";
                    } else {
                        echo "<p class='ml-4'>$code</p>";
                    }
                }
                echo "</div></details>";
            }

            $currentSection = $_GET['section'] ?? 'dashboard';
            foreach ($sections as $id => $section) {
                echo "<div id='$id' class='content-section" . ($id !== $currentSection ? ' hidden' : '') . "'>
                    <h2 class='text-4xl font-bold mb-2 text-stone-900'>{$section['title']}</h2>
                    <p class='text-lg text-stone-600 mb-8'>{$section['desc']}</p>";
                $section['content']();
                echo "</div>";
            }
            ?>
        </main>
    </div>

    <script>
        const tasks = {
            'Core Networking': ['VLANs & Inter-VLAN Routing', 'DHCP Configuration'],
            'Routing': ['Static Routing', 'OSPF Routing'],
            'Wireless & Redundancy': ['Wireless LAN Setup', 'HSRP Redundancy'],
            'LAN Security': ['Port Security, ACLs, & 802.1X'],
            'Finalization': ['Testing & Documentation']
        };

        const taskPoints = {
            'VLANs & Inter-VLAN Routing': 10, 'DHCP Configuration': 10,
            'Static Routing': 10, 'OSPF Routing': 10, 'Wireless LAN Setup': 15,
            'HSRP Redundancy': 15, 'Port Security, ACLs, & 802.1X': 15,
            'Testing & Documentation': 15
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                    document.querySelectorAll('.content-section').forEach(sec => sec.classList.add('hidden'));
                    document.getElementById(link.getAttribute('href').substring(1)).classList.remove('hidden');
                });
            });

            // Code Copying
            document.querySelectorAll('.code-block').forEach(block => {
                const btn = block.querySelector('.copy-btn');
                btn.addEventListener('click', () => {
                    const code = block.querySelector('code').innerText;
                    navigator.clipboard.writeText(code).then(() => {
                        btn.textContent = 'Copied!';
                        btn.classList.add('copy-btn-copied');
                        setTimeout(() => {
                            btn.textContent = 'Copy';
                            btn.classList.remove('copy-btn-copied');
                        }, 2000);
                    });
                });
            });

            // Chart and Task List
            const ctx = document.getElementById('progressChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(taskPoints),
                    datasets: [{
                        data: Object.values(taskPoints),
                        backgroundColor: ['#a8a29e', '#78716c', '#fca5a5', '#ef4444', '#60a5fa', '#2563eb', '#4ade80', '#16a34a'],
                        borderColor: '#ffffff',
                        borderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } },
                        tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.raw} points` } }
                    }
                }
            });

            // Task List
            const taskList = document.getElementById('taskList');
            Object.entries(tasks).forEach(([category, items]) => {
                taskList.innerHTML += `<h4 class="text-lg font-semibold mt-4 text-stone-700">${category}</h4>`;
                items.forEach(task => {
                    const taskId = task.replace(/\s+/g, '-').toLowerCase();
                    taskList.innerHTML += `
                        <div class="flex items-center">
                            <input type="checkbox" id="${taskId}" class="hidden task-checkbox" data-task="${task}">
                            <label for="${taskId}" class="flex items-center cursor-pointer text-stone-600 hover:text-stone-900 w-full">
                                <span class="task-icon w-6 h-6 mr-3 rounded-full border-2 border-stone-300 flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4 stroke-transparent" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <span>${task}</span>
                            </label>
                        </div>`;
                });
            });

            // Task Checkbox Events
            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const icon = this.nextElementSibling.querySelector('.task-icon');
                    if (this.checked) {
                        icon.classList.add('bg-green-500', 'border-green-500');
                        icon.querySelector('svg').classList.add('stroke-white');
                    } else {
                        icon.classList.remove('bg-green-500', 'border-green-500');
                        icon.querySelector('svg').classList.remove('stroke-white');
                    }
                });
            });
        });
    </script>
</body>
</html>
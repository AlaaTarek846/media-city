<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .test-section {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        .log {
            background: #000;
            color: #0f0;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }
        .log-entry {
            margin: 5px 0;
        }
        .success { color: #0f0; }
        .error { color: #f00; }
        .info { color: #0ff; }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .status.connected {
            background: #d4edda;
            color: #155724;
        }
        .status.disconnected {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔔 Pusher Connection Test</h1>
        
        <div id="status" class="status disconnected">
            ⚠️ Disconnected
        </div>

        <div class="test-section">
            <h3>1. Public Channel Test</h3>
            <p>Test connection to public channel: <code>test-channel</code></p>
            <button onclick="testPublicChannel()">Test Public Channel</button>
            <button onclick="subscribePublic()">Subscribe to Public Channel</button>
        </div>

        <div class="test-section">
            <h3>2. Private Channel Test (Admin Notifications)</h3>
            <p>Test connection to private channel: <code>private-admin.notifications</code></p>
            <p><strong>Note:</strong> You need to be logged in as admin for this to work.</p>
            <button onclick="testPrivateChannel()">Test Private Channel</button>
            <button onclick="subscribePrivate()">Subscribe to Private Channel</button>
        </div>

        <div class="test-section">
            <h3>3. Connection Info</h3>
            <p><strong>Pusher Key:</strong> <code>5574d355f663616e7c35</code></p>
            <p><strong>Cluster:</strong> <code>eu</code></p>
            <p><strong>App ID:</strong> <code>1463337</code></p>
        </div>

        <div class="log" id="log">
            <div class="log-entry info">[INFO] Waiting for connection...</div>
        </div>
    </div>

    <script>
        // Enable pusher logging
        Pusher.logToConsole = true;

        let pusher = null;
        let publicChannel = null;
        let privateChannel = null;
        const log = document.getElementById('log');
        const status = document.getElementById('status');

        function addLog(message, type = 'info') {
            const entry = document.createElement('div');
            entry.className = `log-entry ${type}`;
            entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            log.appendChild(entry);
            log.scrollTop = log.scrollHeight;
        }

        function updateStatus(connected) {
            if (connected) {
                status.className = 'status connected';
                status.textContent = '✅ Connected to Pusher';
            } else {
                status.className = 'status disconnected';
                status.textContent = '⚠️ Disconnected';
            }
        }

        // Initialize Pusher
        try {
            pusher = new Pusher('5574d355f663616e7c35', {
                cluster: 'eu',
                forceTLS: true,
                encrypted: true
            });

            pusher.connection.bind('connected', function() {
                addLog('✅ Connected to Pusher', 'success');
                updateStatus(true);
            });

            pusher.connection.bind('disconnected', function() {
                addLog('❌ Disconnected from Pusher', 'error');
                updateStatus(false);
            });

            pusher.connection.bind('error', function(err) {
                addLog('❌ Pusher Error: ' + JSON.stringify(err), 'error');
                updateStatus(false);
            });

            addLog('🔌 Initializing Pusher connection...', 'info');
        } catch (error) {
            addLog('❌ Error initializing Pusher: ' + error.message, 'error');
        }

        function subscribePublic() {
            if (!pusher) {
                addLog('❌ Pusher not initialized', 'error');
                return;
            }

            try {
                if (publicChannel) {
                    pusher.unsubscribe('test-channel');
                }

                publicChannel = pusher.subscribe('test-channel');
                
                publicChannel.bind('pusher:subscription_succeeded', function() {
                    addLog('✅ Subscribed to public channel: test-channel', 'success');
                });

                publicChannel.bind('pusher-test', function(data) {
                    addLog('📨 Received public event: ' + JSON.stringify(data), 'success');
                    alert('Public Event Received!\n\n' + JSON.stringify(data, null, 2));
                });

                addLog('🔄 Subscribing to public channel: test-channel', 'info');
            } catch (error) {
                addLog('❌ Error subscribing to public channel: ' + error.message, 'error');
            }
        }

        function subscribePrivate() {
            if (!pusher) {
                addLog('❌ Pusher not initialized', 'error');
                return;
            }

            // Check if we have auth token (for private channels)
            const token = getCookie('token');
            if (!token) {
                addLog('⚠️ No auth token found. Please login as admin first.', 'error');
                alert('You need to be logged in as admin to test private channels.\n\nPlease login at: /admin/login');
                return;
            }

            try {
                if (privateChannel) {
                    pusher.unsubscribe('private-admin.notifications');
                }

                // For private channels, we need to use Laravel Echo or handle auth manually
                // This is a simplified test - in production, use Laravel Echo
                addLog('⚠️ Private channel subscription requires Laravel Echo', 'info');
                addLog('💡 Use the admin dashboard to test private channels', 'info');
            } catch (error) {
                addLog('❌ Error subscribing to private channel: ' + error.message, 'error');
            }
        }

        function testPublicChannel() {
            addLog('📤 Sending test event to public channel...', 'info');
            
            fetch('/api/dashboard/test-pusher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + getCookie('token') || ''
                },
                body: JSON.stringify({
                    message: 'Test message from browser - ' + new Date().toLocaleTimeString()
                })
            })
            .then(response => response.json())
            .then(data => {
                addLog('✅ Test event sent: ' + JSON.stringify(data), 'success');
            })
            .catch(error => {
                addLog('❌ Error sending test event: ' + error.message, 'error');
            });
        }

        function testPrivateChannel() {
            const token = getCookie('token');
            if (!token) {
                addLog('⚠️ No auth token found. Please login as admin first.', 'error');
                alert('You need to be logged in as admin to test private channels.');
                return;
            }

            addLog('📤 Sending test event to private channel...', 'info');
            
            fetch('/api/dashboard/test-pusher-private', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    message: 'Test private message - ' + new Date().toLocaleTimeString()
                })
            })
            .then(response => response.json())
            .then(data => {
                addLog('✅ Test private event sent: ' + JSON.stringify(data), 'success');
            })
            .catch(error => {
                addLog('❌ Error sending test private event: ' + error.message, 'error');
            });
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        // Auto-subscribe to public channel on load
        setTimeout(() => {
            subscribePublic();
        }, 1000);
    </script>
</body>
</html>





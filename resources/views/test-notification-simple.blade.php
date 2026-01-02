<!DOCTYPE html>
<html>
<head>
    <title>Test Notification API</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .result { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔔 Test Notification API</h1>
    
    <div>
        <button onclick="testUnreadCount()">Test Unread Count API</button>
        <button onclick="testGetMessages()">Test Get Messages API</button>
        <button onclick="testCreateMessage()">Create Test Message</button>
    </div>
    
    <div id="results"></div>

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        function showResult(title, data, type = 'success') {
            const div = document.createElement('div');
            div.className = `result ${type}`;
            div.innerHTML = `<h3>${title}</h3><pre>${JSON.stringify(data, null, 2)}</pre>`;
            document.getElementById('results').appendChild(div);
        }

        async function testUnreadCount() {
            const token = getCookie('token');
            if (!token) {
                showResult('❌ Error', 'No token found. Please login first.', 'error');
                return;
            }

            try {
                const res = await fetch('/api/dashboard/notifications/unread-count', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                showResult('✅ Unread Count API Response', data, res.ok ? 'success' : 'error');
            } catch (error) {
                showResult('❌ Error', { error: error.message }, 'error');
            }
        }

        async function testGetMessages() {
            const token = getCookie('token');
            if (!token) {
                showResult('❌ Error', 'No token found. Please login first.', 'error');
                return;
            }

            try {
                const res = await fetch('/api/dashboard/notifications?filter=unread&per_page=5', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                showResult('✅ Get Messages API Response', data, res.ok ? 'success' : 'error');
            } catch (error) {
                showResult('❌ Error', { error: error.message }, 'error');
            }
        }

        async function testCreateMessage() {
            try {
                const res = await fetch('/api/web/contact-us', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: 'Test User ' + new Date().getTime(),
                        email: 'test' + new Date().getTime() + '@example.com',
                        phone: '01234567890',
                        subject: 'Test Notification - ' + new Date().toLocaleString(),
                        message: 'This is a test message to verify notifications appear in dashboard.'
                    })
                });
                const data = await res.json();
                showResult('✅ Create Message Response', data, res.ok ? 'success' : 'error');
                
                if (res.ok) {
                    setTimeout(() => {
                        testUnreadCount();
                        testGetMessages();
                    }, 1000);
                }
            } catch (error) {
                showResult('❌ Error', { error: error.message }, 'error');
            }
        }

        // Check token on load
        const token = getCookie('token');
        if (token) {
            showResult('✅ Token Found', 'You are logged in. You can test the APIs.', 'success');
        } else {
            showResult('⚠️ No Token', 'Please login at /admin/login first', 'error');
        }
    </script>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Contact Us Form</title>
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
        .form-group {
            margin: 20px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #0056b3;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
        .result.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .result.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .log {
            background: #000;
            color: #0f0;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 20px;
            display: none;
        }
        .log-entry {
            margin: 5px 0;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Test Contact Us Form</h1>
        
        <div class="info-box">
            <h3>ℹ️ Instructions</h3>
            <ol>
                <li><strong>Method 1:</strong> Fill out the form below and click "Send Test Message" (Public API - no login required)</li>
                <li><strong>Method 2:</strong> Login as Admin and click "Send Test Message (Admin)" (Uses authenticated endpoint)</li>
                <li>Check the Dashboard at <code>/admin/contact-message-notifications</code></li>
                <li>Check the notification bell in the header (must be logged in as admin)</li>
                <li>Open browser console (F12) to see Pusher events</li>
            </ol>
            <p><strong>Note:</strong> To see notifications in real-time, you must be logged in as Admin in another tab/window.</p>
        </div>

        <form id="contactForm">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" required value="Test User">
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required value="test@example.com">
            </div>

            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="text" id="phone" name="phone" required value="01234567890">
            </div>

            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required value="Test Message - {{ date('Y-m-d H:i:s') }}">
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" required>This is a test message sent at {{ date('Y-m-d H:i:s') }}. Please check if it appears in the Dashboard notifications.</textarea>
            </div>

            <button type="submit" id="submitBtn">Send Test Message (Public API)</button>
            <button type="button" id="submitAdminBtn" style="background: #28a745; margin-top: 10px;">Send Test Message (Admin - Requires Login)</button>
        </form>

        <div id="result" class="result"></div>
        <div id="log" class="log"></div>
    </div>

    <script>
        const form = document.getElementById('contactForm');
        const result = document.getElementById('result');
        const log = document.getElementById('log');
        const submitBtn = document.getElementById('submitBtn');
        const submitAdminBtn = document.getElementById('submitAdminBtn');

        function addLog(message, type = 'info') {
            log.style.display = 'block';
            const entry = document.createElement('div');
            entry.className = 'log-entry';
            entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            log.appendChild(entry);
            log.scrollTop = log.scrollHeight;
        }

        function showResult(message, isSuccess) {
            result.style.display = 'block';
            result.className = `result ${isSuccess ? 'success' : 'error'}`;
            result.textContent = message;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            result.style.display = 'none';
            log.innerHTML = '';
            log.style.display = 'block';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            addLog('📤 Sending contact form data...');
            addLog('Data: ' + JSON.stringify(data, null, 2));

            try {
                const response = await fetch('/api/web/contact-us', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (response.ok) {
                    addLog('✅ Success! Response: ' + JSON.stringify(responseData, null, 2), 'success');
                    showResult('✅ Message sent successfully! Check the Dashboard for the notification.', true);
                    
                    // Check if Pusher is available
                    if (typeof Pusher !== 'undefined') {
                        addLog('🔔 Pusher is available. Check console for events.');
                    } else {
                        addLog('⚠️ Pusher not loaded. Make sure you are testing from the admin dashboard.');
                    }
                } else {
                    addLog('❌ Error: ' + JSON.stringify(responseData, null, 2), 'error');
                    showResult('❌ Error: ' + (responseData.message || 'Failed to send message'), false);
                }
            } catch (error) {
                addLog('❌ Network Error: ' + error.message, 'error');
                showResult('❌ Network Error: ' + error.message, false);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Test Message';
            }
        });

        // Admin test button
        submitAdminBtn.addEventListener('click', async () => {
            const token = getCookie('token');
            if (!token) {
                showResult('❌ Please login as Admin first. Go to /admin/login', false);
                addLog('⚠️ No admin token found. Please login first.', 'error');
                return;
            }

            submitAdminBtn.disabled = true;
            submitAdminBtn.textContent = 'Sending...';
            result.style.display = 'none';
            log.innerHTML = '';
            log.style.display = 'block';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            addLog('📤 Sending contact message via Admin API...');
            addLog('Data: ' + JSON.stringify(data, null, 2));

            try {
                const response = await fetch('/api/dashboard/test-contact-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (response.ok) {
                    addLog('✅ Success! Response: ' + JSON.stringify(responseData, null, 2), 'success');
                    showResult('✅ Test message sent via Admin API! Check Dashboard notifications.', true);
                    addLog('🔔 Event broadcasted to: private-admin.notifications', 'success');
                    addLog('📨 Event name: contact-message.created', 'success');
                } else {
                    addLog('❌ Error: ' + JSON.stringify(responseData, null, 2), 'error');
                    showResult('❌ Error: ' + (responseData.message || 'Failed to send message'), false);
                }
            } catch (error) {
                addLog('❌ Network Error: ' + error.message, 'error');
                showResult('❌ Network Error: ' + error.message, false);
            } finally {
                submitAdminBtn.disabled = false;
                submitAdminBtn.textContent = 'Send Test Message (Admin - Requires Login)';
            }
        });

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        addLog('📋 Form ready. Fill out and submit to test.');
        
        // Check if admin is logged in
        const token = getCookie('token');
        if (token) {
            addLog('✅ Admin token found. You can use both methods.', 'success');
        } else {
            addLog('⚠️ No admin token. Use Public API method or login first.', 'info');
        }
    </script>
</body>
</html>


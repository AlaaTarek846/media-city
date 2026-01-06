<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification System Debug Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #555;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
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
            background: #f9f9f9;
            border-left: 4px solid #007bff;
        }
        .result.success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        .result.error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        .result.warning {
            border-left-color: #ffc107;
            background: #fff3cd;
        }
        pre {
            background: #000;
            color: #0f0;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .status-success { background: #28a745; color: white; }
        .status-error { background: #dc3545; color: white; }
        .status-warning { background: #ffc107; color: black; }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
        }
        tr:hover {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Notification System Debug Test</h1>
        
        <div class="info-box">
            <h3>ℹ️ Instructions</h3>
            <ol>
                <li>Make sure you are logged in as Admin</li>
                <li>Click "Run Complete Test" to test the entire flow</li>
                <li>Check the results below</li>
                <li>If there are errors, check the details and fix them</li>
                <li>Open Dashboard in another tab: <code>/admin/contact-message-notifications</code></li>
                <li>Open Console (F12) to see Pusher events</li>
            </ol>
        </div>

        <div style="text-align: center; margin: 20px 0;">
            <button onclick="runCompleteTest()">Run Complete Test</button>
            <button onclick="getAllMessages()">Get All Messages</button>
            <button onclick="testEventDispatch()">Test Event Dispatch</button>
            <button onclick="checkDashboard()">Check Dashboard Page</button>
        </div>

        <div id="results"></div>
    </div>

    <script>
        const token = getCookie('token');
        
        if (!token) {
            document.getElementById('results').innerHTML = `
                <div class="result error">
                    <h3>❌ Error: Not Logged In</h3>
                    <p>Please login as Admin first: <a href="/admin/login" target="_blank">Login</a></p>
                </div>
            `;
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        function showResult(title, data, type = 'success') {
            const resultsDiv = document.getElementById('results');
            const resultDiv = document.createElement('div');
            resultDiv.className = `result ${type}`;
            resultDiv.innerHTML = `
                <h3>${title}</h3>
                <pre>${JSON.stringify(data, null, 2)}</pre>
            `;
            resultsDiv.appendChild(resultDiv);
            resultDiv.scrollIntoView({ behavior: 'smooth' });
        }

        async function runCompleteTest() {
            if (!token) {
                alert('Please login as Admin first');
                return;
            }

            document.getElementById('results').innerHTML = '<div class="result"><h3>🔄 Running tests...</h3></div>';

            try {
                const response = await fetch('/api/dashboard/test-notification-flow', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    showResult('✅ Complete Test Results', data, 'success');
                    
                    // Show summary
                    if (data.data && data.data.summary) {
                        const summary = data.data.summary;
                        let summaryHtml = '<h3>📊 Test Summary</h3><ul>';
                        for (const [key, value] of Object.entries(summary)) {
                            const badgeClass = value === 'success' ? 'status-success' : 
                                             value === 'error' ? 'status-error' : 'status-warning';
                            summaryHtml += `<li>${key.replace(/_/g, ' ')}: <span class="status-badge ${badgeClass}">${value}</span></li>`;
                        }
                        summaryHtml += '</ul>';
                        
                        const summaryDiv = document.createElement('div');
                        summaryDiv.className = 'result success';
                        summaryDiv.innerHTML = summaryHtml;
                        document.getElementById('results').appendChild(summaryDiv);
                    }
                } else {
                    showResult('❌ Test Failed', data, 'error');
                }
            } catch (error) {
                showResult('❌ Network Error', { error: error.message }, 'error');
            }
        }

        async function getAllMessages() {
            if (!token) {
                alert('Please login as Admin first');
                return;
            }

            try {
                const response = await fetch('/api/dashboard/test-all-messages', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    let html = `
                        <h3>📨 All Contact Messages</h3>
                        <p><strong>Total:</strong> ${data.data.total} | <strong>Unread:</strong> ${data.data.unread}</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Is Read</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    
                    data.data.data.forEach(msg => {
                        html += `
                            <tr>
                                <td>${msg.id}</td>
                                <td>${msg.name}</td>
                                <td>${msg.email}</td>
                                <td>${msg.subject}</td>
                                <td><span class="status-badge ${msg.is_read ? 'status-success' : 'status-warning'}">${msg.is_read ? 'Read' : 'Unread'}</span></td>
                                <td>${msg.created_at}</td>
                            </tr>
                        `;
                    });
                    
                    html += '</tbody></table>';
                    
                    const resultDiv = document.createElement('div');
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = html;
                    document.getElementById('results').appendChild(resultDiv);
                } else {
                    showResult('❌ Failed to Get Messages', data, 'error');
                }
            } catch (error) {
                showResult('❌ Network Error', { error: error.message }, 'error');
            }
        }

        async function testEventDispatch() {
            if (!token) {
                alert('Please login as Admin first');
                return;
            }

            try {
                const response = await fetch('/api/dashboard/test-event-dispatch', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                
                if (response.ok) {
                    showResult('✅ Event Dispatch Test', data, 'success');
                    alert('Event dispatched! Check Dashboard and Console for the notification.');
                } else {
                    showResult('❌ Event Dispatch Failed', data, 'error');
                }
            } catch (error) {
                showResult('❌ Network Error', { error: error.message }, 'error');
            }
        }

        function checkDashboard() {
            window.open('/admin/contact-message-notifications', '_blank');
        }
    </script>
</body>
</html>






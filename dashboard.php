<?php
session_start();

if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: admin.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas AI Administration</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h2>Atlas AI</h2>
    
    <button onclick="showSection('dashboard')">📊 Dashboard</button>
    <button onclick="showSection('users')">👥 Users</button>
    
    <a href="departments.php"><button>🏢 Departments</button></a>
    <a href="documents.php"><button>📄 Local Files upload</button></a>
    <a href="do.php"><button>📄 SharePoint Files Connect</button></a>

    <button onclick="showSection('branding')">🎨 Branding</button>
    <button onclick="showSection('settings')">⚙ Settings</button>

    <a href="admin_logout.php" class="logout-btn">🚪 Logout</a>
</div>

<!-- Main Content Area -->
<div class="content">

    <!-- Dashboard Section -->
    <div id="dashboard" class="section active">
        <h1>Dashboard Overview</h1>
        <div class="stats">
            <div class="card">
                <h3>Total Users</h3>
                <p id="dashboardUsers">5</p>
            </div>
            <div class="card">
                <h3>Admins</h3>
                <p id="dashboardAdmins">1</p>
            </div>
            <div class="card">
                <h3>Groups</h3>
                <p>5</p>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <p>5</p>
            </div>
        </div>

        <div class="activity-feed">
            <h3>Recent Activity</h3>
            <ul>
                <li>✅ User account created</li>
                <li>✅ Branding settings updated</li>
                <li>✅ Password reset completed</li>
                <li>✅ System operational</li>
            </ul>
        </div>
    </div>

    <!-- Users Section -->
    <div id="users" class="section">
        <div class="welcome-banner">
            <h1>Welcome, Administrator</h1>
            <p>Manage users, Department and view activities.</p>
        </div>

        <div class="stats">
            <div class="card">
                <h3>Total Users</h3>
                <p id="totalUsers">0</p>
            </div>
            <div class="card">
                <h3>Admins</h3>
                <p id="totalAdmins">0</p>
            </div>
            <div class="card">
                <h3>Groups</h3>
                <p>5</p>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <p id="activeUsers">0</p>
            </div>
        </div>

        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <button onclick="showSection('users')">👥 Manage Users</button>
            <button onclick="showSection('branding')">🎨 Branding</button>
            <button onclick="showSection('settings')">⚙ Settings</button>
        </div>

        <h3>Create User</h3>
        <div class="create-user-form">
            <input id="firstName" placeholder="First Name">
            <input id="lastName" placeholder="Last Name">
            <input id="email" placeholder="Email Address">
            <input id="newUsername" placeholder="Username">
            <input id="newPassword" type="password" placeholder="Password">
            <select id="newRole">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <select id="department"></select>
            <button onclick="createUser()">Create User</button>
        </div>

        <br><br>
        <input id="searchUser" placeholder="🔍 Search users...">
        <select id="departmentFilter">
            <option value="">All Departments</option>
        </select>
        <p id="userCount">Showing 0 users</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Group ID</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable"></tbody>
        </table>
    </div>

    <!-- Branding Section -->
    <div id="branding" class="section">
        <h1>Branding</h1>
        <div class="branding-container">
            <div class="branding-card">
                <h3>Logo Settings</h3>
                <img src="logo.png" width="220" id="logoPreview">
                <br><br>
                <input type="file" id="logoFile">
                <button>Upload Logo</button>
            </div>

            <div class="branding-card">
                <h3>AI Settings</h3>
                <label>AI Name</label>
                <input id="brandingAIName" value="Atlas AI">
                <br><br>
                <label>Welcome Message</label>
                <textarea id="welcomeMessage" rows="5">Welcome to Atlas AI.

I am your intelligent assistant.</textarea>
                <br><br>
                <button onclick="saveAISettings()">Save AI Settings</button>
            </div>

            <div class="branding-card">
                <h3>Company Information</h3>
                <label>Company Name</label>
                <input id="companyName" value="Atlas Support">
                <br><br>
                <label>Support Email</label>
                <input id="supportEmail" value="support@atlas.local">
                <br><br>
                <label>Website</label>
                <input id="website" value="www.atlas.local">
                <br><br>
                <button>Save Company Settings</button>
            </div>

            <div class="branding-card">
                <h3>Theme Colours</h3>
                <label>Primary Colour</label>
                <input type="color" value="#4da3ff">
                <br><br>
                <label>Sidebar Colour</label>
                <input type="color" value="#07142f">
                <br><br>
                <button>Save Colours</button>
            </div>
        </div>
    </div>

    <!-- Settings Section (Moved orphan cards inside here) -->
    <div id="settings" class="section">
        <h1>Settings</h1>
        <div class="settings-container">
            <div class="settings-card">
                <h3>⚙ General Settings</h3>
                <label>AI Name</label>
                <input id="aiName" value="Atlas AI">
                <br><br>
                <label>System Name</label>
                <input value="Atlas Support">
                <br><br>
                <button class="saveBtn">Save Settings</button>
            </div>

            <div class="settings-card">
                <h3>🔒 Security</h3>
                <label>Current Password</label>
                <input type="password">
                <br><br>
                <label>New Password</label>
                <input type="password">
                <br><br>
                <label>Confirm Password</label>
                <input type="password">
                <br><br>
                <label>Session Timeout (Minutes)</label>
                <input type="number" value="30">
                <br><br>
                <button class="saveBtn">Change Password</button>
            </div>

            <div class="settings-card">
                <h3>📧 Email Settings</h3>
                <label>SMTP Server</label>
                <input value="smtp.company.com">
                <br><br>
                <label>SMTP Port</label>
                <input value="587">
                <br><br>
                <button class="saveBtn">Save Email Settings</button>
                <button class="saveBtn">Send Test Email</button>
            </div>

            <div class="settings-card">
                <h3>💾 Backup & Recovery</h3>
                <p>Create and restore system backups.</p>
                <br>
                <button class="saveBtn">Create Backup</button>
                <button class="saveBtn">Restore Backup</button>
            </div>

            <div class="settings-card">
                <h3>🖥 System Information</h3>
                <p><strong>Atlas AI Version:</strong> 1.0</p>
                <br>
                <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
                <br>
                <p><strong>Database Status:</strong> ✅ Connected</p>
                <br>
                <p><strong>Server Status:</strong> ✅ Online</p>
            </div>

            <div class="settings-card">
                <h3>📋 Activity Logs</h3>
                <p>View and export administrative activity logs.</p>
                <br>
                <button class="saveBtn">View Logs</button>
                <button class="saveBtn">Export Logs</button>
            </div>
        </div>
    </div>

</div><!-- End Content -->

<script src="dashboard.js"></script>
</body>
</html>

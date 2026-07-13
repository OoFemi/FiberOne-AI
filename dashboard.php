<?php

session_start();

if (!isset($_SESSION["admin"])) {
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

<div class="sidebar">

    <h2>Atlas AI</h2>
<button onclick="showSection('dashboard')">
📊 Dashboard
</button>

    <button onclick="showSection('users')">
        👥 Users
    </button>

    <button onclick="showSection('branding')">
        🎨 Branding
    </button>

    <button onclick="showSection('settings')">
        ⚙ Settings
    </button>

 <a href="admin_logout.php" class=" 🚪 logout-btn">logout</a>
    
</button>


</div>

<div class="content">

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


<div id="users" class="section">

<div class="welcome-banner">

    <h1>
        Welcome, Administrator
    </h1>

    <p>
        Manage users, Department and view activities.
    </p>

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

<div class="activity-feed">

    <h3>Recent Activity</h3>

    <ul>
        <li>✅ User account created</li>
        <li>✅ Branding settings updated</li>
        <li>✅ Password reset completed</li>
        <li>✅ System operational</li>
    </ul>

</div>


<div class="quick-actions">

<h3>Quick Actions</h3>

<button onclick="showSection('users')">
👥 Manage Users
</button>

<button onclick="showSection('branding')">
🎨 Branding
</button>

<button onclick="showSection('settings')">
⚙ Settings
</button>

</div>








<h3>Create User</h3>

<div class="create-user-form">

    <input id="firstName" placeholder="First Name">

    <input id="lastName" placeholder="Last Name">

    <input id="email" placeholder="Email Address">

    <input id="newUsername" placeholder="Username">

    <input
    id="newPassword"
    type="password"
    placeholder="Password">

    <select id="newRole">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <select id="groupId">
        <option value="ATL-GRP-ADMIN">
            Administrators
        </option>

        <option value="ATL-GRP-SUPPORT">
            Support Team
        </option>

        <option value="ATL-GRP-HR">
            HR
        </option>

        <option value="ATL-GRP-FINANCE">
            Finance
        </option>

        <option value="ATL-GRP-OPS">
            Operations
        </option>
    </select>

    <button onclick="createUser()">
        Create User
    </button>

</div>


<br><br>

<input
id="searchUser"
placeholder="🔍 Search users...">

<p id="userCount">
Showing 0 users
</p>


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
<th>Status</th>
<th>Created</th>
<th>Last Login</th>
<th>Actions</th>
</tr>

</thead>

<tbody id="userTable">

</tbody>

</table>

</div>

<div id="branding" class="section">

    <h1>Branding</h1>

    <div class="branding-container">

        <div class="branding-card">

            <h3>Logo Settings</h3>

            <img
            src="logo.png"
            width="220"
            id="logoPreview">

            <br><br>

            <input
            type="file"
            id="logoFile">

            <button>
                Upload Logo
            </button>

        </div>

        <div class="branding-card">

            <h3>AI Settings</h3>

            <label>AI Name</label>

            <input
            id="brandingAIName"
            value="Atlas AI">

            <br><br>

            <label>Welcome Message</label>

            <textarea
            id="welcomeMessage"
            rows="5">

Welcome to Atlas AI.

I am your intelligent assistant.

            </textarea>

            <br><br>

            <button>
                Save AI Settings
            </button>

        </div>

    </div>


<div class="branding-card">

    <h3>Company Information</h3>

    <label>Company Name</label>

    <input
    id="companyName"
    value="Atlas Support">

    <br><br>

    <label>Support Email</label>

    <input
    id="supportEmail"
    value="support@atlas.local">

    <br><br>

    <label>Website</label>

    <input
    id="website"
    value="www.atlas.local">

    <br><br>

    <button>
        Save Company Settings
    </button>

</div>



<div class="branding-card">

    <h3>Theme Colours</h3>

    <label>Primary Colour</label>

    <input
    type="color"
    value="#4da3ff">

    <br><br>

    <label>Sidebar Colour</label>

    <input
    type="color"
    value="#07142f">

    <br><br>

    <button>
        Save Colours
    </button>



<div class="branding-container">

    <div class="branding-card">
        ...
    </div>

    <div class="branding-card">
        ...
    </div>

    <div class="branding-card">
        ...
    </div>

    <div class="branding-card">
        ...
    </div>

</div>
`




</div>









</div>

<div id="settings" class="section">

<h1>Settings</h1>

<br>

<input
id="aiName"
placeholder="AI Name">

<button
class="saveBtn"
onclick="saveAIName()">

Save

</button>

</div>

</div>

<script src="dashboard.js">
</script>

</body>
</html>
``

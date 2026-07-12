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

    <button onclick="showSection('users')">
        👥 Users
    </button>

    <button onclick="showSection('branding')">
        🎨 Branding
    </button>

    <button onclick="showSection('settings')">
        ⚙ Settings
    </button>

 <button onclick="showSection('logout')">
    🚪 Logout
</button>


</div>

<div class="content">

<div id="users" class="section active">

<h1>User Management</h1>

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

<h3>Create User</h3>

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

<br><br>

<input
id="searchUser"
placeholder="🔍 Search users...">

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

<br>

<img
src="logo.png"
width="220">

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

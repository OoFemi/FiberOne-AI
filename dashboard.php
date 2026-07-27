<?php
session_start();

if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: admin.html");
    exit;
}

require "db.php";

$departments = [];
$result = $conn->query("
    SELECT department_name
    FROM departments
    WHERE status='Active'
    ORDER BY department_name
");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row["department_name"];
    }
}

$baseFolder = "/home/femi/n8n-production/files";
$totalDocuments = 0;
$folders = is_dir($baseFolder) ? glob($baseFolder . "/*") : [];

if ($folders) {
    foreach ($folders as $folder) {
        if (!is_dir($folder)) {
            continue;
        }

        $files = glob($folder . "/*");
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $totalDocuments++;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas AI Administration</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        /* Hidden/Active section handling */
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }

        /* Sidebar styling match */
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body{
            font-family:'Segoe UI',sans-serif;
            background:#f4f6f9;
        }
        .sidebar{
            position:fixed;
            left:0;
            top:0;
            width:220px;
            height:100vh;
            background:#001845;
            padding:20px;
            overflow-y: auto;
        }
        .sidebar h2{
            color:white;
            margin-bottom:25px;
        }
        .sidebar button, .sidebar a button{
            width:100%;
            height:45px;
            margin-bottom:10px;
            border:none;
            border-radius:8px;
            background:#4da3ff;
            color:white;
            cursor:pointer;
            font-size:14px;
            text-align: left;
            padding: 0 15px;
        }
        .sidebar a {
            text-decoration: none;
            display: block;
        }
        .logout-btn{
            background:#e74c3c !important;
            text-align: center !important;
            line-height: 45px;
            display: block;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }
        .content{
            margin-left:220px;
            padding:30px;
        }
        .card, .table-card, .stat-card, .branding-card, .settings-card{
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover, .table-card:hover, .stat-card:hover, .branding-card:hover, .settings-card:hover{
            box-shadow: 0 6px 16px rgba(0,0,0,.12);
        }
        .stats{
            display:flex;
            gap:20px;
            margin-bottom:25px;
        }
        .stat-card{
            flex:1;
            text-align:center;
        }
        table{
            width:100%;
            border-collapse:collapse;
            background:white;
        }
        th{
            background:#4da3ff;
            color:white;
            text-align:left;
            padding:12px;
        }
        td{
            padding:12px;
            border-bottom:1px solid #ddd;
        }
        select, input[type=file], input[type=text], input[type=password], input[type=number], textarea{
            width:100%;
            padding:10px;
            border:1px solid #ddd;
            border-radius:6px;
            margin-bottom:15px;
            outline:none;
        }
        .submit-btn, .upload-btn, .saveBtn{
            background:#4da3ff;
            color:white;
            border:none;
            padding:10px 15px;
            border-radius:6px;
            cursor:pointer;
        }
        .action-btn{
            text-decoration:none;
            padding:6px 10px;
            border-radius:5px;
            color:white;
            font-size:12px;
            margin-right:5px;
            display:inline-block;
        }
        .view-btn{ background:#28a745; }
        .delete-btn{ background:#dc3545; }
        .success{ background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px; }
        .error{ background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px; }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h2>Atlas AI</h2>
    
    <button onclick="showSection('dashboard')">📊 Dashboard</button>
    <button onclick="showSection('users')">👥 Users</button>
    <button onclick="showSection('departments')">🏢 Departments</button>
    <button onclick="showSection('documents')">📄 Local Files upload</button>
    <button onclick="showSection('sharepoint')">📁 SharePoint Files</button>
    <button onclick="showSection('branding')">🎨 Branding</button>
    <button onclick="showSection('settings')">⚙ Settings</button>

    <a href="admin_logout.php" class="logout-btn">🚪 Logout</a>
</div>

<!-- Main Content Area -->
<div class="content">

    <!-- Dashboard Section -->
    <div id="dashboard" class="section active">
        <h1>Dashboard Overview</h1>
        <br>
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p id="dashboardUsers" style="font-size:28px; font-weight:bold; color:#4da3ff;">5</p>
            </div>
            <div class="stat-card">
                <h3>Admins</h3>
                <p id="dashboardAdmins" style="font-size:28px; font-weight:bold; color:#4da3ff;">1</p>
            </div>
            <div class="stat-card">
                <h3>Groups</h3>
                <p style="font-size:28px; font-weight:bold; color:#4da3ff;">5</p>
            </div>
            <div class="stat-card">
                <h3>Active Users</h3>
                <p style="font-size:28px; font-weight:bold; color:#4da3ff;">5</p>
            </div>
        </div>

        <div class="card">
            <h3>Recent Activity</h3>
            <ul style="list-style:none; padding-top:10px; line-height: 2;">
                <li>✅ User account created</li>
                <li>✅ Branding settings updated</li>
                <li>✅ Password reset completed</li>
                <li>✅ System operational</li>
            </ul>
        </div>
    </div>

    <!-- Users Section -->
    <div id="users" class="section">
        <h1>Users Management</h1>
        <br>
        <div class="card">
            <h3>Create User</h3>
            <br>
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
            <button class="submit-btn" onclick="createUser()">Create User</button>
        </div>

        <div class="card">
            <input id="searchUser" placeholder="🔍 Search users...">
            <select id="departmentFilter">
                <option value="">All Departments</option>
            </select>
            <p id="userCount" style="margin-bottom:15px; font-weight:bold;">Showing 0 users</p>

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
    </div>

    <!-- Departments Section -->
    <div id="departments" class="section">
        <h1>Departments</h1>
        <br>
        <div class="card">
            <h3>Add Department</h3>
            <br>
            <form method="POST" action="departments.php">
                <input type="text" name="department_name" placeholder="Department Name" required>
                <br><br>
                <button type="submit" class="submit-btn">Add Department</button>
            </form>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Department</th>
                        <th>Group ID</th>
                        <th>Folder</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $deptResult = $conn->query("SELECT * FROM departments ORDER BY department_name");
                if ($deptResult) {
                    while($row = $deptResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["department_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["group_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["folder_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"] ?? 'Active') . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Documents Section -->
    <div id="documents" class="section">
        <h1>Document Management</h1>
        <br>
        <div class="stats">
            <div class="stat-card">
                <h3>Documents</h3>
                <p style="font-size:28px; font-weight:bold; color:#4da3ff;"><?= $totalDocuments ?></p>
            </div>
            <div class="stat-card">
                <h3>Departments</h3>
                <p style="font-size:28px; font-weight:bold; color:#4da3ff;"><?= count($departments) ?></p>
            </div>
            <div class="stat-card">
                <h3>Status</h3>
                <p style="font-size:22px; font-weight:bold; color:#28a745; margin-top:5px;">Live</p>
            </div>
        </div>

        <div class="card">
            <h2>Upload Document</h2>
            <br>
            <form action="upload_documents.php" method="POST" enctype="multipart/form-data">
                <label>Department</label>
                <select name="department" required>
                    <?php foreach ($departments as $dept): ?>
                    <option value="<?= htmlspecialchars($dept) ?>"><?= htmlspecialchars($dept) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Document</label>
                <input type="file" name="document" accept=".pdf,.docx,.txt,.xlsx,.csv" required>

                <button type="submit" class="upload-btn">Upload Document</button>
            </form>
        </div>

        <div class="table-card">
            <h2>Uploaded Documents</h2>
            <input type="text" id="docSearch" placeholder="Search documents...">
            <table id="documentsTable">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Type</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($folders) {
                foreach ($folders as $folder) {
                    if (!is_dir($folder)) continue;
                    $deptName = basename($folder);
                    $files = glob($folder . "/*");
                    if ($files) {
                        foreach ($files as $file) {
                            if (!is_file($file)) continue;
                            $fileName = basename($file);
                            $type = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION));
                            $size = round(filesize($file) / 1024, 2);
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fileName) . "</td>";
                            echo "<td>{$type}</td>";
                            echo "<td>" . htmlspecialchars($deptName) . "</td>";
                            echo "<td class='status' style='color:green; font-weight:bold;'>🟢 Indexed</td>";
                            echo "<td>{$size} KB</td>";
                            echo "<td>
                                <a href='view_document.php?department=" . urlencode($deptName) . "&file=" . urlencode($fileName) . "' class='action-btn view-btn' target='_blank'>View</a>
                                <a href='delete_document.php?department=" . urlencode($deptName) . "&file=" . urlencode($fileName) . "' class='action-btn delete-btn' onclick=\"return confirm('Delete this document?')\">Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    }
                }
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>

    <!-- SharePoint Section -->
    <div id="sharepoint" class="section">
        <h1>SharePoint Files Connect</h1>
        <br>
        <div class="card">
            <h3>Connect SharePoint Integration</h3>
            <p>Link your Microsoft SharePoint repository to auto-sync files into Atlas AI.</p>
            <br>
            <input placeholder="Tenant ID">
            <input placeholder="Client ID">
            <input type="password" placeholder="Client Secret">
            <button class="submit-btn">Connect SharePoint</button>
        </div>
    </div>

    <!-- Branding Section -->
    <div id="branding" class="section">
        <h1>Branding</h1>
        <br>
        <div class="branding-container">
            <div class="branding-card">
                <h3>Logo Settings</h3>
                <img src="logo.png" width="220" id="logoPreview">
                <br><br>
                <input type="file" id="logoFile">
                <button class="submit-btn">Upload Logo</button>
            </div>

            <div class="branding-card">
                <h3>AI Settings</h3>
                <label>AI Name</label>
                <input id="brandingAIName" value="Atlas AI">
                <label>Welcome Message</label>
                <textarea id="welcomeMessage" rows="5">Welcome to Atlas AI.

I am your intelligent assistant.</textarea>
                <button class="submit-btn" onclick="saveAISettings()">Save AI Settings</button>
            </div>

            <div class="branding-card">
                <h3>Company Information</h3>
                <label>Company Name</label>
                <input id="companyName" value="Atlas Support">
                <label>Support Email</label>
                <input id="supportEmail" value="support@atlas.local">
                <label>Website</label>
                <input id="website" value="www.atlas.local">
                <button class="submit-btn">Save Company Settings</button>
            </div>

            <div class="branding-card">
                <h3>Theme Colours</h3>
                <label>Primary Colour</label>
                <input type="color" value="#4da3ff">
                <label>Sidebar Colour</label>
                <input type="color" value="#001845">
                <button class="submit-btn">Save Colours</button>
            </div>
        </div>
    </div>

    <!-- Settings Section -->
    <div id="settings" class="section">
        <h1>Settings</h1>
        <br>
        <div class="settings-container">
            <div class="settings-card">
                <h3>⚙ General Settings</h3>
                <label>AI Name</label>
                <input id="aiName" value="Atlas AI">
                <label>System Name</label>
                <input value="Atlas Support">
                <button class="saveBtn">Save Settings</button>
            </div>

            <div class="settings-card">
                <h3>🔒 Security</h3>
                <label>Current Password</label>
                <input type="password">
                <label>New Password</label>
                <input type="password">
                <label>Confirm Password</label>
                <input type="password">
                <label>Session Timeout (Minutes)</label>
                <input type="number" value="30">
                <button class="saveBtn">Change Password</button>
            </div>

            <div class="settings-card">
                <h3>📧 Email Settings</h3>
                <label>SMTP Server</label>
                <input value="smtp.company.com">
                <label>SMTP Port</label>
                <input value="587">
                <button class="saveBtn">Save Email Settings</button>
                <button class="saveBtn" style="background:#28a745; margin-top:5px;">Send Test Email</button>
            </div>

            <div class="settings-card">
                <h3>💾 Backup & Recovery</h3>
                <p>Create and restore system backups.</p>
                <br>
                <button class="saveBtn">Create Backup</button>
                <button class="saveBtn" style="background:#6c757d; margin-top:5px;">Restore Backup</button>
            </div>

            <div class="settings-card">
                <h3>🖥 System Information</h3>
                <p><strong>Atlas AI Version:</strong> 1.0</p><br>
                <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p><br>
                <p><strong>Database Status:</strong> ✅ Connected</p><br>
                <p><strong>Server Status:</strong> ✅ Online</p>
            </div>

            <div class="settings-card">
                <h3>📋 Activity Logs</h3>
                <p>View and export administrative activity logs.</p>
                <br>
                <button class="saveBtn">View Logs</button>
                <button class="saveBtn" style="background:#17a2b8; margin-top:5px;">Export Logs</button>
            </div>
        </div>
    </div>

</div><!-- End Content -->

<script>
function showSection(sectionId) {
    let sections = document.querySelectorAll('.section');
    sections.forEach(sec => {
        sec.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

// Search functionality for documents table
let docSearch = document.getElementById("docSearch");
if (docSearch) {
    docSearch.addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#documentsTable tbody tr");
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
        });
    });
}
</script>
<script src="dashboard.js"></script>
</body>
</html>

<?php

session_start();

if (!isset($_SESSION["admin"])) {

    header("Location: admin.html");
    exit;

}

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atlas AI Administration</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Segoe UI,sans-serif;
    display:flex;
    height:100vh;
    background:#f4f6f9;
}

.sidebar{
    width:250px;
    background:#0b1020;
    color:white;
    padding:20px;
}

.sidebar h2{
    margin-bottom:25px;
}

.sidebar button{
    width:100%;
    margin-bottom:10px;
    padding:12px;
    background:#4da3ff;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.content{
    flex:1;
    padding:30px;
    overflow:auto;
}

.section{
    display:none;
}

.active{
    display:block;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
}

th{
    background:#4da3ff;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border:1px solid #ddd;
}

input,
select{
    padding:10px;
    margin:5px;
}

.action{
    border:none;
    padding:6px 10px;
    color:white;
    border-radius:5px;
    cursor:pointer;
    margin-right:5px;
}

.edit{
    background:#f39c12;
}

.reset{
    background:#27ae60;
}

.delete{
    background:#e74c3c;
}

.saveBtn{
    padding:10px 20px;
    background:#4da3ff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.saveBtn{
    padding:10px 20px;
    background:#4da3ff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* ADD NEW CSS BELOW HERE */

.stats{
    display:flex;
    gap:20px;
    margin:20px 0;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    min-width:180px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.card p{
    font-size:28px;
    color:#4da3ff;
    font-weight:bold;
}

.quick-actions{
    margin:20px 0;
}

.quick-actions button{
    margin-right:10px;
    padding:10px 15px;
    background:#4da3ff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

#searchUser{
    width:300px;
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#4da3ff;
    color:white;
    padding:12px;
}

tr:nth-child(even){
    background:#f7f7f7;
}

tr:hover{
    background:#eef5ff;
}


#searchUser{
    width:350px;
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
    font-size:14px;
}


loadUsers();
loadSettings();

document.addEventListener(
    "DOMContentLoaded",
    function(){

        document
        .getElementById("searchUser")
        .addEventListener(
            "keyup",
            function(){

                const value =
                this.value.toLowerCase();

                document
                .querySelectorAll(
                    "#userTable tr"
                )
                .forEach(row=>{

                    row.style.display =

                    row.innerText
                    .toLowerCase()
                    .includes(value)

                    ? ""

                    : "none";

                });

            }
        );

    }
);


</style>




</style>

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

    <button onclick="showSection(`logout`)">
🚪 Logout
</button>
        

</div>

<div class="content">

    <!-- USERS -->

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

<br>        


        <h3>Create User</h3>

        <input
id="firstName"
placeholder="First Name">

<input
id="lastName"
placeholder="Last Name">

<input
id="email"
placeholder="Email Address">

<input
id="newUsername"
placeholder="Username">

<input
id="newPassword"
type="password"
placeholder="Password">



        <select id="newRole">

    <option value="user">
        User
    </option>

    <option value="admin">
        Admin
    </option>

</select>

<select id="groupId">

    <option value="ATL-GRP-ADMIN">
        Administrators
    </option>

    <option value="ATL-GRP-SUPPORT">
        Support Team
    </option>

    <option value="ATL-GRP-HR">
        Human Resources
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

        <button onclick="createUser()">
            Create User
        </button>

      <br>

<input
    type="text"
    id="searchUser"
    placeholder="🔍 Search users...">

<br><br>



        <table>

            <thead>

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

            </thead>

            <tbody id="userTable">

            </tbody>

        </table>

    </div>

    <!-- BRANDING -->

    <div id="branding" class="section">

        <h1>Branding</h1>

        <br>

        <img
            src="logo.png"
            width="220"
            id="logoPreview">

        <br><br>

        <input
            type="file"
            id="logoFile">

        <button onclick="uploadLogo()">
            Upload Logo
        </button>

    </div>

    <!-- SETTINGS -->

    <div id="settings" class="section">

        <h1>Settings</h1>

        <br>

        <label>AI Name</label>

        <br><br>

        <input
            id="aiName"
            type="text">

        <button
            class="saveBtn"
            onclick="saveAIName()">

            Save

        </button>

    </div>

</div>

<script>

function showSection(section){

    document
    .querySelectorAll(".section")
    .forEach(item=>{

        item.classList.remove("active");

    });

    document
    .getElementById(section)
    .classList.add("active");

}

async function loadUsers(){

    const response =
    await fetch("get_users.php");

    const users =
    await response.json();

    const table =
    document.getElementById("userTable");

    table.innerHTML = "";

    users.forEach(user=>{

        table.innerHTML += `

        <tr>

             <td>${user.id}</td>
<td>${user.user_id || ''}</td>
<td>${user.first_name || ''}</td>
<td>${user.last_name || ''}</td>
<td>${user.email || ''}</td>
<td>${user.username}</td>
<td>${user.role}</td>
<td>${user.group_id || ''}</td>
<td>${user.status || 'Active'}</td>
<td>${user.created_at}</td>
<td>${user.last_login || ''}</td>

            <td>

                <button
                    class="action edit"
                    onclick="editUser(
                        ${user.id},
                        '${user.username}',
                        '${user.role}'
                    )">

                    Edit

                </button>

                <button
                    class="action reset"
                    onclick="resetPassword(${user.id})">

                    Reset

                </button>

                <button
                    class="action delete"
                    onclick="deleteUser(${user.id})">

                    Delete

                </button>

            </td>

        </tr>

        `;

    });

}

async function createUser(){

    


    const password =
    document.getElementById(
        "newPassword"
    ).value;

    const role =
    document.getElementById(
        "newRole"
    ).value;

    const response =
    await fetch(
        "create_user.php",
        {
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                username,
                password,
                role
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert("User Created");

        loadUsers();

    }

}

async function editUser(
    id,
    currentUser,
    currentRole
){

    const username =
    prompt(
        "Username",
        currentUser
    );

    if(!username) return;

    const role =
    prompt(
        "Role (admin/user)",
        currentRole

    );

    if(!role) return;

    const response =
    await fetch(
        "update_user.php",
        {
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                id,
                username,
                role
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert("User Updated");

        loadUsers();

    }

}

async function deleteUser(id){

    if(
        !confirm(
            "Delete this user?"
        )
    ){
        return;
    }

    const response =
    await fetch(
        "delete_user.php",
        {
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                id
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        loadUsers();

    }

}

async function resetPassword(id){

    const password =
    prompt(
        "Enter New Password"
    );

    if(!password){
        return;
    }

    const response =
    await fetch(
        "reset_password.php",
        {
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                id,
                password
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert(
            "Password Updated"
        );

    }

}

async function uploadLogo(){

    const file =
    document.getElementById(
        "logoFile"
    ).files[0];

    if(!file){
        return;
    }

    const formData =
    new FormData();

    formData.append(
        "logo",
        file
    );

    const response =
    await fetch(
        "upload_logo.php",
        {
            method:"POST",
            body:formData
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert(
            "Logo Updated"
        );

        location.reload();

    }

}

async function loadSettings(){

    const response =
    await fetch(
        "get_settings.php"
    );

    const settings =
    await response.json();

    document.getElementById(
        "aiName"
    ).value =
    settings.ai_name || "Atlas AI";

}

async function saveAIName(){

    const ai_name =
    document.getElementById(
        "aiName"
    ).value;

    const response =
    await fetch(
        "save_settings.php",
        {
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                ai_name
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert(
            "Settings Saved"
        );

    }

}

loadUsers();
loadSettings();

</script>

</body>
</html>

console.log("dashboard.js loaded");

/* Navigation */

function showSection(section){

    document
    .querySelectorAll(".section")
    .forEach(item=>{
        item.classList.remove("active");
    });

    const page =
    document.getElementById(section);

    if(page){
        page.classList.add("active");
    }

}

/* Users */

async function loadUsers(){

    try{

        const response =
        await fetch("get_users.php");

        const users =
        await response.json();

        const userCount =
        document.getElementById("userCount");

        if(userCount){
            userCount.innerText =
            "Showing " +
            users.length +
            " users";
        }

        const totalUsers =
        document.getElementById("totalUsers");

        if(totalUsers){
            totalUsers.innerText =
            users.length;
        }

        const totalAdmins =
        document.getElementById("totalAdmins");

        if(totalAdmins){
            totalAdmins.innerText =
            users.filter(
                u => u.role === "admin"
            ).length;
        }

        const activeUsers =
        document.getElementById("activeUsers");

        if(activeUsers){
            activeUsers.innerText =
            users.filter(
                u => u.status === "Active"
            ).length;
        }

        const table =
        document.getElementById("userTable");

        if(!table){
            return;
        }

        table.innerHTML = "";

        users.forEach(user=>{

            table.innerHTML += `
            <tr>
                <td>${user.id || ""}</td>
                <td>${user.user_id || ""}</td>
                <td>${user.first_name || ""}</td>
                <td>${user.last_name || ""}</td>
                <td>${user.email || ""}</td>
                <td>${user.username || ""}</td>
                <td>${user.role || ""}</td>
                <td>${user.group_id || ""}</td>
                <td>${user.status || ""}</td>
                <td>${user.created_at || ""}</td>
                <td>${user.last_login || ""}</td>
                
<td>
    <button
        class="action edit"
        onclick="editUser(${user.id})">
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
    catch(error){

        console.error(error);

    }

}

async function createUser(){

    try{

        const response =
        await fetch(
            "create_user.php",
            {
                method:"POST",
                headers:{
                    "Content-Type":"application/json"
                },
                body:JSON.stringify({

                    first_name:
                    document.getElementById("firstName").value,

                    last_name:
                    document.getElementById("lastName").value,

                    email:
                    document.getElementById("email").value,

                    username:
                    document.getElementById("newUsername").value,

                    password:
                    document.getElementById("newPassword").value,

                    role:
                    document.getElementById("newRole").value,

                    group_id:
document.getElementById("department").value


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
    catch(error){

        console.error(error);

        alert("Error creating user");

    }

}

/* Branding */

async function saveAISettings(){

    try{

        const ai_name =
        document.getElementById(
            "brandingAIName"
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
                "AI Settings Saved"
            );

        }

    }
    catch(error){

        console.error(error);

        alert(
            "Failed to save AI Settings"
        );

    }

}

function saveCompanySettings(){

    alert(
        "Company Settings Saved"
    );

}

function saveColours(){

    alert(
        "Colours Saved"
    );

}

function uploadLogo(){

    alert(
        "Logo Upload Feature Coming Soon"
    );

}

/* Settings */

function saveSettings(){

    alert(
        "Settings Saved"
    );

}

function changePassword(){

    alert(
        "Password Changed"
    );

}

function saveEmailSettings(){

    alert(
        "Email Settings Saved"
    );

}

function sendTestEmail(){

    alert(
        "Test Email Sent"
    );

}

function createBackup(){

    alert(
        "Backup Created"
    );

}

function restoreBackup(){

    alert(
        "Restore Started"
    );

}

function viewLogs(){

    alert(
        "View Logs"
    );

}

function exportLogs(){

    alert(
        "Logs Exported"
    );

}

/* Startup */

document.addEventListener(
    "DOMContentLoaded",
    function(){

        console.log("DOM loaded");

        loadUsers();
        loadDepartments();

        const search =
        document.getElementById(
            "searchUser"
        );

        if(search){

            search.addEventListener(
                "keyup",
                function(){

                    const value =
                    this.value
                    .toLowerCase();

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

    }
);





function editUser(id){

    alert(
        "Edit User ID: " + id
    );

}

function resetPassword(id){

    alert(
        "Reset Password for User ID: " + id
    );

}



async function deleteUser(id){

    if(
        !confirm(
            "Delete this user?"
        )
    ){
        return;
    }

    try{

        const response =
        await fetch(
            "delete_user.php",
            {
                method:"POST",
                headers:{
                    "Content-Type":"application/json"
                },
                body:JSON.stringify({
                    id:id
                })
            }
        );

        const result =
        await response.json();

        if(result.success){

            alert(
                "User Deleted"
            );

            loadUsers();

        }else{

            alert(
                result.message
            );

        }

    }
    catch(error){

        console.error(error);

        alert(
            "Delete Failed"
        );

    }

}



async function loadDepartments() {

    const response =
        await fetch("get_departments.php");

    const departments =
        await response.json();

    const dropdown =
        document.getElementById("department");

    if (!dropdown) return;

    dropdown.innerHTML = "";

    departments.forEach(dept => {

        dropdown.innerHTML += `
        <option value="${dept.group_id}">
            ${dept.department_name}
        </option>
        `;

   

    const response =
        await fetch("get_departments.php");

    const departments =
        await response.json();

    console.log(departments);

    const dropdown =
        document.getElementById("department");

    if (!dropdown) {
        alert("Dropdown not found");
        return;
    }

    dropdown.innerHTML = "";

    departments.forEach(dept => {

        dropdown.innerHTML += `
        <option value="${dept.group_id}">
            ${dept.department_name}
        </option>
        `;

    });
}



async function loadDepartments() {

    console.log("Loading departments");

    try {

        const response =
            await fetch("get_departments.php");

        const departments =
            await response.json();

        console.log(departments);

        const dropdown =
            document.getElementById("department");

        if (!dropdown) {
            console.log("Department dropdown not found");
            return;
        }

        dropdown.innerHTML = "";

        departments.forEach(dept => {

            dropdown.innerHTML += `
            <option value="${dept.group_id}">
                ${dept.department_name}
            </option>
            `;

        });

    }
    catch(error) {

        console.error(
            "Department load failed",
            error
        );

    }

}

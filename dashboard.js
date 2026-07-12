console.log("dashboard.js loaded");

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

    try{

        const response =
        await fetch("get_users.php");

        const users =
        await response.json();

document.getElementById(
"userCount"
).innerText =
"Showing " +
users.length +
" users";

        console.log(users);

        document.getElementById(
            "totalUsers"
        ).innerText =
        users.length;

        document.getElementById(
            "totalAdmins"
        ).innerText =
        users.filter(
            u => u.role === "admin"
        ).length;

        document.getElementById(
            "activeUsers"
        ).innerText =
        users.filter(
            u => u.status === "Active"
        ).length;

        const table =
        document.getElementById(
            "userTable"
        );

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
                <td>
${user.role === "admin"
? '<span class="role-admin">👑 Admin</span>'
: 'User'}
</td>
                <td>${user.group_id || ""}</td>
                <td>
<span class="status-active">
${user.status || "Active"}
</span>
</td>
                <td>${user.created_at || ""}</td>
                <td>${user.last_login || ""}</td>

                <td>
                    <button class="action edit">
                        Edit
                    </button>

                    <button class="action reset">
                        Reset
                    </button>

                    <button class="action delete">
                        Delete
                    </button>
                </td>
            </tr>
            `;

        });

    }
    catch(error){

        console.error(error);

        alert(
            "Error loading users. Check console."
        );

    }

}

async function createUser(){

    const first_name =
    document.getElementById(
        "firstName"
    ).value;

    const last_name =
    document.getElementById(
        "lastName"
    ).value;

    const email =
    document.getElementById(
        "email"
    ).value;

    const username =
    document.getElementById(
        "newUsername"
    ).value;

    const password =
    document.getElementById(
        "newPassword"
    ).value;

    const role =
    document.getElementById(
        "newRole"
    ).value;

    const group_id =
    document.getElementById(
        "groupId"
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
                first_name,
                last_name,
                email,
                username,
                password,
                role,
                group_id
            })
        }
    );

    const result =
    await response.json();

    if(result.success){

        alert(
            "User Created"
        );

        loadUsers();

    }

}

document.addEventListener(
    "DOMContentLoaded",
    function(){

        console.log(
            "DOM loaded"
        );

        loadUsers();

        const search =
        document.getElementById(
            "searchUser"
        );

        if(search){

            search.addEventListener(
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

    }
);

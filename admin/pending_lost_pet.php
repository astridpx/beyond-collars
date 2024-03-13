<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f4f4f4;
            float: left;
        }

        .content {
            float: right;
            width: 80%;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .small-photo {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php'); ?>
    </div>
    <div class="content">
        <h1>Pending Lost Pets List</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Owner Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Pet Name</th>
                <th>Pet Type</th>
                <th>Pet Details</th>
                <th>Lost Date</th>
                <th>Valid ID Photo</th>
                <th>Pet Photo</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bcdb";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch specific fields from the database including pet_type
            $sql = "SELECT *  FROM add_pet";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["id"]) . "</td>
                            <td>" . htmlspecialchars($row["owner_name"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>" . htmlspecialchars($row["phone"]) . "</td>
                            <td>" . htmlspecialchars($row["pet_name"]) . "</td>
                            <td>" . htmlspecialchars($row["pet_type"]) . "</td>
                            <td>" . htmlspecialchars($row["pet_details"]) . "</td>
                            <td>" . htmlspecialchars($row["lost_date"]) . "</td>
                            <td><img class='small-photo' src='data:image/jpeg;base64," . base64_encode($row['valid_id_photo']) . "' /></td>
                            <td><img class='small-photo' src='data:image/jpeg;base64," . base64_encode($row['pet_photo']) . "' /></td>
                            <td>" . htmlspecialchars($row["address"]) . "</td>
                            <td><a href='/bc/admin/edit_pet_details.php?id=" . htmlspecialchars($row["id"]) . "'>Post</a>  <a href='/bc/admin/pet_delete.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='12'>Error: " . $conn->error . "</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>
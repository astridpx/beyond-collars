<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px; /* Smaller font size */
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f4f4f4;
            float: left;
        }
        .sidebar * {
            font-size: inherit; /* Set font size to inherit for all elements inside sidebar */
        }
        .container {
            margin-left: 250px; /* Width of sidebar */
            padding: 20px;
            overflow-x: auto; /* Enable horizontal scrolling on small screens */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 8px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include('C:/xampp/htdocs/bc/glbl/admin_sidebar.php');?>
    </div>

    <div class="container">
        <h2>Event List</h2>

        <table>
            <tr>
                <th>Title</th>
                <th>Date and Time</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Actions</th> <!-- New column for buttons -->
            </tr>

            <?php
            // Database connection
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "bcdb";

            // Attempt MySQL server connection
            $conn = new mysqli($host, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("ERROR: Could not connect. " . $conn->connect_error);
            }

            // Fetch data from the database
            $sql = "SELECT id, title, when_datetime, description, picture FROM news_event";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["when_datetime"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "'/></td>";
                    echo "<td>";
                    echo "<a href='edit_event.php?id=" . $row["id"] . "'><button class='btn'>Edit</button></a>";
                    echo "<a href='delete_event.php?id=" . $row["id"] . "'><button class='btn' onclick=\"return confirm('Are you sure you want to delete this event?');\">Delete</button></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No events found.</td></tr>";
            }
            // Close connection
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>

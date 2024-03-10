
<style>
    /* Basic styling */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }
    
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #333;
        color: #fff;
        padding-top: 20px;
    }
    
    .sidebar p {
        padding: 10px 20px;
        margin: 0;
    }
    
    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar a {
        padding: 8px 20px; /* Adjusted padding */
        text-decoration: none;
        display: block;
        color: #fff;
        transition: background-color 0.3s;
        font-size: 20px; /* Adjusted font size */
    }
    
    .sidebar a:hover {
        background-color: #555;
    }
    
    .active {
        background-color: #555;
    }
    
    .submenu {
        display: none;
    }
    
    .submenu a {
        padding-left: 30px;
        display: block;
        color: #ccc;
        font-size: 12px; /* Adjusted font size */
    }
    
    .sidebar .has-submenu.active .submenu {
        display: block;
    }
    
    /* Improved design */
    .sidebar a {
        font-weight: bold;
    }
    
    .sidebar a.logout {
        background-color: #d9534f;
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
    }
    
    .sidebar a.logout:hover {
        background-color: #c9302c;
    }
</style>

<body>

<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<div class="sidebar">
    <a>Welcome, <?php echo $username; ?></a>
    <ul>
    <li class="has-submenu" onclick="toggleSubMenu(event)">
            <a href="/bc/admin/admin_home_page.php">Home</a>
        </li>
        <li class="has-submenu" onclick="toggleSubMenu(event)">
            <a>Events</a>
            <ul class="submenu">
                <li><a href="/bc/admin/admin_event.php">Edit Events</a></li>
                <li><a href="/bc/admin/create_event.php">Add Event</a></li>
            </ul>
        </li>
        <li class="has-submenu" onclick="toggleSubMenu(event)">
            <a>Lost Pets</a>
            <ul class="submenu">
                <li><a href="/bc/admin/pending_lost_pet.php">Pending Lost Pet</a></li>
                <li><a href="/bc/admin/pending_stray_pet.php">Pending Stray Pet</a></li>
                <li><a href="/bc/admin/add_lost_pet.php">Add Lost Pet</a></li>
                <li><a href="/bc/admin/add_stray_pet.php">Add Stray Pet</a></li>
            </ul>
        </li>
        <li class="has-submenu" onclick="toggleSubMenu(event)">
            <a>Found Pets</a>
            <ul class="submenu">
                <li><a href="/bc/admin/admin_found_lost_pet.php">Pending Release Lost Pets</a></li>
                <li><a href="/bc/admin/admin_request_release_stray.php">Pending Release Stray Pets</a></li>
            </ul>
        </li>
        <li class="has-submenu" onclick="toggleSubMenu(event)">
            <a>Service</a>
            <ul class="submenu">
                <li><a href="#">User Suggestions</a></li>
                <li><a href="#">Add Service</a></li>
            </ul>
        </li>
    </ul>
    <a href="logout.php" class="logout">Logout</a>
</div>

<script>
    function toggleSubMenu(event) {
        const menuItem = event.currentTarget;
        menuItem.classList.toggle('active');
    }
</script>

</body>
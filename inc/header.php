<?php
if (isset($_COOKIE['admin'])) {
    $admin = $_COOKIE['admin'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>movie rate</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <header>
        <div class="gifh">
            <img class="iiimg" src="photos/Universal Centennial Logo.gif" alt="" width="1500" height="350">
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="AboutUs.php"> About Us </a></li>
            <li><a href="ContactUs.php"> Contact Us </a></li>
            

            <?php if (isset($admin)) { ?>
            <li class="dropdown">
                <a href="AdminControlPanel.php">Hello admin</a>
                <ul>
                    <li><a href="AddMovie.php">Add new movie</a></li>
                    <li><a href="EditMovie.php">Edit movie info</a></li>
                    <li><a href="DeleteMovie.php">Delete movie</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <?php } else { ?>
                    <li><a href="login.php">login</a></li>
                <?php } ?>
            </li>

        </ul>

    </nav>
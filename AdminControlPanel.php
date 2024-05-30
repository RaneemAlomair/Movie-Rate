<?php require_once("inc/header.php"); ?>
<?php
if (!isset($_COOKIE['admin'])) {
	exit(header('Location:login.php'));
}
?>

<div class="content admin-page">

    <h1><em>please choose the type of administration</em></h1>

    <table cellpadding="50">
        <tr>
            <td>
                <a href="DeleteMovie.php">
                    <img src="photos/delete.png" width="250" height="250" alt="Click here to delete a movie">
                </a>
            </td>
            <td>
                <a href="EditMovie.php">
                    <img src="photos/edit.png" width="250" height="250" alt="Click here to update movie info">
                </a>
            </td>
            <td>
                <a href="AddMovie.php">
                    <img src="photos/add.png" width="250" height="250" alt="Click here to add new movie">
                </a>
            </td>
        </tr>
    </table>

</div>

<?php require_once("inc/footer.php"); ?>
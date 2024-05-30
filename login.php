<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>

<?php
define ("FIVE_DAYS", 60 * 60 * 24 * 5);


if (isset($_COOKIE['admin'])) {
    exit(header('Location:AdminControlPanel.php'));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  $result = login($username, $password);

  if ($result) {
	setCookie('admin', 'admin', time() + FIVE_DAYS);
    exit(header('Location:AdminControlPanel.php'));
  }
}

?>

<div class="content login">

    <form method="post" action="#">
        <div>
            <br>
            <span style="position: relative; left: 43%;">
                <img class="imglogin" src="photos/loginn.jpg" height="180" width="190" alt=" Log in photo "></span>
            <br>

            <p class="im" style="text-align: center; color:whitesmoke">
                User Name: <br>
                <input name="username" type="text" placeholder="User Name" required />
            </p>

            <p class="im" style="text-align: center; color: whitesmoke">
                Password: <br>
                <input name="password" type="text" placeholder="Password" required />
            </p>

            <br>
            <div style="position: relative; left: 47%; color: #000;">
                <input class="button" type="submit" value="Log in">
            </div>

        </div>

        <?php if ($error_msg) { ?>
        <div class="error-msg"><?= $error_msg ?></div>
        <?php } ?>

    </form>
</div>

<?php require_once("inc/footer.php"); ?>
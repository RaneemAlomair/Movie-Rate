<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>
<?php
if (!isset($_COOKIE['admin'])) {
	exit(header('Location:login.php'));
}

$movie_id = false;

if (isset($_POST['movie_id'])) {
	$movie_id = $_POST['movie_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $movie_id) {  	
	$result = deleteMovie($movie_id);

  if ($result) {
    $success_msg = "Movie has been deleted successfully.";
  }
}

$movies = getAllMovies();

?>

<div class="content admin-page">

   
    <p class="hed1"> Delete Movie </p>

    <div class="bor" style="padding: 5px 50px;">
        <form method="post" action="DeleteMovie.php" >
            <p class="im">
                Select Movie to delete: <br>
                <select name="movie_id" required>
                    <?php foreach ($movies as $key => $movie2) { ?>
                    <option value="<?php echo $movie2['id']; ?>"
                        <?php if ($movie2['id'] == $movie_id) echo 'selected' ?>>
                        <?php echo $movie2['name']; ?></option>
                    <?php } ?>
                </select>
            </p>

            <input class="button" type="submit" value="submit"> <input class="button" type="reset" value="clear">
        </form>

        <?php if ($success_msg) { ?>
        <div class="success-msg"><?= $success_msg ?></div>
        <?php } else if ($error_msg) { ?>
        <div class="error-msg"><?= $error_msg ?></div>
        <?php } ?>

        
    </div>

</div>

<?php require_once("inc/footer.php"); ?>
<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>
<?php
if (!isset($_COOKIE['admin'])) {
	exit(header('Location:login.php'));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = isset($_POST['name']) ? $_POST['name'] : '';
	$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';	
	$release_year = isset($_POST['release_year']) ? $_POST['release_year'] : '';
  $description = isset($_POST['description']) ? $_POST['description'] : '';
  $movie_poster = '';

  if (isset($_FILES['movie_poster']) && is_uploaded_file($_FILES["movie_poster"]["tmp_name"])) {
    $movie_poster = addslashes(file_get_contents($_FILES["movie_poster"]["tmp_name"]));
  }
  	
	$result = addMovie($name, $category_id, $release_year, $description, $movie_poster);

  if ($result) {
    $success_msg = "Movie has been added successfully.";
  }
}
?>

<div class="content admin-page">

    <p class="hed1"> Add new Movie </p>

    <div class="bor">

        <form method="post" action="#" enctype="multipart/form-data">

            <p class="im">
                Movie Name: <br>
                <input name="name" type="text" style="width: 200px;" placeholder="Movie Name" required/>
            </p>

            <p class="im">
                Movie Category: <br>
                <select name="category_id" style="width: 200px;" placeholder="Movie Category" required>
                    <option selected value="[Select Movie Category]">Select Movie Category</option>
                    <option value="1">Action</option>
                    <option value="2">Adventure</option>
                    <option value="3">Comedy</option>
                    <option value="4">Drama</option>
                </select>
            </p>

            <p class="im">
                Release year: <br>
                <input name="release_year" type="number" style="width: 100px;" placeholder="Release year" value=""
                    min="1900" max="2024" required />
            </p>

            <p class="im">
                Desciption: <br>
                <textarea name="description" style="width: 100%" cols="60" rows="4" placeholder="Desciption"></textarea>
            </p>

            <p class="im">
                Poster: <br>
                <input name="movie_poster" type="file" required />
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
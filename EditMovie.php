<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>
<?php
if (!isset($_COOKIE['admin'])) {
	exit(header('Location:login.php'));
}

$movie_id = false;

if (isset($_GET['id'])) {
	$movie_id = $_GET['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $movie_id) {
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';	
  $release_year = isset($_POST['release_year']) ? $_POST['release_year'] : '';
  $description = isset($_POST['description']) ? $_POST['description'] : '';
  $movie_poster = '';

  if (isset($_FILES['movie_poster']) && is_uploaded_file($_FILES["movie_poster"]["tmp_name"])) {
    $movie_poster = addslashes(file_get_contents($_FILES["movie_poster"]["tmp_name"]));
  }
  	
  $result = editMovie($movie_id, $name, $category_id, $release_year, $description, $movie_poster);

  if ($result) {
    $success_msg = "Movie has been edited successfully.";
  }
}

if ($movie_id) {
  $movie = getMovieInfo($movie_id);
}

$movies = getAllMovies();

?>

<div class="content admin-page">

   
    <p class="hed1"> Update Movie </p>

    <div class="bor" style="padding: 5px 50px;">
        <form>
            <p class="im">
                Select Movie to edit: <br>
                <select name="movie_id" onchange="location.href='EditMovie.php?id='+this.value" style="width: 100%;">
                    <?php foreach ($movies as $key => $movie2) { ?>
                    <option value="<?php echo $movie2['id']; ?>"
                        <?php if ($movie2['id'] == $movie_id) echo 'selected' ?>>
                        <?php echo $movie2['name']; ?></option>
                    <?php } ?>
                </select>
            </p>
        </form>
    </div>

    <?php if (isset($movie)) { ?>

    <div class="bor">
        <form method="post" action="EditMovie.php?id=<?= $movie['id'] ?>" enctype="multipart/form-data">

            <p class="im">
                Movie Name: <br>
                <input name="name" type="text" style="width: 200px;" placeholder="Movie Name" value="<?= $movie['name'] ?>" required />
            </p>

            <p class="im">
                Movie Category: <br>
                <select name="category_id" style="width: 200px;" placeholder="Movie Category" required>
                    <option selected value="[Select Movie Category]">Select Movie Category</option>
                    <option value="1" <?php echo ($movie['category_id'] == '1') ? 'selected' : ''; ?>>Action</option>
                    <option value="2" <?php echo ($movie['category_id'] == '2') ? 'selected' : ''; ?>>Adventure</option>
                    <option value="3" <?php echo ($movie['category_id'] == '3') ? 'selected' : ''; ?>>Comedy</option>
                    <option value="4" <?php echo ($movie['category_id'] == '4') ? 'selected' : ''; ?>>Drama</option>
                </select>
            </p>

            <p class="im">
                Release year: <br>
                <input name="release_year" type="number" style="width: 100px;" placeholder="Release year" value="<?= $movie['release_year'] ?>"
                    min="1900" max="2024" required />
            </p>

            <p class="im">
                Desciption: <br>
                <textarea name="description" style="width: 100%" cols="60" rows="4" placeholder="Desciption"><?= $movie['description'] ?></textarea>
            </p>

            <p class="im">
                Poster: <br>
                <input name="movie_poster" type="file" />
            </p>

            <input class="button" type="submit" value="submit"> <input class="button" type="reset" value="clear">

        </form>

        <?php if ($success_msg) { ?>
        <div class="success-msg"><?= $success_msg ?></div>
        <?php } else if ($error_msg) { ?>
        <div class="error-msg"><?= $error_msg ?></div>
        <?php } ?>

    </div>

    <?php } ?>

</div>

<?php require_once("inc/footer.php"); ?>
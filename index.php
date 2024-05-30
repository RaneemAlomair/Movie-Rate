<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>

<?php
  $movies = getNewMovies(8);
  $img_alt = "Click me to i can move you to the movies page";
?>

<div class="content">

    <h1> Welcome to Movie Rate</h1>

    <h1 class="hed1">Our Movies</h1>

    <div class="movie-list">
        <?php foreach ($movies as $key => $movie) { ?>
            <a href="movie-info.php?id=<?= $movie['id'] ?>"> <img src="<?= $movie['movie_poster'] ?>" alt="<?= $img_alt ?>"></a>
        <?php } ?>
    </div>

</div>

<?php require_once("inc/footer.php"); ?>
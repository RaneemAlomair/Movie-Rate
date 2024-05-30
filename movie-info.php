<?php require_once("inc/header.php"); ?>
<?php require_once("inc/db_functions.php"); ?>

<?php

if (!isset($_GET['id'])) {
	exit(header('Location:index.php'));
}

$movie_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$rating = isset($_POST['rating']) ? $_POST['rating'] : '';
  	$body = isset($_POST['body']) ? $_POST['body'] : ''; echo $movie_id;
  	
	$movie_review = addMovieReview($movie_id, $name, $rating, $body);

	if ($movie_review) {
		exit(header('Location:movie-info.php?id=' . $movie_id));
	  }
}

$movie = getMovieInfo($movie_id);

if ($movie_id) {
    $movie_avg_rate = getMovieAvgRate($movie_id);
	$reviews = getMovieReviews($movie_id);

    if (!$movie_avg_rate)
        $movie_avg_rate = 0;
}
$img_alt = "Click me to i can move you to the movies page";
?>

<div class="content movie-info">

    <p class="hedd"> <?= $movie['name'] ?> </p>

    <div class="movie-poster">
        <a href="index.php"> <img src="<?= $movie['movie_poster'] ?>" alt="<?= $img_alt ?>"></a>
    </div>

    <div class="borderr movie-details">
        <p> 
            <strong>Movie name :</strong> <?= $movie['name'] ?> <br> 
            <strong>Year :</strong> <?= $movie['release_year'] ?> <br>
            <strong>Rate :</strong> [<?= $movie_avg_rate ?> / 5.0]
        </p>
        <p> <strong>Description: </strong> <br> <?= $movie['description'] ?></p>
    </div>

    <div class="formbox">
        <form action="movie-info.php?id=<?= $movie_id ?>" method="POST">
            <h1
                style="text-align: center ; color:whitesmoke; font-family: monospace; font-size: 30px; text-shadow: -1px 1px 3px rgb(193, 193, 193)">
                Add Your Review </h1>
            <p
                style=" position: center; color: whitesmoke; font-family: monospace; font-size: 20px; text-shadow: -1px 1px 3px rgb(193, 193, 193)">
                <label> your Name: <br>
                    <input type="text" name="name" placeholder="" required>
                </label>
            </p>
            <p
                style=" position: center; color: whitesmoke; font-family: monospace; font-size: 20px; text-shadow: -1px 1px 3px rgb(193, 193, 193)">
                <label> Rating: <br>
                    <select name="rating" style="width: 200px;" placeholder="Movie Rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </label>
            </p>
            <p
                style=" position: center; text-align: center; color: whitesmoke; font-family: monospace; font-size: 20px; text-shadow: -1px 1px 3px rgb(193, 193, 193)">
                <label> Your Review: <br><textarea rows="10" col="700" name="body"
                        placeholder="Share Your review" required></textarea><br>
                    <hr>
                </label>
            </p>

            <input class="button" type="submit" id="addReview" value="Send" />

        </form>
    </div>

    <div class="formbox">
        <h1
            style="text-align: left ; color: whitesmoke; font-family: monospace ; font-size: 30px; text-shadow: -1px 1px 3px rgb(193, 193, 193)">
            Reviews </h1>

        <?php foreach ($reviews as $key => $review) { ?>
        <p style="border: solid 1px ; border-radius: 10px; padding: 10px; width: 40%  ; text-align: left; color:whitesmoke">
            <strong> <?= $review['name'] ?> </strong> <br>
            <strong> [<?= $review['rating'] ?> / 5] </strong> <br>
            <?= $review['body'] ?>
        </p>
        <?php } ?>
    </div>

</div>

<?php require_once("inc/footer.php"); ?>
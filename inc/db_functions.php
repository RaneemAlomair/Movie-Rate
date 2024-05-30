<?php
require_once("inc/db_conn.php");

function login($username, $password) {
    global $conn;
    global $error_msg;

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $password = md5($password);
    $query = "SELECT * from `admin` WHERE username = '$username' AND password = '$password'; ";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        $error_msg = "Username or password not matched.";
        return false;
    }

    $error_msg = "Error, Can not login.";
    return false;
}

function getMovieInfo($id) {
    global $conn;
    global $error_msg;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "SELECT * FROM `movie` WHERE id = '$id';";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
        $movie['movie_poster'] = getMoviePoster($movie);
        return $movie;
    }

    return false;
}

function getAllMovies() {
    global $conn;
    global $error_msg;

    $query = "SELECT * FROM `movie` ORDER BY name ASC;";
    $result = mysqli_query($conn, $query);

    $movies = array();

    if ($result && mysqli_num_rows($result) > 0) {
        $movies = $result->fetch_all(MYSQLI_ASSOC);       
        foreach ($movies as $key => &$movie) {
            $movie['movie_poster'] = getMoviePoster($movie);
        }
    }

    return $movies;
}

function getNewMovies($limit) {
    global $conn;
    global $error_msg;

    $query = "SELECT * FROM `movie` ORDER BY id DESC LIMIT $limit;";
    $result = mysqli_query($conn, $query);

    $movies = array();

    if ($result && mysqli_num_rows($result) > 0) {
        $movies = $result->fetch_all(MYSQLI_ASSOC);       
        foreach ($movies as $key => &$movie) {
            $movie['movie_poster'] = getMoviePoster($movie);
        }
    }

    return $movies;
}

function getMoviePoster($movie) {
    if (empty(trim($movie['movie_poster']))) {
        return "photos/empty_img.jpg";
    } else {
        return "data:image/jpeg;base64," . base64_encode($movie['movie_poster']);
    }
}

function addMovie($name, $category_id, $release_year, $description, $movie_poster) {
    global $conn;
    global $error_msg;
    
    $name = mysqli_real_escape_string($conn, $name);
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $release_year = mysqli_real_escape_string($conn, $release_year);
    $description = mysqli_real_escape_string($conn, $description);

    if (empty(trim($name)) || empty(trim($category_id)) || empty(trim($release_year))) {
        $error_msg = "Please, Provide all required movie data.";
        return false;
    }

    $sql = "INSERT INTO `movie` (name, category_id, release_year, description, movie_poster) values ('$name', '$category_id', '$release_year', '$description', '$movie_poster');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    }

    $error_msg = "Error, Can not add Movie.";
    return false;
}

function editMovie($movie_id, $name, $category_id, $release_year, $description, $movie_poster) {
    global $conn;
    global $error_msg;

    $id = mysqli_real_escape_string($conn, $movie_id);
    $name = mysqli_real_escape_string($conn, $name);
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $release_year = mysqli_real_escape_string($conn, $release_year);
    $description = mysqli_real_escape_string($conn, $description);

    if (empty(trim($name)) || empty(trim($category_id)) || empty(trim($release_year))) {
        $error_msg = "Please, Provide all required movie data.";
        return false;
    }

    if (empty(trim($movie_poster))) {
        $sql = "UPDATE `movie` SET name = '$name', category_id = '$category_id', release_year = '$release_year', description = '$description' WHERE id = '$id';";
    } else {
        $sql = "UPDATE `movie` SET name = '$name', category_id = '$category_id', release_year = '$release_year', description = '$description', movie_poster = '$movie_poster' WHERE id = '$id';";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    }

    $error_msg = "Error, Can not edit movie." . $conn->error;
    return false;
}

function deleteMovie($movie_id) {
    global $conn;
    global $error_msg;

    $id = mysqli_real_escape_string($conn, $movie_id);

    $sql = "DELETE FROM `movie` WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    }

    $error_msg = "Error, Can not delete movie." . $sql;
    return false;
}


function getMovieAvgRate($id) {
    global $conn;
    global $error_msg;

    $id = mysqli_real_escape_string($conn, $id);

    $query = "SELECT ROUND(AVG(rating), 1) As rating FROM `review` WHERE movie_id = '$id';";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $movie_rate = mysqli_fetch_assoc($result);
        return $movie_rate['rating'];
    }

    return false;
}


function getMovieReviews($movie_id) {
    global $conn;
    global $error_msg;

    $movie_id = mysqli_real_escape_string($conn, $movie_id);

    $sql = "SELECT * FROM `review` WHERE movie_id = '$movie_id';";
    $result = mysqli_query($conn, $sql);
    
    $reviews = array();

    if ($result && mysqli_num_rows($result) > 0) {     
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
    } 

    return $reviews;
}


function addMovieReview($movie_id, $name, $rating, $body) {
    global $conn;
    global $error_msg;

    $movie_id = mysqli_real_escape_string($conn, $movie_id);
    $name = mysqli_real_escape_string($conn, $name);
    $rating = mysqli_real_escape_string($conn, $rating);
    $body = mysqli_real_escape_string($conn, $body);

    if (empty(trim($movie_id)) || empty(trim($name)) || empty(trim($rating)) || empty(trim($body))) {
        $error_msg = "Please, Provide all required review data.";
        return false;
    }

    $sql = "INSERT INTO `review` (movie_id, name, rating, body) values ('$movie_id', '$name', '$rating', '$body');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return mysqli_insert_id($conn);
    }

    $error_msg = "Error, Can not add review." . $conn->error;
    return false;
}
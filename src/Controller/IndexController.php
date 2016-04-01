<?php
namespace Controller;

use Doctrine\DBAL\Query\QueryBuilder;

class IndexController
{
    public function indexAction()
    {
        include("search.php");
    }

    public function searchAction()
    {

        header('Content-Type: application/json');

        $conn = \MovieSearch\Connexion::getInstance();

        $title = $_GET['title'];
        $time = $_GET['duration'];
        $startYear = $_GET['year_start'];
        $endYear = $_GET['year_end'];
        if (isset($title)) {
            $titleFilm = " SELECT * FROM film_director INNER JOIN artist ON artist_id = artist.id INNER JOIN film ON film_director.film_id = film.id WHERE film.title LIKE '$title%' ";
        }
        if (isset($time)) {
            if ($time == "Tous") {
                $timeFilm = "";
            } else if ($time == "Moins d'une heure") {
                $timeFilm = " AND duration < 3600 ";
            } else if ($time == "Entre 1h et 1h30") {
                $timeFilm = " AND duration BETWEEN 3600 AND 5400 ";
            } else if ($time == "Entre 1h30 et 2h30") {
                $timeFilm = " AND duration BETWEEN 5400 AND 9000 ";
            } else if ($time == "Plus de 2h30") {
                $timeFilm = " AND duration > 9000 ";
            }
        }
        if (isset($startYear)) {
            $startYearFilm = " AND year >= '$startYear' ";
        }
        if (empty($startYear)) {
            $startYearFilm = "";
        }
        if (isset($endYear)) {
            $endYearFilm = " AND year <= '$endYear' ";
        }
        if (empty($endYear)) {
            $endYearFilm = "";
        }

        $stmt = $conn->prepare($titleFilm . $timeFilm . $startYearFilm . $endYearFilm . 'GROUP BY title');
        $stmt->execute();
        $films = $stmt->fetchAll();
        return json_encode(["films" => $films]);
    }
}
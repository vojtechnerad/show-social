<?php
require_once '../includes/dbconn.inc.php';
require_once '../classes/TvShow.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
session_start();

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($requestMethod === 'POST') {
    try {
// Kontrola všech potřebných údajů
        if ($data->showId AND $data->seasonNumber AND $data->episodeNumber) {
            // Získání dat o epizodě z TMDB API
            $selectedTvShow = new TvShow($data->showId);
            $tvShowData = $selectedTvShow->getDataFromTmdb();
            $tvShowEpisodeData = $selectedTvShow->getEpisodeData($data->seasonNumber, $data->episodeNumber);

            // Zadání seriálu do proxy tabulky
            $insStmntShowData = $db->prepare('
            REPLACE INTO tv_shows (id, name, original_name, poster_path)
            VALUES (:id, :name, :original_name, :poster_path);
        ');
            $insStmntShowData->bindParam(':id', $tvShowData['id']);
            $insStmntShowData->bindParam(':name', $tvShowData['name']);
            $insStmntShowData->bindParam(':original_name', $tvShowData['original_name']);
            $insStmntShowData->bindParam(':poster_path', $tvShowData['poster_path']);
            $insStmntShowData->execute();

            // Zadání (Replace) epizody do proxy tabulky epizod
            $insStmntEpData = $db->prepare('
                REPLACE INTO tv_show_episodes (id, show_id, season_number, episode_number, air_date, runtime, name)
                VALUES (:id, :show_id, :season_number, :episode_number, :air_date, :runtime, :name);
            ');
            $insStmntEpData->bindParam(':id', $tvShowEpisodeData['id']);
            $insStmntEpData->bindParam(':show_id', $data->showId);
            $insStmntEpData->bindParam(':season_number', $tvShowEpisodeData['season_number']);
            $insStmntEpData->bindParam(':episode_number', $tvShowEpisodeData['episode_number']);
            $insStmntEpData->bindParam(':air_date', $tvShowEpisodeData['air_date']);
            $insStmntEpData->bindParam(':runtime', $tvShowEpisodeData['runtime']);
            $insStmntEpData->bindParam(':name', $tvShowEpisodeData['name']);
            $insStmntEpData->execute();

            // Kontrola jestli byla epizoda viděna uživatelem
            $seenStmnt = $db->prepare('
                SELECT id, user_id
                FROM seen_episodes
                WHERE id = (:id) AND user_id = (:user_id);
            ');
            $seenStmnt->bindParam(':id', $tvShowEpisodeData['id']);
            $seenStmnt->bindParam(':user_id',$_SESSION['user_id']);
            $seenStmnt->execute();
            $result = $seenStmnt->fetchAll(); // Data pokud viděl, false pokud neviděl

            $response = new stdClass();
            if ($result) {
                //TODO pokud je tak smazat
                $delStmntSeenStatus = $db->prepare('
                DELETE FROM seen_episodes
                WHERE id = (:id) AND user_id = (:user_id);
            ');
                $delStmntSeenStatus->bindParam(':id', $tvShowEpisodeData['id']);
                $delStmntSeenStatus->bindParam(':user_id',$_SESSION['user_id']);
                $delStmntSeenStatus->execute();

                $response->successfulChange = true;
                $response->newSeenStatus = false;
            } else {
                $insStmntSeenStatus = $db->prepare('
                INSERT INTO seen_episodes (id, user_id)
                VALUES (:id, :user_id);
            ');
                $insStmntSeenStatus->bindParam(':id', $tvShowEpisodeData['id']);
                $insStmntSeenStatus->bindParam(':user_id', $_SESSION['user_id']);
                $insStmntSeenStatus->execute();

                $response->successfulChange = true;
                $response->newSeenStatus = true;
            }
            $user = new User($_SESSION['user_id']);
            $watchtimeObject = $user->getWatchtimePerLastDay();
            $response->newWatchtimePercentage = $watchtimeObject->watchtimePercentage;
            header("Content-Type: application/json");
            echo json_encode($response);
        }
    }
    catch (PDOException $PDOException) {
        $response = new stdClass();
        $response->successfulChange = false;
        header("Content-Type: application/json");
        echo json_encode($response);
    }

}
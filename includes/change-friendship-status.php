<?php
require_once 'dbconn.inc.php';
@session_start();
// todo nelogovaný user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetUser = $_POST['target-user'];
    $requesterUser = $_SESSION['user_id'];
    $friendlistStatement = $db->prepare('
        SELECT requesterId, adresseeId, isConfirmed
        FROM friendslist
        WHERE (requesterId = (:requesterUser) AND adresseeId = (:targetUser))
        OR (requesterId = (:targetUser) AND adresseeId = (:requesterUser))
        LIMIT 1;
    ');
    $friendlistStatement->execute(
        array(
            ':requesterUser' => $requesterUser,
            ':targetUser' => $targetUser
        )
    );
    $friendlistData = $friendlistStatement->fetch();
    //var_dump($friendlistData);

    // Pokud není záznam -> zapsat jako non confirmed friendsrequest
    if (!$friendlistData) {
        $insertFriendRequestStatement = $db->prepare('
            INSERT INTO friendslist (requesterId, adresseeId, isConfirmed)
            VALUES (:requesterId, :adresseeId, :isConfirmed);
        ');
        $insertFriendRequestStatement->execute(
            array(
                ':requesterId' => $requesterUser,
                ':adresseeId' => $targetUser,
                ':isConfirmed' => false
            )
        );
    }

    // Pokud je uživatel requester a není potvrzeno = smazat záznam/stáhnout request
    if ($friendlistData['requesterId'] == $requesterUser and $friendlistData['isConfirmed'] == false) {
        $deleteFriendRequestStatement = $db->prepare('
            DELETE FROM friendslist
            WHERE requesterId = (:requesterId) AND adresseeId = (:adresseeId);
        ');
        $deleteFriendRequestStatement->execute(
            array(
                ':requesterId' => $requesterUser,
                ':adresseeId' => $targetUser
            )
        );
    }

    // Pokud je uživatel adresát requestu a není confirmed, tak potvrdit/přijmout
    if ($friendlistData['adresseeId'] == $requesterUser and $friendlistData['isConfirmed'] == false) {
        $confirmFriendRequestStatement = $db->prepare('
                UPDATE friendslist
                SET isConfirmed = true, timestamp = (:currentTime)
                WHERE adresseeId = (:requesterId) AND requesterId = (:adresseeId);
            ');
        $confirmFriendRequestStatement->execute(
            array(
                ':currentTime' => date('Y-m-d H:i:s', time()),
                ':requesterId' => $requesterUser,
                ':adresseeId' => $targetUser
            )
        );
    }

    // Pokud je uživatel requester nebo adresee, a friendrequest je potvrzený => smazat záznam/odevbrat z přátel
    if (($friendlistData['requesterId'] == $requesterUser OR $friendlistData['adresseeId'] == $requesterUser) AND $friendlistData['isConfirmed'] == true) {
        $unfriendUserStatement = $db->prepare('
            DELETE FROM friendslist
            WHERE (requesterId = (:requesterId) AND adresseeId = (:adresseeId))
            OR (requesterId = (:adresseeId) AND adresseeId = (:requesterId));
        ');
        $unfriendUserStatement->execute(
            array(
                ':requesterId' => $requesterUser,
                ':adresseeId' => $targetUser
            )
        );
    }

}
header('Location: ../user.php?id=' . $targetUser);
exit();
?>


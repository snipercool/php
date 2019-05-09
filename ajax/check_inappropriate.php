<?php
    require_once '../bootstrap.php';

    if (!empty($_POST)) {
        $postId = $_POST['postId'];
        $userId = $_SESSION['user'][0];

        $i = new Inappropriate();
        $i->setPostId($postId);
        $i->setUserId($userId);
        $flag = $i->checkInappropriate();
        $i->checkInappropriatePost();

        if ($flag == 'flagged') {
            $result = [
                'status' => 'flagged',
                'message' => 'report was saved',
            ];
        } elseif ($flag == 'unflagged') {
            $result = [
                'status' => 'unflagged',
                'message' => 'report was deleted',
            ];
        }

        echo json_encode($result);
    }

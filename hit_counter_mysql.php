<?php
    $user = "david";
    $password = "123@David";
    $database = "bbdd01";

    try {

        $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

        $siteVisitsMap  = 'siteStats';
        $visitorHashKey = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

           $visitorHashKey = $_SERVER['HTTP_CLIENT_IP'];

        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

           $visitorHashKey = $_SERVER['HTTP_X_FORWARDED_FOR'];

        } else {

           $visitorHashKey = $_SERVER['REMOTE_ADDR'];
        }

        $totalVisits = 0;

        $sql="SELECT dir_ip, visits FROM visits_david WHERE dir_ip=:dir_ip";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':dir_ip', $visitorHashKey);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->execute();
        
        if ($result) {

            $row = $stmt->fetch();
            $totalVisits = $row['visits'] + 1;

        } else {

            $totalVisits = 1;

        }

        $sql = "INSERT INTO visits_david (dir_ip, visits) VALUES (:dir_ip, :visits) ON DUPLICATE KEY UPDATE visits=:visits";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':dir_ip', $visitorHashKey);
        $stmt->bindParam(':visits', $totalVisits);

        $stmt->execute();
        

        echo "Welcome, you've visited this page " .  $totalVisits . " times\n";

    } catch (Exception $e) {
        echo $e->getMessage();
    }
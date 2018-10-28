<?php

    $type = $_GET['type'];

    include 'connection.php';

    if($type == 'like'){

        $query = $_GET['q'];
        
        $sql = "SELECT * FROM marvelcharacters WHERE Name Like '%$query%'";
        $result = mysqli_query($con, $sql);
        
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        print json_encode($rows, JSON_UNESCAPED_SLASHES);
        
        exit(0);

    }else if($type == 'random'){

        $quantity = $_GET['q'];

        $sql = "SELECT * FROM marvelcharacters";
        $result = mysqli_query($con, $sql);

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $rows2 = array();
        for($i=0; $i<$quantity; $i++){
            $rows2[] = $rows[mt_rand(0,mysqli_num_rows($result))-1];
        }
        print json_encode($rows2, JSON_UNESCAPED_SLASHES);

        exit(0);

    }

?>
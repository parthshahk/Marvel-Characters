<?php

    $type = $_GET['type'];

    include 'connection.php';

    if($type == 'like'){

        $query = $_GET['q'];
        $rows = array();

        if($query == ''){
            print json_encode($rows, JSON_UNESCAPED_SLASHES);
            exit(0);
        }
        
        $sql = "SELECT * FROM marvelcharacters WHERE Name Like '%$query%'";
        $result = mysqli_query($con, $sql);
        
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
        $targetQuant=0;
        $randomNumbers = array();
        while($targetQuant < $quantity){

            $rand = mt_rand(0,mysqli_num_rows($result))-1;

            if(array_search($rand, $randomNumbers) !== false){
                continue;
            }
            
            if( (strpos($rows[$rand]['Thumb'], 'not_available') === false) && (strpos($rows[$rand]['Thumb'], '4c002e0305708.gif') === false) ){

                $rows2[] = $rows[$rand];
                $targetQuant++;
                $randomNumbers[] = $rand;

            }
        }

        print json_encode($rows2, JSON_UNESCAPED_SLASHES);
        exit(0);

    }else if($type == 'alphabet'){

        $alphabet = $_GET['q'];

        $sql = "SELECT * FROM marvelcharacters WHERE Name Like '$alphabet%'";
        $result = mysqli_query($con, $sql);
        
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        print json_encode($rows, JSON_UNESCAPED_SLASHES);

        exit(0);

    }

?>
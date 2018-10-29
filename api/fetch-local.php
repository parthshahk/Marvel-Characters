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


        $i=0;
        $randomNumbers = array();
        while($i < $quantity+60){

            $rand = mt_rand(0,mysqli_num_rows($result))-1;

            if(array_search($rand, $randomNumbers) === false){
                $randomNumbers[] = $rand;
                $i++;
            }
        }
    
        $rows2 = array();
        $j=0;
        $i=0;
        while($j < $quantity){
            
            if(strpos($rows[$randomNumbers[$i]]['Thumb'], 'not_available') === false ){
                $rows2[] = $rows[$randomNumbers[$i]];
                $j++;
            }
            $i++;
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
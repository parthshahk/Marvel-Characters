<?php
    function callAPI($method, $url, $data){
        $curl = curl_init();

        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    $apiKey = "8e0822c2d39ec7912fd3db11f96ca6d0";
    $privateKey = "8bcb11577be9096a443a9ce957693003ee36158b";
    $ts = time();
    $string = $ts.$privateKey.$apiKey;
    $hash = md5($string);

    
    
    $get_data = callAPI('GET', 'https://gateway.marvel.com:443/v1/public/characters?orderBy=name&limit=100&offset=0&ts='.$ts.'&apikey='.$apiKey.'&hash='.$hash.'', false);
    $response = json_decode($get_data, true);
    
    $total = $response['data']['count'];
    
    $con=mysqli_connect("localhost","parth","parth","marvel");

    for($i=0; $i<$total; $i++){

        $id = $response['data']['results'][$i]['id'];
        $name = $response['data']['results'][$i]['name'];
        $thumbnail = $response['data']['results'][$i]['thumbnail']['path'].'.'.$response['data']['results'][$i]['thumbnail']['extension'];

        mysqli_query($con,"INSERT INTO characters VALUES($id, '$name', '$thumbnail')");
    }

    echo "done";

?>
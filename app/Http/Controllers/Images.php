<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Http;


class Images extends Controller
{

    public function imageData(){
        


        $imageUrl=$_POST['imageUrl'];
        $recipeId=$_POST['recipeId'];

        $imageName=$recipeId.'.jpg';
        
        // $imageUrl='https://domes-web.net/images/header/logo1.png';
                
        //open connection
        $ch = curl_init();

        //option to send request to url
        curl_setopt($ch,CURLOPT_URL,$imageUrl);

        //option to receive response from url
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);


        //execute
        $data=curl_exec($ch);

        //close connection
        curl_close($ch);

        file_put_contents('img/recipes/'.$imageName, $data);
        
        $response=['image'=>$imageName];
        
        echo json_encode($response);
    }
}

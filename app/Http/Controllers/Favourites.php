<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Favourites extends Controller
{
    //gets records from users_favourites table
    public function getUserFavourites(){
        
        //retrieve user_id from $_SESSION
        $user_id=$_SESSION['user_id'];

        //query the users_favourites table in the database
        $favourites = DB::table('users_favourites')->where('user_fk', $user_id)->get();

        $response=['favourites'=>$favourites];
        echo json_encode($response);
    }

    //adds a record to users_favourites table
    public function addUserFavourite(){
        $user_id=$_SESSION['user_id'];
        $recipe_id=$_POST['recipe_id'];
        $image_url=$_POST['image_url'];
        $ingredients=$_POST['ingredients'];
        $label=$_POST['label'];
        $source=$_POST['source'];
        $totalTime=$_POST['totalTime'];
        $uri=$_POST['uri'];
        $url=$_POST['url'];
        $totalIngredients=$_POST['totalIngredients'];

        

        try {

            //get image data

            //open connection
            $ch = curl_init();

            //option to send request to url
            curl_setopt($ch,CURLOPT_URL,$image_url);

            //option to receive response from url
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);


            //execute
            $data=curl_exec($ch);

            //close connection
            curl_close($ch);

            

            // save recipe to users_favourites table
            DB::table('users_favourites')->insert([
                'user_fk'=>$user_id,
                'recipe_fk'=>$recipe_id
            ]);

            // add recipe to recipes table
            // check if recipe is already saved
            $recipe = DB::table('recipes')->where('recipe_id', $recipe_id)->get();

            if(sizeof($recipe)==0){ //recipe not already saved

                //create a new image url to save with image data on file system
                 $image_url=$recipe_id.'.jpg';

                 file_put_contents('img/recipes/'.$image_url, $data);

                DB::table('recipes')->insert([                    
                    'recipe_id'=>$recipe_id,                     
                     'image_url'=>$image_url,
                     'ingredients'=>$ingredients,
                     'label'=>$label,
                     'source'=>$source,
                     'totalTime'=>$totalTime,
                     'uri'=>$uri,
                     'url'=>$url,
                     'totalIngredients'=>$totalIngredients
                ]);
                
            } 

            $errorDB='success';            
            
        } catch(Exception $e){ 
                $errorDB='Error saving to favourites: '.$e;                
        }    


        $response=['errorDB'=>$errorDB];
        echo json_encode($response);            
    }

    // removes a record from users_favourites table
    public function removeUserFavourite(){
        $user_id=$_SESSION['user_id'];
        $recipe_id=$_POST['recipe_id'];
        try {
            // remove recipe from favourites             
            DB::table('users_favourites')
            ->where('user_fk', '=', $user_id)
            ->where('recipe_fk', '=', $recipe_id)
            ->delete();

            $errorDB='success';            

        } catch(Exception $e){ 
                $errorDB='Error saving to favourites: '.$e;                
        }    


        $response=['errorDB'=>$errorDB];
        echo json_encode($response);  
    }

    // gets records from recipes table (to show all details of a user's saved recipe)
    public function getUserFavouritesFull(){
        

        //the favourites list sent by the front end
        $queryFavourites=json_decode($_POST['favourites']);
        $responseFavourites=[];

        //query the users_favourites table in the database
        foreach ($queryFavourites as $f) {
            $recipe = DB::table('recipes')->where('recipe_id', $f->recipe_fk)->get(); 
            array_push($responseFavourites,$recipe);   
        }

        
       

        $response=['favourites'=>$responseFavourites];
        echo json_encode($response);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Hash;


class Registration extends Controller
{

    
    public function  register(){
        $email=$_POST['email'];
        $password1=$_POST['password1'];
        $password2=$_POST['password2'];
        $errorEmail='';
        $errorPassword='';
        $errorDB='';
        $successMessage='';
        $redirectUrl='/login';
    
        http_response_code(200);

        //validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){      
            $errorEmail='Invalid Email';   
            http_response_code(400);
        }
        
        //check if email exists
        $user = DB::table('users')->where('email', $email)->get();
        if(sizeof($user)>0){
            $errorEmail='Email already in use';   
            http_response_code(400);
        }

        
        
        //check if passwords match
        if(empty(trim($password1)) && empty(trim($password2))){
            $errorPassword='Password cannot be blank';   
            http_response_code(400);
        }
        else{
            if($password1!=$password2){
                $errorPassword='Passwords do not match';   
                http_response_code(400);
            }
        }

        
       
        if($errorEmail=='' && $errorPassword==''){


            
            //hash password
            $hashedPassword = Hash::make($password1);
            
           

            try {
                // add user to database
                DB::table('users')->insert([
                    'email' => $email,
                    'password' => $hashedPassword
                ]);

                $errorDB='success';
                $successMessage='Account successfully created';
                $successRedirect='/login';

            } catch(Exception $e){ 
                    $errorDB='Error adding user: '.$e;                
            }
        }
        $response=['errorEmail'=>$errorEmail,
                    'errorPassword'=>$errorPassword,
                    'errorDB'=>$errorDB,
                    'successMessage'=>$successMessage,
                    'redirectUrl'=>$redirectUrl                
                ];
        echo json_encode($response);
        
    }


}

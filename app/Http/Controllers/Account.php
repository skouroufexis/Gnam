<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use Hash;

class Account extends Controller
{
    public function authenticate(){
        
        $oldPassword=$_POST['password1'];  
        $email=$_SESSION['user'];
        $error=false; 
        $errorMessage='';  
        http_response_code(200);
        
        $user = DB::table('users')->where('email', $email)->get();

        //authenticate in database
        $savedPassword=$user[0]->password;            
        if (!Hash::check($oldPassword, $savedPassword)) {
            // The passwords do not match
            $error=true;      
            $errorMessage='Passwords do not match';         
            http_response_code(400);
        }                  
        $response=['error'=>$error,'errorMessage'=>$errorMessage];
        echo json_encode($response);
    }

    public function editPassword(){
        $newPassword = $_POST['password2'];
        $user_id=$_SESSION['user_id'];
        $errorDB='';
        $successMessage='';        
        // hash new password
        $hashedPassword = Hash::make($newPassword);

        

    
        try {
            //update password
            $user = DB::table('users')
            ->where('user_id', $user_id)
            ->update(['password' => $hashedPassword]);

            $errorDB='';
            $successMessage='Password successfully modified';

        } catch(Exception $e){ 
            $errorDB='Error updating password: '.$e;      
            $successMessage='';  
        }

        $response=['errorDB'=>$errorDB,'successMessage'=>$successMessage,];
        echo json_encode($response);
        
    }

    public Function deleteUser(){
      //  
      $user_id=$_SESSION['user_id'];
      
      

      try {    
        

        $deleted = DB::table('users')->where('user_id',$user_id)->delete();
        $errorDB='success';   
        session_destroy();
        
        } catch(Exception $e){ 
            $errorDB='Error deleting account: '.$e;                
        }    



      $response=['user'=>$errorDB];
      echo json_encode($response);
    }
}

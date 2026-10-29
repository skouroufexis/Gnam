<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Hash;

class Login extends Controller
{
    public function authenticate(){
        $email = $_POST['email'];
        $password=$_POST['password'];  
        $error=false;      
                
        $user = DB::table('users')->where('email', $email)->get();

        //record does not exist    
        if(sizeof($user)==0){
            $error=true;                        
        }
        else{

            //authenticate in database
            $savedPassword=$user[0]->password;            
            if (!Hash::check($password, $savedPassword)) {
                // The passwords match...                
                $error=true;               
            }
            else{
                $_SESSION['user']=$user[0]->email;
                $_SESSION['user_id']=$user[0]->user_id;
            }     

         
        }

        if($error==true){
            return view('login', ['authenticationError' => 'Invalid Credentials']);
        }
        else{
            return redirect()->to('/');
        }
        
    }

    public function logout(){
        session_destroy();
        return redirect()->to('/');
    }

    
}

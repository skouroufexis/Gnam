<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

// session_destroy();

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;
use App\Http\Controllers\Account;
use App\Http\Controllers\Images;
use App\Http\Controllers\Favourites;



Route::get('/', function () {
    //if user is not logged in (!isset $_SESSION['user'])
    if(!isset($_SESSION['user'])){
        return redirect()->to('/login');
        
    }
    else{
        return view('index'); 
    } 
});

Route::get('/guest', function () {
    //user proceeds as guest    
    return view('index');     
});

// USER OPERATIONS

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [Registration::class, 'register']);

Route::post('/login', [Login::class, 'authenticate']);

Route::get('/logout', [Login::class, 'logout']);

Route::post('/authenticatePassword', [Account::class, 'authenticate']);

Route::post('/putPassword', [Account::class, 'editPassword']);

Route::get('/deleteUser', [Account::class, 'deleteUser']);


//Image data (not used)
Route::post('/getImageData', [Images::class, 'imageData']);


// FAVOURITES
Route::get('/getFavourites', [Favourites::class, 'getUserFavourites']);
Route::post('/addFavourite', [Favourites::class, 'addUserFavourite']);
Route::post('/removeFavourite', [Favourites::class, 'removeUserFavourite']);
Route::post('/getFavouritesFull', [Favourites::class, 'getUserFavouritesFull']);








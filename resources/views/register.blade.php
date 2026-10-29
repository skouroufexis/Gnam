
<div class='vue'>
<html>
<x-head title='Register' />    

<body>
    <x-header user="" />

    <main v-if='successMessage==""' class='container'>
        <div class='row  mt-3 text-center'><h2>Register</h2> </div>
        <form class='container' id='registerForm' action="/">
        <div class='row'>
            <label for="email">Email</label>
            <p v-if='errorEmail!=""' class='col-12 error'> <small>@{{errorEmail}}</small> </p>
            <input type="email" class='col-12' name='email' id='email'>
        </div>

        <div class='row mt-1'>
            <label for="password1">Password</label>    
            <p v-if='errorPassword!=""' class='col-12 error'> <small>@{{errorPassword}}</small> </p>        
            <input class='col-11' type="password" name='password1' id='password1' v-model='password1'>
            <button v-if='!showPassword1' type='button' class='btn fas fa-eye col-1' @click='togglePassword1'></button>
            <button v-if='showPassword1' type='button' class='btn fas fa-eye-slash col-1' @click='togglePassword1'></button>
            <input v-if='showPassword1' class='col-11 lightblue noborder' disabled :value='password1'>
        </div>

        <div class='row mt-1'>
            <label for="password2">Repeat Password</label>
            <input class='col-11' type="password"  name='password2' id='password2' v-model='password2'>
            <button v-if='!showPassword2' type='button' class='btn  fas fa-eye col-1' @click='togglePassword2'></button>
            <button v-if='showPassword2' type='button' class='btn  fas fa-eye-slash col-1' @click='togglePassword2'></button>            
            <input  v-if='showPassword2' class='col-11 lightblue noborder' disabled :value='password2'>
        </div>

        <div class='row mt-3 '>            
            <div class='text-center col-12'>
                <button type='button' class='btn col-12  btn-dark rounded mt-3' @click='validateForm'>Register</button>
            </div>
        </div>

        </form>   

        <div class="row">
            <a href='/login' class="col">Back to login page</a>
        </div>
    </main>

   
    
    <div v-if='successMessage!=""'>
        <x-success v-if='success' redirectUrl='redirectUrl' successMessage='successMessage' />
    </div>

</body>


    
</html>
</div>

<script src="js/register.js"></script>   
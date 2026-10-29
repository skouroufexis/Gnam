
<div class="vue">
<html>
<x-head title='Login' />    

<body>
    <x-header user="" />

    <main class='container mt-2'>
        <!-- <div class='row  mt-1 text-center'><h2>Login</h2> </div> -->

        @if(isset($_POST['email']))
        <div class='container'>
            <div class="row error">{{$authenticationError}}</div>            
        </div>
        @endif

        @if (isset($_POST['email']))

        

        <form class='container' action="/login" method='post'>
            @csrf

        <div class='row'>
            <label for="email">Email</label>
            <input type="text" class='col-12 used border' name='email' id='email' value="{{$_POST['email']}}" >
        </div>

        <div class='row mt-1'>
            <label for="password">Password</label>
            <input type="password"  class='col-12 used border' name='password' id='password' value="{{$_POST['password']}}">
        </div>

        <div class='row mt-1'>
            
            <div class='text-center col-12'>
                <button type='submit' class='btn col-12   btn-dark rounded'>Login</button>
            </div>
        </div>

        </form> 

        @else
        <form class='container' action="/login" method='post'>
            @csrf

        <div class='row'>
            <label for="email">Email</label>
            <input type="text" class='col-12 border' name='email' id='email'>
        </div>

        <div class='row mt-1'>
            <label for="password">Password</label>
            <input type="password"  class='col-12 border' name='password' id='password'>
        </div>

        <div class='row mt-3'>
            
            <div class='text-center col-12'>
                <button type='submit' class='btn col-12   btn-dark rounded'>Login</button>
            </div>
        </div>

        </form>    
        @endif


        <div class='row'>
            <div class="col-12 text-center">No account? <a href="/register">Sign-up</a></div>            
        </div>

        <div class='row mt-2'>
            <div class="col-12 text-center">OR</div>            
        </div>

        <div class='row'>
            <div class="col-12 text-center"><a class='black' href="/guest">Continue as guest</a> </div>            
        </div>

    </main>

</body>


    
</html>
</div>

<script src="js/login.js"></script>   
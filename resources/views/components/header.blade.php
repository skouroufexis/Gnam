
<!-- get the first part  from email, display it as username -->
 <?php 
  if(isset($_SESSION['user'])){
    // $initial=substr( $_SESSION['user'],0,1);
    $initial =explode("@",$_SESSION['user']);
    $initial=$initial[0];

  }
 
 ?>
 

<div class = 'container mt-2 shadow-sm'>

    <div id="env" 
    appID="{{ $appID }}" 
     appKEY="{{ $appKEY }}" >

    </div>

    {{$appID}}

    <div class='row'>
        <div class="col">
            @if (isset($_SESSION['user']))  
            <a href='/'>
                <img class='logo' src="img/gnam.png" alt="">
             </a>
            @elseif($_SERVER['REQUEST_URI']=='/guest')
            <a href='/guest'>
                <img class='logo' src="img/gnam.png" alt="">
            </a>

            @else

            <a href='/'>
                <img class='logo' src="img/gnam.png" alt="">
            </a>    

            @endif
        </div> 
        <div class='col text-center margin-v-auto' id="edamam-badge" data-color="badge"></div>

        @if(isset($_SESSION['user']))
        
        <div class="col  text-end margin-v-auto"><span class='orange'>{{$initial}}</span> <button class="btn fas fa-user" @click='toggleTopMenu'></button></div>                
        @endif
    </div>    
        
    @if(isset($_SESSION['user']))
    
        <div v-if='topmenu' class='row' id='userMenu'>            
            <x-userMenu user='{{$_SESSION["user"]}}' />     
        </div>        
    @endif

    
    @if($_SERVER['REQUEST_URI']=='/guest')
         <div class='row text-end'>
         <a href="/login" class='lightblack'>Login/Sign-up</a>    
         </div>       
        
    @endif
    
  

</div>

<!-- <script src="js/header.js"></script>   -->
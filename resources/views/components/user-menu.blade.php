<div v-if='!editPassword' class = 'container'>

    <div class='row mt-1 record'> 
        <button class='btn col-12  text-start' @click='openFavourites'>
            <i class="col-6 fas fa-star golden text-end"></i>
             &nbsp; My Recipes                        
        </button>                                                     
    </div>
    
        
    <div class='row mt-1 record'> 
        <button class='btn col-12 text-start' @click='toggleEditPassword'>
            <i class="col-6 far fa-edit lightblack text-end"></i>
            &nbsp; Edit Password
        </button>                                               
    </div>

    <div class='row mt-1 record'> 
        <button class='btn  col-12 text-start'>
        <a class='nounderline black' href='/logout'> 
            <i class="col-6 fas fa-sign-out-alt text-end"></i>
            &nbsp; Logout
        </a>
        </button>                                                      
    </div>

    <div class='row mt-1 record'>    
        <button class='btn col-12  text-start' @click='deleteAccount'>
            <i class="col-6 fas fa-user-times red text-end"></i>
             &nbsp; Delete Account                        
        </button>                                            
    </div>

    
    <!-- <div class='row mt-2 '>    
        <button class='btn col-12' @click='toggleTopMenu'>
            Back
        </button>                                            
    </div> -->

    
    
</div>

<div v-if='editPassword' class="container menuContainer">
        <x-editPassword />
</div>

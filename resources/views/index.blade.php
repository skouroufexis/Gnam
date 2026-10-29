
<div class="vue">
<html>
<x-head title='Index' />    

<body>
    @if(isset($_SESSION['user']))
    <x-header user='{{$_SESSION["user"]}}' 
   
    />    
    @else
    
    <x-header user=""
    
            
    
    />
    @endif

    

    <Transition>
    <main v-if='main' class='container' id='main'>

        <div v-if='!showFavourites'>
            <div v-if='recipes.length==0' class='sticky-top membrane'>
                <div class="row mt-4">
                    <input type="text" class="col" placeholder='Add ingredient...' v-model='queryIngredient' @keypress='addIngredient'>
                    
                </div>
            
                <div  class="row mt-2 golden"> <span>Ingredients (@{{ingredients.length}}) &nbsp;<button v-if='ingredients!=""' class='btn btn-dark fas fa-search' @click='getRecipes'> Find recipes</button></span></div>  
            </div> 
    
            <div v-if='recipes.length>0' class='row sticky-top membrane py-2 mt-2'>            
                <div>
                    <button  class='btn btn-dark' @click='unsearch'> Back</button>
                </div>
            </div> 
            
            
            <span v-if='loading==false && recipes.length==0'>
                <div v-for='i,index in ingredients' class="row mt-2  p-2 shadow-sm ">        
                    <div class="col ">@{{i}}</div>
                    <div class='col-1  text-center'><button class='btn' @click='removeIngredient(index)'><i class="fas fa-times"></i></button></div>        
                </div>
            </span>
    
    
            <!-- loader -->
            <div v-if='recipes.length==0 &&loading==true' class='row text-center mt-1'>

                <div>
                    <span class="spinner-border spinner-border-sm lightblack"></span>
                        &nbsp; <span class='lightblack'>Loading recipes</span>
                </div>
            </div>        
            <div v-if='recipes.length!=0'>
                <div v-for='r,index in recipes' class="row mt-3  shadow-sm recipeRecord">                                                                            
                                <div class="col-12 title  p-2 text-center d-md-none"><b> | @{{r.recipe.label}}</b></div>
                                <div class="col-12 title  p-2 d-none d-md-block"><b>| @{{r.recipe.label}}</b></div>
                                
                                <div class="col-12 col-md-6  p-2  mt-1 text-center">
                                    <img  class='img-fluid' :src="r.recipe.image" alt="Recipe Image">                    
                                </div>  
                
                                <div class="col-12 col-md-6">
                                    <div class='col-6 mt-2'>
                                        <!-- <p class='mt-1 black'>Ingredient Match:  <span><small>@{{r.percentage}} %</small></span></p>                                                     -->
                                        <p class='mt-1 black'><b>Ingredient Match</b></span> <small></small> <b class='green'><b>@{{r.percentage}}%</b></b> </p>                                                    
                                    </div>
                                    <div class="col-6">
                                    <button v-if='r.percentage>1' class='percentage1 btn rounded-left shadow' :style="{ width: r.percentage + '%' }"></button>                    
                                        <!-- <button v-if='r.percentage>1' class='percentage1 btn shadow rounded-0'><small>@{{r.percentage}} %</small></button>                     -->
                                        
                                        <button v-if='r.percentage<100 && r.percentage>0' class='percentage2 btn rounded-0' :style="{ width: (100 - r.percentage) + '%' }"></button>
                                        <!-- <button v-if='r.percentage==0' class='percentage2 btn rounded-circle' :style="{ width: (100 - r.percentage) + '%' }"><small>0%</small></button> -->
                                        <button v-if='r.percentage==0' class='col percentage2 btn rounded-0 '><small></button>                            
                                    </div>
                                    
                                    <div class='col-12 mt-2'><i class="far fa-clock"></i> @{{r.recipe.totalTime}}</div>
                                    <div class='col-12  mt-2 grey'><small>Total Ingredients (@{{r.recipe.ingredients.length}})</small></div>
                                    <div class='col-12 lightblue'  class='col-12'>
                                            <small v-for='i,index in r.recipe.ingredients'>@{{i}}<span v-if='index<(r.recipe.ingredients.length-1)'>,</span>&nbsp;</small>
                                    </div>
    
                                    
    
                                    <div class='col-12 mt-2'>
                                        <a :href='r.recipe.url' target='_blank'><button class='btn text-start darkgolden' ><span class="fas fa-external-link-alt"></span>&nbsp;View Recipe </button> </a>
                                        
                                    </div>
    
                                    @if(isset($_SESSION['user']))
                                    <div class="col-12">
                                        <!-- <p>@{{r.isFavourite}}</p> -->
                                        <button v-if='r.isFavourite' class='btn' @click='removeFavourite(r)'> <i class="fas fa-star golden"></i></button>
                                        <button v-if='!r.isFavourite' class='btn grey' @click='addFavourite(r)'> <i class="far fa-star"></i> Add to Favourites</button>
                                    </div>
                                    @endif
                                </div>
    
                            
                            
                        
                        
                        <!-- <div class="col ">@{{r.percentage}}</div> -->
    
                        
                </div>
            </div>
        </div>

        <div v-if='showFavourites'>
            <x-favourites  />     
        </div>
    </main>

    
    

    </Transition>

    

</body>
 
</html>
</div>


<script src="js/header.js"></script>


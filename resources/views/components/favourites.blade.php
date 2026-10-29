<div class = 'container'>
    <div class="row mt-2">
        <button class='btn text-start fas fa-times' @click='closeFavourites'></button>
    </div>
    
    <div class="row mt-2 text-center">
        <h2>My Recipes</h2>
    </div>


    <!-- loader -->
    <div v-if='favouritesFull.length==0 &&loading==true' class='row text-center mt-1'>
        <div>
            <span class="spinner-border spinner-border-sm lightblack"></span>
                &nbsp; 
            <span class='lightblack'>Loading recipes</span>
        </div>
    </div>

    <div v-if='favouritesFull.length==0 &&loading==false' class='row text-center mt-1'>
        <div>
            
            <span class='grey'>No saved recipes</span>
        </div>
    </div>


    <div v-if='favouritesFull.length!=0'>
        <div v-for='f,index in favouritesFull' class="row record mt-2 shadow-sm">        
            <div class="col-12 title  p-2 text-center d-md-none">  <b>| @{{f.label}}</b></div>
                <div class="col-12 title  p-2 d-none d-md-block"> <b>| @{{f.label}}</b></div>
                
                <div class="col-12 col-md-6 p-2  mt-1 text-center">
                    <img  class='img-fluid' :src="f.image_url" alt="Recipe Image">                    
                </div>  

                <div class="col-12 col-md-6">                                    
                    
                    <div class='col-12 mt-2'><i class="far fa-clock"></i> @{{f.totalTime}}</div>
                    <div class='col-12  mt-2 grey'><small>Total Ingredients (@{{f.totalIngredients}})</small></div>
                    <div class='col-12 lightblue'  class='col-12'>
                            <small>@{{f.ingredients}}</small>
                    </div>

                    

                    <div class='col-12 mt-2'>
                        <a :href='f.url' target='_blank'><button class='btn text-start darkgolden' ><span class="fas fa-external-link-alt"></span>&nbsp;View Recipe </button> </a>
                        
                    </div>

                    <div class="col-12">                        
                        <button  class='btn' @click='removeFavourite(f)'> <i class="fas fa-star golden"></i> <span class='lightblack'><small>Remove from favourites</small></span></button>                        
                    </div>
                </div>
                
             </div>
             
    </div>  
    
    
</div>



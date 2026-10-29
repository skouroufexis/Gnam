
const { createApp } = Vue;

createApp({
  data() {
    return {
      title: 'Header',
      token:'',
      topmenu:false,
      main:true,
      editPassword:false,
      showFavourites:false,
      password:'',
      password1:'',
      password2:'',
      password3:'',
      showPassword1: false,
      showPassword2: false,
      showPassword3: false,
      oldPasswordMatch:false,
      newPasswordMatch:false,
      errorMessage:'',
      errorNewPassword:'',
      errorDB:'',
      successMessage:'',          
      queryIngredient:'',
      ingredients:[],
      loading:false,
      recipes:[],
      favouritesFull:[],
      favourites:[],
      appID:'',
      appKey:'',

    }
  },

  methods: {
    
    // HEADER METHODS

    toggleTopMenu:function(){
        this.topmenu=!this.topmenu;
        this.main=!this.main;
        
        if(this.editPassword){

        //reset values
        this.password1='';
        this.password2='';
        this.password3='';
        this.oldPasswordMatch=false;
        this.errorMessage='';
        this.errorNewPassword='';
        this.editPassword=false;
        }
        
    },

    openFavourites:function(){
      this.toggleTopMenu();
      
      this.showFavourites=true;

      //send requests to api with all elements of favourites[]
      this.getFavouritesFull();
    },

    closeFavourites:function(){
      
      this.showFavourites=false;
    },

    toggleEditPassword:function(){
        this.editPassword=!this.editPassword;

        //reset values
        this.password1='';
        this.password2='';
        this.password3='';
        this.oldPasswordMatch=false;
        this.errorMessage='';
        this.errorNewPassword='';

        setTimeout(() => {
          document.getElementById('password1').focus();  
        }, 100);
        
    },

    togglePassword1:function(){
      this.showPassword1=!this.showPassword1;
    },
    togglePassword2:function(){
      this.showPassword2=!this.showPassword2;
    },
    togglePassword3:function(){
      this.showPassword3=!this.showPassword3;
    },

    compareOldPassword:function(){

      //compare old password in database before changing it

      //form data
      let form=document.getElementById('editPasswordForm');
      let data = new FormData(form);


      fetch('/authenticatePassword', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': this.token
        },
        body: data
      })
      .then(x => x.json()
      )
      .then(y => {        
        this.errorMessage=y.errorMessage;
        if(y.errorMessage!=''){
          this.oldPasswordMatch=false;
          document.getElementById('password1').focus();
        }
        else{
          this.oldPasswordMatch=true;
        }
        
      })
      .catch(err => console.log(err.message));        
    },

    compareNewPassword:function(){


      if(this.password2.trim()==""||this.password3.trim()=="" ){
        this.errorNewPassword='Password cannot be blank';
        this.successMessage='';
        this.errorDB='';
        document.getElementById('password2').focus();
      }
      else{

          if(this.password2!=this.password3){

            this.errorNewPassword='Passwords do not match';
            this.successMessage='';
            this.errorDB='';    
            document.getElementById('password3').focus();        
          }
          
          else{
            this.errorNewPassword='';
    
    
            //update password in database
    
            //form data
          let form=document.getElementById('editPasswordForm');
          let data = new FormData(form);
    
    
          fetch('/putPassword', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': this.token
            },
            body: data
          })
          .then(x => x.json()
          )
          .then(y => {        
    
                this.successMessage=y.successMessage;    
                this.errorDB=y.errorDB;

                
          })
          .catch(err => console.log(err.message)); 
    
            
          }

      }

      

    },

    resetSuccess:function(){
      this.errorDB='';
      this.successMessage='';

    },

    //INDEX.JS (MAIN PAGE) METHODS

    getFavourites:function(updateF){

      // updateF is set to true if the favourites[] is to be updated as user adds or removes
      // a recipe from favourites. 

      //get user favourites from db

    this.favourites=[];  
    let url ='/getFavourites'; 
     
     fetch(url)
    .then(x => x.json())
    .then(y => {            
      for(f of y.favourites){
        // this.favourites.push(f.recipe_fk)        
        this.favourites.push(f)  
      }

      console.log(this.favourites)
      //

      if(updateF==true){
        this.updateFavourites();
      }
    });
    },
    
    addIngredient:function(event){      
      if(event.key){
        if(event.key==='Enter'){
          this.ingredients.push(this.queryIngredient);
          this.queryIngredient='';
        }
      }
      else{
        this.ingredients.push(this.queryIngredient);
          this.queryIngredient='';
      }
      
      
    },

    removeIngredient:function(i){
      this.ingredients.splice(i,1)
    },

    getRecipes:function(){
      
      this.recipes=[];
      let query ='';      
      this.ingredients.forEach((i,index) => {
        query=query+' '+i;
      });

      

      
      
      let url= 'https://api.edamam.com/api/recipes/v2?type=public&q='+query+'&app_id='+this.appID+'&app_key='+this.appKey+'&field=uri&field=label&field=image&field=images&field=source&field=url&field=ingredients&field=totalTime';
      
      this.loading=true
      fetch(url)
      .then(x => x.json())
      .then(y => {
        let results = y.hits;
        
        console.log(y);

        results.forEach((r) => {
          let matches=0;
          //extrapolate ingredients
          let ingredients=[];          
          r.recipe.ingredients.forEach(element => {
            ingredients.push(element.food)
          });
          
          r.recipe.ingredients=ingredients;

          //add percentage of ingredient match
          //(how many of the queried ingredients are included in the found recipes)

          this.ingredients.forEach(i => {
              ingredients.forEach(ii => {
                if(ii.toUpperCase().includes(i.toUpperCase())){
                  matches++;
                }
              });            
            
          });
          r.percentage= Math.round((matches/ingredients.length)*100);
          r.matches=matches;
          r.totalIngredients=ingredients.length;
          r.recipe_id = r.recipe.uri;
          r.recipe_id=r.recipe_id.split("recipe_");
          r.recipe_id=r.recipe_id[1];

          r.isFavourite=false;
          
          //check if recipe is user favourite
          
          this.favourites.forEach((f) => {
            
            console.log(f);
            console.log(r.recipe_id);
            if(r.recipe_id==f.recipe_fk){
              
              r.isFavourite=true;
              
            }
                        
            
          });
          this.recipes.push(r);  
          
        });
        this.loading=false;
    
        //sort recipes according to ingredient percentage
        this.recipes.sort(function(a, b){return b.percentage - a.percentage});
        console.log(this.recipes);


      });
      
      

      // this.loading=true;
      // setTimeout(() => {
      //   this.recipes.push('1');
      //   this.loading=false;
      // }, 2000);

    },

    unsearch:function(){
      this.recipes=[];
    },

    addFavourite:function(r){
      console.log(r);
      

      //add recipe to user favourites in db
      let data = new FormData();

      //create string with ingredients to add to database
      let ingredients='';
      let c;
      let totalIngredients=r.recipe.ingredients.length;
      for(c=0;c<totalIngredients;c++){
        if(c!=(totalIngredients-1)){
          ingredients=ingredients+r.recipe.ingredients[c]+', ';
        }
        else{
          ingredients=ingredients+r.recipe.ingredients[c];
        }
        
      }
      
      //add form data  
      data.append('recipe_id', r.recipe_id);
      data.append('image_url', r.recipe.image);
      data.append('ingredients', ingredients);
      data.append('label', r.recipe.label);
      data.append('source', r.recipe.source);
      data.append('totalTime', r.recipe.totalTime);
      data.append('uri', r.recipe.uri);
      data.append('url', r.recipe.url);
      data.append('totalIngredients', r.totalIngredients);
      
      //send request
      fetch('/addFavourite', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': this.token
        },
        body: data
      })
      .then(x => x.json()
      )
      .then(y => {                
        this.getFavourites(true);     
        console.log(y.errorDB);      
        // this.recipes=newRecipes;
      })      
      .catch(err => console.log(err.message));

      



      //get image in back-end
      let image=r.recipe.image;
      // let data = new FormData();
      data.append('imageUrl', image);

      data.append('recipeId',r.recipe_id);
      
      
      

      
    
    },

    removeFavourite:function(r){

      
      //remove recipe to user favourites in db
      let data = new FormData();
      data.append('recipe_id', r.recipe_id);

      fetch('/removeFavourite', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': this.token
        },
        body: data
      })
      .then(x => x.json()
      )
      .then(y => {                
        this.getFavourites(true);           
        // this.recipes=newRecipes;
      })      
      .catch(err => console.log(err.message));
    },

    updateFavourites:function(){
      // let newRecipes=[];

          this.recipes.forEach(r => {
            let fav=false;
            this.favourites.forEach(f => {
              if(f.recipe_fk==r.recipe_id){
                fav=true;              
              }              
            });
    
            if(fav==true){
              r.isFavourite=true;
            }
            else{
              r.isFavourite=false;
            }               
           });

           //remove item from favouritesFull[] if user removes it from favourites
           if(this.favouritesFull.length!=0){

            
            let favFull=[];
            console.log(this.favouritesFull);
            this.favouritesFull.forEach(r => {
              
              this.favourites.forEach(f => {
                if(f.recipe_fk==r.recipe_id){                      
                  favFull.push(r)                  
                }              
              });                                             
            });
            this.favouritesFull=favFull;

           }
           
          
    },

    getFavouritesFull:function(){

      this.favouritesFull=[];
      let l=this.favourites.length;            
      let data = new FormData();
      data.append('favourites', JSON.stringify(this.favourites));
     
     fetch('/getFavouritesFull', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': this.token
      },
      body: data
    })
    .then(x => x.json()
    )
    .then(y => {                
           
      console.log(y.favourites); 
      y.favourites.forEach(f => {
        console.log(f[0]);
        console.log(f[0].image_url);
        f[0].image_url='img/recipes/'+f[0].image_url;
        this.favouritesFull.push(f[0])
      });     

      //sort favourites
        this.favouritesFull.sort(function(a, b){
          let name1=a.label.toUpperCase();
          let name2=b.label.toUpperCase();

         return name1.localeCompare(name2);
        });
      console.log(this.favouritesFull);
      
      
    })  
    .catch(err => console.log(err.message)); 
    },

    
    deleteAccount:function(){
      //prompt user if they want to delete their account
      if(confirm('Delete account?')){
        //delete account
        fetch('/deleteUser')
        .then(x => x.json())
        .then(y => {
            console.log(y)
            if(y.user=='success'){
              alert('Account successfully deleted');
              window.location.href = "/";
            }
          });        
      }            
    },
        
  },
  beforeUnmount:function(){
    alert('a');
  },

  mounted:function(){        
   this.token=document.getElementById('token').getAttribute('token');
   this.getFavourites(); 

   this.appID=document.getElementById('env').getAttribute('appID');
   this.appKey=document.getElementById('env').getAttribute('appKEY');       

  }
}).mount('.vue');






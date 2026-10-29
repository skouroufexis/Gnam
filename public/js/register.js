
const { createApp } = Vue;

createApp({
  data() {
    return {
      token:'',
      showPassword1: false,
      showPassword2: false,
      password1:'',
      password2:'',
      errorPassword:'',
      errorEmail:'',
      redirectUrl:'',
      successMessage:'',
      
      
           
    }
  },

  methods: {
    togglePassword1:function(){
        this.showPassword1=!this.showPassword1;
    },
    togglePassword2:function(){
        this.showPassword2=!this.showPassword2
    },

    validateForm:function(){

      //form data
      let form=document.getElementById('registerForm');
      let data = new FormData(form);


      fetch('/register', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': this.token
        },
        body: data
      })
      .then(x => x.json()
      
      )
      .then(y => {
        this.errorEmail=y.errorEmail;
        this.errorPassword=y.errorPassword;
        this.succes=true;
        this.redirectUrl=y.redirectUrl;
        this.successMessage=y.successMessage;
        
        console.log(y);        
      })
      .catch(err => console.log(err.message));
    }

    //
    
  },
  mounted:function(){     

    this.token=document.getElementById('token').getAttribute('token');

  }
}).mount('.vue');






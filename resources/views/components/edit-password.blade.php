<form class='container' id='editPasswordForm' method='POST'>      
    <div v-if='oldPasswordMatch==false' class="row mt-1">
        <p class="col-12 grey">Enter current password</p>

        <small v-if='errormessage!=""' class='error'>@{{errorMessage}}</small>
        <!-- <p v-if='errorPassword!=""' class='col-12 error'> <small>@{{errorPassword}}</small> </p>         -->
        <input class='col-11' type="password" name='password1' id='password1' v-model='password1'>
        <button v-if='!showPassword1' type='button' class='btn fas fa-eye col-1' @click='togglePassword1'></button>
        <button v-if='showPassword1' type='button' class='btn fas fa-eye-slash col-1' @click='togglePassword1'></button>
        <input v-if='showPassword1' class='col-11 lightblue noborder' disabled :value='password1'>
    </div>

    <div v-if='oldPasswordMatch' class="row mt-1">
        
        <p class="col-12 grey">Enter current password</p>
        <input class='col-11 disabled' type="password" name='password1' id='password1' v-model='password1' disabled>
        <button v-if='!showPassword1' type='button' class='btn fas fa-eye col-1' @click='togglePassword1'></button>
        <button v-if='showPassword1' type='button' class='btn fas fa-eye-slash col-1' @click='togglePassword1'></button>
        <input v-if='showPassword1' class='col-11 lightblue noborder' disabled :value='password1'>
    </div>

    <div v-if='!oldPasswordMatch' class="row mt-1">    
        <button  type='button' class='btn btn-dark col col-md-1' @click='compareOldPassword'><i class="fas fa-caret-right"></i> Next</button>    
    </div>


    <div v-if='oldPasswordMatch'>
        <div class='row mt-1'>
            <label for="password2">Enter new password</label>
            <div class='row mt-2'>
                <small v-if='errorNewPassword!=""' class='error'>@{{errorNewPassword}}</small>
                <small v-if='successMessage!="" && errorDB==""' class='success'>@{{successMessage}}</small>
                <small v-if='errorDB!=""'>@{{errorDB}}</small>

            </div>
            <input class='col-11' type="password"  name='password2' id='password2' v-model='password2' @keyup='resetSuccess'>
            <button v-if='!showPassword2' type='button' class='btn  fas fa-eye col-1' @click='togglePassword2'></button>
            <button v-if='showPassword2' type='button' class='btn  fas fa-eye-slash col-1' @click='togglePassword2'></button>            
            <input  v-if='showPassword2' class='col-11 lightblue noborder' disabled :value='password2'>
        </div>
        
        <div class='row mt-1'>
            <label for="password2">Repeat new password</label>
            <input class='col-11' type="password"  name='password3' id='password3' v-model='password3' @keyup='resetSuccess'>
            <button v-if='!showPassword3' type='button' class='btn  fas fa-eye col-1' @click='togglePassword3'></button>
            <button v-if='showPassword3' type='button' class='btn  fas fa-eye-slash col-1' @click='togglePassword3'></button>            
            <input  v-if='showPassword3' class='col-11 lightblue noborder' disabled :value='password3'>
        </div>

        

        <div v-if='successMessage==""' class="row mt-1">    
            <button  type='button' class='btn btn-dark col col-md-1'  @click='compareNewPassword'>Save</button>    
        </div>
        
    </div>

</form>

<div class="row">
    <button class='btn col-12 text-start' @click='toggleEditPassword'><u>Back</u></button>
</div>

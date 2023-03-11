<link href="./assets/admin/assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />

<div style="    position: fixed; width: 100%;height: 100%; background-color: #fff;z-index: 999999999999999; top: 0; left: 0;">










	<div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap" style="width: 480px;">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Log In </h1>
                        <p class="signup-link"></p>
                        <form id="enterForm" class="text-left">
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="email" name="username" type="text" class="form-control" placeholder="ID or Email">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    
                                    <div class="field-wrapper w-100">
                                        <button id="nextBtn" class="btn btn-primary w-100" value="">Log In</button>
                                    </div>
                                    
                                </div>

                                

                            </div>
                        </form>                        
                        <p class="terms-conditions">© 2023 All Rights. </p>

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

















</div>

<script>

$(document).on('click', '#nextBtn', function(e) {

	ajaxCall({ option: 'admintype_login', email : $('#email').val(), pw : $('#password').val(), }, (data) => {
		location.replace('./');
	});

});

$("#enterForm").keydown(function(e){
    if(e.keyCode==13) {
        $('#nextBtn').trigger('click');
		e.preventDefault();
    }
});

$("#enterForm").submit(function(){
	return false;
});
</script>
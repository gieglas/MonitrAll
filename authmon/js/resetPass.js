var ajaxRunCount = 0;
var ENTER_KEY = 13;
var ESC_KEY = 27;

/**
 * Main class for reset password page
 */
var authmonResetPass = {
	/**
     * init Function
     */ 
    init: function() {
		var html="";
		// Get the login token. If it exists then reset Password 
		var loginToken= utils.getParameterByName('t');
		if ((loginToken == null) || (loginToken == '')) {
			html = authmonResetPass.getTmpl('invalidtoken');
			$("#containerdiv").html(html);
		} else {
			authmonResetPass.checkLoginToken(loginToken);
		}
		//HERE:
		// check if the login token exists in the DB OK
		// If not exists show template with Error OK
		// If exists show template with reset password form OK
		//  Bind the click and keypress for form
		//  Handle clickresetpassword 
		
        //authmonResetPass.bindEvents();
    },
	// ----------------------------------- templates ---------------------------------
    /**
     * Get template
     */
    getTmpl:function(tmplStr){
        return $('#'+tmplStr+'tmpl').html();
    },
	// ----------------------------------- Bindings router ---------------------------
	/**
     * Bind page events
     */
    bindEvents : function () {
		//Bindings on the signed in  pages
		$('#form-signed').on('click','.clickAction',this.router);
		$('#resetpasswordform').on('keypress', 'input', this.changeKeyUp );
    },
	/**
    * Handles ENTER_KEY on rest of the forms
    */
    changeKeyUp: function(e){
        if ( e.which === ENTER_KEY ) {		
			//simulate click event on OK	
			$('#'+$(this).data('clickaction')).trigger('click');
			return false;
		}
    },
	/**
     * Handles all routes from the page
     */
    router:function(){
		switch (this.id){
            case "doresetpassword":
				if ($('#resetpasswordform').parsley('validate')){
                    if ($('#input_password_new').val() != $('#input_password_repeat').val() ) {
                        utils.showMessage('Error', 'New Password and repeat password are not the same. ', 'alert-error');
                    } else {
                        arr = $('#resetpasswordform').serializeArray();
                        //get the array of data from the form
                        authmonResetPass.doResetPassword(arr);   
                    }
                }
			break;
		}
	},
	// ----------------------------------- ajax functions ----------------------------
	/**
     * Handles the do reset form action
     * 
     */
    doResetPassword: function (dataIn=null) {
        
		$.ajax({
			type: 'POST', 
			cache: false,
            contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: 'api/AuthResetPassword',
			dataType: "json",
			data: JSON.stringify(dataIn),
			success: function(data) {
				//TODO: Load template success
			   var html = authmonResetPass.getTmpl('successresetpass');
			   $("#containerdiv").html(html);
               utils.showMessage('Success', 'Success','alert-success');
			},
			error: function(jqXHR, textStatus, errorThrown){
				if (jqXHR.status == 400) {
                    var data=JSON.parse($.trim(jqXHR.responseText));
                    utils.showMessage('Error', data["feedback"],'alert-error');
				} else {
                    utils.showMessage('Error', 'An error has occured. ' + textStatus , 'alert-error');
				}
			}
        });
    },
	/**
	*
	*Checks if the login token is correct (exists in the database)
	*/
	checkLoginToken: function(loginToken) {
		// ajax request
		$.ajax({
			type: 'POST', 
			cache: false,
			contentType: 'application/json',
			url: 'api/AuthCheckResetPassToken',
			dataType: "json",
			data: JSON.stringify([{'name':'loginToken','value': loginToken}]),
			success: function(data) {
				//resetTokenFound
				var template = authmonResetPass.getTmpl('resetpass');
				var mustacheData={data:data};
				var html = Mustache.render(template, mustacheData);
				$("#containerdiv").html(html);
				authmonResetPass.bindEvents();
			},
			error: function(jqXHR, textStatus, errorThrown){
				var html = authmonResetPass.getTmpl('invalidtoken');
				$("#containerdiv").html(html);
			}
		});
	}
}


$(document).ready(function () {
    authmonResetPass.init();
    $('#refreshIcon').hide();
	jQuery.ajaxSetup({
        beforeSend: function() {
            ajaxRunCount++;	
            $('#refreshIcon').show();
        },
        complete: function(){
            ajaxRunCount--;
            if (ajaxRunCount <= 0) $('#refreshIcon').hide();
        },
        success: function() {}
	});	
});
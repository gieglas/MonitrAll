var tokenobj=null;
var tokenSetDate=new Date();
/**
 * Main class for login
 */



var authmonInApp = {
    /**
     * init Function
     */ 
    init: function() {
        //check if can access localstorage
        if(typeof(Storage) == "undefined") {
            alert('Browser does not support.');
            return null;
        }
        //check if logged in show details package
        if (localStorage.token) {
            //set tokenobj
            authmonInApp.isLoggedIn();
            return true;
        //if not logged in show login page
        } else {
            authmonInApp.logoutCommon();
            return false;
        }
    },
// ----------------------------------- common functions ---------------------------------
    /**
     * Login Commons. 
     */
    loginCommon: function (data){
        try {
            // Store
            localStorage.removeItem("token");
            localStorage.setItem("token", data.token);
            //set tokenobj
            tokenobj= data;
            //reset set token set date 
            tokenSetDate=new Date();
        }
        catch(err) {
			utils.showMessage('Error', 'An error has occured. ', 'alert-error');
        }
    },
    /**
     * Logout Commons
     */ 
    logoutCommon: function (){
        // Store
        localStorage.removeItem("token");
        //set tokenobj
        tokenobj= null;
        window.location.href = "authmon/?r=../";
    },
    /**
     * 
     *  renew token
     */
     renewTokenCommon: function (){
        if (tokenobj.refreshin == null) return false;
        //autorenew token
        if (((tokenobj.refreshin-(new Date() - tokenSetDate) / 1000 /60) < 0)) {
            authmonInApp.renewToken();
        }
     },
     /**
     * Ajax errors returned (not status 200)
     */ 
    ajaxError: function (jqXHR, textStatus, errorThrown){
       switch (jqXHR.status) {
            //Authorization Codes 
            case 400:
            case 401:
                authmonInApp.logoutCommon();
				utils.showMessage('Error', "NOT Logged In. " + errorThrown , 'alert-error');
                break;
            //Other errors usually 500
            default:
				utils.showMessage('Error', 'An error has occured. ' + textStatus , 'alert-error');
            }
    },
// ----------------------------------- ajax functions ---------------------------------
    /**
     * Handles login click and other actions performed when logged in 
     */
    isLoggedIn: function(){
        var aUrl = "";
        aUrl='authmon/api/isLoggedIn';
        // ajax request
		$.ajax({
			type: 'POST', 
			cache: false,
            async: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: aUrl,
			dataType: "json",
			data: JSON.stringify([{'name':'uid','value': ''}]),
			success: function(data) {
                authmonInApp.loginCommon(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
			    authmonInApp.logoutCommon();
				//authmonInApp.ajaxError(jqXHR, textStatus, errorThrown,true);
			}
		});	
    },
    /**
     * Handles renew token action
     */
    renewToken: function(){
        //dataIn = {"token":localStorage.token};
        // ajax request
		$.ajax({
			type: 'POST', 
			cache: false,
			async: false,
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: 'authmon/api/renewToken',
			dataType: "json",
			success: function(data) {
                authmonInApp.loginCommon(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonInApp.logoutCommon();
				//authmonInApp.ajaxError(jqXHR, textStatus, errorThrown,true);
			}
		});	
    }
}
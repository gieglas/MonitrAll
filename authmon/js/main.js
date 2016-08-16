var ajaxRunCount = 0;
var ENTER_KEY = 13;
var ESC_KEY = 27;
var tokenobj=null;
var tokenSetDate=new Date();
var redirectTo=null;
/**
 * Main class for login
 */

var authmonApp = {
    /**
     * init Function
     */ 
    init: function() {
        //check if can access localstorage
        if(typeof(Storage) == "undefined") {
            alert('Browser does not support.');
            return null;
        }
		// Get the redirect to 
		redirectTo= utils.getParameterByName('r');
		
        //check if logged in show details package
        if (localStorage.token) {
            //set tokenobj
            //tokenobj= JSON.parse(Base64.decode(localStorage.token.split('.')[1]));
            authmonApp.isLoggedIn();
        //if not logged in show login page
        } else {
            authmonApp.logoutCommon();
            var html = authmonApp.getTmpl('login');
            $('#signIn_frm' ).parsley();
            $("#containerdiv").html(html);
        }
        authmonApp.bindEvents();
    },
// ----------------------------------- templates ---------------------------------
    /**
     * Get template
     */
    getTmpl:function(tmplStr){
        return $('#'+tmplStr+'tmpl').html();
    },
// ----------------------------------- Bindings router ---------------------------------
    /**
     * Bind page events
     */
    bindEvents : function () {
        //Bindings on signin page
		$('#signIn_frm').on('click','#loginBtn',this.loginClick);
		$('#signIn_frm').on('keypress', 'input', this.loginKeyUp );
		
		//Bindings on the signed in  pages
		$('#form-signed').on('click','.clickAction',this.router);
		$('#changedetailsform').on('keypress', 'input', this.changeLoggedinKeyUp );
		$('#changepassform').on('keypress', 'input', this.changeLoggedinKeyUp );
		$('#newuserform').on('keypress', 'input', this.changeLoggedinKeyUp );
		$('#edituserform').on('keypress', 'input', this.changeLoggedinKeyUp );
		$('#newgroupadminform').on('keypress', 'input', this.changeLoggedinKeyUp );
		$('#editgroupadminform').on('keypress', 'input', this.changeLoggedinKeyUp );		
    },
	/**
	* Show modal and sets the uid and action in the ok button 
	*/
	showForm: function (uid,action) {
		$('#okModal').data('uid',uid);
		$('#okModal').data('action',action);
		$('#modalGeneral').modal();
	},
	/**
	* Closes the modal
	*/
	closeForm: function () {
		$('#modalGeneral').modal('hide');
	},
	/**
	* Ok modal. Handles events related to confirmation from modal form.
	*/
	okModal: function () {
        switch($(this).data('action')) {
            case "groupdelete":
                //set data 
                arr=[{'name':'uid','value': $(this).data('uid')}];
                //do action 
                authmonApp.doForms('groupdelete',arr, 'grouplist');
                break;
            case "userdelete":
                //set data 
                arr=[{'name':'uid','value': $(this).data('uid')}];
                //do action 
                authmonApp.doForms('userdelete',arr, 'userlist');
                break;
        }
		return null;
	},
    /**
    * Handles ENTER_KEY on login form
    */
    loginKeyUp: function(e){
        if ( e.which === ENTER_KEY ) {		
			//simulate click event on OK	
			authmonApp.loginClick();
			return false;
		}
    },
    /**
    * Handles ENTER_KEY on rest of the forms
    */
    changeLoggedinKeyUp: function(e){
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
        //autorenew token
        if (((tokenobj.refreshin-(new Date() - tokenSetDate) / 1000 /60) < 0) &&  (this.id!="logoutBtn")) {
            authmonApp.renewToken();
        }
        switch (this.id){
            case "logoutBtn":
                //logout and reload
                authmonApp.logoutCommon();
                authmonApp.init();
                break;
            case "changepass":
            case "changedetails":
            case "grouplist":
            case "userlist":
            case "newuser":
            case "newgroup":
            case "groupedit":
            case 'useredit':
                authmonApp.isLoggedIn(this.id,$(this).data('uid'));
                break;
            case "userhomeBtn":
                authmonApp.init();
                break;
			case 'userresertpass':
				//set data 
                arr=[{'name':'uid','value': $(this).data('uid')}];
                //do action 
                authmonApp.doForms('userresertpass',arr);
				break;
            case "dochangedetails":
                if ($('#changedetailsform').parsley('validate')){
                    arr = $('#changedetailsform').serializeArray();
                    //get the array of data from the form
                    authmonApp.doForms('dochangedetails',arr);
                }
                break;
            case "doeditgroup":
                if ($('#editgroupadminform').parsley('validate')){
                    arr = $('#editgroupadminform').serializeArray();
                    //get the array of data from the form
                    authmonApp.doForms('doeditgroup',arr, 'grouplist');
                }
                break;
            case "donewuser":
                if ($('#newuserform').parsley('validate')){
                    arr = $('#newuserform').serializeArray();
                    //get the array of data from the form
                    authmonApp.doForms('donewuser',arr,'userlist');
                    //alert('test');
                }
                break;
            case "doedituser":
                if ($('#edituserform').parsley('validate')){
                    arr = $('#edituserform').serializeArray();
                    //get the array of data from the form
                    authmonApp.doForms('doedituser',arr,'userlist');
                }
                break;
            case "donewgroup":
                if ($('#newgroupadminform').parsley('validate')){
                    arr = $('#newgroupadminform').serializeArray();
                    //get the array of data from the form
                    authmonApp.doForms('donewgroup',arr,'grouplist');
                }
                break;
            case "grouprights":
                authmonApp.isLoggedIn(this.id,$(this).data('uid'));
                break;
            case "doeditgrouprights": 
                arr = $('#editgrouprightsform').serializeArray();
                //get the array of data from the form
                var uid=$(this).data('uid');
                //alert('test ' + uid);
                var mewArr=[arr,uid];
                authmonApp.doForms('doeditgrouprights',mewArr);
                break;
            case "groupdelete":
                authmonApp.showForm($(this).data('uid'),'groupdelete');
                break;
            case "userdelete":
                authmonApp.showForm($(this).data('uid'),'userdelete');
                break;
            case "dochangepass":
                if ($('#changepassform').parsley('validate')){
                    if ($('#input_password_new').val() != $('#input_password_repeat').val() ) {
                        utils.showMessage('Error', 'New Password and repeat password are not the same. ', 'alert-error');
                    } else {
                        arr = $('#changepassform').serializeArray();
                        //get the array of data from the form
                        authmonApp.doForms('dochangepass',arr);   
                    }
                }
                break;
            
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
            //var decodetoken=Base64.decode(data.token.split('.')[1]);
            //console.log(decodetoken);
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
        utils.closeMessage();
    },
    /**
     * Ajax errors returned (not status 200)
     */ 
    ajaxError: function (jqXHR, textStatus, errorThrown,doInit){
       switch (jqXHR.status) {
            //Authorization Codes 
            case 400:
            case 401:
                authmonApp.logoutCommon();
                if (doInit) { authmonApp.init();}
				utils.showMessage('Error', "NOT Logged In. " + errorThrown , 'alert-error');
                break;
            //Other errors usually 500
            default:
				utils.showMessage('Error', 'An error has occured. ' + textStatus , 'alert-error');
            }
    },
// ----------------------------------- ajax functions ---------------------------------
    /**
     * Handles login click
     */
    loginClick: function(){
        if ($('#signIn_frm').parsley('validate')){
            dataIn = {"username":$('#login_input_username').val(),"password":$('#login_input_password').val()};
            // ajax request
            $.ajax({
                type: 'POST', 
                cache: false,
                contentType: 'application/json',
                url: 'api/login',
                dataType: "json",
                data: JSON.stringify(dataIn),
                success: function(data) {
                    //IS LOGGED IN 
                    authmonApp.loginCommon(data);
                    utils.showMessage('Success', 'Logged in succesfully','alert-success');
                    //check if redirectto is set
                    if ((redirectTo !== '') && (redirectTo !== null)) {
                        window.location.replace(redirectTo);
                        return null;
                    }
                    authmonApp.init();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    var data=JSON.parse($.trim(jqXHR.responseText));
                    if (data["feedback"] == "Locked") {
                        authmonApp.logoutCommon();
                        utils.showMessage('Error', "User Is LOCKED. Please wait a while and try again." , 'alert-error');
                    } else {
                        authmonApp.ajaxError(jqXHR, textStatus, errorThrown,false);
                    }
                }
            });
        }
    },
    /**
     * Handles all form ajax actions
     * 
     */
    doForms: function(formActions=null,dataIn=null,returnAction=null) {
        var aUrl = "";
        switch (formActions) {
            case 'dochangedetails':
                aUrl='api/do/changeDetails';
                break;
            case 'dochangepass':
                aUrl='api/do/changePassword';
                break;
            case 'doedituser':
                aUrl='api/do/changeUserById';
                break;
            case 'doeditgroup':
                aUrl='api/do/changeGroupById';
                break;
            case 'donewgroup':
                aUrl='api/do/addNewGroup';
                break;
            case 'groupdelete':
                aUrl='api/do/deleteGroupById';
                break;
            case 'donewuser':
                aUrl='api/do/addNewUser';
                break;
            case 'userdelete':
                aUrl='api/do/deleteUserById';
                break;
            case 'doeditgrouprights':
                aUrl='api/do/updateGroupRights';
                break
			case 'userresertpass':
				aUrl='api/do/resetPassword';
                break
        }
        
        $.ajax({
			type: 'POST', 
			cache: false,
            contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: aUrl,
			dataType: "json",
			data: JSON.stringify(dataIn),
			success: function(data) {
                authmonApp.closeForm();
                switch (formActions) {
                    //change details
                    case 'dochangedetails':
                        utils.showMessage('Success', 'Success','alert-success');
                        authmonApp.renewToken();
						break;
					//change details
                    default:
                        if (returnAction!==null) {
                            authmonApp.isLoggedIn(returnAction,"",false);
                        }
                        utils.showMessage('Success', 'Success','alert-success');
                }
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonApp.closeForm();
				if (jqXHR.status == 400) {
                    var data=JSON.parse($.trim(jqXHR.responseText));
                    utils.showMessage('Error', data["feedback"],'alert-error');
				} else {
                    authmonApp.ajaxError(jqXHR, textStatus, errorThrown,true);
				}
			}
        });
    },
    /**
     * Handles login click and other actions performed when logged in 
     */
    isLoggedIn: function(loginAction=null,uid="",clearMessage=true){
        var aUrl = "";
        switch (loginAction) {
            case 'changedetails':
                aUrl='api/get/getDetails';
                break;
            case 'userlist':
                aUrl='api/get/getUsers';
                break;
            case 'grouplist':
            case 'newuser':
                aUrl='api/get/getGroups';
                break;
            case 'groupedit':
                aUrl='api/get/getGroupById';
                break;
            case 'useredit':
                aUrl='api/get/getUserById';
                break;
            case 'grouprights':
                aUrl='api/get/getGroupRightsById';
                break;
            default:
                aUrl='api/isLoggedIn';
        }
        // ajax request
		$.ajax({
			type: 'POST', 
			cache: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: aUrl,
			dataType: "json",
			data: JSON.stringify([{'name':'uid','value': uid}]),
			success: function(data) {
                var template = '';
                //get temmplate 
                switch (loginAction) {
                    case 'changepass':
                    case 'changedetails':
                    case 'newuser':
                    case 'grouplist':
                    case 'userlist':
                    case "newgroup":
                    case 'groupedit':
                    case 'useredit':
                    case 'grouprights':
                        //get appropriate Mustache template
                        template = authmonApp.getTmpl(loginAction);
                        break;
                    default:
                    //simple isLoggedIn action
                        if (tokenobj===null) {
                            tokenobj=data;
                        }
                        template = authmonApp.getTmpl('loggedin');
                    }
                
                //set the data for Mustache template
                var mustacheData={name:tokenobj.name,
                                    isAdmin:function () {return (tokenobj.isAdmin=="1"?true:false)},
                                    uid:uid,
                                    data:data
                };
                if (loginAction == 'grouprights') {
                    mustacheData.isRights= function () {return (this.has_right==1);}
                }
                //render the Mustache template 
                var html = Mustache.render(template, mustacheData);
                $("#containerdiv").html(html);
                //enable any datatables 
                if (mustacheData.data.length > 0) {
                    $('.table').dataTable({"bLengthChange": true, "iDisplayLength": 25});
                }
                //bind client events
                authmonApp.bindEvents();
                
                //set default values for radio and select  
                switch (loginAction) {
                    case 'groupedit':
                        //$('input:radio[name='+data.form.fields[i].id+']').val([data.form.fields[i].default_value]);
                        $('#enabled').val(data[0].enabled);
                        break;
                    case 'useredit':
                        //$('input:radio[name='+data.form.fields[i].id+']').val([data.form.fields[i].default_value]);
                        $('#is_ldap').val(data.user.is_ldap);
                        $('#group_id').val(data.user.group_id);
                        $('#is_admin').val(data.user.is_admin);
                        $('#enabled').val(data.user.enabled);
                        break;
                    case 'groupedit':
                        $('#enabled').val(data.user.enabled);
                        break;
                    }
                if (clearMessage) { utils.closeMessage();}
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonApp.ajaxError(jqXHR, textStatus, errorThrown,true);
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
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: 'api/renewToken',
			dataType: "json",
			success: function(data) {
                authmonApp.loginCommon(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonApp.ajaxError(jqXHR, textStatus, errorThrown,true);
			}
		});	
    }
}


$(document).ready(function () {
    authmonApp.init();
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
	$('#modalGeneralFooter').on('click','#cancelModal',authmonApp.closeForm);
	$('#modalGeneralFooter').on('click','#okModal',authmonApp.okModal);
});
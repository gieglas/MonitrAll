/**
 * MonitrAll - Monitor anything 
 *
 * @author      Constantinos Evangelou <gieglas@gmail.com>
 * @copyright   2013-2017 Constantinos Evangelou
 * @link        http://_________
 * @license     The MIT License (MIT)
 * @version     2.1
 *
 * MIT LICENSE
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2013 Constantinos Evangelou
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *  
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * appMonitor
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since Version 1.0
 * @since Version 2.0 Added support for authmon. 
 */

//create the app object. all classes and objects to be created under app Object
var MonitorAllApp = MonitorAllApp || {};
var ENTER_KEY = 13;
var ESC_KEY = 27;
var ajaxRunCount = 0;
var previousFlotPoint = 0;
var currentResultData = null;
//---------------------Model----------------------------------------------------------------------
var resultsGroupsModel = {
	groupsData : null,
	frontPageData: null,
	tempServiceData: null,
	dashData:null,
		
	//function to return a specific item object using the index
	getItemByIndex : function(itemIndex){
		return this.itemsData[itemIndex];
	},
	//function to return a specific item object using the index
	getGroupByIndex : function(itemIndex){
		return this.groupsData[itemIndex];
	},
	//:TODO could use an index to improve perfomance 
	//get the index of the group in the listsGroup array
	getGroupIndexById: function(group_id) {
		for(var i = 0; i < this.groupsData.length; i++){
			if(this.groupsData[i].id == group_id){
				return i;
			}
		}
	},
	//get the item object in the groupsData array
	getItemById: function(item_id) {
		//for all groups
		for(var i = 0; i < this.groupsData.length; i++){
			//for all items in groups
			for(var j = 0; j < this.groupsData[i].items.length; j++){
				if (this.groupsData[i].items[j].id == item_id){
					return this.groupsData[i].items[j];
				}
			}
		}
		//if nothing is found
		return null;
	},
	//get the group object in the groupsData array
	getGroupById: function(group_id) {
		for(var i = 0; i < this.groupsData.length; i++){
			if(this.groupsData[i].id == group_id){
				var obj = this.groupsData[i];
				obj.index_i = i;
				return obj;
			}
		}
	},
	//get the front page items
	getFrontPageItems: function(){
		var k = 0;
		var frontPageArray = [];
		//for all groups
		for(var i = 0; i < this.groupsData.length; i++){
			//for all items in groups
			for(var j = 0; j < this.groupsData[i].items.length; j++){
				//if frontpage
				if (this.groupsData[i].items[j].frontpage == 1) {
					frontPageArray[k] = this.groupsData[i].items[j];
					k++;					
				}
			}
		}
		//set frontPageData 
		this.frontPageData = frontPageArray;
	},
	//get the dashboard object in the dashData array
	getDashById: function(dash_id) {
		for(var i = 0; i < this.dashData.length; i++){
			if(this.dashData[i].id == dash_id){
				var obj = this.dashData[i];
				return obj;
			}
		}
	}

}
//---------------------Router---------------------------------------------------------------------
var appRouter = {
	//all things needed to initialize the views
	//------------------INIT-----------------------------
	init: function() {
        // Client-side routes    
        Sammy(function() {
            //home
            this.get('#home', function() {
                MonitorAllApp.currentParams = [];
                appRouter.doHome(null);
            });
			//login
			this.get('#login', function() {
				window.location.replace('authmon/?r=../');
			});
			//dashboard
			this.get('#dashboards/:dashid', function() {
				MonitorAllApp.currentParams = [];
                appRouter.doHome(this.params.dashid);				
			});
			//results with Name -----------
			this.get('#results/:iteminid', function() {
                var dataIn=[];
                //get parameteres (for filtering)
                for (var param in this.params.toHash()) {
                    //other than the iteminid
                    if (param != 'iteminid') {
                        dataIn.push({"name":param,"value":this.params[param]});
                    }
                }
                //set parameters to be used in other functions
                MonitorAllApp.currentParams = dataIn;
                //call doResults with only 2 agruments
                appRouter.doResults(this.params.iteminid,dataIn);
			}); 
			//--------------------------------------
            //results
            /*this.get('#results/:groupIndexId/:itemIndexId', function() {
                var dataIn=[];
                //get parameteres (for filtering)
                for (var param in this.params.toHash()) {
                    //other than the groupid and itemid
                    if ((param != 'groupIndexId') && (param != 'itemIndexId')){
                        dataIn.push({"name":param,"value":this.params[param]});
                    }
                }
                //set parameters to be used in other functions
                MonitorAllApp.currentParams = dataIn;
                appRouter.doResults(this.params.groupIndexId,this.params.itemIndexId,dataIn);
            });*/
            //filter results 
            //this.get('#results/:groupIndexId/:itemIndexId/:filterName', function() {
            this.get('#results/:iteminid/:filterName', function() {
                var dataIn=[];
                //add in data in the filtername first
                dataIn.push({"name":"filterName","value":this.params.filterName});
                //get parameteres (for filtering)
                for (var param in this.params.toHash()) {
                    //other than the iteminid
                    if (param != 'iteminid') {
                        dataIn.push({"name":param,"value":this.params[param]});
                    }
                }
                
                //set parameters to be used in other functions
                MonitorAllApp.currentParams = dataIn;
                //call doResults with only 2 agruments
                appRouter.doResults(this.params.iteminid,dataIn);
            });
            //about
            this.get('#about', function() {
                MonitorAllApp.currentParams = [];
                //hide any messages from previous actions
                utils.closeMessage();
                utils.hideModal();
                alert( 'this is about');            
            });
            //default
            this.get('', function() { this.app.runRoute('get', '#home') });
        }).run();
	},
	//------------------ACTIONS FUNCTIONS-----------------------------
	doHome: function (dashId) {
		//chech if ajax is running
		if (ajaxRunCount <= 0) {
			//frontpage
			if (dashId == null){
				//DEBUG: alert('this is home');
				//hide any messages from previous actions
				utils.closeMessage();
				utils.hideModal();
				//render the breadcrumb
				resultsViews.renderBreadcrumbs({"parents":[],"current":"Home"});  
				//get data with ajax
				appRouter.getResultsGroupList();
				//Clear Content
				$("#modulex").html("");		
				//render the front commons
				resultsViews.renderModuleFrontCommon(resultsGroupsModel.frontPageData);
				//for all front page data
				for(var i = 0; i < resultsGroupsModel.frontPageData.length; i++){
					appRouter.getResults(resultsGroupsModel.frontPageData[i].group_index_num,resultsGroupsModel.frontPageData[i].index_num,true,[])
				}
			//dashboard
			} else {				
				//hide any messages from previous actions
				utils.closeMessage();
				utils.hideModal();
				if (resultsGroupsModel.groupsData == null) {
					appRouter.getResultsGroupList();
				}
				var dashItem=resultsGroupsModel.getDashById(dashId);
				//hack for index_nums
				for (var i = 0; i < dashItem.items.length; i++){
					dashItem.items[i].group_index_num = resultsGroupsModel.getItemById(dashItem.items[i].result_id).group_index_num;
					dashItem.items[i].index_num = resultsGroupsModel.getItemById(dashItem.items[i].result_id).index_num;
				}
				//if the model data re not filled fill them 
				//render the breadcrumb
				resultsViews.renderBreadcrumbs({"parents":[{"name":"Home","url":"#"}],"current":dashItem.name});
				//get data with ajax
				appRouter.getResultsGroupList();
				//set activeList on sidebar element
				$(".activeList").removeClass("activeList");
				$('#accordionDashboards'+dashId).addClass('activeList');	
				//accordeon open hack
				$(".in").removeClass("in");
				$('#collapseDashboards').addClass('in');	
				//Clear Content
				$("#modulex").html("");	
				//render the front commons
				resultsViews.renderModuleDashCommon(dashItem);
				//for all front page data
				for(var i = 0; i < dashItem.items.length; i++){
					appRouter.getResults(dashItem.items[i].group_index_num,dashItem.items[i].index_num,true,[])
				}
			}
		}else {
            utils.showMessage('Info', 'System is still processing previous request', 'alert-info');
        }		
	}, 
	doResults: function(arg1,arg2) {
        //the function can be called as follows :
        // doResults(resultId,dataIn)
        var groupIndexId = null;
        var itemIndexId = null;
        var dataIn =null;

		//chech if ajax is running
		if (ajaxRunCount <= 0) {
			//DEBUG: alert( 'this is results' + groupIndexId + ' ' + itemIndexId); 
            //hide any messages from previous actions
            utils.closeMessage();
            utils.hideModal();
            //if the model data re not filled fill them 
            if (resultsGroupsModel.groupsData == null) {
                appRouter.getResultsGroupList();
            }
            
            //get groupIndexId and itemIndexId from the id that was passed
            var inItem=resultsGroupsModel.getItemById(arg1);
            groupIndexId = inItem.group_index_num;
            itemIndexId = inItem.index_num;
            dataIn = arg2;
            
            //render the breadcrumb
            //:TODO better breadcrumb
            breadcrumbData={"parents":[{"name":"Home","url":"#"}],"current":resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].name}
			resultsViews.renderBreadcrumbs(breadcrumbData);
			//set activeList on sidebar element
			$(".activeList").removeClass("activeList");
			$('#accordion'+groupIndexId+itemIndexId).addClass('activeList');	
			//accordeon open hack
            $(".in").removeClass("in");
			$('#collapse'+groupIndexId).addClass('in');	
			//render the modules commons , name desc etc
			resultsViews.renderModuleCommon(resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId]);
            //finally get data with ajax
            appRouter.getResults(groupIndexId,itemIndexId,false,dataIn);  
		}else {
            utils.showMessage('Info', 'System is still processing previous request', 'alert-info');
        }			
	},
	doForm: function(groupIndexId,itemIndexId,formIndexId,scope,lineid){
		//chech if ajax is running
		if (ajaxRunCount <= 0) {			
			var formData = {"form":null,"group_index_num":null,"item_index_num":null,"lineid":null};
			//define form scope
			if (scope == "results") {
				formData.form = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].forms[formIndexId];
			} else if (scope == "line") {
				formData.form= resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms[formIndexId];
			}
			//first check if the form has filter_auto
			//----------------FILTER_AUTO--------------
			if ((formData.form.filter_auto == 1) && (formData.form.type == "filter") ) {
				var dataIn = [];
				//add lineid if exists
				if (lineid) {
						dataIn.push({"name":"lineid","value":lineid});
				}
				var targetForm  = "";
				//get form target based on scope
                if (scope == "results") {
                    targetForm = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].forms[formIndexId];	
                } else if (scope == "line") {
                    targetForm = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms[formIndexId];
                }			
                //get targetItem
				var targetItem = resultsGroupsModel.getItemById(targetForm.target);
				//perform filter without showing the form
				appRouter.doFilter(targetItem.group_index_num,targetItem.index_num,targetForm.id,dataIn);
			} //----------------RENDER FORM--------------
			else {
				//find if any of the data has options_url and get options
				for(var i = 0; i < formData.form.fields.length; i++){
					if (formData.form.fields[i].option_url) {
						//get the options from ajax
						appRouter.getServiceData(formData.form.fields[i].option_url,[]);
						formData.form.fields[i].options = resultsGroupsModel.tempServiceData;
					}
				}
				//----------------------------------------------------
				//find if any of the forms has "default_values_url" and get the defaults
				var formDefaults = null;			
				if (formData.form.default_values_url) {
					var formDefaultsDataIn =[];
					if (lineid) {
						formDefaultsDataIn.push({"name":"lineid","value":lineid});
					}
					appRouter.getServiceData(formData.form.default_values_url,formDefaultsDataIn);
					formDefaults = resultsGroupsModel.tempServiceData;
					//get result headers from json object 
					var headers = utils.getHeaders(formDefaults);
					//for all values returned by formDelfaults 
                    for(var i = 0; i < headers.length; i++){
						//for all fields in form object
						for(var j = 0; j < formData.form.fields.length; j++){
							//if the header of the result is same as the id of the filed
							//set the default value						
							if (formData.form.fields[j].id == headers[i]) {
								formData.form.fields[j].default_value = formDefaults[0][headers[i]];
							}
						}
					}
				}
				
				//----------------------------------------------------
				//prepare data with groupindexid and itemid
				formData.group_index_num = groupIndexId;
				formData.item_index_num = itemIndexId;			
				//add line id if applicable
				formData.lineid = lineid;
				resultsViews.renderForm(formData);			 
			}
			
		}else {
            utils.showMessage('Info', 'System is still processing previous request', 'alert-info');
        }
	},
	doFilter:function(groupIndexId,itemIndexId,formId,dataIn){
	    
		var location_url="#results/"+resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].id+(dataIn.length>0?"/"+formId:"");		
		for(var i = 0; i < dataIn.length; i++){
            location_url+=(i==0?'?':'&')+dataIn[i].name+'='+dataIn[i].value;
		}
		window.location=location_url;
	},
	//------------------AJAX FUNCTIONS-----------------------------
	getServiceData: function(url,dataIn) {
		// ajax request
		//:TODO loading msg	
		$.ajax({
			type: 'post',
			cache: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: url, //use the api
			//this is a special case. This ajax call gets the data for our
			// model so it need to finish before we can do anything else
            async: false,
			dataType: "json",
			data: JSON.stringify(dataIn),
			success: function(data) {
				//update the model
				resultsGroupsModel.tempServiceData = data;
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonInApp.ajaxError(jqXHR, textStatus, errorThrown);
			}
		});
	},	
	getResultsGroupList:function () {		
		//login: renew token
        authmonInApp.renewTokenCommon();
		// ajax request
		//:TODO loading msg	
		$.ajax({
			type: 'GET',
			cache: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: 'api/getResultsGroupList', //use the api
			//this is a special case. This ajax call gets the data for our
			// model so it need to finish before we can do anything else
            async: false,
			dataType: "json",
			success: function(data) {
				//use global response function				
				appRouter.responseResponse('getResultsGroupList',data,null,null,null,null);
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonInApp.ajaxError(jqXHR, textStatus, errorThrown);
			}
		});			
    },
    getResults:function(groupIndexId,itemIndexId,isFront,dataIn){
        //login: renew token
        authmonInApp.renewTokenCommon();
        // ajax request
		$.ajax({
			type: 'POST',
			cache: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			//----------------------use js Model data to find the ID of the result (from the config)
			url: 'api/getResults/' + resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].id, //use the api
			dataType: "json",
			data: JSON.stringify(dataIn),
			//async:(isFront?false:true),
			success: function(data) {
				//use global response function				
				appRouter.responseResponse('getResults',data,groupIndexId,itemIndexId,null,isFront);				
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonInApp.ajaxError(jqXHR, textStatus, errorThrown);
			}
		});		
    },
    /*processForm:function(groupIndexId,itemIndexId,formIndexId,dataIn){
        //login: renew token
        authmonInApp.renewTokenCommon();
        //ajax request		
		$.ajax({
			type: 'POST',
			cache: false,
			contentType: 'application/json',
			url: 'api/processForm',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			dataType: "json",
			data: JSON.stringify(dataIn),
			success: function(data) {				
				//use global response function				
				appRouter.responseResponse('processForm',data,null,null,null,null);
			},
			error: function(jqXHR, textStatus, errorThrown){
				utils.showMessage('Error', 'An error has occured while adding. ' + textStatus , 'alert-error');
				utils.hideModal();
			}
		});
    },*/
    syncServices:function(dataIn,groupIndexId,itemIndexId,formIndexId,isFront) {
        //login: renew token
        authmonInApp.renewTokenCommon();
        
        //ajax request		
		$.ajax({
			type: 'POST',
			cache: false,
			contentType: 'application/json',
			headers: {"Authorization": "Bearer "+ localStorage.token},
			url: 'api/syncServices/' + resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].id, //use the api
			dataType: "json",
			data: JSON.stringify(dataIn),
			success: function(data) {		
				//for all responces		
				for(var i = 0; i < data.length; i++){
				//use global response function				
				appRouter.responseResponse(data[i].name,data[i].data,groupIndexId,itemIndexId,formIndexId,isFront);
				}				
			},
			error: function(jqXHR, textStatus, errorThrown){
				authmonInApp.ajaxError(jqXHR, textStatus, errorThrown);
				utils.hideModal();
			}
		});
    },
    //------------------RESPONSE FUNCTIONS-----------------------------
    responseResponse:function(name,data,groupIndexId,itemIndexId,formIndexId,isFront) {
        currentResultData = data;
        switch (name) {
            case 'getResultsGroupList':
                //update the model
				resultsGroupsModel.groupsData = data.groups;
				resultsGroupsModel.dashData = data.dashboards;
				resultsGroupsModel.getFrontPageItems();
				//render the view
				resultsViews.renderResultsSideBar(data);
            break;
            case 'getResults':
                //render the view
				//depending on the ui_type render the correct view
				//DEBUG: alert(resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].ui_type);
				switch (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].ui_type)
				{
				case 'Percent':
                    resultsViews.renderModuleDataConditionals(data,'Percent',groupIndexId,itemIndexId,isFront);
					break;
				case 'Table':
					resultsViews.renderModuleDataTable(data,groupIndexId,itemIndexId,isFront);
					break;
				case 'Details':
					resultsViews.renderModuleDataDetails(data,groupIndexId,itemIndexId,isFront);
					break;
				case 'Boxes':
					resultsViews.renderModuleDataConditionals(data,'Boxes',groupIndexId,itemIndexId,isFront);
					break;
				case 'ConditionTable':
					resultsViews.renderModuleDataConditionals(data,'ConditionTable',groupIndexId,itemIndexId,isFront);
					break;
				case 'Todo':
					resultsViews.renderModuleDataConditionals(data,'Todo',groupIndexId,itemIndexId,isFront);					
					break;
				case 'LineChart':
					resultsViews.renderModuleDataCharts(data,'LineChart',groupIndexId,itemIndexId,isFront);
					break;
				case 'BarChart':
					resultsViews.renderModuleDataCharts(data,'BarChart',groupIndexId,itemIndexId,isFront);
					break;
				case 'FillChart':
					resultsViews.renderModuleDataCharts(data,'FillChart',groupIndexId,itemIndexId,isFront);
					break;
				case 'PieChart':
					resultsViews.renderModuleDataCharts(data,'PieChart',groupIndexId,itemIndexId,isFront);
					break;
				default:
					resultsViews.renderModuleDataSimple(data,groupIndexId,itemIndexId,isFront);
				}
				//no update fot the model needed
            break;
            case 'processForm':
                if (data.success) {
					utils.showMessage('Success', 'Form processed succesfully','alert-success');
					utils.hideModal();
				} else {
					utils.showMessage('Error', 'An error has occured.','alert-error');
					utils.hideModal();
				}				
				//alert(data);
            break;
        }
    }
}

//---------------------Views---------------------------------------------------------------------

//create the views object

var resultsViews = {

	//all things needed to initialize the views
	//------------------INIT-----------------------------
	init: function() {
		//bind events on dom
		this.bindEvents();
	},
	//------------------BIND EVENTS-----------------------------
	bindEvents : function () {
		//click on refresh
		$('#content').on('click','.refresh-button',this.refreshModuleClick);
		//click on csv download
		$('#content').on('click','.csv-button',this.csvDownloadClick);		
		//click on json download
		$('#content').on('click','.json-button',this.jsonDownloadClick);		
		//click on refresh front
		$('#content').on('click','.refresh-button-front',this.refreshFrontModuleClick);	
		//click on refresh dash
		$('#content').on('click','.refresh-button-dash',this.refreshDashModuleClick);	
		//click on show menu
		$('#content').on('click','#showmenu',this.showMenu);
		//load results form
		$('#content').on('click','.results-button',this.loadForm);			
		//load line form
		$('#content').on('click','.line-button',this.loadLineForm);	
	},
	//------------------EVENT FUNCTIONS-----------------------------
	showMenu: function(){		
        $('#content').toggleClass('span12 span9');			
        $('#sidebar').toggleClass('hide span3');
		return false;
	},
	refreshModuleClick: function() {
		// get the groupId and itemId
		var iteminid = $(this).data('id');	
		//:DEBUG alert('id:' + iteminid );
		appRouter.doResults(iteminid,MonitorAllApp.currentParams);
		return false;
	},
	csvDownloadClick: function() {
		//:TODO maybe server side would be better
		utils.downloadJSON2CSV.apply(this,[currentResultData, 'export.csv']);		
	},
	jsonDownloadClick: function() {
		//:TODO maybe server side would be better
		utils.downloadJSON.apply(this,[currentResultData, 'export.txt']);		
	},
	refreshFrontModuleClick: function() {		
		appRouter.doHome(null);
		return false;
	},
	refreshDashModuleClick: function() {
		// get dashId
		var dashId = $(this).data('dash');
		appRouter.doHome(dashId);
		return false;
	},
	loadForm: function (){
		// get the groupId and itemId
		var groupId = $(this).data('group');	
		var itemId = $(this).data('item');	
		var formId = $(this).data('form');	
		//:DEBUG alert('group:' + groupId + ' item:' + itemId + ' form:' + formId);
		appRouter.doForm(groupId,itemId,formId,"results",null);
		return false;
	},
	loadLineForm:function(){
		// get the groupId and itemId
		var groupId = $(this).data('group');	
		var itemId = $(this).data('item');	
		var formId = $(this).data('form');	
		//get line id 
		var lineid = $(this).data('lineid');
		//:DEBUG alertalert('group:' + groupId + ' item:' + itemId + ' form:' + formId);
		appRouter.doForm(groupId,itemId,formId,"line",lineid);
		return false;
	},
	formKeyUp: function(e) {
		//handle enter on form elements so that it does not submit form
		if (( e.which === ENTER_KEY ) && !($(this).is('textarea'))) {		
			//simulate click event on OK	
			$('#okModal').click();
			return false;
		}else if (e.which === ESC_KEY) {			
			resultsViews.closeForm();
		}
	},
	closeForm: function () {
		utils.hideModal();
	},
	okForm: function () {
		var formId = $(this).data('formid');	
		if ($('#'+formId).parsley('validate')){
			//obj = utils.serializeObject($('#'+formId));	
			//get arrat of all form elements			
			arr = $('#'+formId).serializeArray();			
			// get the group, item and form index num
			var groupnum = $(this).data('group');	
			var itemnum = $(this).data('item');	
			var formnum = $(this).data('form');
			//get line id if applicable
			var lineid = $(this).data('lineid');
			//get form scope
			var scope = $(this).data('formscope');
			//get form type 
			var formtype = $(this).data('formtype');
			//-----------------HANDLE FORM-----------------------
			if (formtype == "form") {
				//prepare form data
                //Use syncServices for synchronous process
                var syncServicesData = [];
                var syncService = {"data":null,"name":null};
                // define processForm service request
                syncService.name = "processForm"
                syncService.data = {"data":null,"name":null};
                syncService.data.data = arr;
                if (lineid) {
                    syncService.data.data.push({"name":"lineid","value":lineid});
                }
                //define form scope
                if (scope == "results") {
                    syncService.data.name = resultsGroupsModel.groupsData[groupnum].items[itemnum].forms[formnum].id;	
                } else if (scope == "line") {
                    syncService.data.name = resultsGroupsModel.groupsData[groupnum].items[itemnum].lineForms[formnum].id;
                }			
				//push service request to queue
				syncServicesData.push(syncService);
				// define getResults service request
				syncService = {"data":null,"name":null};
                syncService.name = "getResults";
                syncService.data = {"data":null,"name":null};
                syncService.data.name = resultsGroupsModel.groupsData[groupnum].items[itemnum].id;
                //set the current parameters
                syncService.data.data = MonitorAllApp.currentParams;
                //push service request to queue
				syncServicesData.push(syncService);	
				appRouter.syncServices(syncServicesData,groupnum,itemnum,formnum,false);
			//-----------------HANDLE FILTER-----------------------
			} else if (formtype == "filter") {
				var targetForm  = "";
				//get form target based on scope
                if (scope == "results") {
                    targetForm = resultsGroupsModel.groupsData[groupnum].items[itemnum].forms[formnum];	
                } else if (scope == "line") {
                    targetForm = resultsGroupsModel.groupsData[groupnum].items[itemnum].lineForms[formnum];
                }
                //get targetItem
				var targetItem = resultsGroupsModel.getItemById(targetForm.target);
				// if there is defined a line id add to the parameters
				if (lineid) {
                    arr.push({"name":"lineid","value":lineid});
                }
				appRouter.doFilter(targetItem.group_index_num,targetItem.index_num,targetForm.id,arr);
			}
			
		}		
		//utils.hideModal();		
	},
	//------------------RENDER FUNCTIONS-----------------------------
	renderForm:function(data){
		var _counter = 0;	
		var _counterc = 0;
		//get template from html
		var template =$('#formCommonTmpl').html();
		//add conditions to data
		//Extend the object with functions to decide what input type it is		
		data.isText= function () {return (this.type.toLowerCase() == "text"?true:false);};
		data.isPassword= function () {return (this.type.toLowerCase() == "password"?true:false);};
		data.isTextArea= function () {return (this.type.toLowerCase() == "textarea"?true:false);};		
		data.isSelect= function () {return (this.type.toLowerCase() == "select"?true:false);};
		data.isTypehead= function () {return (this.type.toLowerCase() == "typehead"?true:false);};
		//data.isDate= function () {return (this.type.toLowerCase() == "date"?true:false);};
		data.isCheckList= function () {return (this.type.toLowerCase() == "checklist"?true:false);};		
		data.isRadio= function () {return (this.type.toLowerCase() == "radio"?true:false);};		
		data.isRequired= function () {return (this.required != "0"?true:false);};
		//get the first radio button of the group. parsley only needs to add on the first
		data.isFirstRadio= function () {_counter++; return _counter == 1?true:false;};
		//get the first check list of the group. parsley only needs to add on the first
		data.isFirstChecklist= function () {_counterc++; return _counterc == 1?true:false;};
		//add check if line id
		data.hasLineId= function () {if (data.lineid) return true; else return false;};
		//render html using template and data
		var html = Mustache.render(template, data);		
		//set the html on the page
		$("#modalGeneral").html(html);		
		//bind events
		$('#modalGeneralFooter').on('click','#cancelModal',this.closeForm);		
		$('#modalGeneralFooter').on('click','#okModal',this.okForm);
		//key press on all form elements
		$('#modalGeneralBody').on( 'keypress', '.formInput', this.formKeyUp );		
		//set default options 
		for(var i = 0; i < data.form.fields.length; i++){
			if ( data.form.fields[i].type == 'select') {
				$('#'+data.form.fields[i].id).val(data.form.fields[i].default_value);
			} else if (data.form.fields[i].type == 'typehead') { 
				//typehead
				var datumObj = [];
				datumObj = data.form.fields[i].options;
				for (var j = 0; j < datumObj.length; j++){
					datumObj[j].tokens=datumObj[j].name.split(" ");
					datumObj[j].tokens.push(datumObj[j].value);
				}
				$('#'+data.form.fields[i].id).typeahead({
				name: '#'+data.form.fields[i].id,
				local:datumObj,
				template: 
				  '<p class="typehead-name">{{value}}</p><p class="typehead-description"><i class="{{icon}}"></i>{{name}}</p>'
				,
				limit: 50,
				engine: Hogan
                });
			} else if (data.form.fields[i].type == 'radio') { 
				$('input:radio[name='+data.form.fields[i].id+']').val([data.form.fields[i].default_value]);
			} else if (data.form.fields[i].type == 'checklist') {
				$('input:checkbox[name='+data.form.fields[i].id+']').val([data.form.fields[i].default_value]);
			}
		}		

		//parley
		$( '#'+data.form.id ).parsley();
		//Markdown with Pagedown
		// create a pagedown converter - regular and sanitized versions are both supported
		var converter = new Markdown.getSanitizingConverter();
		// tell the converter to use Markdown Extra
		Markdown.Extra.init(converter, {highlighter: "highlight"});
		$(".markdown").html(converter.makeHtml(data.form.description));
		utils.highlightCode();
		//load modal
		$('#modalGeneral').modal();
		//focus on the first input of the form
		$('#modalGeneral input:visible:enabled:first').focus();
		//DEBUG:  alert(html);
	},
	renderResultsSideBar: function (data) {		
		//get template from html
		var template =$('#resultsSideBarTmpl').html();
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$("#accordion1").html(html);
		//DEBUG: alert(html);
	},
	renderBreadcrumbs: function(data){
		//get template from html;
		var template =$('#breadcrumbsTmpl').html();
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$("#cbreadcrumb").html(html);
		//DEBUG:  alert(html);
	}, 
	renderModuleCommon: function(data){
		//get template from html
		var template =$('#moduleTmpl').html();
		//add function to get if the module has forms
		data.hasForms = function () {
				if (this.forms.length > 0) return true;
                 else return false;
			}
		data.hasIcon = function (){
				if (this.icon) return true;
                 else return false;
		}			
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$("#modulex").html(html);
		//Markdown with Pagedown		
		// create a pagedown converter - regular and sanitized versions are both supported
		var converter = new Markdown.getSanitizingConverter();
		// tell the converter to use Markdown Extra
		Markdown.Extra.init(converter, {highlighter: "highlight"});
		$(".module-description").html(converter.makeHtml(data.description));
		utils.highlightCode();
		//DEBUG:  alert(html);
	}, 
	renderModuleFrontCommon:function(data){
		//get template from html
		var template =$('#moduleFrontTmpl').html();
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$("#modulex").html(html);
		//DEBUG:  alert(html);
	},
	renderModuleDashCommon:function(data){
		//get template from html
		var template =$('#moduleDashTmpl').html();
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$("#modulex").html(html);
		//Markdown with Pagedown		
		// create a pagedown converter - regular and sanitized versions are both supported
		var converter = new Markdown.getSanitizingConverter();
		// tell the converter to use Markdown Extra
		Markdown.Extra.init(converter, {highlighter: "highlight"});
		$(".module-description").html(converter.makeHtml(data.description));
		utils.highlightCode();
		//DEBUG:  alert(html);
	},	
	renderModuleDataTable: function(data,groupIndexId,itemIndexId,isFront){
		/*get module id depending if is in front page*/
		var moduleId = '#module-data' + (isFront?groupIndexId+'_'+itemIndexId:'');
		//get table headers from json object 
		var headers = utils.getHeaders(data);
		//DEBUG: alert(headers);
		var headersLength = headers.length;
		//construct template from headers
		var template = '<table cellpadding="0" cellspacing="0" border="0" class="table "><thead><tr>';
		//fill in template the headers
		for(var i = 0; i < headersLength; i++){
			template = template +'<th>' + headers[i] + '</th>';
		}
		//for forms and not front
		if (!isFront) {
			template = template + '{{#hasForms}}<th></th>{{/hasForms}}';
		}		
		template = template + '</tr></thead><tbody>{{#data}}<tr>';
		//fill in template the data
        for(var i = 0; i < headersLength; i++){
            var classStr = "";
            // if column is value then change class depending to green red orange
            if (headers[i].toLowerCase() == 'value') {
                var classStr = ' class="{{#green}}box-success-clrs{{/green}} {{#red}}box-error-clrs{{/red}} {{#orange}}box-alert-clrs{{/orange}}"';
            }
			template = template +'<td'+classStr+'>{{' + headers[i] + '}}</td>';
		}
		//for forms and not front
		if (!isFront) {
			template = template + '{{#hasForms}}<td> {{#lineForms}}<a href="#" data-group="{{group_index_num}}" data-item="{{index_num}}" data-form="{{form_index_num}}" data-lineid="{{lineid}}" class="line-button"><span class="label label-info">{{#hasIcon}}<i class="{{icon}} icon-white"></i> {{/hasIcon}}{{name}}</span></a>{{/lineForms}}</td>{{/hasForms}}';
		}
		template = template + '</tr>{{/data}}</tbody></table>';
		//----------------------------------------------------
		
		
		
		//add conditions to data
		//Extend the object with functions to decide if green, red or orange
		//default is false in case there is nothing in the config
		var newData = {data: [], 
					   lineForms: [],
					//extend groupnum and indexnum to be used in forms
					group_index_num:function () {return groupIndexId},
					index_num: function () {return itemIndexId},
					//extent functions
					green: function () {return false;},
					red: function () {return false;},
					orange: function () {return false;},
					front: function () {return isFront},
					notFront: function () {return !isFront},
					hasForms: function () {if (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms.length > 0) return true;
						else return false;},
					hasIcon: function () {if (this.icon) return true;
						else return false;}};
		newData.data = data; 	
		//add line forms
		newData.lineForms = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms;		
		//conditions
		//if green condition exist ... red orange respectevily
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_value)) {
				//change the function to represent the condition 
				newData.green=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_value)) return true};
			} 
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_value)) {
				newData.orange=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_value)) return true};
			}
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_value)) {
				newData.red=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_value)) return true};
			}
		data = newData;
		
		
		
		//DEBUG: alert (template);
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$(moduleId).html(html);
		//DEBUG:  alert(html);
		//datatable
		if ((data.data.length > 0) && (!isFront)){
			$('.table').dataTable({"bLengthChange": true, "iDisplayLength": 25,"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
		}		
	},
	renderModuleDataDetails: function(data,groupIndexId,itemIndexId,isFront){
		/*get module id depending if is in front page*/
		var moduleId = '#module-data' + (isFront?groupIndexId+'_'+itemIndexId:'');
		//get table headers from json object 
		var headers = utils.getHeaders(data);
		//DEBUG: alert(headers);
		var headersLength = headers.length;
		//construct template from headers
		var template = '';		
		template = template +'<table cellpadding="0" cellspacing="0" border="0" class="tableDetails "><tbody>{{#.}}';
		//for forms and not front
		if (!isFront) {
			template = template + '{{#hasForms}}<tr><td>{{#lineForms}}<a href="#" data-group="{{group_index_num}}" data-item="{{index_num}}" data-form="{{form_index_num}}" data-lineid="{{lineid}}" class="line-button"><span class="label label-info">{{#hasIcon}}<i class="{{icon}} icon-white"></i> {{/hasIcon}}{{name}}</span></a>{{/lineForms}}</td><td></td></tr>{{/hasForms}}';
		}
		//fill in template the headers and fill in template the data
		for(var i = 0; i < headersLength; i++){
			template = template +'<tr><td class="tableDetailsTitle"><b>' + headers[i] + '</b></td><td class="details-markdown">{{' + headers[i] + '}}</td></tr>';
		}		
		template = template + '<tr class="tableDetailsTr"><td></td><td>&nbsp;</td></tr>{{/.}}</tbody></table><hr>';
		//----------------------------------------------------
		//add line forms
		data.lineForms = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms;		
		//add form functions 
		data.hasForms = function () {if (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms.length > 0) return true;
						else return false;};
		data.hasIcon = function () {if (this.icon) return true;
						else return false;};
		data.group_index_num = function () {return groupIndexId};
		data.index_num = function () {return itemIndexId};
		//DEBUG: alert (template);
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$(moduleId).html(html);
		//DEBUG:  alert(html);		
		//Markdown with Pagedown
		// create a pagedown converter - regular and sanitized versions are both supported
		var converter = new Markdown.getSanitizingConverter();
		// tell the converter to use Markdown Extra
		Markdown.Extra.init(converter, {highlighter: "highlight"});
		$( ".details-markdown" ).each(function( index ) {
			$(this).html(converter.makeHtml($(this).html()));
		});
		utils.highlightCode();
		
	}, 
	renderModuleDataSimple: function(data,groupIndexId,itemIndexId,isFront){
		/*get module id depending if is in front page*/
		var moduleId = '#module-data' + (isFront?groupIndexId+'_'+itemIndexId:'');
		//get table headers from json object 
		var headers = utils.getHeaders(data);
		//DEBUG: alert(headers);
		var headersLength = headers.length;
		//construct template from headers
		var template = '{{#.}}';
		//fill in template the headers and values
		for(var i = 0; i < headersLength; i++){
			template = template + headers[i] + ': {{' + headers[i] + '}} ';
		}
		template = template + '</br>{{/.}}';
		//----------------------------------------------------
		//DEBUG: alert (template);
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		$(moduleId).html(html);
		//DEBUG:  alert(html);
	},
	renderModuleDataConditionals: function(data,ui_type,groupIndexId,itemIndexId,isFront){
		/*get module id depending if is in front page*/
		var moduleId = '#module-data' + (isFront?groupIndexId+'_'+itemIndexId:'');
		// these ui types are only different by the template
		//get template from html
		switch (ui_type) {
		case 'Percent':			
			if (!isFront) {
				resultsViews.renderModuleDataTable(data,groupIndexId,itemIndexId,isFront);
			}
			template =$('#modulePercentTmpl').html();
			break;
		case 'Boxes':
			template =$('#moduleBoxesTmpl').html();
			break;
		case 'ConditionTable':
			template =$('#moduleConditionTableTmpl').html();
			break;
		case 'Todo':
			template =$('#moduleTodoTmpl').html();
			break;
		default:
			resultsViews.renderModuleDataSimple(data);
		}
		//add conditions to data
		//Extend the object with functions to decide if green, red or orange
		//default is false in case there is nothing in the config
		var newData = {data: [], 
					   lineForms: [],
					//extend groupnum and indexnum to be used in forms
					group_index_num:function () {return groupIndexId},
					index_num: function () {return itemIndexId},
					//extent functions
					green: function () {return false;},
					red: function () {return false;},
					orange: function () {return false;},
					front: function () {return isFront},
					notFront: function () {return !isFront},
					hasForms: function () {if (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms.length > 0) return true;
						else return false;},
					hasIcon: function () {if (this.icon) return true;
						else return false;}};
		newData.data = data; 	
		//add line forms
		newData.lineForms = resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].lineForms;		
		//conditions
		//if green condition exist ... red orange respectevily
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_value)) {
				//change the function to represent the condition 
				newData.green=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_green_value)) return true};
			} 
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_value)) {
				newData.orange=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_orange_value)) return true};
			}
			if ((resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_operator) && (resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_value)) {
				newData.red=function(){if (utils.compare(this.value,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_operator,resultsGroupsModel.groupsData[groupIndexId].items[itemIndexId].condition_red_value)) return true};
			}
		data = newData;
		//render html using template and data
		var html = Mustache.render(template, data);
		//set the html on the page
		if (ui_type == 'Percent') {
			$(moduleId).prepend(html);
		} else {
			$(moduleId).html(html);
		}		
		//DEBUG:  alert(html);
		//datatable
		if ((ui_type == 'ConditionTable') && (!isFront)) {		
			//datatable
			if (data.data.length > 0) {
				$('.table').dataTable({"bLengthChange": true, "iDisplayLength": 25,"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
			}						
		}
	}, 
	renderModuleDataCharts: function(data,ui_type,groupIndexId,itemIndexId,isFront){
		/*get module id depending if is in front page*/
		var moduleId = '#module-data' + (isFront?groupIndexId+'_'+itemIndexId:'');
		if (!isFront) {
			resultsViews.renderModuleDataTable(data,groupIndexId,itemIndexId,isFront);
		}
		
		/*get chartplaceholder id depending if is in front page*/
		var chartplaceholderId = 'chartplaceholder' + (isFront?groupIndexId+'_'+itemIndexId:'');
		var chartData = [];
		var ticks = [];
		var dataSet = [];
		var options = {};
		if (ui_type =='PieChart') {
			// convert into flot charts data
			for(var i = 0; i < data.length; i++){
				dataSet[i] = {label:data[i].name,data:Number(data[i].value),color:null};
			}
			options = {
                series: {pie: {show: true}}
			};
		} else if ((ui_type =='LineChart') || (ui_type =='BarChart') || (ui_type =='FillChart')) {
			// convert into flot charts data
            for(var i = 0; i < data.length; i++){
				//all values are converted to numbers
				chartData[i] = [i, Number(data[i].value)];
				ticks[i] = [i, data[i].name];
			}
			//Labels of the chart
			dataSet = [
				{ label: "Values", data: chartData, color: "#5482FF" }
			];
			//options
			options = {
				series: {bars: {show: true},points: { show: true, fill: false }},
				bars: {align: "center",barWidth: 0.5},
				xaxis: {ticks: ticks},
				grid: { hoverable: true, clickable: true }
			};
			//different optios.series for line and fill
			if (ui_type =='LineChart') {
				options.series = {lines: {show: true,fill: false},points: { show: true, fill: false }};
			} else if (ui_type =='FillChart') {
				options.series = {lines: {show: true,fill: true},points: { show: true, fill: false }};
			}
		}		
		//set the html on the page
		$(moduleId).prepend('<div id="' + chartplaceholderId + '" class="span12" style="height:300px;background-color: #ffffff;"></div>');
		//load plot chart
		$.plot($("#"+chartplaceholderId), dataSet, options);		

		//MOUSEOVER -----
		$("#"+chartplaceholderId).bind("plothover", function (event, pos, item) {
	        //$("#x").text(pos.x.toFixed(2));
	        //$("#y").text(pos.y.toFixed(2));

	        
	        if (item) {
	            if (previousFlotPoint != item.dataIndex) {
	                previousFlotPoint = item.dataIndex;
	                
	                $("#specialtooltip").remove();
	                //var x = item.datapoint[0].toFixed(2),
	                var y = item.datapoint[1];
	                
	                utils.showTooltip(item.pageX, item.pageY,
	                            item.series.xaxis.ticks[item.dataIndex].label + " = " + y);
	                //item.series.label
	            }
	        }
	        else {
	            $("#specialtooltip").remove();
	            previousFlotPoint = null;            
	        }
        
	    });
	}
}

//---------------------Load ---------------------------------------------------------------------

$(document).ready(function () {
	/*if ($.browser.mobile) {
		alert('is mobile');
	}*/
	//if (!authmonInApp.init()) return false;
	//change name on the screen
    $('#loggedInAs').html(tokenobj.name);
	MonitorAllApp.currentParams = null;	
    appRouter.init();
	resultsViews.init();	
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
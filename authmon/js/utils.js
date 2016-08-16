//---------------------Utilities---------------------------------------------------------------------
window.utils = {	
    showMessage: function(title, text, klass,error) {
        $('#messages').html('<div class="alert  ' + klass + '"><strong>' + title + '</strong> ' + text+'<button type="button" class="close" data-dismiss="alert">x</button></div>');
        $('#messages').show();
    },
    closeMessage: function() {
        $('#messages').hide();
    },
    showModal: function(title,bodyTemplate,footerTemplate,objBody,objFooter) {
		$('#modalGeneralHeader').html(title);
		// Render using the templates
		$("#modalGeneralBody").html($("#" + bodyTemplate).tmpl(objBody));	
		$("#modalGeneralFooter").html($("#" + footerTemplate).tmpl(objFooter));	
		$('#modalGeneral').modal();
	}, 
	hideModal: function() {
		$('#modalGeneral').modal('hide');
		$("#modalGeneral").html("");
	}, 
	getParameterByName: function(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
};
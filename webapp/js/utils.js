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
 * utils
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

//-------------------------------------------------------------------------------------------------
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
	getHeaders: function(obj) {
        var cols = new Array();
        var p = obj[0];
        for (var key in p) {
            cols.push(key);
        }
        return cols;
    },
    compare: function (post, operator, value) {
		switch (operator) {
		case '>':   return post > Number(value);
		case '<':   return post < Number(value);
		case '>=':  return post >= Number(value);
		case '<=':  return post <= Number(value);
		case '==':  return post == Number(value);
		case '!=':  return post != Number(value);
		case '===': return post === value;
		case '!==': return post !== value;
		case '><': return post > Number(value.split(" ")[0]) && post < Number(value.split(" ")[1]) ;
		}
	},
	//might not need it...https://github.com/maxatwork/form2js may be more suitable
	// or maybe simply serializeArray
	serializeObject: function(formObj) {
	    var o = {};
	    var a = formObj.serializeArray();
	    $.each(a, function() {
	    	if (o[this.name] !== undefined) {
	    		if (!o[this.name].push) {
	    			o[this.name] = [o[this.name]];
	    		}
	    		o[this.name].push(this.value || '');
	    	} else {
	    		o[this.name] = this.value || '';
	    	}
	    });
	    return o;
	}, 
	showTooltip: function (x, y, contents) {
        $('<div id="specialtooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    },
    downloadJSON2CSV: function (objArray,filename)
    {
        var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

        var str = '';

        for (var i = 0; i < array.length; i++) {
            var line = '';

            for (var index in array[i]) {
                line += array[i][index] + ',';
            }

            // Here is an example where you would wrap the values in double quotes
            // for (var index in array[i]) {
            //    line += '"' + array[i][index] + '",';
            // }

            line.slice(0,line.Length-1); 

            str += line + '\r\n';
        }
         // Data URI
         //csvData = "data:text/csv;charset=utf-8," + encodeURIComponent(str);

         $(this)
            .attr({
            'download': filename,
                'href': URL.createObjectURL(new Blob([str], {
                  type: 'text/csv;charset=utf-8;'
            })),
                'target': '_blank'
        })
    },
     downloadJSON: function (objArray,filename)
    {
        

        var str = JSON.stringify(objArray)

         // Data URI
         //jsonData = "data:text;charset=utf-8," + encodeURIComponent(str);         

         $(this)
            .attr({
            'download': filename,
                'href': URL.createObjectURL(new Blob([str], {
                  type: 'text;charset=utf-8;'
            })),
                'target': '_blank'
        })
    },
    highlightCode: function() {
    	$('pre code').each(function(i, e) {hljs.highlightBlock(e)});    	
    }
};

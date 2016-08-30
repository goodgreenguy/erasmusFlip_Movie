/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$('#sel_all').click(function(){
	$('#sel_chk').trigger('click');
});

$('#sel_all2').click(function(){
	$('#sel_chk2').trigger('click');
});



$(function () {
    'use strict';
/* 
var file_url = function( id ){
	$('.fileupload').each( function(){
		var hndlr = '';
		if ( this.id == 'csv' )
			hndlr = 'hndlr_csv.php';
		else if ( this.id == 'img' )
			hndlr = 'hndlr_img.php';
		var url = {
			'url' : hndlr
		};
		console.log(  url.url.toString() );
		return url.url.toString();
	});
} */

var csv_file = $('#csv');
var img_file = $('#img');
var fileName = "";
var all = [ csv_file, img_file ];

    // Initialize the jQuery File Upload widget:
csv_file.fileupload({
		dropZone: $(this),
	// formData: this.filename,
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
		
        url: 'hndlr_csv.php'
    })
	.bind('fileuploadadd', function (e, data) {
	  $.each(data.files, function (index, file) {
		fileName = file.name;
	  });
	})
	.bind('fileuploadsubmit', function (e, data) {
	  data.formData = {
		  "file" : fileName,
		  };
	});

	
	// Initialize the jQuery File Upload widget:
img_file.fileupload({
		dropZone: $(this),
		// Uncomment the following to send cross-domain cookies:
    //xhrFields: {withCredentials: true},
     url: 'hndlr_img.php'
    })
		.bind('fileuploadadd', function (e, data) {
	  $.each(data.files, function (index, file) {
		fileName = file.name;
	  });
	})
		.bind('fileuploadsubmit', function (e, data) {
	  data.formData = {
		  "file_img" : fileName,
		  };
	});

// Enable iframe cross-domain access via redirect option:
img_file.fileupload(
	'option',
	'redirect',
	 window.location.href.replace(
		 /\/[^\/]*$/,
		'/cors/result.html?%s'
	 )
);


// Load existing files:
csv_file.addClass('fileupload-processing');
	$.ajax({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: csv_file.fileupload('option', 'url'),
			dataType: 'json',
			context: csv_file[0]
	}).always(function () {
			$(this).removeClass('fileupload-processing');
	}).done(function (result) {
			$(this).fileupload('option', 'done')
					.call(this, $.Event('done'), {result: result});
});
				
       // Load existing files:
img_file.addClass('fileupload-processing');
$.ajax({
		// Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url:  img_file.fileupload('option', 'url'),
		dataType: 'json',
		context:  img_file[0]
}).always(function () {
		$(this).removeClass('fileupload-processing');
}).done(function (result) {
		$(this).fileupload('option', 'done')
				.call(this, $.Event('done'), {result: result});
});


});

/* $('#csv').fileupload({

  // This function is called when a file is added to the queue
  add: function (e, data) {
    //This area will contain file list and progress information.
    var tpl = $('<li class="working">'+
                '<input type="text" value="0" data-width="48" data-height="48" data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" />'+
                '<p></p><span></span></li>' );

    // Append the file name and file size
    tpl.find('p').text(data.files[0].name)
                 .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

    // Add the HTML to the UL element
    data.context = tpl.appendTo('ul');

    // Initialize the knob plugin. This part can be ignored, if you are showing progress in some other way.
    //tpl.find('input').knob();

    // Listen for clicks on the cancel icon
    tpl.find('span').click(function(){
      if(tpl.hasClass('working')){
              jqXHR.abort();
      }
      tpl.fadeOut(function(){
              tpl.remove();
      });
    });

    // Automatically upload the file once it is added to the queue
    var jqXHR = data.submit();
  },
  progress: function(e, data){

        // Calculate the completion percentage of the upload
        var progress = parseInt(data.loaded / data.total * 100, 10);

        // Update the hidden input field and trigger a change
        // so that the jQuery knob plugin knows to update the dial
        data.context.find('input').val(progress).change();

        if(progress == 100){
            data.context.removeClass('working');
        }
    }
});
//Helper function for calculation of progress
function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
        return '';
    }

    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }
    return (bytes / 1000).toFixed(2) + ' KB';
}
 */
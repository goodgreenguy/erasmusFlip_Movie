<?php 
session_start(); 

if(!isset($_SESSION['user_is_logged_in']))
	header('location: index.php');

include 'header.php';

		

?>

<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="plugins/jQuery-File-Upload-9.12.5/css/jquery.fileupload.css">
<link rel="stylesheet" href="plugins/jQuery-File-Upload-9.12.5/css/jquery.fileupload-ui.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="plugins/jQuery-File-Upload-9.12.5/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="plugins/jQuery-File-Upload-9.12.5/css/jquery.fileupload-ui-noscript.css"></noscript>

<body>

<div class="container">
	
  <h2>Hello <?php echo $_SESSION['user_name'];?>! Welcome to the StoryInventor management pages!</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Story review</a></li>
    <li><a data-toggle="tab" href="#menu2">Story Guidelines Import</a></li>
    <li><a data-toggle="tab" href="#menu3">Image upload</a></li>
  </ul>

  <div class="tab-content">
 
    <div id="home" class="tab-pane fade in active">
      <h3>Story review for <?php echo $_SESSION['user_school'] . ' from ' . $_SESSION['user_country'] ?></h3>
	  <h4>Secret word: <?php echo $_SESSION['secret'] ?></h4>
      <p>
	  <div class="row">
			<div class="col-md-3 form-group">
			  <label for="st_class">Class</label>
			  <select class="form-control" id="st_class">
				<option> </option>
			  </select>
			</div>
			<div class="col-md-3 form-group">
			  <label for="country">Student:</label>
			  <select class="form-control" id="students">
				<option> </option>
			  </select>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-body" id="story">
			</div>
		</div>
	  
	  </p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Story Guidelines Import</h3>
	  <h4>Here you can upload CSV files containing story guidelines</h4>
	  <h4><a href="/files/guidelines_template.csv">Click here to download the template</a></h4>
<!--       <p>
			<form id="csv" action="hndlr_csv.php" method="post" enctype="multipart/form-data" target="formInfo">
				<h3>Select CSV file to upload:</h3>
				  <div class="row">
					  <input type="file" name="uploadctl" multiple />
					  <ul id="fileList">
				  </div>
				<div class="row">
				   <label class="btn btn-primary"><input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">Browse</label>
					<label class="btn btn-info"><input type="submit" name="submit" style="display: none;">Upload</label>
					<button class="btn btn-success" name="import">Import</button>
					<p id="csv_file"></p>
				</div>
			</form>
	   </p>  -->
	    <h3>Upload (only CSV files)</h3>
      <p>
	      <!-- The file upload form used as target for the file upload widget -->
			<form class="fileupload" id="csv" action="backend.php" method="POST" enctype="multipart/form-data">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Add files...</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel upload</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<span id="sel_all" class="btn btn-primary">Select All  </span>
						<input hidden type="checkbox" id="sel_chk" class="sel_all toggle">
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="col-lg-5 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				<!-- The table listing the files available for upload/download -->
				<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
			</form>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Image upload for mystery box (only jp(e)g, png, gif)</h3>
      <p>
	      <!-- The file upload form used as target for the file upload widget -->
			<form class="fileupload" id="img" action="backend.php" method="POST" enctype="multipart/form-data">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Add files...</span>
							<input type="file" name="files" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel upload</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<span id="sel_all" class="btn btn-primary">Select All  </span>
						<input hidden type="checkbox" id="sel_chk" class="sel_all toggle">
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="col-lg-5 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				<!-- The table listing the files available for upload/download -->
				<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
			</form>
	  </p>
    </div>
  </div>

	<div class="col-md-offset-3 col-md-3">
		<form class="form-signin form" role="form" method="post" >
				<button class="btn btn-lg btn-primary" formaction="admin.php?action=logout">Log Out</button>
		</form>
	</div>

<div class="col-md-3">
<!-- Trigger the modal with a button -->
<?php 
	if(isset($_SESSION['user_is_logged_in']) && $_SESSION['user_name'] == 'admin' )
echo '
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Register User</button>

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">New user Registration</h4>
		  </div>
		  <div class="modal-body">
			
		
		 <h2 align=center class="form-signin-heading">Registration</h2>
        <p>
		 <form class="form-signin" method="post" action="admin.php?action=register" name="registerform">
			<p><div><label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label></div>
			<input class="form-control" id="login_input_username" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /></p>
			
			<p><div><label for="login_input_email">User\'s email</label></div>
			<input class="form-control" id="login_input_email" type="email" name="user_email" required /></p>
			
			<p><div><label for="login_input_country">Country</label></div>
			<input class="form-control" id="login_input_country" type="text"  name="user_country" required /></p>
			
			<p><div><label for="login_input_school">School</label></div>
			<input class="form-control" id="login_input_school" type="text" name="user_school" required /></p>
			
			<p><div><label for="login_input_school">Secret</label></div>
			<input class="form-control" id="login_input_secret" type="text" name="user_secret" required /></p>
			
			<p><div><label for="login_input_password">Password (min. 6 characters)</label></div>
			<input  id="login_input_password" class="form-control login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /></p>
		
			<p><div><label for="login_input_password_repeat">Repeat password</label></div>			
			<input  id="login_input_password_repeat" class="form-control login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /></p>

			<input class="btn btn-lg  btn-block btn-primary" type="submit" name="register" value="Register" />

        </form>
		</p>
	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		';
?>
	  </div>
	</div>
	
</div>

</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>





<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
	 </tr>
        <!-- ... -->
        <!-- ... -->
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="plugins/jQuery-File-Upload-9.12.5/js/main.js"></script>
<script>

 function handleUserData( data )
 {
	// var schools = [];
	// var countries = []
	
	// $.each(data, function(i, val){
		// schools[i] = val['user_school'];
		// countries[i] = val['user_country'];
	// });
   // $.each(schools, function(index, school){
	 // if( $('#'+school).text() != school )
		// $('#country').append('<option id="' + school + '">' + school + '</option>'); 
  // });
}

	var countries = [];
	var students = [];
	var st_class = [];
	var st_story = [];
	var student_data;

function handleStudData( data )
{
	student_data = data;
	$.each(data, function(i, val){
		students[i] = val['name'];
		st_class[i] = val['class'];
		st_story[ val['name' ] ] = val['story']; // access story by student name
	});
    

  $.each(st_class, function(i, val){
	  if( $('#'+val).text() != val )
		$('#st_class').append('<option id="' + val + '">' + val + '</option>'); //add option if not already present
	  	
  });
	  
   $.each(students, function(i, value){
		if( student_data[i].class ==  $('#st_class').val() )
			$('#students').append('<option>' + value + '</option>');
	});

}

function strTo_ul( str, id )
{
	var split = str.split(',');
	var cList = $('ul[id="'+ id + '"]' );
	$.each(split, function(i)
	{
		var li = $('<li/>')
			.addClass('ui-menu-item')
			.attr('role', 'menuitem')
			.text(split[i])
			.appendTo(cList);
		
	});
}

function getUserData( callback )
{
  var tosend = "submit=getUserData";
  $.ajax({
  type: "GET",
  url: "backend.php",
  data: tosend,
  success: function( data ){ callback( data );},
  dataType: 'json'
  });
}
function getStudData( callback )
{
  tosend = "submit=getStudData";
    $.ajax({
  type: "GET",
  url: "backend.php",
  data: tosend,
  success: function( data ){ callback( data );},
  dataType: 'json',
	error: function(xhr, ajaxOptions, thrownError) {
	console.log(thrownError);}
  });
}

function assign_st(  )
{
	console.log();
		
}

$(document).ready(function(){
	
	getUserData( handleUserData );
	getStudData( handleStudData );
	
	$('#students').change(function(){
		$('#story').text( st_story[ $(this).val() ] );
	});
	
	$('#st_class').change(function(){
		$('#students').change();
		//$('#story').text( st_story[ $('#students').val() ] );
	});

	$('#students').change();
	
	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});
	
	 $('#st_class').change(function(){
		 $('#students').find( 'option' ).remove();
		$.each( students, function(i, value){ 
			if( student_data[i].class ==  $('#st_class').val())
				$('#students').append('<option>' + value + '</option>');
		});
		 $('#students').change();
	 });
});

</script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="plugins/jQuery-File-Upload-9.12.5/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
</body>
</html>
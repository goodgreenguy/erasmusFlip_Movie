<?php 
include 'header.php';
include 'backend.php';
 ?>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Story Guidelines
                    </a>
                </li>
                <li class="note_whole">
					  <img src="img/note.png" class="img-responsive" >
					<div class="note">
						<p class="note_title">Characters</p>
						<p class="note_text" id="Characters"></p>
					</div>
                </li>
                <li class="note_whole">
					<img src="img/note.png" class="img-responsive" >
					<div class="note">
						<p class="note_title">Settings</p>
						<p class="note_text" id="Settings"></p>
					<div>
                </li>
                <li class="note_whole">
					 <img src="img/note.png" class="img-responsive" >
					 <div class="note">
						 <p class="note_title">Plots</p>
						 <p class="note_text" id="Plots"></p>
					 </div>
                </li>
                <li class="note_whole">
					<img src="img/note.png" class="img-responsive" >
					<div class="note">
						<p class="note_title">Ends of Stories</p>
						<p class="note_text" id="Ends of Stories"></p>
					</div>
			      </li>
                <li class="note_whole">
					<img src="img/note.png" class="img-responsive" >
					<div class="note">
						<p class="note_title">Mystery Box</p>
						<p class="note_text" id="Mystery"></p>
					</div>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Your Story</h1> 
							<div>
								<a href="#menu-toggle" class="btn btn-success" id="menu-toggle">Toggle Story Guidelines</a>
						    </div>
						   </br>
							<form class="form-horizontal" action="story.php?action=submit_story" method="post" name="story_form">
								<div class="form-group">
								<div class="row">
									<label for="name" class="col-sm-1 control-label">Name</label>
									<div class="col-sm-3">
									  <input name="stud_name" type="text" class="form-control" id="name" placeholder="Your Name" required>
									</div>
									<label for="stud_secret" class="col-sm-1 control-label">Secret Word</label>
									<div class="col-sm-3">
									  <input name="stud_secret" type="text" class="form-control" id="stud_secret" placeholder="Secret Word" required>
									</div>
								</div>
								<div class="row">
									<label for="class" class="col-sm-1 control-label">Class</label>
									<div class="col-sm-3">
									  <select name="stud_class_nr" class="col-md-1 col-sm-1 form-control" id="stud_class_nr"  required>
										  <option>1</option>
										  <option>2</option>
										  <option>3</option>
										  <option>4</option>
										  <option>5</option>
										  <option>6</option>
										  <option>7</option>
										  <option>8</option>
										  <option>9</option>	
									  </select>
									</div>
									<div	 class="col-sm-3">
									  <select name="stud_class_lt" class="col-md-1  	col-sm-1 form-control" id="stud_class_lt"  required>
										  <option>A</option>
										  <option>B</option>
										  <option>C</option>
										  <option>D</option>
										  <option>E</option>
										  <option>F</option>
										  <option>G</option>
									  </select>
									</div>
									<input name="stud_class" class="form-control" id="stud_class" readonly >
								</div>
								</div>
								<br/>
								<textarea name="stud_story" class="story_input" placeholder="Enter Your Story Here..."></textarea>
								<div class="col-md-offset-4 col-sm-offset-4">
									<button type="submit" name="sub_story" class="btn btn-info btn-lg">Submit Story</button>
								</div>
							</form>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	$(document).ready(function(){
		$('li.note_whole').each(function() {
			var div_id = $(this).find('p.note_text').attr('id');
			var note_text = Cookies.get(div_id);
			if( note_text == "" )
				$(this).remove();
			$( '[id="' + div_id +'"]').text(note_text);
		});
		
		jQuery.validator.addMethod("lettersonly", function (value, element) {
		return this.optional(element) || /^[a-z0-9_-]+$/i.test(value);
		}, "Please use only a-z0-9_-");
		$('.form-control').validate({
			rules: {
				login: {
					minlength: 3,
					maxlength: 15,
					required: true,
					lettersonly: true
				},
				password: {
					minlength: 3,
					maxlength: 15,
					required: true,
					lettersonly: true
				},
			},
			highlight: function (element) {
				$(element).closest('.control-group').addClass('has-error');
			}
		});
		$('#stud_class').text( $('#stud_class_nr').val() + $('#stud_class_lt').val() );
		
		$('#stud_class_nr').change( function(){ 
			$('#stud_class').val( $(this).val() + $('#stud_class_lt').val() );
		});
	
		$('#stud_class_lt').change( function(){ 
			$('#stud_class').val( $('#stud_class_nr').val() + $(this).val() );
		});
		
	});
    </script>

</body>

</html>

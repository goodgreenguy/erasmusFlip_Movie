<?php 
include 'header.php';
include 'backend.php';
 ?>

<body>

    <div id="wrapper" class="back">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                  <span class="story_side"> Story Guidelines</span>
                </li>
                <li class="note_whole">
					<div class="note">
						<p class="note_title">Characters</p>
						<ul class="note_list" id="Characters">
						</ul>
						<img src="img/note.png" class="img-responsive" >
					</div>
                </li>
                <li class="note_whole">
					<div class="note">
						<p class="note_title">Settings</p>
						<ul class="note_list" id="Settings">
						</ul>
					  <img src="img/note.png" class="img-responsive" >
					</div>
                </li>
                <li class="note_whole">
					 <div class="note">
						 <p class="note_title">Plots</p>
						 	<ul class="note_list" id="Plots">
							</ul>
					  <img src="img/note.png" class="img-responsive" >
					 </div>
                </li>
                <li class="note_whole">
					<div class="note">
						<p class="note_title">Ends of Stories</p>
						 	<ul class="note_list" id="Endings">
							</ul>
					  <img src="img/note.png" class="img-responsive" >
					</div>
									</li>
                <li class="note_whole">
					<div class="note">
						<p class="note_title">Mystery Box</p>
						<ul class="note_list" id="Mystery">
						</ul>
					  <img src="img/note.png" class="img-responsive" >
					</div>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="back" id="page-content-wrapper">
						<div class="row"><img class="sun pulse img-responsive" src="img/sun.png"></div>
							
					 <!--	<img class="island_story img-responsive" src="img/island_cl.png"> -->    

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="story_title">Your Story</h1>
											</div>
                </div>
								
							<div>
								<a href="#menu-toggle" class="btn btn-success" id="menu-toggle">Toggle Story Guidelines</a>
							</div>
						   </br>
							<form class="form-horizontal" action="story.php?action=submit_story" method="post" name="story_form">
								<div class="form-group">
								<div class="row">
									<label for="name" class="col-sm-1 control-label">Name</label>
									<div class="col-sm-3 col-md-3 col-lg-3">
									  <input name="stud_name" type="text" class="form-control" id="name" placeholder="Your Name" required>
									</div>
									<label for="stud_secret" class="col-sm-1 control-label">Secret Word</label>
									<div class="col-sm-3 col-md-3 col-lg-3">
									  <input name="stud_secret" type="text" class="form-control" id="stud_secret" placeholder="Secret Word" required>
									</div>
								</div>
								<br/>
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
									<div class="col-sm-3">
									  <select name="stud_class_lt" class="col-md-1 col-sm-1 form-control" id="stud_class_lt"  required>
										  <option>A</option>
										  <option>B</option>
										  <option>C</option>
										  <option>D</option>
										  <option>E</option>
										  <option>F</option>
										  <option>G</option>
									  </select>
									</div>
									<div class="col-md-2 col-sm-2">
										<input name="stud_class" class="col-md-1 col-sm-1 form-control" id="stud_class" readonly >
									</div>
								</div>
								</div>
								<br/>
								<textarea name="stud_story" class="story_input" placeholder="Enter Your Story Here..."></textarea>
								<input readonly id="gdl" name="guidelines" hidden></input>
								<div class="col-md-offset-4 col-sm-offset-4">
									<button type="submit" name="sub_story" class="btn btn-success btn-lg">Submit Story</button>
								</div>
							</form>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
<script>
function strTo_ul( str, id )
{
	if( id != "Mystery" )
	{
		var split = str.split(',');
		$("#gdl").val( $('#gdl').val() + (str + '_') ); // put data into hidden element to store it into db
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
}
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
		
		
	$(document).ready(function()
	{
		$('li.note_whole').each(function() {
			var par_id = $(this).find('ul').attr('id');
			var note_text =  Cookies.get(par_id);
			var ul_id = "ul_" + par_id;
			var text = "";
			if( note_text === "" )
				$(this).remove();
			else if( par_id == "Mystery")
			{
			  $('#Mytery').append('<img src="files/img/123/' + note_text +'">'); // todo
			}
			else	
			{
			  strTo_ul( note_text, par_id );
			}
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
		
		$('#stud_class_nr').change( function(){ 
			$('#stud_class').val( $(this).val() + $('#stud_class_lt').val() );
		});
		$('#stud_class_lt').change( function(){ 
			$('#stud_class').val( $('#stud_class_nr').val() + $(this).val() );
		});
		
			$('#stud_class_nr').change();
			$('#stud_class_lt').change();
	});
</script>

</body>

</html>

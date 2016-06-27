<?php  
include 'header.php';
?>
<body>
<div class="container">
	<div class="row">
		<p id="welcome">Welcome to Erasmus Flip & Movie project!</p>
		</br>
		</br>
	</div>
	<div class="row">
		<div id="Characters" class="box_whole col-md-6 col-sm-7 ">
			<!-- <img src="img/box_cover.png" class="box box_cover floating" alt="Character">
			<img src="img/box_body.png" class="box box_align floating" alt="Character" > -->
			<img src="img/box_whole.png" class="box box_align floating" alt="Character" >
		</div>
		<div id="Setting" class="box_whole col-md-6 col-sm-7 ">
			<!-- <img src="img/box_cover.png" class="box box_cover floating" alt="Setting">
			<img src="img/box_body.png" class="box box_align floating" alt="Setting" > -->
			<img src="img/box_whole.png" class="box box_align floating" alt="Setting" >
		</div>

	</div>

	<div class="row">
		<div id="Plot" class="box_whole col-md-6 col-sm-7">
			<!--  <img src="img/box_cover.png" class="box box_cover floating" alt="Plot">
			<img src="img/box_body.png" class="box box_align floating" alt="Plot" > -->
			<img src="img/box_whole.png" class="box box_align floating" alt="Plot" >
		</div>
		
		<div id="Ending" class="box_whole col-md-6 col-sm-7">
			<!-- <img src="img/box_cover.png" class="box box_cover floating" alt="Endings">
			<img src="img/box_body.png" class="box box_align floating" alt="Endings" > -->
			<img src="img/box_whole.png" class="box box_align floating" alt="Endings" >

		</div>
	</div>
	<div class="row mystery">
		<div id="Mystery" class="box_whole col-md-6 col-sm-7">
			<img src="img/box_whole.png" class="box box_align floating" alt="Mystery" >

			<!-- <img src="img/box_cover.png" class="box box_cover floating" alt="Mystery">
			<img src="img/box_body.png" class="box box_align floating" alt="Mystery" > -->
		</div>
	</div>

</div>

<script type="text/javascript" >
	var Mystery = ["IBM", "MujoHaso"];
	var Characters = ["Potjeh, Starac Vijest, Marun, Ljutiša", "Mujo i Haso"];
	var Setting = ["Grandpa’s cottage, forest, well, sky,", "vedro na planini"];
	var Plot = ["revealing the truth, forgetting the truth, travel around the world, quarrel, the truth is inside the heart, good deeds lead to heaven", "idu negdje"];
	var Ending = ["forgiveness, Hearth- symbol of family reunion, good deeds lead to heaven", "dosli tamo"];
var story = {
 "Characters" : Characters,
 "Setting" : Setting,
 "Plot" : Plot,
 "Ending" : Ending,
 "Mystery" : Mystery
};

function selectRandom(arg)
{
	num = Math.floor(Math.random() * story[arg].length);
	ret = story[arg][ num ];
	return( ret );
}

$.fn.animateRotate = function(angle, duration, easing, complete) {
  var args = $.speed(duration, easing, complete);
  var step = args.step;
  return this.each(function(i, e) {
    args.complete = $.proxy(args.complete, e);
    args.step = function(now) {
      $.style(e, 'transform', 'rotate(' + now + 'deg)');
      if (step) return step.apply(e, arguments);
    };

    $({deg: 0}).animate({deg: angle}, args);
  });
};

function store_sessionData()
{
	var tosend = "submit=";
	$.ajax({
	type: "GET",
	url: "backend.php",
	data: tosend,
	dataType : 'json'
	//success: function(data){ callback(data);}
	});
}

function pen()
{
	$("body").append('<div id="pen" class="pendiv fadeIn"></div>');
	$('#pen').append('<div id="link" class="hidden"><a href="story.php"><img src="img/pen.png" class="pen img-responsive" style="transform: rotate(-40deg);"><p class="pen">Click Here to Start Writing!</p></a></div>');
	$('#link').removeClass('hidden').fadeIn();
}
$(document).ready(function(){
	var boxes_opened = [];
	var effect ="";
	var pen_active = false;
	$(".box_whole").click(function(){
		var cloud_text = "";

		if( $.inArray( this.id, boxes_opened) == -1 ) // disable multiple cloud spawn 
		{ 
			if( this.id == "Ending" )
			{
				boxes_opened.push("Plot");
				$('#Plot').find('img').removeClass('floating').addClass('pulse');
			}
			else if( this.id == "Plot" )
			{
				boxes_opened.push("Ending");
				$('#Ending').find('img').removeClass('floating').addClass('pulse');
			}
			boxes_opened.push(this.id);			
			//$( "#" + this.id + " img").remove();
			$(this).find('img').fadeOut().remove();
			// add
			//$(this).append('<img src="img/box_cover.png" class="box box_cover" alt="Plot">');
			//$(this).append('<img src="img/box_body.png" class="box box_align tossing" alt="Plot" >');
			$(this).append('<img src="img/cloud.png" class="bigEntrance" alt="Plot" >').addClass('tossing');
			$(this).append('<p class="cloud_title">'+ this.id + '</p>');
			cloud_text = selectRandom(this.id);
			$(this).append('<p class="pop_text fadeIn">' + cloud_text + '</p>');
			Cookies.set(this.id, cloud_text);
		}
		
		if( ( boxes_opened.length == 5 ) && !pen_active )
		{
			pen_active = true;
			setTimeout(pen,3000);
				//$("#pen").addClass('slideDown');
			//$('#pen').append('<a href="story.php"> <img src="img/pen.png" class="pen img-responsive" alt="Plot" style="transform: rotate(-40deg);"><p class="pen">Click Here to Start Writing!</p></a>').addClass('slideDown');
			//.delay(4000).addClass('floating')
		}
	});
})

</script>
</body>

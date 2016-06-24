<?php include 'header.php'; ?>
<body>
<div class="container">
	<div class="row">
		<p class="welcome">Welcome to Erasmus Flip & Movie project!</p>
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
	<div id="pen" class="pen"></div>

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

/*$(this).find('.box_cover').animateRotate(-45, {
	  duration: 1000,
	  easing: 'linear',
	  complete: function () {},
	  step: function () {}
	});*/
	
$(document).ready(function(){
	var boxes_opened = [];
	var effect ="";
	var pen_active = false;
	
	$(".box_whole").click(function(){
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
			$(this).append('<p class="pop_text fadeIn">' + selectRandom(this.id) + '</p>');
		}
		
		if( ( boxes_opened.length == 5 ) && !pen_active )
		{
			pen_active = true;
			$('#pen').append('<a href="story.php"> <img src="img/pen.png" class="pen" alt="Plot" style="transform: rotate(-40deg);"><p class="pen">Click Here to Start Writing!</p></a>').addClass('slideDown');
			//.delay(4000).addClass('floating')
		}
	});
})

</script>
</body>

<?php  
	include 'header.php';
?>
<body class="back">
<div class="container">
	<div id="app">
		<span class="page_title">STORYINVENTOR</span>
		<div class="row"><img class="sun pulse img-responsive" src="img/sun.png"></div>
		<div class="row"><a href="http://www.flipandmovie.eu/"><img class="img-responsive logo" src="img/logo_small.png"></img></a></div>
		<img class="island img-responsive" src="img/island_cl.png">
		<div class="clouds_up"></div>
<!-- 			<div class="waves waves1">
				<img class="floating  img-responsive" src="img/waves3.png">
			</div> -->
			<div class="waves waves2">
				<img class="  img-responsive" src="img/waves3.png">
			</div>
			<div class="waves waves3">
				<img class="  img-responsive" src="img/waves3.png">
			</div>
			<div class="waves waves4">
				<img class="  img-responsive" src="img/waves3.png">
			</div>
			<div class="waves waves5">
				<img class=" floating img-responsive" src="img/waves3.png">
			</div>
			<div class="waves waves6">
				<img class="  img-responsive" src="img/waves3.png">
			</div>
		<div class="row boxes_off">
			<div id="Characters" class="inline tossing col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<p class="box_text ">Characters</p>
				<img src="img/chest.png" id="chars" class="box chars" alt="Characters" >
			</div>
			<div id="Settings" class="inline tossing col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<p class="box_text box_text_set">Settings</p>
				<img src="img/chest.png" id="set" class="box set" alt="Settings" >
			</div>
			<div id="Plots" class="inline tossing col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<p class="box_text plots box_text_set">Plots</p>
				<img src="img/chest.png" id="plot" class="box plot" alt="Plots" >
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-2"></div>
			<div id="Endings" class="inline front tossing col-md-4 col-sm-4 col-xs-4">
				<p class="box_text ">Ends of Stories</p>
				<img src="img/chest.png" id="ends" class="box ends" alt="Endings" >
			</div>
			<div id="Mystery" class="inline front tossing col-md-4 col-sm-4 col-xs-4">
				<p class="box_text ">Mystery Box</p>
				<img src="img/chest.png" id="myst" class="box myst" alt="Mystery" >
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" >



var Mystery = ["Mystery 1", "Mystery 2"];
var Characters = ["Potjeh, Starac Vijest, Marun, Ljutiša",
"Giant Regoč, Fairy Kosjenka, Ljiljo – village boy, Grandpa, Grandma, Children",
"Fisherman Palunko, \
Palunko’s wife,\
Vlatko (Palunko’s son),\
King of the Sea,\
Zora – underwater goddess,\
Mermaids (sea girls)"];

var Settings = ["Grandpa’s cottage, forest, well, sky",
 "Meadow with horses, Village, Legen town",
 "Modest house located in the karst area at the foot of the mountain, Sea, Water mill (wheel), Underwater castle"];

var Plots = ["revealing the truth, forgetting the truth, travel around the world, quarrel, the truth is inside the heart, \
good deeds lead to heaven", 
"Friendship between giant and fairy, Journey to the unknown, \
Eternal conflict between love and hate, Quarrel of the villagers - destruction of the village",
"Human greed, Human curse-we are never happy with what we have, we always want more and more…,\
Woman’s unconditional faith,\
Dedication and faith in the family"
];

var Ending = ["forgiveness, Hearth- symbol of family reunion, good deeds lead to heaven", 
"Final celebration of the villagers,\
Sadness of the villagers (when they realize that they are left all alone),\
The return of Grandpa and Grandma,\
Force of friendship,\
Reconstruction of the village",
"Family reunion,\
Forgiveness,\
Faith in the family,\
Good and love always win,\
Strong, courageous and wise woman who is determined to protect her family\
"];

var story1 = {
 "Characters" : Characters,
 "Settings" : Settings,
 "Plots" : Plots,
 "Ends of Stories" : Ending,
 "Mystery" : Mystery
};

var story = {
 "Characters" : '',
 "Settings" : '',
 "Plots" : '',
 "Endings" : '',
 "Mystery" : ''
};


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


function pen()
{
	$("body").append('<div id="pen" class="pendiv fadeIn"></div>');
	$('#pen').append('<div id="link" class="hidden"><div class="row"><a href="story.php"><img src="img/pen.png" class="pen img-responsive" style="transform: rotate(-40deg);"><p class="pen">Click The Pencil to Start Writing!</p></a>\
	<a href="."><p class="pen pen_try">Or try again...</p></a></div></div>');
	$('#pen').append('');
	$('#link').removeClass('hidden').fadeIn();

}

function handleStoryData( data )
{
	$.each( data, function(i, key ) 
	{
		for( val in key )
		{
			story[ val ] = data[ i ][val];
			console.log(story[ val ]);
		}
	
		
	});
		
//story[ "Characters" ]  = data["characters"];
/* : '',
 "Settings" : '',
 "Plots" : '',
 "Ends of Stories" : '',
 "Mystery" : ''*/

}

function getStoryData( callback )
{
  tosend = "submit=getStoryData";
  $.ajax({
  type: "GET",
  url: "backend.php",
  data: tosend,
  success: function( data ){ callback( data );},
  dataType: 'json',
  error: function(xhr, ajaxOptions, thrownError) { console.log(thrownError);}
  });
}

var boxes_opened = [];
var effect ="";
var pen_active = false;

function replace_chest( id )
{
	var cloud_text = "";
	var cookie_exp = 0.0007;
	if( $.inArray( id, boxes_opened) == -1 ) // disable multiple cloud spawn 
	{ 
		cloud_text = story[ id ];

		if( id == "Ends of Stories" )
		{
			boxes_opened.push("Plots");
			$('#Plots').find('img').addClass('pulse');
			Cookies.set(id, cloud_text, { expires: cookie_exp });
			Cookies.set('Plots', '', { expires: cookie_exp });
		}
		else if( id == "Plots" )
		{
			boxes_opened.push("Ends of Stories");
			$('div[id="Ends of Stories"]').find('img').addClass('pulse');
			Cookies.set(id, cloud_text, { expires: cookie_exp });
			Cookies.set("Ends of Stories", "", { expires: cookie_exp });
		}
		else
		{
			Cookies.set(id, cloud_text, { expires: cookie_exp });
		}
		boxes_opened.push(id);			

		var conv = "#"+id;
		$(conv).find('img').remove();
		$(conv).find('p').remove();
		
		$(conv).append('<img src="img/cloud.png" class="cloud" alt="' + id +'" >');
		$(conv).append('<p class="cloud_title">'+ id + '</p>');

		$(conv).append('<ul class="cloud_list" id="' + id + '"></ul>');
		$(conv).addClass('cloud_up');
		strTo_ul( cloud_text, id );
	}
	
	if( ( boxes_opened.length == 5 ) && !pen_active )
	{
		pen_active = true;
		setTimeout(pen,2000);
	}
}

$(document).ready(function(){
	
	getStoryData( handleStoryData );
		
	$.each(story, function(arg){
		Cookies.remove(story[arg]);
	})
	

	$(".tossing").click( function(){
	replace_chest( this.id );
	});
})

</script>
</body>
</html>
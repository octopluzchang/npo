//Navigation Bar Shrink on scroll
$(window).scroll(function() {
    parallax();
    var windscroll = $(window).scrollTop();
    if (windscroll >= 600) {
        $('#homeLogo').fadeIn();
         $('#homeNav').css({
             'background-color': '#fff',
            'border-bottom': '1px solid #8215d1'
         });
        

    } else {
          $('#homeLogo').fadeOut();
        $('#homeNav').css({
             'background-color': '#transparent',
            'border-bottom': 'none'
         });

    }
     
}).scroll();

//Parallox Scrolling Controll
function parallax(){
  var scrolled = $(window).scrollTop();
    $('#landing video').css('opacity',1-(scrolled*0.003));
    $('#landing .content').css('opacity',1-(scrolled*0.003));
    $('#about .content').css('margin-left',-(scrolled*0.5)+'px');
    $('#doSomething .content').css('margin-right',500-(scrolled*0.5)+'px');
    $('#getSomething .content').css('margin-left',1000-(scrolled*0.5)+'px');
  /*$('#bgvid').css('top',-(scrolled*0)+'px');*/
}


//Smooth Scrolling
$(document).ready(function(){


$('a[href*=#]:not([href=#])').click(function() { 
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) { 
			var target = $(this.hash); 
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

			
						
				if (target.length) { 
					$('html,body').animate({ 
						scrollTop: target.offset().top-70 }, 500); return false; } } 
						
						
			
		
						});
    
    });
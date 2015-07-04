//Fix Project images overlapping
jQuery(window).on('load', function(){
var $container = $('.pool');
// initialize Masonry after all images have loaded  
$container.imagesLoaded( function() {
  $container.masonry();
});
});


(function($)
{
    /**
     * Auto-growing textareas; technique ripped from Facebook
     * 
     * 
     * http://github.com/jaz303/jquery-grab-bag/tree/master/javascripts/jquery.autogrow-textarea.js
     */
    $.fn.autogrow = function(options)
    {
        return this.filter('textarea').each(function()
        {
            var self         = this;
            var $self        = $(self);
            var minHeight    = $self.height();
            var noFlickerPad = $self.hasClass('autogrow-short') ? 0 : parseInt($self.css('lineHeight')) || 0;
            var settings = $.extend({
                preGrowCallback: null,
                postGrowCallback: null
              }, options );

            var shadow = $('<div></div>').css({
                position:    'absolute',
                top:         -10000,
                left:        -10000,
                width:       $self.width(),
                fontSize:    $self.css('fontSize'),
                fontFamily:  $self.css('fontFamily'),
                fontWeight:  $self.css('fontWeight'),
                lineHeight:  $self.css('lineHeight'),
                resize:      'none',
    			'word-wrap': 'break-word'
            }).appendTo(document.body);

            var update = function(event)
            {
                var times = function(string, number)
                {
                    for (var i=0, r=''; i<number; i++) r += string;
                    return r;
                };

                var val = self.value.replace(/&/g, '&amp;')
                                    .replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(/\n$/, '<br/>&nbsp;')
                                    .replace(/\n/g, '<br/>')
                                    .replace(/ {2,}/g, function(space){ return times('&nbsp;', space.length - 1) + ' ' });

				// Did enter get pressed?  Resize in this keydown event so that the flicker doesn't occur.
				if (event && event.data && event.data.event === 'keydown' && event.keyCode === 13) {
					val += '<br />';
				}

                shadow.css('width', $self.width());
                shadow.html(val + (noFlickerPad === 0 ? '...' : '')); // Append '...' to resize pre-emptively.
                
                var newHeight=Math.max(shadow.height() + noFlickerPad, minHeight);
                if(settings.preGrowCallback!=null){
                  newHeight=settings.preGrowCallback($self,shadow,newHeight,minHeight);
                }
                
                $self.height(newHeight);
                
                if(settings.postGrowCallback!=null){
                  settings.postGrowCallback($self);
                }
            }

            $self.change(update).keyup(update).keydown({event:'keydown'},update);
            $(window).resize(update);

            update();
        });
    };
})(jQuery);

$(document).ready(function(){
//Tab Selector
    $('.tab li').click(function(){
        /*if($('.tab li').hasClass('selected')){
            $(this).removeClass('selected')
        }*/
         $('.tab li').removeClass('selected');
        $(this).addClass('selected');
    });

    
//Jquery UI Plugins
    //Date Picker
    
    $('input[name="newProjectDate"]').datepicker();
    
//Textarea Auto Grow
    $('textarea').autogrow();
    
//Login Panel Control
    $('.navigationBar .right, #loginPanel').mouseenter(function(){
        $('#loginPanel').slideDown();
    });
    
    $(' #loginPanel').mouseleave(function(){
        $('#loginPanel').slideUp();
    });
    
//Randomly adding projects
    var e = $('.project');
    //Set Project number
    for (var i = 0; i<100;i++) {
    e.clone().insertAfter(e);
    }
    
    //Random Images
    var images = ['images/projectImagePlaceholder_1.jpg', 'images/projectImagePlaceholder_2.jpg', 'images/projectImagePlaceholder_3.jpg'];
    $('.projectImage img').each(function(){ 
    $(this).attr('src', images[Math.floor(Math.random() * images.length)]);
    });
    
    //Random Titles
    var titles = ['徵求學生設計Logo', '慈善晚會設計規劃流程', '社會設計實踐與分析研究計畫', '企劃專題講座與整合行銷之實踐'];
    $('.projectName').each(function(){ 
    $(this).html(titles[Math.floor(Math.random() * images.length)]);
    });
    
    //Random Numbers of tags
    /*var tags = $('.projectHeader .tagContainer li');
    for (var i = 0; i< Math.random();i++) {
    tags.clone().insertAfter(tags);
    }*/
    
    
//Blurry Filter on popup shows
    //Show Trigger Plugin
    
$('.modal').on('show.bs.modal', function (e) {
  $('.pool, #profile, .navigationBar').addClass('blur')
});
    $('.modal').on('hide.bs.modal', function (e) {
  $('.pool, #profile, .navigationBar').removeClass('blur')
});
});


//Navigation Bar Shrink on scroll
$(window).scroll(function() {
    var windscroll = $(window).scrollTop();
    if (windscroll >= 195) {
        $('.tab, #profile .userAvator, #profile .userName').addClass('fixed');
    } else {
        $('.tab, #profile .userAvator, #profile .userName').removeClass('fixed'); 
    }

}).scroll();


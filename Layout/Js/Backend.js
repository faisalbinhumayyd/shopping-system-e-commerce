// global vars
var WinWidth  = "100%";
var WinHeight = $(window).height();

// set initial div height / width
$('.window').css({
    'width': WinWidth,
    'height': WinHeight,
});
// make sure div stays full width/height on resize
$(window).resize(function(){
    $('.window').css({
        'width': WinWidth,
        'height': WinHeight,
    });
});

//Change Size After Scroll
$(document).ready(function(){
    var scrollTop = 0;
    $(window).scroll(function(){
        scrollTop = $(window).scrollTop();
        $('.counter').html(scrollTop);
        if(scrollTop >= 100){
            $('#Navbar').addClass('scrolled-nav');
        }else if(scrollTop < 100){
            $('#Navbar').removeClass('scrolled-nav');
        } 
    }); 
 });

//Change active tab


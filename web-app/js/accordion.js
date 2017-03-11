/***********************************************************************************************************************
DOCUMENT: includes/javascript.js
DEVELOPED BY: Ryan Stemkoski
COMPANY: Zipline Interactive
EMAIL: ryan@gozipline.com
PHONE: 509-321-2849
DATE: 3/26/2009
UPDATED: 3/25/2010
DESCRIPTION: This is the JavaScript required to create the accordion style menu.  Requires jQuery library
NOTE: Because of a bug in jQuery with IE8 we had to add an IE stylesheet hack to get the system to work in all browsers. I hate hacks but had no choice :(.
************************************************************************************************************************/
$(document).ready(function() {
	 
    $('.accordionButton').click(function() {
        $('.accordionButton').removeClass('on');
        $('.accordionContent').slideUp('normal');
   
        if($(this).next().is(':hidden') == true) {
            $(this).addClass('on');
            $(this).next().slideDown('normal');
        }
    });
    $('.accordionButton').mouseover(function() {
        $(this).addClass('over');
    }).mouseout(function() {
        $(this).removeClass('over');
    });
    $('.accordionContent').hide();
    
    $('.accordionButtonInterno').click(function() {
        $('.accordionButtonInterno').removeClass('on');
        $('.accordionContentInterno').slideUp('normal');
   
        if($(this).next().is(':hidden') == true) {
            $(this).addClass('on');
            $(this).next().slideDown('normal');
        }
    });
    $('.accordionButtonInterno').mouseover(function() {
        $(this).addClass('over');
    }).mouseout(function() {
        $(this).removeClass('over');
    });
    $('.accordionContentInterno').hide();
});

$(function(){
    'use strict';
    $('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    })
    .blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    
    //add asterisk on the required field
    $('input').each(function () {
        if ($(this).attr('required') ==='required'){
            $(this).before('<span class="asterisk">*</span>');
        }
    });

    // show password function
    var passField = $('.password');
    $('.show-pass').hover(function(){
        passField.attr('type','text');
    },function(){
        passField.attr('type','password');
    });
    
    //confirmation msj for delete 
    $('.confirm').click(function(){
        return confirm('Are You Sure?');
    });
    // Category view option
    $('.cat h3').click(function(){
        $(this).next('.full-view').fadeToggle(500);
    });

    //trigger the selectbox it plugin 
    $("select").selectBoxIt({
        autoWidth: false
    });    
});
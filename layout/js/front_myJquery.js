$(function(){
    'use strict';
    //trigger the selectboxit plugin 
    $("select").selectBoxIt({
        autoWidth: false
    });  
    
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

    
    //switch between login and signup
    $('.login-page h1 span').click(function(){
        $(this).removeClass('selected').siblings().addClass('selected');
        $(this).hide().siblings().show();
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn();
        
    });
    $('.live').keyup(function(){
        $($(this).data('class')).text($(this).val());
    });
});
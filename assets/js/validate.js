$(document).ready(function(){
    $('form[name="login"] input').on('focusout', function(){
        validateEmpty(this);
    });
    $('form[name="addTask"] input').on('focusout', function(){
        validateEmpty(this);
        if($(this).attr('id') == 'inputEmailAdd'){
            validateEmail(this);
        }
    });
    $('form[name="addTask"] textarea').on('focusout', function(){
        validateEmpty(this);
    });

    $('form[name="editTask"] input').on('focusout', function(){
        validateEmpty(this);
        if($(this).attr('id') == 'inputEmailEdit'){
            validateEmail(this);
        }
    });
    $('form[name="editTask"] textarea').on('focusout', function(){
        validateEmpty(this);
    });

});

function validateEmpty(input){
    if($(input).attr('type') == 'submit'){
        return 1;
    }
    neighbor = $(input).siblings('.invalidMessage');
    existNeighbor = neighbor.length > 0 ? 1 : 0;
    if($(input).val() == ''){
        $(input).addClass('invalid');
        $(input).removeClass('valid');
        if(existNeighbor){
            neighbor.remove();
        }
        $(input).after("<div class='alert alert-danger invalidMessage'>Поле обязательно для заполнения</div>");
        return 0;
    } else {
        $(input).addClass('valid');
        $(input).removeClass('invalid');
        if(existNeighbor){
            neighbor.remove();
        }
        return 1;
    }
}

function validateEmail(input){
    if($(input).attr('type') == 'submit'){
        return;
    }
    let neighbor = $(input).siblings('.invalidMessage');
    let existNeighbor = neighbor.length > 0 ? 1 : 0;
    let email = $(input).val();

    let pattern  = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let isValid = pattern.test(email);
    if(!isValid){
        $(input).addClass('invalid');
        $(input).removeClass('valid');
        if(!existNeighbor){
            $(input).after("<div class='alert alert-danger invalidMessage'>В поле должен быть адрес эл.почты</div>");
        }
        return 0;
    } else {
        $(input).addClass('valid');
        $(input).removeClass('invalid');
        if(existNeighbor){
            neighbor.remove();
        }
        return 1;
    }

}
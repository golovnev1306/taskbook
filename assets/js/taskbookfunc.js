function errorDisplay(text, selector, type = 'danger')
{
    let htmlText = '';
    htmlText += "<div class='alert alert-"+type+" alert-dismissible fade in' role='alert'>";
    htmlText +=     "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    htmlText +=         "<span aria-hidden='true'>&times;</span>";
    htmlText +=         "</button>";
    htmlText +=     "<strong>" + text + "</strong>";
    htmlText += "</div>";
    $(selector).html(htmlText);
}

function clickAutorization(e)
{
    e.preventDefault();
    let login = $('input[name=login]').val();
    let pass = $('input[name=pass]').val();
    $(this).find('input').each(function(index){
        if(!validateEmpty(this)){
            return;
        }
    });
    $.ajax({
        url:'/login',
        type:'POST',
        data:{login:login, pass:pass},
        success:function(data){
            if(data == 1){
                location.href = location.href;
            } else {
                errorDisplay(data, '.validatePassMessage');
            }
        }
    });
}

function clickAdd(e)
{
    let isValid = true;
    e.preventDefault();
    let userName = $('input[name=inputUserNameAdd]').val();
    let email = $('input[name=inputEmailAdd]').val();
    let text = $('textarea[name=inputTextAdd]').val();
    $(this).find('input, textarea').each(function(){
        if($(this).attr('id') == 'inputEmailAdd'){
            if(!validateEmail(this)){
                isValid = false;
                return;
            }
        }
        if(!validateEmpty(this)){
            isValid = false;
            return;
        }
    });
    if(!isValid){
        return;
    }
    $.ajax({
        url:'/addtask',
        type:'POST',
        data:{userName:userName, email:email, text:text},
        success:function(data){
            if(data == 1){
                location.href = location.href;
            } else {
                errorDisplay(data, '.validateFormMessage');
            }
        }
    });
}

function sortTask(e, sort)
{
    e.preventDefault();
    let sortValue = $(e.target).attr('data-sort');
    $.ajax({
        url:'/sort',
        type:'POST',
        data:{sort:sort, sortValue:sortValue},
        success:function(data){
            if (data == 1) {
                location.href = location.href;
            } else {
                errorDisplay(data, '.displayError');
            }
        }
    });
}

function clickEdit(e)
{
    let isValid = true;
    e.preventDefault();
    let userName = $('input[name=inputUserNameEdit]').val();
    let email = $('input[name=inputEmailEdit]').val();
    let text = $('textarea[name=inputTextEdit]').val();
    let id = $('input[name=hiddenIdEdit]').val();
    $(this).find('input, textarea').each(function(){
        if($(this).attr('id') == 'inputEmailEdit'){
            if(!validateEmail(this)){
                isValid = false;
                return;
            }
        }
        if(!validateEmpty(this)){
            isValid = false;
            return;
        }
    });
    if(!isValid){
        return;
    }
    $.ajax({
        url:'/edittask',
        type:'POST',
        data:{userName:userName, email:email, text:text, id:id},
        success:function(data){
            if(data == 1){
                location.href = location.href;
            } else {
                errorDisplay(data, '.validateFormMessage');
            }
        }
    });
}
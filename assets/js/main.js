$(document).ready(function(){
    $('.edit').on('click',function(){
        let thisTask = $(this).closest('.task');
        let id = thisTask.attr('data-id');
        let name = thisTask.find('.taskName').text();
        let email = thisTask.find('.taskEmail').text();
        let text = thisTask.find('.taskText').text();

        $('#editModal').find('#inputUserNameEdit').val(name);
        $('#editModal').find('#inputEmailEdit').val(email);
        $('#editModal').find('#inputTextEdit').val(text);
        $('#editModal').find('#hiddenIdEdit').val(id);
    });

    $('form[name="editTask"]').on('submit', clickEdit);
    $('form[name="login"]').on('submit', clickAutorization);
    $('form[name="addTask"]').on('submit', clickAdd);

    $('.sortLink:not(.active)').on('click', function(e){
        sortTask(e, 'sortType');
    });
    $('.sortByLink:not(.active)').on('click', function(e){
        sortTask(e, 'sortField');
    });

    $('.delete').on('click',function(){
        if(confirm('Действительно хотите удалить?')){
            let thisTask = $(this).closest('.task');
            let id = thisTask.attr('data-id');
            $.ajax({
                url:'/deletetask',
                type:'POST',
                data:{'id':id},
                success:function(data){
                    if(data == 1){
                        location.href = location.href;
                    } else {
                        errorDisplay(data, '.displayError');
                    }
                }
            });
        }
    });

    $('.performed').on('click',function(){
        if(confirm('Статус изменится на "выполнен", продолжить?')){
            let thisTask = $(this).closest('.task');
            let id = thisTask.attr('data-id');
            $.ajax({
                url:'/performtask',
                type:'POST',
                data:{'id':id},
                success:function(data){
                    if(data == 1){
                        location.href = location.href;
                    } else {
                        errorDisplay(data, '.displayError');
                    }
                    
                }
            });
        }
    });
});

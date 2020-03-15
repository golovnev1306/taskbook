<?php if( isset($_SESSION['success']) ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=$_SESSION['success']?>
    </div>
<?php endif;
unset($_SESSION['success']);
?>
<div class="displayError"></div>

<!-- Кнопка запуска модального окна -->  
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal">
  <span class='glyphicon glyphicon-plus'></span> Добавить задачу
</button>

<div class='sortWrap'>
  <div class='sortBy row'>
    <div class='col-xs-4 col-md-2'>Сортировать по:</div>
    <div class='col-xs-8 col-md-10'>
      <a class='<?if($_SESSION['sortField'] == 'user_name' || !isset($_SESSION['sortField'])):?>active <?endif;?>sortByLink' href="/" data-sort='user_name'>Имени пользователя</a> 
      <a class='<?if($_SESSION['sortField'] == 'email'):?>active <?endif;?>sortByLink' href="/" data-sort='email'>Email</a> 
      <a class='<?if($_SESSION['sortField'] == 'is_performed'):?>active <?endif;?>sortByLink' href="/" data-sort='is_performed'>Статусу</a>
    </div>
  </div>
  <div class='sort row'>
    <div class='col-xs-4 col-md-2'></div>
    <div class='col-xs-8 col-md-10'>
      <a class='<?if($_SESSION['sortType'] == 'desc' || !isset($_SESSION['sortType'])):?>active <?endif;?>sortLink' href="/" data-sort='desc'>Убыванию</a> 
      <a class='<?if($_SESSION['sortType'] == 'asc'):?>active <?endif;?>sortLink' href="/" data-sort='asc'>Возрастанию</a>
    </div>
  </div>
</div>

<!-- Модальное окно для добавления -->  
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class='row'>
        <div class='col-xs-10'>
          <h4 class="modal-title" id="myModalLabel">Добавление задачи</h4>
        </div>
        <div class='col-xs-2'>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        </div>
      </div>
      <div class="validateFormMessage"></div>
      <form name="addTask">
      <div class="modal-body">
        <div class="form-group">
          <label for="inputUserNameAdd">Имя пользователя</label>
          <input type="text" class="form-control" id="inputUserNameAdd" name="inputUserNameAdd">
        </div>
        <div class="form-group">
          <label for="inputEmailAdd">E-mail</label>
          <input type="email" class="form-control" id="inputEmailAdd" name="inputEmailAdd">
        </div>
        <div class="form-group">
          <label for="inputTextAdd">Текст задачи</label>
          <textarea class="form-control" id="inputTextAdd" name="inputTextAdd" rows="3"></textarea>
          
        </div>

        </div>
        <div class="modal-footer">
          <div class="col-xs-12">
            <input type="submit" value='Сохранить' class='btn btn-primary'>
          </div>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Модальное окно для изменения -->  
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="editModalLabel">Изменение задачи</h4>
      </div>
      <div class="validateFormMessage"></div>
      <form name="editTask">
      <div class="modal-body">
        <div class="form-group">
          <label for="inputUserNameEdit">Имя пользователя</label>
          <input type="text" class="form-control" id="inputUserNameEdit" name="inputUserNameEdit">
        </div>
        <div class="form-group">
          <label for="inputEmailEdit">E-mail</label>
          <input type="email" class="form-control" id="inputEmailEdit" name="inputEmailEdit">
        </div>
        <div class="form-group">
          <label for="inputTextEdit">Текст задачи</label>
          <textarea class="form-control" id="inputTextEdit" name="inputTextEdit" rows="3"></textarea>
          
        </div>
        <input type="hidden" id='hiddenIdEdit' name='hiddenIdEdit'> 

        </div>
        <div class="modal-footer">
          <div class="col-xs-12">
            <input type="submit" value='Сохранить' class='btn btn-primary'>
          </div>
        </div>
      </form>
      
    </div>
  </div>
</div>

<?php
if($tasks){
  echo "<h2>Список задач</h2>";
}
  ?>
<div class='tasks'>
<?php
if($tasks){
    foreach($tasks as $task){?>
        <div class='task col-xs-12' data-id='<?=$task['id']?>'>
          <div class='taskName'><?=$task['user_name'];?></div>
          <div class='taskEmail'><?=$task['email'];?></div>
          <?php if($_SESSION['user']['isAdmin']){?>
          <div class='taskControlButtons'>
          <?php if(!$task['is_performed']){?><span title="Поставить отметку о выполнении" class="glyphicon glyphicon-ok performed"></span><?php }?>
            <span title="Редактировать"><span data-toggle="modal" data-target="#editModal" class='glyphicon glyphicon-pencil edit'></span></span>
            <span title="Удалить" class='glyphicon glyphicon-remove delete'></span>
          </div>
          <?php }?>
          <div class='taskText'><?=$task['text'];?></div>
          
            <?php if($task['is_performed']){?>
              <div class='taskPerformed'>
                <span class="glyphicon glyphicon-ok"></span> Выполнено</div>
            <?php }?>
            <?php if($task['is_edited_admin']){?>
              <div class='taskPerformed'>
                Отредактировано администратором</div>
            <?php }?>
        </div>
    <?php }
?>
</div>
<div class="pagination">
<?php
echo $pagination->getButtons();
?>
</div>
<?php
} else {
?>
    <p>Задач нет</p>
<?php
}
?>
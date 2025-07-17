<style>
  .table_blur {
  background: #f5ffff;
  border-collapse: collapse;
  text-align: left;
}
.table_blur th {
  border-top: 1px solid #777777;	
  border-bottom: 1px solid #777777; 
  box-shadow: inset 0 1px 0 #999999, inset 0 -1px 0 #999999;
  background: linear-gradient(#9595b6, #5a567f);
  color: white;
  padding: 10px 15px;
  position: relative;
}
.table_blur th:after {
  content: "";
  display: block;
  position: absolute;
  left: 0;
  top: 25%;
  height: 25%;
  width: 100%;
  background: linear-gradient(rgba(255, 255, 255, 0), rgba(255,255,255,.08));
}
.table_blur tr:nth-child(odd) {
  background: #ebf3f9;
}
.table_blur th:first-child {
  border-left: 1px solid #777777;	
  border-bottom:  1px solid #777777;
  box-shadow: inset 1px 1px 0 #999999, inset 0 -1px 0 #999999;
}
.table_blur th:last-child {
  border-right: 1px solid #777777;
  border-bottom:  1px solid #777777;
  box-shadow: inset -1px 1px 0 #999999, inset 0 -1px 0 #999999;
}
.table_blur td {
  border: 1px solid #e3eef7;
  padding: 10px 15px;
  position: relative;
  transition: all 0.5s ease;
}
.table_blur tbody:hover td {
  color: transparent;
  text-shadow: 0 0 3px #a09f9d;
}
.table_blur tbody:hover tr:hover td {
  color: #444444;
  text-shadow: none;
}
  </style>


<?php
           session_start();
           ob_start();
           ini_set('display_errors', 'On');
           $ses = wp_get_current_user()->user_login;
           if($ses == false)
            {
             ob_end_clean();
             echo '<p>Страница доступна ТОЛЬКО авторизированым пользователям. Пожалуйста, залогиньтесь по ссылке ниже, чтобы продолжить</p>';
             echo '<a class="btn" href="https://www.arcaim.net/wp-login.php" name="sucsess">Залогинится</a>';
             exit;
            }
           $sql_check_info = "SELECT ARCW_users.* FROM ARCW_users WHERE login='$ses'";
           $result_check = mysqli_query($link,$sql_check_info);
           if(empty($result_check))
           {
             $sql_client = "INSERT INTO ARCW_users(login) values ('$ses')";
             $result_cs = mysqli_query($link,$sql_client);
           }
           echo '<a class="btn" href="https://www.arcaim.net/addword/" name="universe_add">Добавить слово</a> <br>
           <br>';
          echo '<form action="" method="post">
          <input type="submit" name="button_public" value="Опубликовать словарь!"> <br> 
          <br>
          </form>';
            if (isset($_POST['button_public']))
            {
              $id_word_list = $_SESSION['id_word_list'];
              $sql_update_public = "UPDATE arcw_word_list SET public_list = '1' WHERE arcw_word_list.id = '$id_word_list'";
              $sql_check_word_empty = "SELECT arcw_word_list.* FROM arcw_word_list WHERE arcw_word_list.id = '$id_word_list'";
              $result_check = mysqli_query($link, $sql_check_word_empty);
              if($result_check == false)
              {
                echo '<script>alert("Для публикации словаря нужно заполнить его словами")</script>';
              }
              elseif($result_check == true){
                $result_update = mysqli_query($link, $sql_update_public);
                echo '<script>alert("Словарь успешно опубликован")</script>';
              } 
            }
            echo '<form action="" method="post">
            <input type="submit" name="button_unpublic" value="Скрыть словарь"></form> <br>
            <br>';
            if (isset($_POST['button_unpublic']))
            {
              $id_word_list = $_SESSION['id_word_list'];
              $sql_update_public = "UPDATE arcw_word_list SET public_list = '0' WHERE arcw_word_list.id = '$id_word_list'";
              $result_update = mysqli_query($link, $sql_update_public);
              echo '<script>alert("Словарь успешно скрыт")</script>';
              } 
          $id_word_list = $_SESSION['id_word_list'];
          $sql2 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $id_word_list AND arcw_word.list_id = $id_word_list AND ARCW_users.login = '$ses'";
          $result2 = mysqli_query($link,$sql2);
          if($result2 == true)
          {
          echo "<table class='table_blur'><tr><th>Слово</th><th> Перевод слова </th><th>Удалить слово</th></tr>";
          while($count = mysqli_fetch_row($result2))
          {
          echo "<tr>";
          echo "<td>" . $count[1] . "</td>";
          echo "<td>" . $count[2] . "</td>";
          echo '<td><button onclick="get_id(' . $count[0] . ')">Удалить слово</button></td>';
          }
echo "</table>";
        } elseif($result2 == false) {
          echo "Словарь пустой. Добавьте новые слова, чтобы начать работу с ним";
        }


    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      // здесь можно выполнить любые действия с ID вакансии
      $sql323 = "DELETE FROM arcw_word WHERE id = $id";
                 $result44 = mysqli_query($link, $sql323);
                 if($result44)
                 {
                   echo '<script>alert("Слово удалено. Для того, чтобы увидеть изменения - обновите страницу")</script>';
                   //ob_end_clean();
                   //echo '<a class="btn" href="http://workshop/?page_id=460" name="universe_add">Вернуться на страницу с вакансиями</a>';
                   //exit;
                 } else
                 {
                  echo '<script>alert("Произошла ошибка")</script>';
                  //ob_end_clean();
                  //echo '<a class="btn" href="http://workshop/?page_id=460" name="universe_add">Вернуться на страницу с вакансиями</a>';
                  //exit;
                 }
      //echo 'ID вакансии: ' . $id;
  }
      ?>

<script>
    function get_id(id) {
        var form = document.createElement("form");
        form.method = "POST";
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "id";
        input.value = id;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
</script>
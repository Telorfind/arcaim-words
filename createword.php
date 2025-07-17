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
     $ses = wp_get_current_user()->user_login;
     //var_dump($ses);
     if($ses == false)
      {
       ob_end_clean();
       echo '<h3>Страница доступна ТОЛЬКО авторизированым пользователям. Пожалуйста, залогиньтесь по ссылке ниже, чтобы продолжить</h3>';
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
          if(isset($_POST['button']))
        {
            //$sql23 = "SELECT * FROM ARCW_word_list WHERE LOWER(login) LIKE '%$ses%'";
            //$result_SQ = pg_query($link,$sql23);
            $list_id = $_SESSION['id_word_list'];
            $word = $_POST['word'];
            $word_translate = $_POST['word_translate'];
            //$fathername_client = $_POST['name_company'];
            //$adress_client = $_POST['adress_client'];
            $sql_add_word_list = "INSERT INTO arcw_word(word, word_translate, list_id) values ('$word','$word_translate','$list_id')";
            $result = mysqli_query($link,$sql_add_word_list);
            //$resa = pg_fetch_assoc($result);
            if($result)
            {
                echo '<script>alert("Слово успешно добавлено")</script>';
                echo '<a class="btn" href="https://www.arcaim.net/addword" name="universe_add">Добавить ещё слово</a>';
                echo '<a class="btn" href="https://www.arcaim.net/wordsedit" name="universe_add">Просмотреть текущее состояние словаря</a>';
                exit;
            }
            else{
              echo '<script>alert("Произошла ошибка. Пожалуйста, повторите попытку")</script>';
              echo '<a class="btn" href="https://www.arcaim.net/addword/" name="universe_add">Попробовать снова</a>';
              exit;
            }
        }
        ?>
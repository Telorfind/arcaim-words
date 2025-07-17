<?php
      session_start();
      //ini_set('display_errors', 'Off');
      if(!$_SESSION['login'])
      {
          echo("Для доступа к этой странице АВТОРИЗИРУЙТЕСЬ!");
      }
      $ses=$_SESSION['login'];
      $pas=$_SESSION['name'];
        $link = pg_connect("hostaddr=127.0.0.1 port=5433 dbname=arcaim_word_users user=$ses password=$pas") or die("Неверное имя пользователя или пароль");
        $stat = pg_connection_status($link);
        if ($stat === PGSQL_CONNECTION_OK) {
          $sql = "SELECT * FROM ARCW_users WHERE LOWER(login) LIKE '%$ses%'";
          $result = pg_query($link,$sql);

          //$resa = pg_fetch_assoc($result);
          if(isset($_POST['button']))
        {
            $sql23 = "SELECT * FROM ARCW_users WHERE LOWER(login) LIKE '%$ses%'";
            $result_SQ = pg_query($link,$sql23);
            $user_id = pg_fetch_result($result_SQ, 0,0);
            $language = $_POST['position_vacantion'];
            $name_word_list = $_POST['salary'];
            //$fathername_client = $_POST['name_company'];
            //$adress_client = $_POST['adress_client'];
            $sql_add_word_list = "insert into arcw_word_list (language_lernen, name, user_id) values ('$language','$name_word_list','$user_id')";
            $result = pg_query($link,$sql_add_word_list);
            //$resa = pg_fetch_assoc($result);
            if($result)
            {
                echo '<script>alert("Словарь успешно добавлен")</script>';
                echo '<a class="btn" href="http://arcaim/create_slowo/" name="universe_add">Вернуться на страницу со словарями</a>';
                exit;
            }
            else{
              echo '<script>alert("Произошла ошибка. Пожалуйста, повторите попытку")</script>';
              echo '<a class="btn" href="http://arcaim/create_slowo/" name="universe_add">Попробовать снова</a>';
              exit;
            }
        }
    }
        ?>
<?php
       ob_start();
        echo '<form action="" method="post">
        <p>Язык словаря <br> 
        <select name="language">
        <option value="DE">DE</option>
        <option value="EN">EN</option>
        </select> <br>
        <p>Перевод <br> 
        <select name="language_translate">
        <option value="UA">UA</option>
        <option value="RU">RU</option>
        <option value="DE">DE</option>
        <option value="EN">EN</option>
        </select>
         <br> 
        Название словаря: <br> 
        <input type="text" name="name_word_list" /> <br>
        </p> <br>
        <input type="submit" name="button" value="Создать словарь"> <br>
        </form>';
       $ses = wp_get_current_user()->user_login;
       ini_set('display_errors', 'On');
       if ($ses == false)
       {
        ob_end_clean();
        echo '<h3>Страница доступна ТОЛЬКО авторизированым пользователям. Пожалуйста, залогиньтесь по ссылке ниже, чтобы продолжить</h3>';
        echo '<a class="btn" href="https://www.arcaim.net/wp-login.php" name="sucsess">Залогинится</a>';
        exit;
       }
       $sql_check_info = "SELECT arcw_users.* FROM arcw_users WHERE login='$ses'";
       $result_check = mysqli_query($link,$sql_check_info);
       if(empty($result_check))
       {
         $sql_client = "INSERT INTO ARCW_users(login) values ('$ses')";
         $result_cs = mysqli_query($link,$sql_client);
       }
          //$resa = pg_fetch_assoc($result);
          if(isset($_POST['button'])){
            $sql23 = "SELECT id FROM ARCW_users WHERE login = '$ses'";
            $result_SQ = mysqli_query($link,$sql23);
            $array = mysqli_fetch_array($result_SQ);
            $user_id = $array[0];
            //$finfo = mysqli_fetch_field_direct($result_SQ, 1);
            //$user_id = $finfo->id;
            //mysqli_free_result($result_SQ);
            //var_dump($user_id);
            //$user_id = mysqli_fetch_result($result_SQ, 0,0);
            $language = $_POST['language'];
            $language_translate = $_POST['language_translate'];
            $name_word_list = $_POST['name_word_list'];
            $public = 0;
            $sql_add_word_list = "INSERT INTO arcw_word_list(language_lernen, language_translate, name, public_list, user_id) values ('$language', '$language_translate','$name_word_list','$public','$user_id')";
            $result = mysqli_query($link,$sql_add_word_list);
            //$resa = pg_fetch_assoc($result);
            if($result == true)
            {
                ob_end_clean();
                echo '<script>alert("Словарь успешно добавлен")</script>';
                echo '<a class="btn" href="https://www.arcaim.net/mywordlists" name="sucsess">Вернуться на страницу со словарями</a>';
                exit;
            }
            else{
              ob_end_clean();
              echo '<script>alert("Произошла ошибка. Пожалуйста, повторите попытку")</script>';
              echo '<a class="btn" href="https://www.arcaim.net/createwordlist" name="deny">Попробовать снова</a>';
              exit;
            }
        }
        ?>
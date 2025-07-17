<?php
 session_start();
 ob_start();
 echo '<form action="" method="post">
 <h4>Регистрация аккаунта
         </h4>
<p>
Email 
<input type="text" name="email" />
Telegram (номер телефона или юзернейм) 
<input type="text" name="telegram" />
Логин 
<input type="text" name="login_USER" />
Ваш родной язык
<select name="language_user">
   <option value="UA">UA</option>
   <option value="RU">RU</option>
   <option value="DE">DE</option>
   <option value="EN">EN</option>
   </select>
Пароль 
<input type="text" name="password" />
 <input type="submit" name="button" value="Регистрация">
 </form>';
 //ini_set('display_errors', 'Off');
 //$ses=$_SESSION['login'];
 //$pas=$_SESSION['name'];
   $link = pg_connect("hostaddr=127.0.0.1 port=5433 dbname=arcaim_word_users user=postgres password=sedsxd12") or die("Неверное имя пользователя или пароль");
   $stat = pg_connection_status($link);
   if ($stat === PGSQL_CONNECTION_OK) {
   if(isset($_POST['button']))
   {
       $email = $_POST['email'];
       $telegram = $_POST['telegram'];
       $login_client = $_POST['login_USER'];
       $language_user = $_POST['language_user'];
       $password_user = $_POST['password'];
       $sql_client = "INSERT INTO ARCW_users(login, language_usera, email_user, Telegram, Verifikation_user) values ('$login_client', '$language_user', '$email', '$telegram', false)";
       $sql_client_role = "CREATE ROLE $login_client WITH LOGIN PASSWORD '$password_user'";
       $sql_client_grand_role = "GRANT SELECT ON ARCW_users TO $login_client";
       $sql_client_grand_role2 = "GRANT SELECT ON ARCW_word_list TO $login_client";
       $sql_client_grand_role6 = "GRANT SELECT ON ARCW_word TO $login_client";
       $sql_client_grand_role5 = "GRANT INSERT ON ARCW_word_list TO $login_client";
       $sql_client_grand_role7 = "GRANT INSERT ON ARCW_word TO $login_client";
       $sql_client_grand_role3 = "GRANT USAGE ON SEQUENCE ARCW_word_list_id_seq TO $login_client";
       $sql_client_grand_role4 = "GRANT USAGE ON SEQUENCE ARCW_word_id_seq TO $login_client";
       $sql_client_grand_role8 = "GRANT USAGE ON SEQUENCE arcw_statistik_id_seq TO $login_client";
       $sql_client_grand_role9 = "GRANT USAGE ON SEQUENCE verific_users_id_seq TO $login_client";
       $sql_client_grand_role10 = "GRANT UPDATE ON ARCW_word_list TO $login_client";
       $sql_client_grand_role11 = "GRANT UPDATE ON ARCW_users TO $login_client";
       $sql_client_grand_role12 = "GRANT UPDATE ON arcw_statistik TO $login_client";
       $sql_client_grand_role13 = "GRANT UPDATE ON VERIFIC_users TO $login_client";
       $sql_client_grand_role14 = "GRANT DELETE ON arcw_statistik TO $login_client";
       $sql_client_grand_role15 = "GRANT DELETE ON VERIFIC_users TO $login_client";
       $sql_client_grand_role16 = "GRANT INSERT ON arcw_statistik TO $login_client"; 
       $sql_client_grand_role17 = "GRANT INSERT ON VERIFIC_users TO $login_client";
       $sql_client_grand_role18 = "GRANT SELECT ON arcw_statistik TO $login_client";
       $sql_client_grand_role19 = "GRANT SELECT ON VERIFIC_users TO $login_client";
       $sql_client_grand_role20 = "GRANT UPDATE ON ARCW_word TO $login_client";
       $sql_client_grand_role21 = "GRANT DELETE ON ARCW_word_list TO $login_client";
       $sql_client_grand_role22 = "GRANT DELETE ON ARCW_users TO $login_client";
       $sql_client_grand_role23 = "GRANT DELETE ON ARCW_word TO $login_client";
       $result = pg_query($link,$sql_client);
         if($result)
         {
         $result_role = pg_query($link,$sql_client_role);
         $result1 = pg_query($link,$sql_client_grand_role);
         $result2 = pg_query($link,$sql_client_grand_role2);
         $result3 = pg_query($link,$sql_client_grand_role3);
         $result4 = pg_query($link,$sql_client_grand_role4);
         $result5 = pg_query($link,$sql_client_grand_role5);
         $result6 = pg_query($link,$sql_client_grand_role6);
         $result7 = pg_query($link,$sql_client_grand_role7);
         $result8 = pg_query($link,$sql_client_grand_role8);
              $result9 = pg_query($link,$sql_client_grand_role9);
              $result10 = pg_query($link,$sql_client_grand_role10);
              $result11 = pg_query($link,$sql_client_grand_role11);
              $result12 = pg_query($link,$sql_client_grand_role12);
              $result13 = pg_query($link,$sql_client_grand_role13);
              $result14 = pg_query($link,$sql_client_grand_role14);
              $result15 = pg_query($link,$sql_client_grand_role15);
              $result16 = pg_query($link,$sql_client_grand_role16);
              $result17 = pg_query($link,$sql_client_grand_role17);
              $result18 = pg_query($link,$sql_client_grand_role18);
              $result19 = pg_query($link,$sql_client_grand_role19);
              $result20 = pg_query($link,$sql_client_grand_role20);
              $result21 = pg_query($link,$sql_client_grand_role21);
              $result22 = pg_query($link,$sql_client_grand_role22);
              $result23 = pg_query($link,$sql_client_grand_role23);
              ob_end_clean();
              echo '<h5>Регистрация завершена!</h5><br>';
              echo '<a class="btn" href="http://arcaim/enter/" name="button_kommon">Авторизироваться</a>';
              }
              else{
                echo 'Данный логин уже занят. Попробуйте другой <br> <a href="http://arcaim" class="button">Вернуться на главную и попробовать снова</a>';
              }
            }
        }
?>

<style>
@media screen and (max-width: 600px) {
	table {width:100%;} 
	thead {display: none;} 
	tr:nth-of-type(2n) {background-color: inherit;} 
	tr td:first-child {background: #f0f0f0; font-weight:bold;font-size:1.3em;} 
	tr th:first-child {font-weight:bold;font-size:1.3em;} 
	tbody td, tbody th {display: block; text-align:center;} 
	tbody td, tbody th:before { content: attr(data-th); display: block; text-align:center; } 
}

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
        echo '<p>Страница доступна ТОЛЬКО авторизированым пользователям. Пожалуйста, залогиньтесь по ссылке ниже, чтобы продолжить</p>';
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
      
      //ini_set('display_errors', 'Off');
      //$pas=$_SESSION['name'];
        //$stat = pg_connection_status($link);
        /*if ($link == true)
        {
            echo "База данных подключена успешно";
        }
        else{
            echo "Отказано в доступе";
        }*/
        //if ($stat === PGSQL_CONNECTION_OK) {
          $sql2 = "SELECT arcw_word_list.* FROM arcw_word_list, ARCW_users WHERE user_id = ARCW_users.id AND ARCW_users.login = '$ses'";
          $result2 = mysqli_query($link,$sql2);
          if($result2 == true)
          {
          echo "<div class='tables-responsive swipeignore'><table class='table_blur'><tr><th>Название словаря    </th> <th>Язык словаря     </th><th>Перевод словаря    </th> <th>Внести изменения в словарь    </th></tr>";
          while($count = mysqli_fetch_row($result2))
          {
          echo "<tr>";
          echo "<td>" . $count[3] . "</td>";
          echo "<td>" . $count[1] . "</td>";
          echo "<td>" . $count[2] . "</td>";
          echo '<td><button onclick="get_id(' . $count[0] . ')">Редактировать словарь</button></td>';
          }
echo "</table></div>";
        } elseif($result2 == false)
        {
            echo "Словари отсутствуют";
        }
    //}

    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      // здесь можно выполнить любые действия с ID вакансии
      $_SESSION['id_word_list'] = $id;
      echo '<script>window.location.replace("https://www.arcaim.net/wordsedit/");</script>';
      exit;
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
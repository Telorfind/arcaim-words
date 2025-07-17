<style>
body {
    text-align: center;
    padding-top: 10%;
    font-family: sans-serif;
  background-image: url('bg.jpg');
  background-size: cover;
  height: 100vh;
  color: #fff;
  
}
.table-wrap {
    text-align: center;
    display: inline-block;
  background-color: #fff;
  padding: 2rem 2rem;
  color: #000;
}
 
 table {
    border: 1px solid #ccc;
    width: 100%;
    margin:0;
    padding:0;
    border-collapse: collapse;
    border-spacing: 0;
  }
 
  table tr {
    border: 1px solid #ddd;
    padding: 5px;
  }
 
  table th, table td {
    padding: 10px;
    text-align: center;
    border-right: 1px solid #ddd;
  }
 
  table th {
    color: #fff;
    background-color: #444;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
  }


@media screen and (max-width: 600px) {
  table {
    border: 0;
  }
  table thead {
    display: none;
  }
  table tr {
    margin-bottom: 10px;
    display: block;
    border-bottom: 2px solid #ddd;
  }
  table td {
    display: block;
    text-align: right;
    font-size: 13px;
    border-bottom: 1px dotted #ccc;
    border-right: 1px solid transparent;
  }
  table td:last-child {
    border-bottom: 0;
  }
  table td:before {
    content: attr(data-label);
    float: left;
    text-transform: uppercase;
    font-weight: bold;
  }
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
          echo "<div class='table-wrap'><table><tr><th>ID     </th><th>Язык словаря     </th><th>Перевод словаря    </th> <th>Название словаря    </th> <th>Внести изменения в словарь    </th></tr><tbody>";
          while($count = mysqli_fetch_row($result2))
          {
          echo "<tr>";
          echo "<td>" . $count[0] . "</td>";
          echo "<td>" . $count[1] . "</td>";
          echo "<td>" . $count[2] . "</td>";
          echo "<td>" . $count[3] . "</td>";
          echo '<td><button onclick="get_id(' . $count[0] . ')">Редактировать словарь</button></td>';
          }
echo "</tbody></table> </div>";
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
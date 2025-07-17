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
      //ini_set('display_errors', 'Off');
      $ses=$_SESSION['login'];
      $pas=$_SESSION['name'];
        $link = pg_connect("hostaddr=127.0.0.1 port=5433 dbname=arcaim_word_users user=$ses password=$pas") or die("Неверное имя пользователя или пароль");
        $stat = pg_connection_status($link);
        if ($stat === PGSQL_CONNECTION_OK) {
          $sql2 = "SELECT arcw_word_list.* FROM arcw_word_list, arcw_users WHERE user_id = arcw_users.id AND LOWER(arcw_users.login) LIKE '%$ses%'";
          $result2 = pg_query($link,$sql2);
          echo "<table class='table_blur'><tr><th>ID     </th><th>Язык словаря     </th><th>Название словаря    </th> <th>Внести изменения в словарь    </th></tr>";
          while($count = pg_fetch_row($result2))
          {
          echo "<tr>";
          echo "<td>" . $count[0] . "</td>";
          echo "<td>" . $count[1] . "</td>";
          echo "<td>" . $count[2] . "</td>";
          echo '<td><button onclick="get_id(' . $count[0] . ')">Редактировать словарь</button></td>';
          }
echo "</table>";
    }

    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      // здесь можно выполнить любые действия с ID вакансии
      $_SESSION['id_word_list'] = $id;
      echo '<script>window.location.replace("http://arcaim/editword/");</script>';
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
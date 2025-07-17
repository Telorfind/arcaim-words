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

.main{
        display: none;
    }

.voice2{
        display: none;
    }
 
body
{
    background: #cfd8dc;
}

.card-container
{
    font-family: 'Open Sans', sans serif;
    font-size: 120px;
    font-weight: bold;

    width: 400px;
    height: 250px;
    margin: 80px auto;

    border-radius: 10px;

    perspective: 1400px;
}

.card
{
    position: relative;

    height: 100%;

    border-radius: 10px;

    widht: 100%;
    transform-style: preserve-3d;
}

.front,
.back
{
    display: flex;

    width: 100%;
    height: 100%;

    border-radius: 10px;

    justify-content: center;
    align-items: center;
    backface-visibility: hidden;
}

.front
{
    color: #fff;
    background: #2196f3;
}

.back
{
    position: absolute;
    top: 0;
    left: 0;

    transform: rotateY(180deg);

    color: #2196f3;
    background: #fff;
}
</style>

<?php
      session_start();
      //ini_set('display_errors', 'Off');
      $ses=$_SESSION['login'];
      $pas=$_SESSION['name'];
        $link = pg_connect("hostaddr=127.0.0.1 port=5433 dbname=arcaim_word_users user=$ses password=$pas") or die("Неверное имя пользователя или пароль");
        $stat = pg_connection_status($link);
        echo '<form action="" method="post">
        <p>Поиск словаря по названию: </p>
        <input type="text" name="name_word_list" /> <br>
        <input type="submit" name="button" value="Поиск!"> <br>
        </form>';
        if ($stat === PGSQL_CONNECTION_OK) {
          ob_start();
          $sql_QL = "SELECT arcw_word_list.*, arcw_users.login FROM arcw_word_list, arcw_users WHERE user_id = arcw_users.id AND arcw_word_list.public_list = 'true'";
          $result_QL = pg_query($link,$sql_QL);
          echo "<table class='table_blur'><tr><th>ID     </th><th>Язык словаря     </th><th>Перевод словаря    </th> <th>Имя словаря    </th><th>Автор словаря    </th><th>Действие    </th></tr>";
          while($count = pg_fetch_row($result2))
          {
          echo "<tr>";
          echo "<td>" . $count[0] . "</td>";
          echo "<td>" . $count[1] . "</td>";
          echo "<td>" . $count[2] . "</td>";
          echo "<td>" . $count[3] . "</td>";
          echo "<td>" . $count[6] . "</td>";
          echo '<td><button onclick="get_id(' . $count[0] . ')">Выбрать словарь</button></td>';
          }
          echo "</table>";
        }

        if (isset($_POST['button']))
        {
          if ($stat === PGSQL_CONNECTION_OK) {
            ob_end_clean();
            $name_word_list = $_POST['name_word_list'];
            $sql_QL = "SELECT arcw_word_list.*, arcw_users.login FROM arcw_word_list, arcw_users WHERE user_id = arcw_users.id AND arcw_word_list.public_list = 'true' AND arcw_world_list.name = '$name_word_list'";
            $result_QL = pg_query($link,$sql_QL);
            echo "<table class='table_blur'><tr><th>ID     </th><th>Язык словаря     </th><th>Перевод словаря    </th> <th>Имя словаря    </th><th>Автор словаря    </th><th>Действие    </th></tr>";
            while($count = pg_fetch_row($result2))
            {
            echo "<tr>";
            echo "<td>" . $count[0] . "</td>";
            echo "<td>" . $count[1] . "</td>";
            echo "<td>" . $count[2] . "</td>";
            echo "<td>" . $count[3] . "</td>";
            echo "<td>" . $count[6] . "</td>";
            echo '<td><button onclick="get_id(' . $count[0] . ')">Выбрать словарь</button></td>';
            }
            echo "</table>";
            ob_start();
          }
        }

        if (isset($_POST['id'])) {
              ob_end_clean();
              $id = $_POST['id'];
            // здесь можно выполнить любые действия с ID вакансии
              $slovar = $id;
              $massive[] = NULL;
              //$slovar = $_POST['limit'];
              $game_mode = $_POST['game'];
              $_SESSION['slovar'] = $slovar; 
              echo "Перед началом пожалуйста повторите слова, после того, как закончите просмотр нажмите в конце таблицы кнопку Начать игру";
              $sql_wordlist_1 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, arcw_users, arcw_word_list WHERE user_id = arcw_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar";
              $result = pg_query($link,$sql_wordlist_1);
              //$massive = array();
              unset($_SESSION['massive_game1']);
              unset($_SESSION['word_slovo']);
              unset($_SESSION['random_nummer']);
              $sql_wordlist_2_5 = "SELECT count(arcw_word.*) FROM arcw_word, arcw_users, arcw_word_list WHERE user_id = arcw_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar";
              $result2_5 = pg_query($link,$sql_wordlist_2_5);
              $count_max = pg_fetch_result($result2_5, 0,0);
              $max = $count_max - 1;
              $i = 0;
              while ($i <= $max)
              {
                array_push($massive, $i);
                $i++;
              }
              unset($massive[0]);
              $_SESSION['massive_game1'] = $massive;
              //var_dump($massive);
              ob_start();
              echo "<table class='table_blur'><tr><th>Слово</th><th> Перевод слова </th></tr>";
              while($count = pg_fetch_row($result))
              {
              echo "<tr>";
              echo "<td>" . $count[1] . "</td>";
              echo "<td>" . $count[2] . "</td>";
          }
              echo "</table>";
              echo '<form action="" method="post">
              <input type="submit" name="button2" value="Начать игру!"> <br>
              </form>';
        }


        if (isset($_POST['button2'])) {
          ob_end_clean();
          //$massive = [0][0];
          $massive = $_SESSION['massive_game1'];
          $slovar = $_SESSION['slovar'];
          $sql_wordlist_2 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, arcw_users, arcw_word_list WHERE user_id = arcw_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar AND LOWER(arcw_users.login) LIKE '%$ses%'";
          $result2 = pg_query($link,$sql_wordlist_2);
          $sql_wordlist_2_5 = "SELECT count(arcw_word.*) FROM arcw_word, arcw_users, arcw_word_list WHERE user_id = arcw_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar AND LOWER(arcw_users.login) LIKE '%$ses%'";
          $result2_5 = pg_query($link,$sql_wordlist_2_5);
          $count_max = pg_fetch_result($result2_5, 0,0);
          ob_start();
          $max = $count_max - 1;
          //$random_nummer = rand(0, $max);
          $i = 0;
          while(true){
          $random_nummer = rand(0, $max);
          $key_search = $random_nummer + 1;
          if(array_key_exists($key_search, $massive) == true)
          {
            $_SESSION['random_nummer'] = $random_nummer;
            //$i = 1;
            break; 
          }
            if(empty($massive))
            {
              ob_end_clean();
              echo("Игра окончена. Все слова из словаря были успешно правильно отвечены!");
              echo '<a class="btn" href="http://arcaim/lernenword/" name="arca_AS">Вернуться в меню выбора игр</a> <br>';
              /*var_dump($os);
              var_dump($random_nummer);
              var_dump($max);
              var_dump($count_max);
              var_dump($massive);*/
              exit;
            }
        }
          $random_nummer = $_SESSION['random_nummer'];
          $word_slovo = pg_fetch_result($result2, $random_nummer, 1);
          echo "<body onload='speak();'>
         </body>";
          //echo '<form action="" method="post">';
          echo "<h5> $word_slovo </h5> <div class='voice2'>
          <input id='text' value='$word_slovo' readonly>
          </div>
          <button onclick='speak();'>Произнести вслух</button> <br>
          <br>";
          //echo "$random_nummer <br>";
          //var_dump($massive);
          echo '<form action="" method="post">';
          echo '<input type="text" name="users_antwort" />';
          echo '<input type="submit" name="button3" value="Проверить cлово!">
          </form>';
          //echo "<div class='voice2'>
          //<input id='text' value='$word_slovo' readonly>
          //</div>
          //<button onclick='speak();'>Произнести вслух</button>";
          //$translate_word = $_POST['users_antwort'];
          //$_SESSION['random_nummer'] = $random_nummer;
          //$_SESSION['translate_word'] = $translate_word;
          $_SESSION['word_slovo'] = $word_slovo; 
          $_SESSION['massive_game1'] = $massive;
      }

      if (isset($_POST['button3']))
      {
        ob_end_clean();
        $slovar = $_SESSION['slovar'];
        $word_slovo = $_SESSION['word_slovo'];
        $random_nummer = $_SESSION['random_nummer'];
        $massive = $_SESSION['massive_game1'];
        ob_start();
        $translate_word = $_POST['users_antwort'];
        echo "<h5> Вы написали: $translate_word </h5> <br>";
        $sql_wordlist_3 = "SELECT arcw_word.word_translate FROM arcw_word, arcw_users, arcw_word_list WHERE user_id = arcw_users.id AND arcw_word_list.id = $slovar AND arcw_word.word = '$word_slovo' AND LOWER(arcw_users.login) LIKE '%$ses%'";
        $result3 = pg_query($link,$sql_wordlist_3);
        $true_ant = pg_fetch_result($result3, 0,0);
        echo "<h5> Правильный ответ: $true_ant </h5> <br>";
        if($translate_word == $true_ant)
        {
          echo "<h5> Ответ верный, переходите к следующему слову!</h5><br>";
          $key = $random_nummer + 1;
          unset($massive[$key]);
          //array_pop($massive, $random_nummer);
          unset($_SESSION['massive_game1']);
          $_SESSION['massive_game1'] = $massive;
          echo '<form action="" method="post">
          <input type="submit" name="button2" value="Перейти к следующему слову!"> <br>
          </form>';
        } 
        else{
          echo "Ответ НЕ ВЕРНЫЙ! Запомните перевод этого слова и повторите попытку позже!<br>";
          echo '<form action="" method="post">
          <input type="submit" name="button2" value="Перейти к следующему слову!"> <br>
          </form>';   
         }
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

    function speak(){ // Функция речи
        var lang = "de-DE"; // Задаём стандартный язык произношения
        //let main = document.querySelector('.main'); // Получаем главное меню
        //let sel = document.querySelector('#lang'); // Получаем селектор для наполнение
        let sound = document.querySelector('#text'); // Получаем элемент input
        let land = window.speechSynthesis.getVoices();
        var speech = window.speechSynthesis, // Объявляем переменные
            voice = '',
            ourvoice = []; // Сюда будем складывать доступные звуки браузера
        if (0 === ourvoice.length) { // Если равно нулю, то...
            var voices = speech.getVoices(); // Получаем все языки
        }
        for (var i = 0; i < voices.length; i++) { // Находим указанный в списке
            if (lang == voices[i].lang) {
                voice = voices[i]; // Ставим язык как параметр
            }
        }
        var readme = new SpeechSynthesisUtterance(sound.value); // вводим текст
        readme.voice = voice; // Задаём язык произношения
        speech.speak(readme); // Произносим
    }
</script>
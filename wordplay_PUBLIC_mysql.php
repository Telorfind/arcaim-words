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
      ob_start();
      $ses = wp_get_current_user()->user_login;
      //var_dump($ses);
      //ini_set('display_errors', 'On');
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
       ob_start();
         // $sql_QL = "SELECT arcw_word_list.* FROM arcw_word_list, ARCW_users WHERE user_id = ARCW_users.id AND ARCW_users.login = '$ses'";
          //$result_QL = mysqli_query($link,$sql_QL);
          echo '<form action="" method="post">
          <p>Поиск словаря по названию: </p>
          <input type="text" name="name_word_list" /> <br>
          <input type="submit" name="button_search" value="Поиск!"> <br>
          <br>
          </form>';
            $sql_QL = "SELECT arcw_word_list.*, ARCW_users.login FROM arcw_word_list, ARCW_users WHERE user_id = ARCW_users.id AND arcw_word_list.public_list = '1'";
            $result_QL = mysqli_query($link,$sql_QL);
            echo "<table class='table_blur'><tr><th>Имя словаря    </th><th>Язык словаря     </th><th>Перевод словаря    </th> <th>Автор словаря    </th><th>Действие    </th></tr>";
            while($count = mysqli_fetch_row($result_QL))
            {
            echo "<tr>";
            //echo "<td>" . $count[0] . "</td>";
            echo "<td>" . $count[3] . "</td>";
            echo "<td>" . $count[1] . "</td>";
            echo "<td>" . $count[2] . "</td>";
            echo "<td>" . $count[6] . "</td>";
            echo '<td><button onclick="get_id(' . $count[0] . ')">Выбрать словарь</button></td>';
            }
            echo "</table>";
            if (isset($_POST['button_search']))
            {
                ob_end_clean();
                echo '<form action="" method="post">
                <p>Поиск словаря по названию: </p>
                <input type="text" name="name_word_list" /> <br>
                <input type="submit" name="button_search" value="Поиск!"> <br>
                <br>
                </form>';
                $name_word_list = $_POST['name_word_list'];
                $sql_search = "SELECT arcw_word_list.*, ARCW_users.login FROM arcw_word_list, ARCW_users WHERE user_id = ARCW_users.id AND arcw_word_list.public_list = '1' AND arcw_word_list.name LIKE '%$name_word_list%'";
                $result_search = mysqli_query($link,$sql_search);
                echo "<table class='table_blur'><tr><th>Имя словаря    </th><th>Язык словаря     </th><th>Перевод словаря    </th> <th>Автор словаря    </th><th>Действие    </th></tr>";
                while($count = mysqli_fetch_row($result_search))
                {
                echo "<tr>";
                //echo "<td>" . $count[0] . "</td>";
                echo "<td>" . $count[3] . "</td>";
                echo "<td>" . $count[1] . "</td>";
                echo "<td>" . $count[2] . "</td>";
                echo "<td>" . $count[6] . "</td>";
                echo '<td><button onclick="get_id(' . $count[0] . ')">Выбрать словарь</button></td>';
                }
                echo "</table>";
                //exit;
            }
          if (isset($_POST['id'])) {
              ob_end_clean();
              $massive[] = NULL;
              $slovar = $_POST['id'];
              //$game_mode = $_POST['game'];
              $_SESSION['slovar'] = $slovar; 
              echo "Перед началом пожалуйста повторите слова, после того, как закончите просмотр нажмите в конце таблицы кнопку Начать игру";
              $sql_wordlist_1 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar";
              $result = mysqli_query($link,$sql_wordlist_1);
              if(empty($result))
              {
              echo "Для того, чтобы работать с данным словарём, пожалуйста, добавьте в него слова";
              exit;
              }
              //$massive = array();
              unset($_SESSION['massive_game1']);
              unset($_SESSION['word_slovo']);
              unset($_SESSION['random_nummer']);
              $sql_wordlist_2_5 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar";
              $result2_5 = mysqli_query($link,$sql_wordlist_2_5);
              //$count_max = pg_fetch_result($result2_5, 0,0);
              //$max = $count_max - 1;
              //$i = 0;
              //while ($i <= $count_max)
              //{
                //array_push($massive, );
                //$i++;
              //}
              while($count2_5 = mysqli_fetch_row($result2_5))
              {
               array_push($massive, $count2_5[0]); 
             }
              unset($massive[0]);
              $_SESSION['massive_game1'] = $massive;
              //var_dump($massive);
              ob_start();
              echo "<table class='table_blur'><tr><th>Слово</th><th> Перевод слова </th></tr>";
              while($count = mysqli_fetch_row($result))
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
            $sql_wordlist_2 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar AND ARCW_users.login = '$ses'";
            $result2 = mysqli_query($link,$sql_wordlist_2);
            $sql_wordlist_2_5 = "SELECT arcw_word.*, arcw_word_list.name FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar AND ARCW_users.login = '$ses'";
            $result2_5 = mysqli_query($link,$sql_wordlist_2_5);
            //$count_max = pg_fetch_result($result2_5, 0,0);
            ob_start();
            $sql_count = "SELECT count(arcw_word.id) FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.list_id = $slovar AND ARCW_users.login = '$ses'";
            $result_count = mysqli_query($link,$sql_count);
            $array_count_MAX = mysqli_fetch_array($result_count);
            $max = $array_count_MAX[0];
            //$max = $count_max - 1;
            //$random_nummer = rand(0, $max);
            //$i = 0;
            while(true){
            $key_search = rand(1, $max);
            //var_dump($key_search);
            //$key_search = $random_nummer + 1;
            if(array_key_exists($key_search, $massive) == true)
            {
              $_SESSION['random_nummer'] = $key_search;
              //$i = 1;
              //var_dump($random_nummer);
              break; 
            }
              if(empty($massive))
              {
                ob_end_clean();
                echo("Игра окончена. Все слова из словаря были успешно правильно отвечены!");
                echo '<a class="btn" href="https://www.arcaim.net/word_public" name="arca_AS">Вернуться в меню выбора игр</a> <br>';
                /*var_dump($os);
                var_dump($random_nummer);
                var_dump($max);
                var_dump($count_max);
                var_dump($massive);*/
                exit;
              }
          }
            $random_nummer = $_SESSION['random_nummer'];
            //$word_slovo = pg_fetch_result($result2, $random_nummer, 1);
            $id_word = $massive[$random_nummer];
            $sql_word = "SELECT arcw_word.* FROM arcw_word WHERE arcw_word.id = $id_word";
            $result_word = mysqli_query($link,$sql_word);
            $array_word = mysqli_fetch_array($result_word);
            $word_slovo = $array_word[1];
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
          $id_word = $massive[$random_nummer];
          ob_start();
          $translate_word = $_POST['users_antwort'];
          echo "<h5> Вы написали: $translate_word </h5> <br>";
          $sql_wordlist_3 = "SELECT arcw_word.word_translate FROM arcw_word, ARCW_users, arcw_word_list WHERE user_id = ARCW_users.id AND arcw_word_list.id = $slovar AND arcw_word.word = '$word_slovo' AND ARCW_users.login = '$ses' AND arcw_word.id = $id_word";
          $result3 = mysqli_query($link,$sql_wordlist_3);
          $array_result3 = mysqli_fetch_array($result3);
          $true_ant = $array_result3[0];
          echo "<h5> Правильный ответ: $true_ant </h5> <br>";
          if($translate_word == $true_ant)
          {
            echo "<h5> Ответ верный, переходите к следующему слову!</h5><br>";
            //$key = $random_nummer + 1;
            unset($massive[$random_nummer]);
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
    /*var lang = "de-DE"; // Задаём стандартный язык произношения
    let main = document.querySelector('.main'); // Получаем главное меню
    //let sel = document.querySelector('#lang'); // Получаем селектор для наполнение
    let sound = document.querySelector('#text'); // Получаем элемент input
    let land = window.speechSynthesis.getVoices(); */// Тестовый вызов для получения языков(Так как speech с 2018 года работает исключительно по активации.
    //activate.onclick = function() { // При нажатии на кнопку
        //let reactivate = window.speechSynthesis.getVoices(); // Реактивируем получения языков воспроизводимости
        //reactivate.forEach(function (c) { //Для каждого элемента
            //let opt = document.createElement('option'); // Создаём option
            //opt.value = c.lang; // В value помещяем код языка
            //opt.innerText = c.name; // В текст option название языка
            //sel.appendChild(opt); // Добавляем в селект
        //});
        //document.querySelector('#activate').style.display = 'none'; // Скрываем начальную кнопку
        //main.style.display = 'block'; // Показываем основной блок
    //};

    //sel.onchange = function () { // При выборе селекта
      //  lang = this.value; // Меняем язык на выбранный
    //};

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
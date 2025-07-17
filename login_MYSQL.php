<?php
if (isset($_POST['button'])) {
		$login = $_POST['login'];//$_REQUEST['login'];
		$password = $_POST['password'];//$_REQUEST['password'];
		//$stat = pg_connection_status($link);
        ob_start();
		if ($link == true) {
			session_start(); 
			$_SESSION['auth'] = true; 
			$_SESSION['name'] = $password; 
			$_SESSION['login'] = $login;
                        ob_end_clean();
            echo " Вы успешно авторизировались! <br>";
            echo "<br>";            
            echo '<a href="" class="btn"> Перейти на страницу со словарями </a> <br>';
            exit;
                     
       } else {
        echo("Ошибка: " . mysqli_connect_error());
       }
}
?>
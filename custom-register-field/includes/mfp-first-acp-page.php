 <?php
?>
<div class="wrap">
 <h1>Привет!</h1>
 <p>Это первая страница плагина :)</p>
 
  </div>
 <?php

 $user       = get_userdata(1);
$username   = $user->user_login;
$first_name = $user->first_name;
$last_name  = $user->last_name;
$user_email  = $user->user_email;


echo "<b>$first_name $last_name</b> зашел(а) на сайт под логином: <b>$username</b> и е-мейлом <b>$user_email.</b>";

?>
<br/><br/><br/><br/><br/>
<?php

$user2       = get_users();
foreach ($user2 as $v) {
echo "<b>$v->first_name $v->last_name</b> числится на сайте под логином: <b>$v->user_login</b> и е-мейлом <b>$v->user_email.</b><br/><br/>";
}
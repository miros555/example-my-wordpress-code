<?php
/*
Plugin Name: My Plugin for Custom Register Field
Description: Это мой плагин, который создаёт отдельную админ-ссылку
Author: Mirax
*/

// Хук событие 'admin_menu', запуск функции 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'mfp_Add_My_Admin_Link' );
 
// Добавляем новую ссылку в меню Админ Консоли
function mfp_Add_My_Admin_Link() {
 add_menu_page(
 'My Super Page', // Название страниц (Title)
 'My Super Plugin', // Текст ссылки в меню
 'manage_options', // Требование к возможности видеть ссылку 
 'userscoder/includes/mfp-first-acp-page.php' // 'slug' - файл отобразится по нажатию на ссылку
 );
} 
 
 
 

//******************************Registration Form****************////////


function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $adress ) {
    echo '
    <style>
    div {
        margin-bottom:2px;
    }
      
    input{
        margin-bottom:4px;
    }
    </style>
    ';
  
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="username">Username <strong>*</strong></label>
    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
    </div>
      
    <div>
    <label for="password">Password <strong>*</strong></label>
    <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
    </div>
      
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>
      
      
    <div>
    <label for="website">Website</label>
    <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
    </div>
     
                             <!--*****Radio*****-->
    
     <div style="display:flex;">
     <div><label class="r"><p><input class="r" type="radio" name="gender" value="male"/> </label>Мужчина</p></div> 
     <div><label class="r"><p><input class="r" type="radio" name="gender" value="female"/></label> Женщина</p> </div>
      </div>
      
    <div>
    <label for="firstname">First Name</label>
    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
    </div>
      
    <div>
    <label for="website">Last Name</label>
    <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
    </div>
    
    
    <div>
    <label for="nickname">Nickname</label>
    <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
    </div>
      
    <div>
    <label for="adress">Adress </label>
    <textarea name="adress">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
    </div>
    <input type="submit" name="submit" value="Register"/>
    </form>
    ';
}





function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $adress )  {

global $reg_errors;
$reg_errors = new WP_Error;

if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
}
if ( 4 > strlen( $username ) ) {
    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
}
if ( username_exists( $username ) ) {
    $reg_errors->add('user_name', 'Sorry, that username already exists!');

}

    if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
}

if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
    
 if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
}

if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
}

if ( ! empty( $website ) ) {
    if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
        $reg_errors->add( 'website', 'Website is not a valid URL' );
    }
}
if ( is_wp_error( $reg_errors ) ) {
  
    foreach ( $reg_errors->get_error_messages() as $error ) {
      
        echo '<div>';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';
    }
}
}



function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $adress;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   $nickname,
        'description'   =>   $adress,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
}


function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['website'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['nickname'],
        $_POST['adress']
        );
          
        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $adress;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $nickname   =   sanitize_text_field( $_POST['nickname'] );
        $adress        =   esc_textarea( $_POST['adress'] );
  
        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $adress
        );
    }
  
    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $adress
        );
}


// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
  
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}


/*================*/


add_filter('user_contactmethods', 'ved_user_contactmethods');
function ved_user_contactmethods($user_contactmethods){
  $user_contactmethods['position_user'] = 'Должность';
  $user_contactmethods['hobby_user'] = 'Хобби';
  return $user_contactmethods;
}

/*    Редактируем профиль пользователя
========================================*/

//Изменение контактов
add_filter('user_contactmethods', 'my_user_contactmethods');

function my_user_contactmethods($user_contactmethods)
{
    unset($user_contactmethods['jabber']);
    unset($user_contactmethods['yim']);
    unset($user_contactmethods['aim']);

    $user_contactmethods['vkontakte'] = '<b>ВКонтакте</b>'; 

    return $user_contactmethods;
}



/*********List Users**********/

function wpb_recently_registered_users() {
global $wpdb;
 
$recentusers = '<ul class="recently-user">';



$usernames = $wpdb->get_results("SELECT user_nicename, user_registered, user_url, user_email FROM $wpdb->users ORDER BY ID DESC LIMIT 10");
 
foreach ($usernames as $username) {
    
$gender  = get_usermeta($user_id->city);

if (!$username->user_url) :
$recentusers .= '<li>' .get_avatar($username->user_email, 45) .$username->user_nicename. $username->user_registered. $gender."</a></li>";
else :
$recentusers .= '<li>' .get_avatar($username->user_email, 45).'<a href="'.$username->user_url.'">'.$username->user_nicename."</a></li>";
endif;
}
$recentusers .= '</ul>';
 
return $recentusers;
}



/*************************************************/

function show_profile_fields( $user ) { ?> 
 	<h3>Дополнительная информация</h3>
 	<!-- добавляется ещё один блок в профиле, в примере он будет называться "Дополнительная информация" -->
 	<table class="form-table">
 	<!-- для того чтобы ваши поля выглядели так же, как и стандартные в WordPress, прописывайте такие же классы как и тут -->
 	<!-- добавляем поле город -->
 	<tr><th><label for="city">Adress</label></th>
 	<td><input type="text" name="city" id="city" value="<?php echo esc_attr(get_the_author_meta('city',$user->ID));?>" class="regular-text" /><br /></td></tr>
 	<!-- добавляем поле пол -->
 	<th><label for="gender">Пол</label></th>
 	<td><?php $gender = get_the_author_meta('gender',$user->ID ); ?>
 		<ul>
 			<li><label><input value="мужской" name="gender"<?php if ($gender == 'мужской') { ?> checked="checked"<?php } ?> type="radio" /> мужской</label></li>
 			<li><label><input value="женский"  name="gender"<?php if ($gender == 'женский') { ?> checked="checked"<?php } ?> type="radio" /> женский</label></li>
 		</ul>			
 	</td></tr>
 	<!-- закрываем теги и применяем функцию -->
 	</table>
 <?php }
add_action( 'show_user_profile', 'show_profile_fields' );
add_action( 'edit_user_profile', 'show_profile_fields' );


function save_profile_fields( $user_id ) {
	update_usermeta( $user_id, 'city', $_POST['city'] );
	update_usermeta( $user_id, 'gender', $_POST['gender'] );
}
 
add_action( 'personal_options_update', 'save_profile_fields' );
add_action( 'edit_user_profile_update', 'save_profile_fields' );
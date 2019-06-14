<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );    
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css?16755675' );
}
//добавляем поле 'real-comment' start
function wph_add_new_comment_field($args) {
 
  if (preg_match('/<textarea.*textarea>/', $args['comment_field'], $match)){
    $textarea = $match[0];
    $real_textarea = str_replace('comment', 'real-comment', $textarea, $count);
 
    if ($count) {
        $hidden_textarea = str_replace( '<textarea', 
        '<textarea style="display:none;"', $textarea );
        $hidden_textarea = str_replace( 'required="required"', 
        '', $hidden_textarea );
        $hidden_textarea = str_replace( 'aria-required="true"', 
        '', $hidden_textarea );
        $args['comment_field'] = str_replace($textarea, 
        "$hidden_textarea$real_textarea", $args['comment_field']);
    }
  }
  return $args;
}
add_filter('comment_form_defaults', 'wph_add_new_comment_field', 30);
//добавляем поле 'real-comment' end
 
//проверка на спам start 
function wph_verify_spam() {
    if(false === strpos($_SERVER['REQUEST_URI'], 'wp-comments-post.php'))
        return; 
    if(!empty($_POST['comment']))
        wp_die('Спаму нет!');
 
    $_POST['comment'] = $_POST['real-comment'];
}
add_filter('init', 'wph_verify_spam');
//проверка на спам end
//
## Функция для подсветки слов поиска в WordPress
add_filter('the_content', 'kama_search_backlight');
add_filter('the_excerpt', 'kama_search_backlight');
add_filter('the_title', 'kama_search_backlight');
function kama_search_backlight( $text ){
	// ------------ Настройки -----------
	$styles = ['',
		'color: #000; background: #99ff66;',
		'color: #000; background: #ffcc66;',
		'color: #000; background: #99ccff;',
		'color: #000; background: #ff9999;',
		'color: #000; background: #FF7EFF;',
	];

	// только для страниц поиска...
	if ( ! is_search() ) return $text;

	$query_terms = get_query_var('search_terms');
	if( empty($query_terms) ) $query_terms = array(get_query_var('s'));
	if( empty($query_terms) ) return $text;

	$n = 0;
	foreach( $query_terms as $term ){
		$n++;

		$term = preg_quote( $term, '/' );
		$text = preg_replace_callback( "/$term/iu", function($match) use ($styles,$n){
			return '<span style="'. $styles[ $n ] .'">'. $match[0] .'</span>';
		}, $text );
	}
	return $text;
}

?>
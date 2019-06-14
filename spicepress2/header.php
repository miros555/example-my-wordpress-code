<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
	
	<?php
//keywords и description на главной
if($_SERVER['REQUEST_URI'] == '/') { ?>
<meta name="keywords" content="сок дніпро,кооператив дніпро,сільськогосподарський,сільське господарство, дніпро" />
<meta name="description" content="Сайт сільськогосподарського обслуговуючого кооперативу Дніпро" />
<?php } else {
//keywords и description на остальных страницах
if (get_post_meta($post->ID, 'metakeywords', 1) != "") echo '<meta name="keywords" content="'.get_post_meta($post->ID, 'metakeywords', 1).'" />'.PHP_EOL;
if (get_post_meta($post->ID, 'metadescription', 1) != "") echo '<meta name="description" content="'.get_post_meta($post->ID, 'metadescription', 1).'" />'.PHP_EOL;
} ?>
</head>
<body <?php body_class( ); ?> >
<div id="wrapper">
<?php get_template_part('header/header-navbar'); ?>
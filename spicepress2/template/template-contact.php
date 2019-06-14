<?php 
/**
 * Template Name: Contact page
 */
get_header();
spicepress_breadcrumbs(); ?>

<!-- Contact Section -->
<section class="cont-section">
	<div class="container">
	
		<div class="row">	
			<!--Contact Form Section-->
			<?php if( get_theme_mod('contact_form_enable',true) == true ): ?>
			<div class="col-md-<?php echo ( is_active_sidebar( 'wdl_contact_page_sidebar' ) ? '8' :'12' ); ?> col-xs-12">
			<div class="cont-form-section wow fadeInDown animated animated" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInDown;">
					<?php 
				the_post();
				the_content();
					?>	
			</div>
			</div>
			<?php endif; ?>
			<!--/Contact Form Section-->
			<?php $posts = get_posts ("category=fin&orderby=date&numberposts=10"); ?> 
<?php if ($posts) : ?>
<?php foreach ($posts as $post) : setup_postdata ($post); ?>

    <div>
        <div> 
            <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> 
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>

			<!--Contact Info-->
			<?php if( get_theme_mod('contact_info_enable',true) == true ):?>
			<div class="col-md-<?php echo ( is_active_sidebar( 'wdl_contact_page_sidebar' ) ? '4' :'12' ); ?> col-xs-12">
					
				<?php 
				if( is_active_sidebar('wdl_contact_page_sidebar') ) :
					echo '<div class="sidebar">';
					dynamic_sidebar( 'wdl_contact_page_sidebar' ); 
					echo '</div>';
				endif;
				?>
				
			</div>
			<?php endif; ?>
			<!--Contact Info-->	                     
		</div>
	</div>
</section>
<!-- /Contact Section -->

<?php get_footer(); ?>

<h3>НОВОСТИ</h3>
<ul>
<?php query_posts('showposts=5'); ?>
<?php while (have_posts()) : the_post(); ?>
<li><a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail() ?>
<?php the_title(); ?></a>
<p><?php the_excerpt (); ?> </p>
</li>
<?php endwhile; ?>
</ul>




<?php get_footer(); ?>
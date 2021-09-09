<?php
/**
 * Template Name: Template form
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) :
				the_post();
				do_action( 'storefront_page_before' );
				get_template_part( 'content', 'page' );
				get_template_ananas();
				do_action( 'storefront_page_after' );
			endwhile; 
			?>
		</main>
	</div>
<?php
get_footer();
?>

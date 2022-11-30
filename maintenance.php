<?php get_header(); ?>
<h1>CHILD maintenance page <?php bloginfo( 'name' ); ?></h1>
			
			<?php $primary_description = get_bloginfo( 'description', 'display' );
			if ( $primary_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $primary_description; ?></p>
			<?php endif; ?>

			<a href="">Se connecter</a>

<? get_footer(); ?>
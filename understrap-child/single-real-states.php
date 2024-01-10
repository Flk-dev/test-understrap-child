<?php get_header(); ?>
	<div class="wrapper" id="single-wrapper">
		<div class="container" id="content" tabindex="-1">
			<div class="row">
				<main class="site-main" id="main">
					<ul>
						<li><strong>Площадь</strong>: <?php the_field( 'square' ); ?></li>
						<li><strong>Стоимость</strong>: <?php the_field( 'price' ); ?></li>
						<li><strong>Адрес</strong>: <?php the_field( 'address' ); ?></li>
						<li><strong>Жилая площадь</strong>: <?php the_field( 'living_area' ); ?></li>
						<li><strong>Этаж</strong>: <?php the_field( 'floor' ); ?></li>
					</ul>
				</main>
			</div><!-- .row -->
		</div><!-- #content -->
	</div><!-- #single-wrapper -->
<?php get_footer();

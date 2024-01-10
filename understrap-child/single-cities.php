<?php get_header();

$states = new WP_Query( [
	'post_type'      => 'real-states',
	'posts_per_page' => - 1,
	'meta_query'     => [
		[
			'key'   => '_cities',
			'value' => get_the_ID(),
			'compare'   => 'LIKE',
		]
	]
] );

?>

<?php if ( $states->have_posts() ) { ?>
	<div class="block">
		<div class="container">
			<h2 class="block__title">Недвижимость из города <?php the_title(); ?></h2>
			<div class="block__row row">
				<?php while ( $states->have_posts() ) {
					$states->the_post(); ?>
					<div class="col-4">
						<?php get_template_part( 'templates/real-state', null, [ 'has_specifications' => true ] ); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php }
wp_reset_postdata(); ?>


<?php get_footer();

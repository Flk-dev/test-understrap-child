<?php

$has_specifications = isset( $args['has_specifications'] ) ? $args['has_specifications'] : false;

?>

<div class="block__item">
	<a href="<?php the_permalink(); ?>" class="block__item-image">
		<?php the_post_thumbnail(); ?>
	</a>
	<a href="<?php the_permalink(); ?>" class="block__item-title"><h4><?php the_title(); ?></h4>
	</a>
	<?php if ( $has_specifications ) { ?>
		<ul class="block__item-specifications">
			<li><strong>Площадь</strong>: <?php the_field( 'square' ); ?></li>
			<li><strong>Стоимость</strong>: <?php the_field( 'price' ); ?></li>
			<li><strong>Адрес</strong>: <?php the_field( 'address' ); ?></li>
			<li><strong>Жилая площадь</strong>: <?php the_field( 'living_area' ); ?></li>
			<li><strong>Этаж</strong>: <?php the_field( 'floor' ); ?></li>
		</ul>
	<?php } ?>
</div>
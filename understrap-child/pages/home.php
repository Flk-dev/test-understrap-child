<?php get_header(); /* TEMPLATE NAME: Home */

$states = new WP_Query( [
	'post_type'      => 'real-states',
	'posts_per_page' => - 1
] );

$cities = new WP_Query( [
	'post_type'      => 'cities',
	'posts_per_page' => - 1
] );

$cities_checkboxes = [];

?>

<?php if ( $states->have_posts() ) { ?>
    <div class="pt-4 pb-4">
        <div class="container">
            <h2 class="mb-3">Недвижимость</h2>
            <div class="row">
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

<?php if ( $cities->have_posts() ) { ?>
    <div class="pt-4 pb-4">
        <div class="container">
            <h2 class="mb-3">Города</h2>
            <div class="row">
				<?php while ( $cities->have_posts() ) {
					$cities->the_post();

					// Save cities for form
					$cities_checkboxes[] = [
						'id'    => get_the_ID(),
						'title' => get_the_title()
					];

					?>
                    <div class="col-4">
						<?php get_template_part( 'templates/real-state' ); ?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
<?php }
wp_reset_postdata(); ?>

<div class="container">
    <form class="form">
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" name="title" class="form-control" placeholder="Введите заголовок">
        </div>
        <div class="form-group">
            <label for="square">Площадь</label>
            <input type="text" name="square" class="form-control" placeholder="Введите площадь">
        </div>
        <div class="form-group">
            <label for="square">Стоимость</label>
            <input type="text" name="price" class="form-control" placeholder="Введите стоимость">
        </div>
        <div class="form-group">
            <label for="address">Адрес</label>
            <input type="text" name="address" class="form-control" placeholder="Введите адрес">
        </div>
        <div class="form-group">
            <label for="living_area">Жилая площадь</label>
            <input type="text" name="living_area" class="form-control" placeholder="Введите площадь">
        </div>
        <div class="form-group">
            <label for="floor">Этаж</label>
            <input type="text" name="floor" class="form-control" placeholder="Введите этаж">
        </div>
	    <?php if ( ! empty( $cities_checkboxes ) ) { ?>
            <div class="form__checkboxes">
                <legend>Выбрать город</legend>
                <?php foreach ( $cities_checkboxes as $cities_checkbox ) { ?>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="_cities[]" value="<?= $cities_checkbox['id']; ?>" class="form-check-input" id="city_<?= $cities_checkbox['id']; ?>">
                        <label class="form-check-label" for="city_<?= $cities_checkbox['id']; ?>"><?= $cities_checkbox['title']; ?></label>
                    </div>
                <?php } ?>
            </div>
	    <?php } ?>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
        <div class="alert alert-success form__message"></div>
    </form>
</div>

<?php get_footer(); ?>

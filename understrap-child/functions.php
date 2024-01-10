<?php

add_action( 'wp_enqueue_scripts', 'rs_enqueue_scripts' );
function rs_enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '', true );
}

add_action( 'init', 'rs_register_post_types' );
function rs_register_post_types() {
	// Real states
	register_post_type( 'real-states', [
		'label'               => null,
		'labels'              => [
			'name'               => 'Недвижимость',
			'singular_name'      => 'Недвижимость',
			'add_new'            => 'Добавить недвижимость',
			'add_new_item'       => 'Добавление недвижимости',
			'edit_item'          => 'Редактирование недвижимости',
			'new_item'           => 'Новая недвижимость',
			'view_item'          => 'Смотреть недвижимость',
			'search_items'       => 'Искать недвижимость',
			'not_found'          => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'parent_item_colon'  => '',
			'menu_name'          => 'Недвижимость',
		],
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => false,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'hierarchical'        => false,
		'rewrite'             => [
			'slug'       => 'real-states',
			'with_front' => false,
			'pages'      => false,
			'feeds'      => false,
			'feed'       => false,
		],
		'has_archive'         => 'real-states',
		'query_var'           => true,
		'supports'            => [ 'title', 'thumbnail' ],
	] );

	// Real state types
	register_taxonomy( 'type', [ 'real-states' ], [
		'label'             => 'Тип недвижимости',
		'labels'            => array(
			'name'              => 'Типы недвижимости',
			'singular_name'     => 'Тип недвижимости',
			'search_items'      => 'Искать Тип',
			'all_items'         => 'Все Типы',
			'parent_item'       => 'Родит. Тип',
			'parent_item_colon' => 'Родит. Тип',
			'edit_item'         => 'Ред. Тип',
			'update_item'       => 'Обновить Тип',
			'add_new_item'      => 'Добавить Тип',
			'new_item_name'     => 'Новый Тип',
			'menu_name'         => 'Тип недвижимости',
		),
		'description'       => 'Рубрики для типа недвижимости',
		'public'            => true,
		'show_in_nav_menus' => false,
		'show_ui'           => true,
		'show_tagcloud'     => false,
		'hierarchical'      => true,
		'rewrite'           => array(
			'slug'         => 'type',
			'hierarchical' => false,
			'with_front'   => false,
			'feed'         => false
		),
		'show_admin_column' => true,
	] );

	// Cities
	register_post_type( 'cities', [
		'label'               => null,
		'labels'              => [
			'name'               => 'Города',
			'singular_name'      => 'Города',
			'add_new'            => 'Добавить город',
			'add_new_item'       => 'Добавление города',
			'edit_item'          => 'Редактирование города',
			'new_item'           => 'Новая город',
			'view_item'          => 'Смотреть город',
			'search_items'       => 'Искать город',
			'not_found'          => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'parent_item_colon'  => '',
			'menu_name'          => 'Города',
		],
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => false,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'hierarchical'        => false,
		'rewrite'             => [
			'slug'       => 'cities',
			'with_front' => false,
			'pages'      => false,
			'feeds'      => false,
			'feed'       => false,
		],
		'has_archive'         => false,
		'query_var'           => true,
		'supports'            => [ 'title', 'editor', 'thumbnail' ],
	] );
}

add_action( 'admin_init', 'rs_add_meta_boxes' );
function rs_add_meta_boxes() {
	add_meta_box( 'rs_add_meta_boxes', 'Города', 'rs_meta_cities', 'real-states', 'side' );
}

function rs_meta_cities( $post ) {
	$cities = get_posts( [
		'post_type'   => 'cities',
		'numberposts' => - 1
	] );

	$_cities = get_post_meta( $post->ID, '_cities', true );

	if ( ! empty( $cities ) ) { ?>
		<div class="rs-meta__cities">
			<div class="rs-meta__cities-list">
				<?php foreach ( $cities as $city ) { ?>
					<div class="rs-meta__cities-item">
						<input type="checkbox" name="_cities[]" id="city_<?= $city->ID ?>"
                               value="<?= $city->ID; ?>" <?= ( ! empty( $_cities ) && in_array( $city->ID, $_cities ) ? 'checked' : '' ); ?>>
						<label for="city_<?= $city->ID ?>"><?= $city->post_title; ?></label>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php }
}

add_action( 'save_post', 'rs_save_meta_cities' );
function rs_save_meta_cities( $post_id ) {
	if ( 'real-states' != get_post_type( $post_id ) ) {
		return $post_id;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	if ( isset( $_POST['_cities'] ) ) {
		update_post_meta( $post_id, '_cities', array_map( 'intval', $_POST['_cities'] ) );
	}
}

add_action( 'wp_ajax_save_real_state', 'save_real_state' );
add_action( 'wp_ajax_nopriv_save_real_state', 'save_real_state' );
function save_real_state() {
	$errors = new WP_Error();

	$fields_request = [ 'title', 'square', 'price', 'address', 'living_area', 'floor' ];
	$data           = [];

	$cities = $_POST['_cities'];

	foreach ( $fields_request as $field ) {
		if ( empty( $_POST[ $field ] ) ) {
			$errors->add( $field, 'Поле является обязательным' );
		} else {
			$data[ $field ] = htmlspecialchars( $_POST[ $field ] );
		}
	}

	if ( ! empty( $errors->errors ) ) {
		wp_send_json_error( [
			'errors' => $errors->errors
		] );
	}

	$post_data = [
		'post_title'   => $data['title'],
		'post_content' => '',
		'post_status'  => 'publish',
		'post_author'  => 1,
		'post_type'    => 'real-states',
	];
	$post_id = wp_insert_post( wp_slash( $post_data ) );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( [
			'errors' => $post_id->get_error_message()
		] );
	} else {
	    // Save cities
		if ( ! empty( $cities ) ) {
			update_post_meta( $post_id, '_cities', array_map( 'intval', $_POST['_cities'] ) );
		}

		// Save other fields
		foreach ( $data as $key => $datum ) {
			update_post_meta( $post_id, $key, $data[ $key ] );
		}

		wp_send_json_success( [
			'message' => 'Недвижимость добавлена'
		] );
	}
}

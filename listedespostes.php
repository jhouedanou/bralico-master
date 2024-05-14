<?php

add_filter(
	'forminator_cform_render_fields',
	function( $wrappers, $form_id ) {

		$allowed_forms = array (
			293,
		);

		if ( ! in_array( $form_id, $allowed_forms) ) {
			return $wrappers;
		}

		$select_fields_data = array(
			'select-1' => 'offre-emploi',
			//'select-2' => 'CPT_2',
		);

		foreach ( $wrappers as $wrapper_key => $wrapper ) {
			if ( ! isset( $wrapper[ 'fields' ] ) ) {
				continue;
			}

			if ( 
				isset( $select_fields_data[ $wrapper[ 'fields' ][ 0 ][ 'element_id' ] ] ) &&
				! empty( $select_fields_data[ $wrapper[ 'fields' ][ 0 ][ 'element_id' ] ] )
			) {
				$posts = get_posts( array( 'post_type' => $select_fields_data[ $wrapper[ 'fields' ][ 0 ][ 'element_id' ] ] ) );

				if ( ! empty( $posts ) ) {
					$new_options = array();

					foreach( $posts as $post ) {
						$new_options[] = array(
							'label' => $post->post_title,
							'value' => $post->ID,
							'limit' => '',
							'key'   => forminator_unique_key(),
						);
					}

					$wrappers[ $wrapper_key ][ 'fields' ][ 0 ][ 'options' ] = $new_options;
				}
			}
		}

		return $wrappers;
	},
	10,
	2
);
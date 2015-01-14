<?php
	$args = array( 'post_type' => 'bios', 'order' => 'ASC', 'orderby' => 'title', 'meta_key' => '_cmbi_emp_type', 'meta_value' => '"physician"' );
	$query = get_posts( $args );

	$count = 0;
	$letter = '';


	foreach( $query as $phys ) {
		
		#get the data
		$post_id = $phys->ID;
		$lname = $phys->post_title;
		$fname = get_post_meta( $post_id, '_cmbi_fname', true );
		$phone = get_post_meta( $post_id, '_cmbi_fphone', true );

		$primary_obj = get_term( get_post_meta( $post_id, '_cmbi_primary', true ), 'location');
		$primary = $primary_obj->name;

		$meddeg_arr = wp_get_post_terms( $post_id, 'med_degree', array( "fields" => "names" ) );
		$location_arr = wp_get_post_terms( $post_id, 'location', array( "fields" => "names" ) );

		#create the name
		$name = $fname . ' ' . $lname;

		if ( count( $meddeg_arr ) > 0 ) {
			foreach ( $meddeg_arr as $deg ) {
				$name .= ', ' . $deg; 
			}
		} else $name .= ', ' . $meddeg_arr[0]; 

		#fill letter array
		if ( substr( $lname, 0, 1 ) != $letter ) {
			$letter = substr( $lname, 0, 1 );
			$letters[] = $letter;
		} //end if

		#create name array


		$count++;
	} //end foreach phys_list

	$p_name = Timber::get_context();
	$p_name['letters'] = $letters;
	Timber::render( 'physician-name-filter.twig', $p_name); 


?>
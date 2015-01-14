<?php
	$red = get_terms( 'language', array( 'orderby' => 'name' ) );

	echo '<h3>By Language</h3>';
	echo '<ul id="langDir" class="col-xs-12">';
	foreach( $red as $r ) {
		echo '<li class="'. $r->slug . '">' . $r->name .'</li>';
	} //end echo each langauge
	echo '</ul>';

	foreach( $red as $r ) {

		$args = array( 
			'post_type' => 'bios', 
			'meta_query' => array(
				'key'		=> '_cmbi_emp_type', 
				'value' 	=> 'physician',
				'compare'	=> 'in'  
				),
			'tax_query'	=> array(
				array(
					'taxonomy'	=> 'language',
					'field'		=> 'slug',
					'terms'		=> $r->slug,
					)
				)
			);

		$post_list = get_posts( $args );

		foreach( $post_list as $post ){

			#get the data for name
			$post_id = $post->ID;
			$lname = $post->post_title;
			$fname = get_post_meta( $post_id, '_cmbi_fname', true );
			$meddeg_arr = wp_get_post_terms( $post_id, 'med_degree', array( "fields" => "names" ) );

			#create the name
			$name = $fname . ' ' . $lname;

			if ( count( $meddeg_arr ) > 0 ) {
				foreach ( $meddeg_arr as $deg ) {
					$name .= ', ' . $deg; 
				}
			} 

			#fill letter array
			if ( substr( $lname, 0, 1 ) != $letter ) {
				$letter = substr( $lname, 0, 1 );
				$letters[] = $letter;
			} //end if

			#get data for specialties list
			$spec_arr = wp_get_post_terms( $post_id, 'specialty', array( "fields" => "names" ) );

			#get data for primary location
			$primary_obj = get_term( get_post_meta( $post_id, '_cmbi_primary', true ), 'location');
			$p_loc_name = $primary_obj->name;

			$t_id = 'taxonomy_' . $primary_obj->term_id;
			$term_meta = get_option( $t_id );
			$p_loc_add = $term_meta['street_address'];
			$p_loc_ste = $term_meta['suite_number'];
			$p_loc = $term_meta['city'] . ' ' . $term_meta['state'] . ' ' . $term_meta['zip_code'];

			#get phone number
			$phone = get_post_meta( $post_id, '_cmbi_fphone', true );

			#get permalink
			$perma = get_permalink( $post_id );

			#get specialties
			if( $spec_arr ){
				if ( count( $spec_arr ) > 1 ) {
					foreach ( $spec_arr as $s ) {
						$specs .= $s . ' | '; 
					}
				} else $specs = $spec_arr[0] . '<br />';
			}

			#print out div
			echo '<div class="' . $r->slug . ' col-xs-5 col-sm-3">';
			echo '<a href="' . $perma . '" />' . $name . '</a><br />';
			
			if( $specs ){
				echo $specs;
			} 

			if( $p_loc_name ) {
				echo '<hr />';
				echo $p_loc_name . '<br />';
				echo $p_loc_add . ' ' . $p_loc_ste . '<br />';
				echo $p_loc . '<br />';
			}

			if( $phone ) {
				echo $phone . '<br />';
			}

			echo '</div>';
		
		} //end foreach post_list

	} //end foreach red
?>
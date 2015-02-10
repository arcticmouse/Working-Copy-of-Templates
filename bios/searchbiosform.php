<form action="<?php echo home_url( '/' ); ?>" method="get" class="form-stacked">
    <fieldset>
		<div class="clearfix">
			<div class="input-append input-prepend">

					<h3>By Name</h3>
					<input type="text" name="s" id="search" placeholder="<?php _e("Last Name","bonestheme"); ?>" value="<?php the_search_query(); ?>" />    
					<input type="text" name="fname" id="fname" placeholder="<?php _e("First Name","bonestheme"); ?>" value="<?php the_search_query(); ?>" />

					<h3>By Employee Type</h3>
					<input type="checkbox" name="emp_type[]" id="emp_type" value="faculty" /><?php _e("Faculty","bonestheme"); ?>
					<input type="checkbox" name="emp_type[]" id="emp_type" value="staff" /><?php _e("Staff","bonestheme"); ?>

				<h3>By Department</h3>
					<select name="department" id="department" size=8>
						<option value="" selected="selected">----Make a Choice----</option>
						<?php
							//get posts
							$args = array( 'post_type' => 'bios',  'numberposts' => -1 );
							$post_list = get_posts( $args );
							//print out departments and list them
							foreach( $post_list as $post ){
								$d = get_post_meta( get_the_ID(), '_cmbi_department' );
								$dt = strtoupper( $d[0] );
								if( !in_array( $dt, $departments ) && ( $dt != '' ) ) {
									$departments[] = $dt;
								} //end if
							} //end for each

							sort( $departments );

							foreach( $departments as $dpt ){
								echo '<option name=' . $dpt->slug . ' value=' . $dpt->slug . '>' . $dpt . '</option>';
							}
						?>
					</select>

					<h3>Sort By</h3>
					<input type="radio" name="sort_opt" value="fname">First Name
					<input type="radio" name="sort_opt" value="lname">Last Name
					<input type="radio" name="sort_opt" value="dept">Department
					<input type="hidden" name="post_type" value="bios" /><br /><br />
					<button type="submit" class="btn btn-primary"><?php _e("Search Biographies","bonestheme"); ?></button>
				</div>
			</div>
        </div>
    </fieldset>
</form>
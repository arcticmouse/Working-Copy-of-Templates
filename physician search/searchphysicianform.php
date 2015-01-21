<form action="<?php echo home_url( '/' ); ?>" method="get" class="form-stacked col-xs-offset-1">
    <fieldset>
		<div class="clearfix">
			<div class="input-append input-prepend">
				<span class="add-on"><i class="icon-search"></i></span>
				
				<div class="row">
					<input type="text" name="s" id="search" placeholder="<?php _e("Last Name","bonestheme"); ?>" value="<?php the_search_query(); ?>" />
					<input type="text" name="fname" id="fname" placeholder="<?php _e("First Name","bonestheme"); ?>" value="<?php the_search_query(); ?>" />
				</div><br />
					
				<div class="row">
						<div class="col-xs-2">By Specialty</div>
						<select name="specialty" id="specialty" class="col-xs-6">
							<?php
								#get_terms in switch to blog doesnt work, lines 6-8 & 114-115 make and delete a fake taxonomy in current blog
								#http://wordpress.stackexchange.com/questions/98247/get-post-by-term-from-custom-taxonomy-in-another-blog-on-the-network
								global $wp_taxonomies;
								if( !taxonomy_exists( 'specialty' ) )
									$wp_taxonomies['specialty'] = 'delete';

								$specialties = get_terms( 'specialty', array( 'hide_empty' => 0 ) );

								foreach ($specialties as $spec) {
									echo '<option name=' . $spec->term_id . ' value=' . $spec->term_id . '>' . $spec->name . '</option>';
								}

								if( $wp_taxonomies['specialty'] == 'delete' )
									unset( $wp_taxonomies['specialty'] );
							?>
						</select>
					</div><br />

					<div class="row">
						<div class="col-xs-2">By Language</div>
						<select name="language" id="language" class="col-xs-6">
							<?php

								#get_terms in switch to blog doesnt work, lines 6-8 & 114-115 make and delete a fake taxonomy in current blog
								#http://wordpress.stackexchange.com/questions/98247/get-post-by-term-from-custom-taxonomy-in-another-blog-on-the-network
								global $wp_taxonomies;
								if( !taxonomy_exists( 'language' ) )
									$wp_taxonomies['language'] = 'delete';

								$languages = get_terms( 'language', array( 'hide_empty' => 0 ) );

								foreach ($languages as $lang) {
									echo '<option name=' . $lang->term_id . ' value=' . $lang->term_id . '>' . $lang->name . '</option>';
								}


								if( $wp_taxonomies['language'] == 'delete' )
									unset( $wp_taxonomies['language'] );

							?>
						</select>
					</div><br />

					<div class="row">
						<div class="col-xs-2">By Location</div>
	 					<select name="location" id="location" class="col-xs-6">
							<?php

								#get_terms in switch to blog doesnt work, lines 6-8 & 114-115 make and delete a fake taxonomy in current blog
								#http://wordpress.stackexchange.com/questions/98247/get-post-by-term-from-custom-taxonomy-in-another-blog-on-the-network
								global $wp_taxonomies;
								if( !taxonomy_exists( 'location' ) )
									$wp_taxonomies['location'] = 'delete';

								$location = get_terms( 'location', array( 'hide_empty' => 0 ) );

								foreach ($location as $loc) {
									echo '<option name=' . $loc->term_id . ' value=' . $loc->term_id . '>' . $loc->name . '</option>';
								}


								if( $wp_taxonomies['location'] == 'delete' )
									unset( $wp_taxonomies['location'] );

							?>
						</select>
					</div>


				<input type="hidden" name="post_type" value="bios" />
				<input type="hidden" name="_cmbi_emp_type" value="physician" />
				<br /><br />
				<button type="submit" class="btn btn-primary"><?php _e("Search for Physician","bonestheme"); ?></button>
			</div>
        </div>
    </fieldset>
</form>
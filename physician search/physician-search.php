<?php
/**
 * Template Name: Physician Search Page
 *
 */

?>
<?php get_header(); ?>

<header class='page-title'>
	<div class='container'>
		UNT HEALTH SCIENCE CENTER  | Extraordinary Physicians, Every Day
	</div>
</header>

<div class="container">
	<div class="row main-wrapper">
		<div class="main-content">

			<div class="page-header">
				<h1 class="archive_title h2">
					UNT Health Sciences Physician Search
				</h1>
			</div>


			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<div class="row">
					
					<?php 
						switch_to_blog(1);
						get_template_part( 'searchphysicianform' );
						restore_current_blog();	
					?>

				</div>

				<div class="row">
					<div class="col-xs-offset-1"><br /><br /><iframe src="https://www.google.com/maps/d/embed?mid=zlTnU0ilWcE4.kfGX1KfQWYwQ"></iframe></div>
				</div>
			
				<footer>

				</footer> <!-- end article footer -->

			</article> <!-- end article -->


			<?php if (function_exists('page_navi')) { // if expirimental feature is active ?>

				<?php page_navi(); // use the page navi function ?>

			<?php } else { // if it is disabled, display regular wp prev & next links ?>
				<nav class="wp-prev-next">
					<ul class="clearfix">
						<li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "bonestheme")) ?></li>
						<li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "bonestheme")) ?></li>
					</ul>
				</nav>
			<?php } ?>

		<!-- end #main -->
		</div>
				<?php get_sidebar( 'physiciansearch' ); //sidebar1 id ?>

			<!-- end #content -->
	</div>
</div>
<?php get_footer(); ?>
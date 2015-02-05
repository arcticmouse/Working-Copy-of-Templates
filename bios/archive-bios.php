<?php
/**
 * Template Name: Bios Archive
 *
 */

?>
<?php get_header(); ?>

<header class='page-title'>
	<div class='container'>
		UNT HEALTH SCIENCE CENTER  | Extraordinary Stories, Every Day
	</div>
</header>

<div class="container">
	<div class="row main-wrapper">
		<div class="main-content">

			<div class="page-header">
				<h1 class="archive_title h2">
					Bios
				</h1>
			</div>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</article> <!-- end article -->

			<?php endwhile; ?>

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


			<?php else : ?>

			<article id="post-not-found">
			    <header>
			    	<h1><?php _e("No Posts Yet", "bonestheme"); ?></h1>
			    </header>
			    <section class="post_content">
			    	<p><?php _e("Sorry, What you were looking for is not here.", "bonestheme"); ?></p>
			    </section>
			    <footer>
			    </footer>
			</article>

			<?php endif; ?>

		<!-- end #main -->
		</div>
				<?php get_sidebar(); // sidebar 1 ?>

			<!-- end #content -->
	</div>
</div>
<?php get_footer(); ?>
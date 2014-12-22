<?php
/*
Template Name: Research Homepage
*/
get_header(); ?>
<div class="research">
  <div id="content" class="">
  	<div id="main" class="" role="main">
  		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
    			<header class='page-title-breadcrumbs'>
    				<div class='container'>
    					<?=get_bloginfo('name')?>
              <div class="breadcrumbs">
                <?php the_breadcrumb(); ?>
              </div>
    				</div>
    			</header>
          <?
          $context = Timber::get_context();
          // Lots of stuff happens in this function /library/card-control/card-control.php
          $context['cards'] = Cards::prepare_homepage_cards();
          // get_news_items('category', how_many[optional]);
          $context['news_items'] = Cards::get_news_items('research', 1);
          $context['sidebar'] = Timber::get_sidebar('../sidebar-calendar.php');
          Timber::render('research-cards.twig', $context);
          ?>
    		</article> <!-- end article -->
  		<?php endwhile; ?>
  		<?php else : ?>
    		<article id="post-not-found">
    		    <header>
    		    	<h1><?php _e("Not Found", "bonestheme"); ?></h1>
    		    </header>
    		    <section class="post_content">
    		    	<p><?php _e("Sorry, but the requested resource was not found on this site.", "bonestheme"); ?></p>
    		    </section>
    		    <footer>
    		    </footer>
    		</article>
  		<?php endif; ?>
  	</div> <!-- end #main -->
  </div> <!-- end #content -->
</div>
<?php get_footer(); ?>
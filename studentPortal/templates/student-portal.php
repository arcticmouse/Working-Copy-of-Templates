<?php
/*
Template Name: Student Portal Homepage
*/
/**
 * Getting all the page data $vars to use throughout the template
 */
get_header();
?>

<style>
.no-padding{
	padding: 0;
}
.academic, .academic:hover{
	background-color: #56a2d6 !important;
	color: #fff !important;
	font-weight: bold;
}
.academic::after{
	background: transparent !important;
}
.resources{
	background-color: #00457c !important;
	color: #fff !important;
	font-weight: bold;
}
.resources::after{
	background: transparent !important;
}
.financial{
	background-color: #00853e !important;
	color: #fff !important;
	font-weight: bold;
}
.financial::after{
	background: transparent !important;
}
.other{
	background-color: #6c2180 !important;
	color: #fff !important;
	font-weight: bold;
}
.other::after{
	background: transparent !important;
}
.twitter{
	overflow-y: scroll;
}
.main-content{
/*	left: 25% !important; */
}
</style>

<?php
		  /**************************************/
		  //get the twitter feed
		  /**************************************/
		  /**
		   * Carrie's note to whoever comes along next:
		   *
		   * The following code chunk utilizes TwitterWP, which is located in the hsc/library/ file and
		   * called in the hsc/functions.php file
		   *
		   * [https://github.com/jtsternberg/TwitterWP]
		   *
		   * The code isn't very well documented, so honestly not sure if you'll opt to use it. It uses the WordPress
		   * HTTP API  [http://codex.wordpress.org/HTTP_API] to connect to the Twitter API and let's you pull out
		   * one slice of data at a time (i.e. the tweet, the date), which makes styling much easier than just using
		   * the Twitter Embedded Widget
		   *
		   * Your Twitter app credentials came from here -> https://apps.twitter.com/app/6893751/keys (requires a
		   * login to the UNTHSC Twitter account)
		   *
		   * The code below obviously works for this page only. Next step would be to wrap it in a function and hook
		   * it wherever you want (not sure if you want this conditionally on certain pages, but that'd be better if
		   * you don't need to show a tweet on every page)
		   */

		  // app credentials (must be in this order)
		  $app = array(
		    'consumer_key' => 'N5zVgDHtCOIncu7rOrpI5HI1L', //Twitter API Key
		    'consumer_secret' => '8Lec12UcsYgglgMR759HuoNqaq9KAZLEgLh0TS1TG9CW2aO5uP', //Twitter API Secret
		    'access_token' => '29803896-Np4MQ4YKXNi3r03ZXWOwjna9s7zVpDdIZ2ciTIPnQ',
		    'access_token_secret' => 'c7Z4FzY0tZAdZgjowuXgWCvORQCnHBq22hKm9VJjabi4r',
		  );

		  // initiate your app
		  $tw = TwitterWP::start( $app );

		  $user   = 'unthsc';
		    // bail here if the user doesn't exist
		    if ( ! $tw->user_exists( $user ) )
		      return;

		  $latest    = $tw->get_tweets( $user, 5 ); // change the number to number of tweets you want returned
		  //$created   = $latest[0]->created_at;
		  //$created   = strtotime( $created );
		  //$created   = human_time_diff( $created, current_time( 'timestamp' ) );
		  //$update    = $latest[0]->text;
		  foreach( $latest as $late ){
		  	$twitterfeed[] = $late->text;
		  }
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<header class='page-title'>
		<div class='container text-left'>
			<?=get_bloginfo('name')?>
            <div class="breadcrumbs">
				<?php the_breadcrumb(); ?>
            </div><!--breadcrumbs -->
		</div><!-- container -->

	</header>

<div class="container">
	<div class="row main-wrapper">
		<div class="main-content col-sm-6 col-xs-12">
		  <?
          $context = Timber::get_context();
          // Lots of stuff happens in this function /library/card-control/card-control.php
          $context['cards'] = Cards::prepare_homepage_cards();
          $context['twitterfeed'] = $twitterfeed;
          Timber::render('student-portal.twig', $context);
          ?>
    </div>
  	</div>
  			<?php get_sidebar(); // sidebar 1 ?>
</div>




<?php endwhile;
	else : echo "Post Not Found"; //Make a 404 function here
	endif;
?>




<?php get_footer(); ?>
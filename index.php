<?php
/* REDUX TEST */


get_header(); ?>

	<article>

		<header class="entry-header">
			<h1>Redux Framework Sample Theme</h1>
		</header><!-- .entry-header -->

		<div class="entry-content">

		<pre>
		<?php

		/**
			Because templates are within a Wordpress function, you need but specify global $opt_name once in your header.php.
			From there you can access the variable in any template file.
		**/

		global $redux_demo;
		$data_r = print_r($redux_demo, true);
		$data_r_sans = htmlspecialchars($data_r, ENT_QUOTES);
		echo $data_r_sans;

		?>


		</pre>

		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

<?php get_footer(); ?>

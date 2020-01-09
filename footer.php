<footer class="footer"><div class="footer-inner">

	<?php
	/*===============================
	=            Contact            =
	===============================*/ ?>
	
	<address>
		<?php global $projectSettings; ?>
		<dl>
			<dt><?= $projectSettings['coord-name']; ?></dt>
			<dd><?= $projectSettings['coord-address']; ?></dd>
			<dd><?= $projectSettings['coord-postal-code']; ?></dd>
			<dd><?= $projectSettings['coord-city']; ?></dd>
			<dd><?= $projectSettings['coord-phone-1']; ?></dd>
			<?php if ( $projectSettings['coord-phone-2'] != '' ) { echo '<dd>'.$projectSettings['coord-phone-2'].'</dd>'; } ; ?>
		</dl>
	</address>


	<?php /*=====  FIN Contact  =====*/

	/*====================================
	=            Microdonnées            =
	====================================*/

		global $imgSizes;
		$localbusiness = array(
			'@context' => 'http://schema.org',
			'@type' => 'LocalBusiness',
			'address' => array(
				'@type' => 'PostalAddress',
				'streetAddress' => $projectSettings['coord-address'],
				'postalCode' => $projectSettings['coord-postal-code'],
				'addressLocality' => $projectSettings['coord-city'],
				'addressRegion' => 'FR'
			),
			'geo' => array(
				'@type' => 'GeoCoordinates',
				'latitude' => $projectSettings['coord-lat'],
				'longitude' => $projectSettings['coord-long']
			),
			'description' => $projectSettings['micro-desc'],
			'name' => $projectSettings['coord-name'],
			'image' => array(
				'@type' => 'ImageObject',
				'url' => get_bloginfo('template_directory').'/images/logo.jpg',
				"width" => $imgSizes['share']['width'],
				"height" => $imgSizes['share']['height']
			),
			'telephone' => pc_phone($projectSettings['coord-phone-1']),
			'pricerange' => '€€'
		);
		
		$localbusiness = apply_filters( 'pc_filter_local_business', $localbusiness ); ?>

		<script type="application/ld+json">
			<?= json_encode($localbusiness,JSON_UNESCAPED_SLASHES); ?>
		</script>


	<?php /*=====  FIN Microdonnées  =====*/

	/*==================================
	=            Navigation            =
	==================================*/ ?>

	<nav id="footer-nav" class="f-nav">
		<ul class="f-nav-list f-nav-list--l1 f-p-nav-list f-p-nav-list--l1 reset-list">
			<li class="f-nav-item f-nav-item--l1 f-p-nav-item f-p-nav-item--l1">&copy; <?= $projectSettings['coord-name']; ?></li>
		<?php
			$footer_shortcuts_config = array(
				'theme_location'  	=> 'footer_primary',
				'nav_prefix'		=> array('f-nav', 'f-p-nav'), // custom
				'items_wrap'      	=> '%3$s',
				'depth'           	=> 1,
				'item_spacing'		=> 'discard',
				'container'       	=> '',
				'fallback_cb'     	=> false,
				'walker'          	=> new Pc_Walker_Nav_Menu()
			);
			wp_nav_menu( $footer_shortcuts_config );
		?>
		</ul>
	</nav>

	<?php /*=====  FIN Navigation  =====*/ ?>


</div></footer>

</div> <?php // fin .body-inner ?>

<script src="<?php bloginfo('template_directory'); ?>/scripts/scripts.min.js"></script>

<?php wp_footer(); ?>

</body>
</html>

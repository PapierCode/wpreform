<footer class="footer layout"><div class="footer-inner">

	<?php
	/*===============================
	=            Contact            =
	===============================*/ ?>
	
	<address>
		<?php global $settings_project; ?>
		<dl>
			<dt><?= $settings_project['coord-name']; ?></dt>
			<dd><?= $settings_project['coord-address']; ?></dd>
			<dd><?= $settings_project['coord-postal-code']; ?></dd>
			<dd><?= $settings_project['coord-city']; ?></dd>
			<dd><?= $settings_project['coord-phone-1']; ?></dd>
			<?php if ( $settings_project['coord-phone-2'] != '' ) { echo '<dd>'.$settings_project['coord-phone-2'].'</dd>'; } ; ?>
		</dl>
	</address>


	<?php /*=====  FIN Contact  =====*/

	/*====================================
	=            Microdonnées            =
	====================================*/

		global $images_project_sizes;
		$local_business = array(
			'@context' => 'http://schema.org',
			'@type' => 'LocalBusiness',
			'address' => array(
				'@type' => 'PostalAddress',
				'streetAddress' => $settings_project['coord-address'],
				'postalCode' => $settings_project['coord-postal-code'],
				'addressLocality' => $settings_project['coord-city'],
				'addressRegion' => 'FR'
			),
			'geo' => array(
				'@type' => 'GeoCoordinates',
				'latitude' => $settings_project['coord-lat'],
				'longitude' => $settings_project['coord-long']
			),
			'description' => $settings_project['micro-desc'],
			'name' => $settings_project['coord-name'],
			'image' => array(
				'@type' => 'ImageObject',
				'url' => get_bloginfo('template_directory').'/images/logo.jpg',
				"width" => $images_project_sizes['share']['width'],
				"height" => $images_project_sizes['share']['height']
			),
			'telephone' => pc_phone($settings_project['coord-phone-1']),
			'pricerange' => '€€'
		);
		
		$local_business = apply_filters( 'pc_filter_local_business', $local_business ); ?>

		<script type="application/ld+json">
			<?= json_encode($local_business,JSON_UNESCAPED_SLASHES); ?>
		</script>


	<?php /*=====  FIN Microdonnées  =====*/

	/*==================================
	=            Navigation            =
	==================================*/ ?>

	<nav id="footer-nav" class="f-nav">
		<ul class="f-nav-list f-nav-list--l1 f-p-nav-list f-p-nav-list--l1 reset-list">
			<li class="f-nav-item f-nav-item--l1 f-p-nav-item f-p-nav-item--l1">&copy; <?= $settings_project['coord-name']; ?></li>
		<?php
			$nav_footer_config = array(
				'theme_location'  	=> 'nav-footer',
				'nav_prefix'		=> array('f-nav', 'f-p-nav'), // custom
				'items_wrap'      	=> '%3$s',
				'depth'           	=> 1,
				'item_spacing'		=> 'discard',
				'container'       	=> '',
				'fallback_cb'     	=> false,
				'walker'          	=> new Pc_Walker_Nav_Menu()
			);
			wp_nav_menu( $nav_footer_config );
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

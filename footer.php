<footer class="footer cl-bloc fs-bloc"><div class="footer-inner">

	<?php
	/*===================================
	=            Coordonnées            =
	===================================*/ ?>
	
	<address class="coord">
		<?php global $settings_project; ?>
		<dl class="coord-list">
			<dt class="coord-item coord-item--logo">
				<?php
					$logo_footer_datas = array(
						'url' => get_bloginfo('template_directory').'/images/logo-footer.svg',
						'width' => 100,
						'height' => 25,
						'alt' => 'Logo '.$settings_project['coord-name']
					);
					$logo_footer_datas = apply_filters( 'pc_filter_footer_logo', $logo_footer_datas );
					?>
					<img src="<?= $logo_footer_datas['url']; ?>" alt="<?= $logo_footer_datas['alt']; ?>" width="<?= $logo_footer_datas['width']; ?>" height="<?= $logo_footer_datas['height']; ?>" />
			</dt>
			<dd class="coord-item coord-item--addr">
				<span class="coord-ico"><?= pc_svg('map',null,'svg-block'); ?></span>
				<span class="coord-txt">
					<?= $settings_project['coord-address'].' <br/>'.$settings_project['coord-postal-code'].' '.$settings_project['coord-city']; ?>

					<?php if ( $settings_project['coord-lat'] != '' && $settings_project['coord-long'] != '' ) { ?>
						<br aria-hidden="true"/><button class="reset-btn btn-display-pop no-print" data-cible="map" data-lat="<?= $settings_project['coord-lat']; ?>" data-long="<?= $settings_project['coord-long']; ?>" aria-hidden="true">Afficher la carte</button>
					<?php } ?>

				</span>
			</dd>
			<dd class="coord-item coord-item--phone">
				<span class="coord-ico"><?= pc_svg('phone',null,'svg-block'); ?></span>
				<span class="coord-txt">
					<a href="tel:<?= pc_phone($settings_project['coord-phone-1']); ?>"><?= $settings_project['coord-phone-1']; ?></a>
					<?php if ( $settings_project['coord-phone-2'] != '' ) {
						echo '<br/><span class="coord-sep"> - </span><a href="tel:'.pc_phone($settings_project['coord-phone-2']).'">'.$settings_project['coord-phone-2'].'</a>';
					} ?>
				</span>
			</dd>
		</dl>
	</address>


	<?php /*=====  FIN Coordonnées  =====*/

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
		
		$local_business = apply_filters( 'pc_filter_local_business', $local_business, $settings_project ); ?>

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

<?php /*----------  Pop-up plein écran  ----------*/ ?>
<div class="pop no-print" aria-hidden="true"></div>

<?php $sprite_to_js_array = array('arrow','cross');
apply_filters( 'pc_filter_sprite_to_svg', $sprite_to_js_array );
pc_sprite_to_js( $sprite_to_js_array ); ?>
<script src="<?php bloginfo('template_directory'); ?>/scripts/scripts.min.js"></script>

<?php wp_footer(); ?>

</body>
</html>

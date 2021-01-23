<?php

// masquer les sous pages dans la gestion des menus ?
// add_filter( 'nav_menu_items_page_recent', 'pc_test', 10, 3 );
// add_filter( 'nav_menu_items_page', 'pc_test', 10, 3 );
// function pc_test($posts, $args, $post_type) {
//     foreach ($posts as $key => $post) {
//         if ( $post->post_parent > 0 ) { unset($posts[$key]); }
//     }
//     return $posts;
// }

// https://codex.wordpress.org/User:Amereservant/Editing_and_Customizing_htaccess_Indirectly

// add_filter('mod_rewrite_rules', 'my_htaccess_contents');

// function my_htaccess_contents( $rules ) {

// $pc_rules = <<<EOD
// \n# Files protection
// <files .htaccess>
// 	order allow,deny
// 	deny from all
// </files>
// <files wp-config.php>
// 	order allow,deny
// 	deny from all
// </files>

// # Disable Directory Listings in this Directory and Subdirectories
// Options -Indexes

// # Expires caching
// <IfModule mod_expires.c>
// ExpiresActive On
// ExpiresByType image/svg+xml "access plus 1 month"
// ExpiresByType image/jpg "access plus 1 month"
// ExpiresByType image/jpeg "access plus 1 month"
// ExpiresByType image/gif "access plus 1 month"
// ExpiresByType image/png "access plus 1 month"
// ExpiresByType text/css "access plus 1 month"
// ExpiresByType text/javascript "access plus 1 month"
// ExpiresByType text/x-javascript "access plus 1 month"
// ExpiresByType application/pdf "access plus 1 month"
// ExpiresByType application/javascript "access plus 1 month"
// ExpiresByType image/icon "access plus 1 month"
// ExpiresDefault "access plus 2 days"
// </IfModule>

// <IfModule mod_headers.c>

// # disabled MIME-Type sniffing
// Header always set X-Content-Type-Options "nosniff"

// # X-XSS-Protection
// Header always set X-XSS-Protection "1; mode=block"

// # prevent Clickjacking
// Header always set X-FRAME-OPTIONS "DENY"

// # cookies https
// Header edit Set-Cookie ^(.*)$ $1;HttpOnly;Secure

// # cache
// <FilesMatch ".(js|css|svg|html)$">
// Header append Vary: Accept-Encoding
// </FilesMatch>

// </IfModule>\n
// EOD;


// $rules = str_replace( 'RewriteBase /', 'RewriteBase / '.PHP_EOL.'RewriteCond %{SERVER_PORT} 80', $rules);
// $rules = str_replace( '80', '80'.PHP_EOL.'RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [L,R=301]', $rules);
// // pc_var($rules);
// // exit();

// return $rules.$pc_rules;

// }
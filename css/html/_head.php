<!doctype html>

<html class="theme-<?= $_GET['theme']; ?> is-<?= $html_class; ?>" lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>Préformaté <?= $_GET['theme'].'/'.$html_class; ?></title>

	<link rel="stylesheet" id="preform-style-css"  href="http://dev.preform.papier-code.fr/wp-content/themes/pc-preform/style.css" type="text/css" media="screen" />
<link rel="stylesheet" id="preform-print-style-css"  href="http://dev.preform.papier-code.fr/wp-content/themes/pc-preform/css/print.css" type="text/css" media="print" />
<link rel="stylesheet" id="preform-font-face-css"  href="http://dev.preform.papier-code.fr/wp-content/themes/pc-preform/css/font-face/font-face.css" type="text/css" media="screen" />

<link rel="stylesheet" id="preform-font-face-css"  href="http://dev.preform.papier-code.fr/wp-content/themes/pc-preform/css/v-<?= $_GET['theme']; ?>.css" type="text/css" media="screen" />

</head>

<body>

	<div class="body-inner">
		<header class="header">
			<div class="header-inner cl-bloc fs-bloc">
				<div class="h-logo">
					<a href="http://dev.preform.papier-code.fr" class="h-logo-link" title="Accueil Préformaté Papier Codé"><img class="h-logo" src="http://dev.preform.papier-code.fr/wp-content/themes/pc-preform/images/logo.svg" alt="Logo" width="150" height="150" />
					</a>
					<div class="h-nav-btn-box">
						<button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-h-nav reset-btn" aria-hidden="true" tabindex="-1">
							<span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span>
							<span class="h-nav-btn-txt">Menu</span>
						</button>
					</div>
				</div>
				<nav id="header-nav" class="h-nav"><div class="h-nav-inner">
					<ul class="h-nav-list h-nav-list--l1 h-p-nav-list h-p-nav-list--l1 reset-list"><li class="h-nav-item h-nav-item--l1 h-p-nav-item h-p-nav-item--l1  "><a  title="Page parent" href="http://dev.preform.papier-code.fr/page-parent/" class="h-nav-link h-nav-link--l1 h-p-nav-link h-p-nav-link--l1 "><span class="h-nav-link-inner h-nav-link-inner--l1 h-p-nav-link-inner h-p-nav-link-inner--l1 ">Page parent</span></a></li><li class="h-nav-item h-nav-item--l1 h-p-nav-item h-p-nav-item--l1  "><a  title="Actualités" href="http://dev.preform.papier-code.fr/actualites/" class="h-nav-link h-nav-link--l1 h-p-nav-link h-p-nav-link--l1 "><span class="h-nav-link-inner h-nav-link-inner--l1 h-p-nav-link-inner h-p-nav-link-inner--l1 ">Actualités</span></a></li><li class="h-nav-item h-nav-item--l1 h-p-nav-item h-p-nav-item--l1  "><a  title="Contact" href="http://dev.preform.papier-code.fr/contact/" class="h-nav-link h-nav-link--l1 h-p-nav-link h-p-nav-link--l1 "><span class="h-nav-link-inner h-nav-link-inner--l1 h-p-nav-link-inner h-p-nav-link-inner--l1 ">Contact</span></a></li></ul>					
					<ul class="social-list social-list--header reset-list no-print"><li class="social-item"><a class="social-link social-link--facebook" href="https://www.facebook.com" title="Facebook (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">Facebook</span><svg aria-hidden="true" class="no-print svg-block" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#FFF" d="M7.2 4v2.9H5v3.5h2.2V20h4.4v-9.6h3s.3-1.7.4-3.5h-3.4V4.5c0-.4.5-.8 1-.8H15V.1C13.8 0 12.3 0 11.7 0 7.1 0 7.2 3.5 7.2 4z"/></svg></a></li><li class="social-item"><a class="social-link social-link--twitter" href="https://www.twitter.com" title="Twitter (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">Twitter</span><svg aria-hidden="true" class="no-print svg-block" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#FFF" d="M20 3.9c-.7.3-1.5.5-2.4.6.8-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1-.7-.8-1.8-1.3-3-1.3-2.3 0-4.1 1.8-4.1 4 0 .3 0 .6.1.9-3.3-.1-6.3-1.7-8.3-4.2-.4.6-.6 1.3-.6 2.1 0 1.4.7 2.6 1.8 3.4-.6-.1-1.2-.3-1.8-.6v.1c0 2 1.4 3.6 3.3 4-.3 0-.7.1-1.1.1-.3 0-.5 0-.8-.1.5 1.6 2 2.8 3.8 2.8-1.4 1.1-3.2 1.7-5.1 1.7-.3 0-.7 0-1-.1C1.9 17.3 4.1 18 6.4 18 13.8 18 18 11.8 18 6.5V6c.8-.6 1.4-1.3 2-2.1z"/></svg></a></li><li class="social-item"><a class="social-link social-link--instagram" href="https://www.papier-code.fr" title="Instagram (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">Instagram</span><svg aria-hidden="true" class="no-print svg-block" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14,2a4,4,0,0,1,4,4v8a4,4,0,0,1-4,4H6a4,4,0,0,1-4-4V6A4,4,0,0,1,6,2h8m0-2H6A6,6,0,0,0,0,6v8a6,6,0,0,0,6,6h8a6,6,0,0,0,6-6V6a6,6,0,0,0-6-6Z" fill="#fff"/><path d="M10,7a3,3,0,1,1-3,3,3,3,0,0,1,3-3m0-2a5,5,0,1,0,5,5,5,5,0,0,0-5-5Z" fill="#fff"/><path d="M15.34,3.41a1.25,1.25,0,1,0,1.25,1.25,1.25,1.25,0,0,0-1.25-1.25Z" fill="#fff"/></svg></a></li><li class="social-item"><a class="social-link social-link--linkedin" href="https://www.papier-code.fr" title="LinkedIn (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">LinkedIn</span><svg aria-hidden="true" class="no-print svg-block" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M.34,6.63h4.2V20H.34ZM2.43,0A2.42,2.42,0,0,1,4.86,2.4,2.42,2.42,0,0,1,2.43,4.8,2.42,2.42,0,0,1,0,2.4,2.42,2.42,0,0,1,2.43,0" fill="#fff"/><path d="M6.94,6.63h4V8.45H11A4.43,4.43,0,0,1,15,6.3c4.25,0,5,2.76,5,6.35V20H15.81V13.48c0-1.55,0-3.49-2.18-3.49s-2.52,1.69-2.52,3.42V20H6.91Z" fill="#fff"/></svg></a></li></ul>				
				</div></nav>
			</div>
		</header>

		<button type="button" title="Fermer le menu" class="btn-overlay reset-btn js-h-nav" aria-hidden="true" tabindex="-1"><span class="visually-hidden">Fermer le menu</span></button>

		<main id="main" class="main cl-bloc"><div class="main-inner">
		
			<header class="main-header">
				
				<h1>Bienvenue sur le Préformaté</h1>

			</header>
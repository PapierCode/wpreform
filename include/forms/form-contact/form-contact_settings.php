<?php
/**
 * 
 * Formulaire de contact : configuration 
 * 
 */

/*==================================
=            Formulaire            =
==================================*/
 
$form_contact_settings = array(
	'title'				=> 'Formulaire de contact',
	'css'				=> 'form form--contact',
	'label-required'	=> '&nbsp;<abbr title="Champ obligatoire" class="form-required">*</abbr>',
	'label-recaptcha'	=> 'Protection contre les spams',
	'submit-title'		=> 'Envoyer un e-mail',
	'submit-txt'		=> 'Envoyer'
);

$form_contact_settings = apply_filters( 'pc_filter_form_contact_settings', $form_contact_settings );

 
/*=====  FIN Formulaire  =====*/

/*==============================
=            Champs            =
==============================*/

$form_contact_fields = array(
	'contact-last-name' => array(
		'type'		    	=> 'text',
		'label-txt' 		=> 'Nom',
		'email-from-txt'	=> true
	),
	'contact-name' => array(
		'type'		    	=> 'text',
		'label-txt' 		=> 'Prénom'
	),
	'contact-phone' => array(
		'type'		    	=> 'text',
		'label-txt' 		=> 'Téléphone'
	),
	'contact-mail' => array(
		'type'		    	=> 'email',
		'label-txt' 		=> 'E-mail',
		'required' 	    	=> true
    ),
	'contact-message' => array(
		'type'		    	=> 'textarea',
		'label-txt' 		=> 'Message',
		'required' 	    	=> true,
		'attr'				=> 'rows="5"'
	),
	'contact-cgu' => array(
		'type'		    	=> 'checkbox',
		'label-txt' 		=> 'J\'ai lu et j\'accepte la <a href="'.get_the_permalink($projectSettings['cgu-page']).'" title="Politique de confidentialité">Politique de confidentialité</a>',
		'required' 	    	=> true,
		'desc'				=> 'Les données de ce formulaire ne sont pas stockées et uniquement utilisées pour répondre à votre demande.',
		'email-not-in'		=> true
	)
);

$form_contact_fields = apply_filters( 'pc_filter_form_contact_fields', $form_contact_fields );


/*=====  FIN Champs  =====*/
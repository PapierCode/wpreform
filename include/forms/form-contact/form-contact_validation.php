<?php

/**
*
** Traitement du formulaire de contact
*
**/

/*=================================
=            Variables            =
=================================*/

// erreur globale
$form_contact_global_error 		= false;
// erreur recaptcha
$form_contact_spam_error		= false;

// validation envoi
$form_contact_mail_sent_error	= false;
$form_contact_mail_sent 		= false;


/*=====  FIN Variables  ======*/


// si le formulaire vient d'être validé
if ( !empty( $_POST ) ) {

/*============================================================
=            Vérification des champs obligatoires            =
============================================================*/

foreach ($form_contact_fields as $name => $datas) {
	
	if ( isset( $datas['required'] ) && $datas['required'] == true ) {

		$form_contact_fields[$name]['error'] = false;

		switch ($datas['type']) {

			case 'checkbox':
				if ( !isset($_POST[$name]) ) {
					$form_contact_fields[$name]['error'] = true;
					$form_contact_global_error = true;
				}
				break;

			case 'email':
				if ( trim( $_POST[$name] ) === '' || !filter_var( trim( $_POST[$name] ), FILTER_VALIDATE_EMAIL ) ) {
					$form_contact_fields[$name]['error'] =  true;
					$form_contact_global_error = true;
				}
				break;
			
			default:
				if ( trim( $_POST[$name] ) === '' ) {
					$form_contact_fields[$name]['error'] =  true;
					$form_contact_global_error = true;
				}
				break;

		}

	}

}

/*----------  reCaptcha  ----------*/

if ( $captcha->isValid( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] ) === false ) {

	$form_contact_spam_error 	= true;
	$form_contact_global_error	= true;

}


/*=====  FIN Vérification des champs obligatoires  ======*/

/*===================================================
=            Construction & envoi E-mail            =
===================================================*/

if ( !$form_contact_global_error ) {


/*----------  Contenu  ----------*/

$form_contact_message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>';

foreach ($form_contact_fields as $name => $datas) {
	
	if ( !isset($datas['email-not-in']) && isset( $_POST[$name] ) ) {

		switch ( $datas['type'] ) {
			case 'checkbox':
				$form_contact_message .= '<p><strong>'.sanitize_text_field($datas['label-txt']).' :</strong> oui</p>';
				break;

			case 'email':
				$form_contact_message .= '<p><strong>'.$datas['label-txt'].' :</strong> '.sanitize_email( $_POST[$name] ).'</p>';
				// paramètre email
				$form_contact_from_mail = sanitize_email( $_POST[$name] );
				break;
			
			default:
				$form_contact_message .= '<p><strong>'.$datas['label-txt'].' :</strong> '.sanitize_text_field( $_POST[$name] ).'</p>';
				// paramètre email
				if ( isset($datas['email-form-txt']) ) { $form_contact_from_name = sanitize_text_field( $_POST[$name] ); }
				break;
		}

	}

}

$form_contact_message .= '</body></html>';


/*----------  Paramètres  ----------*/

// sujet du mail
$form_contact_subject = $projectSettings['form-subject'];
// destinataire
$form_contact_to = $projectSettings['form-for'];
// si nom de l'expéditeur manquant
if ( !isset( $form_contact_from_name ) || $form_contact_from_name == '' ) { $form_contact_from_name = 'sans nom'; }
// entête
$form_contact_mail_headers = array(
   'Content-Type: text/html; charset=UTF-8',
   'From: '.$form_contact_from_name.' <'.$form_contact_from_mail.'>',
);


/*----------  envoi/validation  ----------*/

if ( wp_mail( $form_contact_to, $form_contact_subject, $form_contact_message, $form_contact_mail_headers ) ) { 
	$form_contact_mail_sent = true;
} else {
	$form_contact_mail_sent_error = true;
}


/*=====  FIN Construction & envoi E-mail  ======*/


} // FIN if !form_contact_global_error

} // FIN if !empty($_POST)
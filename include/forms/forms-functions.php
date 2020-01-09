<?php
/**
 * 
 * Fonctions pour formulaires
 * 
 */

/*============================================
=            affichage d'un champ            =
============================================*/

/**
 * 
 * Afficher un label
 * 
 * @param string    $for        attribut for
 * @param bool      $required   champ obligatoire
 * @param string    $txt        texte du label
 * 
 */

function pc_form_display_label( $for, $required, $txt ) {

    if ( $required ) { $txt .= '&nbsp;<abbr title="Champ obligatoire" class="form-required">*</abbr>'; }

    echo '<label for="'.$for.'">'.$txt.'</label>';

}


/**
 * 
 * Afficher un champ text, number, email ou textarea
 * 
 * @param string    $name               attribut name et id
 * @param array     $datas
 *                  string  type        text/email/number/textearea
 *                  string  label       texte du label
 *                  string  css         classes css spéciales
 *                  bool    required    champ obligatoire
 *                  string  attr        attributs supplémentaires
 *                  bool    error       champ en erreur
 *                  string  desc        description/aide
 * @param bool      $email_sent         email envoyé
 * 
 */

function pc_form_display_field_input_textarea( $name, $datas, $mail_sent = false ) {

    /*----------  Configuration  ----------*/ 
    
    // si des propriétés ne sont pas définies
    $datas = array_merge(
        array(
            'type'		    => 'text',
            'label' 	    => 'Sans nom',
            'css'           => '',
            'required' 	    => false,
            'attr'          => '',
            'error'		    => false,
            'desc'          => '',
        ),
        $datas
    );

    // type de champ
    $type = $datas['type'];

    // valeur du champ
    $value = ( !$mail_sent && !empty($_POST) ) ?  $_POST[$name] : '';

    // classes css du container : défaut
    $css = 'form-item form-item--'.$type.' form-item--'.$name;
    // classes css du container : erreur
    if ( $datas['error'] ) { $css .= ' form-item--error'; } 
    // classes css du container : custom
    if ( $datas['css'] != '' ) { $css .= ' '.$datas['css']; }

    // attributs custom
    $other = ( $datas['attr'] != '' ) ? ' '.$datas['attr'] : '';

    // champ obligatoire
    $other .= ( $datas['required'] ) ? ' required' : '';
    
    // accessibilité
    $other .= ( $datas['desc'] != '' ) ? ' aria-describedby="desc-'.$name.'"' : '';
    $other .= ( $datas['error'] ) ? ' aria-invalid="true"' : '';


    /*----------  affichage  ----------*/
    
    echo '<li class="'.$css.'">';

        // label
        pc_form_display_label( $name, $datas['required'], $datas['label-txt'] );
        
        echo '<div>';

            // input type text/number/email
            if ( $type == 'text' || $type == 'number' || $type == 'email' ) {

                echo '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$other.'/>';

            // textarea
            } else if ( $type == 'textarea' ) {

                echo '<textarea id="'.$name.'" name="'.$name.'"'.$other.'>'.$value.'</textarea>';

            }

            // description/aide
            if ( $datas['desc'] != '' ) { echo '<p id="desc-'.$name.'">'.$datas['desc'].'</p>'; }

        echo '</div>';

	echo '</li>';

}


/**
 * 
 * Afficher un champ checkbox
 * 
 * @param string    $name               attribut name et id
 * @param array     $datas
 *                  string  label       texte du label
 *                  string  css         classes css spéciales
 *                  bool    required    champ obligatoire
 *                  string  attr        attributs supplémentaires
 *                  bool    error       champ en erreur
 *                  string  desc        description/aide
 * @param bool      $email_sent         email envoyé
 * 
 */

function pc_form_display_field_checkbox( $name, $datas, $mail_sent = false ) {

    /*----------  Configuration  ----------*/ 
    
    // si des propriétés ne sont pas définies
    $datas = array_merge(
        array(
            'label' 	    => 'Sans nom',
            'css'           => '',
            'required' 	    => false,
            'attr'          => '',
            'error'		    => false,
            'desc'          => '',
        ),
        $datas
    );

    // classes css du container : défaut
    $css = 'form-item form-item--checkbox form-item--'.$name;
    // classes css du container : erreur
    if ( $datas['error'] ) { $css .= ' form-item--error'; } 
    // classes css du container : custom
    if ( $datas['css'] != '' ) { $css .= ' '.$datas['css']; }

    // attributs custom
    $other = ( $datas['attr'] != '' ) ? ' '.$datas['attr'] : '';

    // champ obligatoire
    $other .= ( $datas['required'] ) ? ' required' : '';

    // coché
    $other .= ( !$mail_sent && isset($_POST[$name]) ) ? ' checked' : '';

    // accessibilité
    $other .= ( $datas['desc'] != '' ) ? ' aria-describedby="desc-'.$name.'"' : '';
    $other .= ( $datas['error'] ) ? ' aria-invalid="true"' : '';


    /*----------  Affichage  ----------*/

    echo '<li class="'.$css.'">';
        echo '<div>';
            echo '<input type="checkbox" name="'.$name.'" id="'.$name.'" value="1"'.$other.' />';
            echo '<label for="'.$name.'">'.$datas['label-txt'].'</label>';
        echo '</div>';
        if ( $datas['desc'] != '' ) { echo '<p id="desc-'.$name.'">'.$datas['desc'].'</p>'; };
	echo '</li>';

}


/*=====  FIN affichage d'un champ  =====*/
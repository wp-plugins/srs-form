<?php
/*
Plugin Name: SRS_Form 
Plugin URI:http://www.mediafire.com/download/lrlccr6ktrxn7bh/SRS_Form.zip
Description: A Simple Contact Form for your WordPress Site 
Version: 1.0
Author: Samonta Roy, Sadiatun Nur Hafsa
Author URI:http://samonta.wordpress.com
Tested On: wordpress 4.1.1
Tested up to: 3.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function SRS_markup_test(){
echo '<h2><Font color=blue>Simple Contact Form</h2>';
echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
echo '<table border="1">
    <tr>
        <td>Name (required):</td>
        <td> <input type="text" name="srs-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["srs-name"] ) ? esc_attr( $_POST["srs-name"] ) : '' ) . '" size="40" /> </td>
     </tr>
     <tr>
        <td>email (required):</td>
        <td><input type="email" name="srs-email" value="' . ( isset( $_POST["srs-email"] ) ? esc_attr( $_POST["srs-email"] ) : '' ) . '" size="40" /></td>
     </tr>
     <tr>
        <td>Password:</td>
        <td> <input type="text" name="srs-Password" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["srs-Password"] ) ? esc_attr( $_POST["srs-Password"] ) : '' ) . '" size="40" /> </td>
     </tr>
     
     <tr>
        <td>City (required):</td>
        <td><input type="text" name="srs-city" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["srs-city"] ) ? esc_attr( $_POST["srs-city"] ) : '' ) . '" size="40" /></td>
     </tr>
     <tr>
        <td>Contact No:</td>
        <td> <input type="text" name="srs-ContactNo" pattern="[ 0-9 ]+" value="' . ( isset( $_POST["srs-ContactNo"] ) ? esc_attr( $_POST["srs-ContactNo"] ) : '' ) . '" size="40" /> </td>
     </tr>
     <tr>
        <td colspan="2"><br>Enter any comments below (required):<br>
        <textarea rows="5" cols="35" name="srs-message">' . ( isset( $_POST["srs-message"] ) ? esc_attr( $_POST["srs-message"] ) : '' ) . '</textarea></td>
     </tr>
     <tr>
        <td colspan="2" align="center"><br>
            <input type="submit" name="srs-submitted" value="Send"> <input type="reset">
            <br><br>
        </td>
     </tr>
</table>';
echo '</form>';	
}

function srs_deliver_mail() {
 
    // if the submit button is clicked, send the email
    if ( isset( $_POST['srs-submitted'] ) ) {
 
        // sanitize form values
        $name    = sanitize_text_field( $_POST["srs-name"] );
        $email   = sanitize_email( $_POST["srs-email"] );
        $city = sanitize_text_field( $_POST["srs-city"] );
        $message = esc_textarea( $_POST["srs-message"] );
		
		$Password = sanitize_text_field( $_POST["srs-Password"] );
		$ContactNo = sanitize_text_field( $_POST["srs-ContactNo"] );
 
        // get the blog administrator's email address
        $to = get_option( 'admin_email' );
 
        $headers = "From: $name <$email>" . "\r\n";
 
        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $city, $message, $headers ) ) {
            echo '<div>';
            echo '<p>Thanks for submission, please wait for our response.</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
}
function srs_shortcode() {
    ob_start();
    srs_deliver_mail();
    SRS_markup_test();
    return ob_get_clean();
}
add_shortcode( 'SRS_FORM', 'srs_shortcode' );
?>
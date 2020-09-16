<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Material - White Label WordPress Admin Theme Theme
 * @Since: Mtrl 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Material - White Label WordPress Admin Theme Theme Plugin.
 */
?>
<?php

function mtrl_custom_login() {
    global $mtrladmin;
       $mtrladmin = mtrladmin_network($mtrladmin);       

    global $mtrl_css_ver;

    $url = plugins_url('/', __FILE__).'../'.$mtrl_css_ver.'/mtrl-login.min.css';
    wp_deregister_style('mtrl-login');
    wp_register_style('mtrl-login', $url);
    wp_enqueue_style('mtrl-login');

   /* $url = plugins_url('/', __FILE__) . '../js/mtrl-login-scripts.js';
    wp_deregister_script('mtrl-login-scripts-js');
    wp_register_script('mtrl-login-scripts-js', $url);
    wp_enqueue_script('mtrl-login-scripts-js');*/


    echo "\n<style type='text/css'>";

    /*text, backgrounds, link color*/
    echo mtrl_css_background("body, #wp-auth-check-wrap #wp-auth-check", "login-background","","","imp") . "\n";
    echo "@media screen and ( min-width: 767px ){";
        echo mtrl_css_background(".login form", "login-form-background",($mtrladmin['login-form-bg-opacity']) == "" ? "0.9" : $mtrladmin['login-form-bg-opacity'],"","imp") . "\n";
        echo mtrl_css_background(".login h1", "login-logo-background","","","imp") . "\n";
    echo "}";
    echo "@media screen and ( max-width: 768px ){";
        echo mtrl_css_background("#login", "login-form-background",($mtrladmin['login-form-bg-opacity']) == "" ? "0.9" : $mtrladmin['login-form-bg-opacity'],"","imp") . "\n";
    echo "}";

    echo mtrl_link_color("body.login #backtoblog a, body.login #nav a, body.login a", "login-link-color") . "\n";
    echo mtrl_css_color(".login, .login form label, .login form, .login .message", "login-text-color") . "\n";

    /*login button*/
    echo mtrl_css_bgcolor(".login.wp-core-ui .button-primary", "login-button-bg") . "\n";
    echo mtrl_css_bgcolor(".login.wp-core-ui .button-primary:hover, .login.wp-core-ui .button-primary:focus", "login-button-hover-bg") . "\n";
    echo mtrl_css_color(".login.wp-core-ui .button-primary", "login-button-text-color") . "\n";


    /*form input fields - text and checkbox*/
    echo mtrl_css_bgcolor(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-bg-color", ($mtrladmin['login-input-bg-opacity']) == "" ? "0.5" : $mtrladmin['login-input-bg-opacity'],"","imp") . "\n";
    echo mtrl_css_bgcolor(".login form .input:hover, .login form input[type=checkbox]:hover, .login input[type=text]:hover, .login form .input:focus, .login form input[type=checkbox]:focus, .login input[type=text]:focus", "login-input-bg-color", ($mtrladmin['login-input-bg-hover-opacity']) == "" ? "0.8" : $mtrladmin['login-input-bg-hover-opacity'],"","imp") . "\n";
    echo mtrl_css_color(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-text-color") . "\n";
    echo mtrl_css_color(".login.wp-core-ui input[type=checkbox]:checked:before", "login-input-text-color") . "\n";

    echo mtrl_css_border_color(".login form .input, .login input[type=text]", "login-input-border-color", "1.0", "bottom") . "\n";
    echo mtrl_css_border_color(".login form .input:hover, .login input[type=text]:hover,.login input[type=checkbox]:hover, .login input[type=password]:hover ,.login form .input:focus, .login input[type=text]:focus,.login input[type=checkbox]:focus, .login input[type=password]:focus", "login-button-bg", "1.0", "all") . "\n";
    echo mtrl_css_border_color(".login form input[type=checkbox]", "login-input-border-color", "1.0", "all") . "\n";

    /* input fields icons */
    echo mtrl_css_color(".login label[for='user_login']:before, .login label[for='user_pass']:before, .login label[for='user_email']:before", "login-input-border-color") . "\n";

    /*form input fields - other fields - for future use*/
    echo mtrl_css_bgcolor("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-bg-color", ($mtrladmin['login-input-bg-opacity']) == "" ? "0.5" : $mtrladmin['login-input-bg-opacity']) . "\n";
    echo mtrl_css_color("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-text-color") . "\n";


    /*login error message*/
    echo mtrl_css_bgcolor(".login #login_error, .login .message", "login-input-bg-color", ($mtrladmin['login-input-bg-opacity']) == "" ? "0.5" : $mtrladmin['login-input-bg-opacity'],"","imp") . "\n";
    echo mtrl_css_color(" .login .message,  .login .message a, .login #login_error, .login #login_error a", "login-input-text-color") . "\n";


    /*login logo*/
	$logo_url = "";
    if (isset($mtrladmin['login-logo']['url']) && $mtrladmin['login-logo']['url'] != "") {
        $logo_url = $mtrladmin['login-logo']['url'];
    } else {
        $logo_url = $mtrladmin['logo']['url'];
    }

    echo '.login h1 a { background-image: url("' . $logo_url . '") !important;}';


echo "</style>\n"; 


/*


    echo '.login{color: '.$mtrladmin['login-link-color']['regular'].'}';
    echo '.login.wp-core-ui .button-primary{ 
    height: 34px;
    line-height: 28px;
    border-radius : 0px;
    padding: 0 12px 2px;
    border-color: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
    -ms-box-shadow: none;
    -moz-box-shadow: none;
    -o-shadow: none;
}';

    echo ".login.wp-core-ui input[type=checkbox]{
    box-shadow: none;
    -ms-box-shadow: none;
    -moz-box-shadow: none;
    -o-shadow: none; 
    border-color: " . $mtrladmin['separator-color'] . "
    }";

    if (isset($mtrladmin['login-logo']['url']) && $mtrladmin['login-logo']['url'] != "") {
        $logo_url = $mtrladmin['login-logo']['url'];
    } else {
        $logo_url = $mtrladmin['logo']['url'];
    }

    echo '.login h1 a { background-image: url("' . $logo_url . '");'
    . 'background-size: contain;min-height: 88px;width:auto;}';

    */



}


function mtrl_custom_loginlogo_url() {

    global $mtrladmin;
       $mtrladmin = mtrladmin_network($mtrladmin);       

    $logourl = "https://wordpress.org/";

    if(isset($mtrladmin['logo-url']) && trim($mtrladmin['logo-url']) != ""){
        $logourl = $mtrladmin['logo-url'];
    }
    return $logourl;
}




function mtrl_login_options(){

       global $mtrladmin;
       $mtrladmin = mtrladmin_network($mtrladmin);       

       // back to blog
       $backtoblog = "block";
       $element = 'backtosite_login_link';
       
       if(isset($mtrladmin[$element]) && trim($mtrladmin[$element]) != ""){
            if($mtrladmin[$element] == "0"){
                $backtoblog = "none";
       }}
         
       $style = "";
       $style .= " #backtoblog { display:".$backtoblog." !important; } ";


       // forgot password

       $forgot = "block";
       $element = 'forgot_login_link';
       
       if(isset($mtrladmin[$element]) && trim($mtrladmin[$element]) != ""){
            if($mtrladmin[$element] == "0"){
                $forgot = "none";
       }}
       
       $style .= " #nav { display:".$forgot." !important; } ";

       echo "<style type='text/css' id='mtrl-login-extra-css'>".$style."</style>";

}


// change title
function mtrl_loginlogo_title() {
    global $mtrladmin;
       $mtrladmin = mtrladmin_network($mtrladmin);       

    $logourl = "";

    if(isset($mtrladmin['login-logo-title']) && trim($mtrladmin['login-logo-title']) != ""){
        $logourl = $mtrladmin['login-logo-title'];
    }
    return $logourl;
}
add_filter( 'login_headertext', 'mtrl_loginlogo_title' );



// lost password

/*
function remove_lostpassword_text ( $text ) {
     if ($text == 'Lost your password?'){$text = '';}
        return $text;
     }
//add_filter( 'gettext', 'remove_lostpassword_text' );




// change login redirect link

function admin_login_redirect( $redirect_to, $request, $user )
{
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) ) {
            return $redirect_to;
        } else {
            return home_url();
        }
    }
    else 
    {
        return $redirect_to;
    }
}
add_filter("login_redirect", "admin_login_redirect", 10, 3);

*/
/*
$args = array(
        'echo' => true,         // To echo the form on the page
        'redirect' => site_url( $_SERVER['REQUEST_URI'] ),   // The URL you redirect logged in users
        'form_id' => 'loginform',                            // Id of the form
        'label_username' => __( 'Username' ),                // Label of username
        'label_password' => __( 'Password' ),                // Label of password
        'label_remember' => __( 'Remember Me' ),             // Label for remember me
        'label_log_in' => __( 'Log In' ),                    // Label for log in
        'id_username' => 'user_login',                       // Id on username textbox
        'id_password' => 'user_pass',                        // Id on password textbox
        'id_remember' => 'rememberme',                       // Id on rememberme textbox
        'id_submit' => 'wp-submit',                          // Id on submit button
        'remember' => true,                                  // Display remember me checkbox
        'value_username' => NULL,                            // Default username value
        'value_remember' => false );                         // Default rememberme checkbox

wp_login_form( $args );

*/




?>
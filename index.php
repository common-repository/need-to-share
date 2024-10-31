<?php
/**
 * @package need-to-share
 * @version 2.0.2
 */
/*
Plugin Name: Need To Share
Plugin URI: http://wordpress.org/plugins/need-to-share/
Description: This plugin adds a share window to all next posts pages
Version: 2.0.2
Author URI: http://msalsas.com/en/
*/

/*  Copyright 2014  Manolo Salsas Durán  (email : manolez@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class load_language 
{
    public function __construct()
    {
    add_action('init', array($this, 'load_my_translation324'));
    }

     public function load_my_translation324()
    {
        load_plugin_textdomain('need-to-share', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
    }
}

$needToShareLoadLang = new load_language;


/**********************************************************/

/*******************ADMIN PANEL****************************/

/******************* Settings *******************************/
function need_to_share_register_settings() {
	register_setting( 'need_to_share_options-group', 'need_to_share_fb_app_id' ); 
	register_setting( 'need_to_share_options-group', 'need_to_share_text_to_show' ); 
	register_setting( 'need_to_share_options-group', 'need_to_share_always' ); 	
	register_setting( 'need_to_share_options-group', 'need_to_share_background_color' );	
	register_setting( 'need_to_share_options-group', 'need_to_share_border_color' );	
	register_setting( 'need_to_share_options-group', 'need_to_share_margin_top' );
	register_setting( 'need_to_share_options-group', 'need_to_share_percent_showing' );
	register_setting( 'need_to_share_options-group', 'need_to_share_time_delay' );

} 
add_action( 'admin_init', 'need_to_share_register_settings' );



function need_to_share_settings() {

    add_menu_page('Need To Share Settings', 'Need To Share Settings', 'administrator', 'need_to_share_settings', 'need_to_share_display_settings');

}
add_action('admin_menu', 'need_to_share_settings');


function need_to_share_display_settings() {



    $fbAppId = is_numeric(get_option('need_to_share_fb_app_id')) ? get_option('need_to_share_fb_app_id') : '';

    $textToShow = get_option('need_to_share_text_to_show') ? get_option('need_to_share_text_to_show') : __("Share it!", 'need-to-share');

    $showAlways = get_option('need_to_share_always') == 'enabled' ? 'checked ' : '';

	$backgroundColor = get_option('need_to_share_background_color') ? get_option('need_to_share_background_color') : 'gray';

	$borderColor = get_option('need_to_share_border_color') ? get_option('need_to_share_border_color') : 'black';

	$marginTop = get_option('need_to_share_margin_top') ? get_option('need_to_share_margin_top') : '100px';
	
	$percentShowing = is_numeric(get_option('need_to_share_percent_showing')) ? get_option('need_to_share_percent_showing') : '100';

	$timeDelay = is_numeric(get_option('need_to_share_time_delay')) ? get_option('need_to_share_time_delay') : '10';


    $html = '</pre>
<div class="wrap"><form action="options.php" method="post" name="options">';
       
	$html2 = '<h2>' . __('Select Your Settings', 'need-to-share') . '</h2>

<table class="form-table" width="100%" cellpadding="10">
<tbody>
<tr>
<td scope="row" align="left">
 <label>' . __('Facebook App ID', 'need-to-share') . '</label>
<input type="text" name="need_to_share_fb_app_id" value="' . $fbAppId . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('Text to show', 'need-to-share') . '</label>
<input type="text" name="need_to_share_text_to_show" value="' . $textToShow . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
 <input type="checkbox" name="need_to_share_always" value="enabled" ' . $showAlways . ' /><label>' . __('Show always on posts (if unchecked, it will be shown only on next posts pages)', 'need-to-share') . '</label></td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('Background color (CSS value). E.g. #CCCCCC', 'need-to-share') . '</label>
<input type="text" name="need_to_share_background_color" value="' . $backgroundColor . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('Border color (CSS value). E.g. #223344', 'need-to-share') . '</label>
<input type="text" name="need_to_share_border_color" value="' . $borderColor . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('Margin Top (CSS value). E.g. 300px', 'need-to-share') . '</label>
<input type="text" name="need_to_share_margin_top" value="' . $marginTop . '" /></td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('When to show (percentage). E.g. 50', 'need-to-share') . '</label>
<input type="text" name="need_to_share_percent_showing" value="' . $percentShowing . '" />%</td>
</tr>
<tr>
<td scope="row" align="left">
 <label>' . __('Timing delay in seconds. E.g. 30', 'need-to-share') . '</label>
<input type="text" name="need_to_share_time_delay" value="' . $timeDelay . '" />s</td>
</tr>


</tbody>
</table>';
 
 $html3 = '</form></div>
<pre>
';

    echo $html;
    settings_fields('need_to_share_options-group');
    do_settings_sections('need_to_share_options-group');
    echo $html2;
    submit_button();
    echo $html3;

}




if ( isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] ) {
	
		function add_FB_init_function_needToShare()
		{
			echo "<div id='fb-root'></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = '//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=" . get_option('need_to_share_fb_app_id') . "&version=v2.0'; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>";
		}
		add_action('wp_footer', 'add_FB_init_function_needToShare');
		
		function needToShare438574($content)
		{
			if(! is_admin() && is_single()) {
				$randNumber = mt_rand(1,100);
				if($randNumber <= get_option('need_to_share_percent_showing'))
				{ 
					$lastBarNeedToShare = substr( $_SERVER['REQUEST_URI'], strrpos( $_SERVER['REQUEST_URI'], '/' ) + 1 );
					$lastBarNeedToShare = strlen($lastBarNeedToShare) > 0 ? $lastBarNeedToShare : substr( $_SERVER['REQUEST_URI'], strrpos( $_SERVER['REQUEST_URI'], '/', strrpos( $_SERVER['REQUEST_URI'], '/' ) - strlen($_SERVER['REQUEST_URI']) - 1 ) + 1 );
					$lastBarNeedToShare = str_replace( '/', '', $lastBarNeedToShare );
					if ( get_option('need_to_share_always') !== 'enabled' && is_numeric( $lastBarNeedToShare ) || get_option('need_to_share_always') == 'enabled' ) {	
						
						//Twitter button
						$twbtnNeetToShare = '<div id="tw-need-to-share"><a href="https://twitter.com/share" data-count="vertical" class="twitter-share-button" data-url="' . get_the_permalink() . '" data-lang="es" data-text="' . get_the_title() . '" ';
						
						//Check first category for hashstag
						$categories = get_the_category();
						if( $categories[0] ) {
							$cat_name = str_replace(' ', '_', $categories[0]->cat_name);
							$twbtnNeetToShare .= 'data-hashtags="' . $cat_name . '"';
						}
						
						$twbtnNeetToShare .= '>Twittear</a>'."<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>";		
						
						//Facebook button				
						$fbbtnNeedToShare = "<div id='fb-need-to-share'>";
						$fbbtnNeedToShare .= '<div class="fb-like" data-href="' . get_the_permalink() . '" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div></div>';

						//Gplus button
						$gplusbtnNeedToShare = '<div id="gplus-need-to-share"><script src="https://apis.google.com/js/platform.js" async defer> {lang: "es"} </script>';
						$gplusbtnNeedToShare .= '<div class="g-plusone" data-size="tall" data-href="' . get_the_permalink() . '"></div></div>';
						
									
						$content = $content . '<div id="needtoshare" style="background: ';
						$content .= get_option('need_to_share_background_color') ? get_option('need_to_share_background_color') . '; ' : 'gray; ';
						$content .= get_option('need_to_share_margin_top') ? 'top: ' . get_option('need_to_share_margin_top') . '; ' : '100px; ';					
						$content .= get_option('need_to_share_border_color') ? 'border: 5px solid ' . get_option('need_to_share_border_color') . '"' : '5px solid black"';
						$content .= '><div id="close-need-to-share"><img src="' . WP_PLUGIN_URL . '/need-to-share/img/close.png" class="need-to-share-close-image"/></div><p>';
						$content .= get_option('need_to_share_text_to_show') ? get_option('need_to_share_text_to_show') : __("Share it!", 'need-to-share');
						$content .= ':</p>' . $twbtnNeetToShare . $fbbtnNeedToShare . $gplusbtnNeedToShare . '</div>';
				
						
						wp_register_script( 'needtoshare', plugins_url('/js/needtoshare.js', __FILE__), array( 'jquery' ));

						wp_localize_script( 'needtoshare', 'need_to_share_data', array('timeDelay' => get_option('need_to_share_time_delay') * 1000 ) );
						
						wp_enqueue_script( 'needtoshare' );
							
						wp_enqueue_style( 'needtoshare.css', plugins_url('/css/needtoshare.css', __FILE__) );
					}
				}
			}
			return $content;
		}
		add_filter('the_content', 'needToShare438574', 1);
}



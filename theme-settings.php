<?php
// $Id: theme-settings.php,v 1.8 2011/01/01 13:20:14 njyoung Exp $

function ncstate_official_form_system_theme_settings_alter(&$form, $form_state) {

// Generate the form using Forms API. http://api.drupal.org/api/7
  $form['custom'] = array(
    '#title' => 'Custom theme settings', 
    '#type' => 'fieldset', 
  );
    
  $form['custom']['title_image_url'] = array(
    '#title' => 'Site Title Image Full URL',
    '#description' => t('Transparent PNG / GIF title of your site. OIT Design (http://oitdesign.ncsu.edu) can create this correctly for you. Must include http:// or https://'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('title_image_url'),
    '#size' => 120,
    '#maxlength' => 255,
    '#required' => TRUE,
  );

  $form['custom']['site_title_vertical_offset'] = array(
    '#title' => 'Site Title Vertical Offset (px)',
    '#description' => t('Move the site title vertically (helpful if you change the size or font options). NOTE: include "px" on the end of your offset.'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('site_title_vertical_offset'),
    '#size' => 6,
    '#maxlength' => 5,
    '#required' => TRUE,
  );

  $form['custom']['site_title_horizontal_offset'] = array(
    '#title' => 'Site Title Horizontal Offset (px)',
    '#description' => t('Move the site title horizontally (helpful if you change the size or font options). NOTE: include "px" on the end of your offset.'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('site_title_horizontal_offset'),
    '#size' => 6,
    '#maxlength' => 5,
    '#required' => TRUE,
  );

  $form['custom']['show_breadcrumbs'] = array(
    '#title' => 'Show Breadcrumbs when available',
    '#type' => 'select',
    '#default_value' => theme_get_setting('show_breadcrumbs'),
    '#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );

  $form['custom']['breadcrumb_separator'] = array(
    '#title' => 'Breadcrumb Separator',
    '#description' => t('The character that will go in between breadcrumb items. Include spaces if necessary'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('breadcrumb_separator'),
    '#size' => 15,
    '#maxlength' => 10,
    '#required' => FALSE,
  );

  $form['custom']['show_post_info_on_search'] = array(
    '#title' => 'Show Post Information on Search Results',
    '#type' => 'select',
    '#default_value' => theme_get_setting('show_post_info_on_search'),
    '#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );

  $sliderTransitionTimeArray = array(
      1000 => '1 Second',
      3000 => '3 Seconds',
      5000 => '5 Seconds',
      10000 => '10 Seconds',
      15000 => '15 Seconds',
      20000 => '20 Seconds',
      30000 => '30 Seconds',
      60000 => '60 Seconds',
    );

  $form['custom']['slider_transition_time'] = array(
        '#type'          => 'select',
        '#title'         => t('Set the slider transition time'),
        '#default_value' => theme_get_setting('slider_transition_time'),
        '#description'   => t("<p>This is the amount of seconds each slide will display before transitioning to the next panel. If you are not using a slider anywhere on your site, ignore this setting.</p>"),
        '#required'      => TRUE,
        '#options'       => $sliderTransitionTimeArray,
    );

  $form['custom']['copyright_information'] = array(
    '#title' => 'Copyright information',
    '#description' => t('Information about copyright holder of the website - will show up at the bottom of the page'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('copyright_information'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  );

  $form['custom']['footer_contact_information'] = array(
    '#title' => 'Footer Contact Information',
    '#description' => t('For example: North Carolina State University Raleigh, NC 27695 Phone: (919) 515-2011'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('footer_contact_information'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  $form['custom']['social_facebook_url'] = array(
    '#title' => 'Facebook page URL',
    '#description' => t('Change this to your own facebook URL, or leave as the default (http://facebook.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('social_facebook_url'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  
  $form['custom']['social_youtube_url'] = array(
    '#title' => 'Youtube Account URL',
    '#description' => t('Change this to your own youtube channel URL, or leave as the default (http://youtube.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('social_youtube_url'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  
  $form['custom']['social_twitter_url'] = array(
    '#title' => 'Twitter Account URL',
    '#description' => t('Change this to your own twitter account URL, or leave as the default (http://twitter.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('social_twitter_url'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );

}

function ncstate_official_generate_array($min, $max, $increment, $postfix, $unlimited = NULL) {
  $array = array();
  if ($unlimited == 'first') {
    $array['none'] = 'Unlimited';
  }
  for ($a = $min; $a <= $max; $a += $increment) {
    $array[$a . $postfix] = $a . ' ' . $postfix;
  }
  if ($unlimited == 'last') {
    $array['none'] = 'Unlimited';
  }
  return $array;
}

<?php
// $Id: template.php,v 1.16.2.3 2010/05/11 09:41:22 goba Exp $

// pass variables to javascript so they can use the base path and theme path
$js = "var base_path = '". base_path() . "';";
drupal_add_js($js, 'inline');

$themePath = "var theme_path = '". path_to_theme() . "';";
drupal_add_js($themePath, 'inline');

  drupal_add_js(array('ncstate_official' => array(
      'slider_transition_time' => theme_get_setting('slider_transition_time'),
    )), 'setting');

/*
* Initialize theme settings
*/
/**
 * Override or insert variables into the html template.
 */
function ncstate_official_preprocess_html(&$variables) {
   /* Add dynamic stylesheet */
  ob_start();
  include('css/base/dynamic.css.php');
  $dynamic_styles = ob_get_contents();
  ob_end_clean();
  drupal_add_css($data = $dynamic_styles, $options['type'] = 'inline', $options['weight'] = CSS_SYSTEM - 1);
}

/**
 * Override or insert variables into the block template.
 */
function ncstate_official_preprocess_block(&$variables) {
  // Remove "block" class from blocks in "Main page content" region
  if ($variables['elements']['#block']->region == 'content') {
    foreach ($variables['classes_array'] as $key => $val) {
      if ($val == 'block') {
        unset($variables['classes_array'][$key]);
      }
    }
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */

function ncstate_official_breadcrumb($variables) {
  // Wrap separator with span element.
  if (!empty($variables['breadcrumb'])) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<span class="access">' . t('You are here') . '</span>';
    $output .= '<div class="breadcrumb">' . implode('<span class="separator"> ' . theme_get_setting('breadcrumb_separator') . '</span>', $variables['breadcrumb']) . '</div>';
    return $output;
  }
}



/**
 * Override or insert PHPTemplate variables into the templates.
 */

function ncstate_official_preprocess_page(&$variables) {
  
  /*
  echo '<pre><hr /><hr /><hr /><hr /><hr /><hr />';
  print_r($variables);
  die();
  */


  	/* Add dynamic stylesheet */
  	ob_start();
  	//include('dynamic.css.php');
  	include(drupal_get_path('theme', 'ncstate_official') . '/css/base/dynamic.css.php');
  	$variables['dynamic_styles'] = ob_get_contents();
  	ob_end_clean();

	// Drupal wants us to set the indexes/custom variables ahead of time, or it will throw an error for the world to see (it will work, just with errors)
	$variables['page']['region-widths']['show-left-region'] = '';
	$variables['page']['region-widths']['show-right-region'] = '';

	// detect, set and store the widths for the different regions, based on what's being displayed (left, right, center and all combinations)
	$variables['page']['region-widths']['maxPageWidth'] = 90;// maximum number of columns in the grid system

	// check to see if there are left or right regions to make it easier to set widths of regions below
	
        if($variables['page']['left_above_menu'] || $variables['page']['left_primary_menu'] || $variables['page']['left_secondary_menu'] || $variables['page']['left_below_menu']) {
                // there is something in the left region, so set the necessary widths here
                $variables['page']['region-widths']['show-left-region'] = true;
                $variables['page']['region-widths']['left-region-width'] = 20;
        }

        if($variables['page']['right_top_sidebar'] || $variables['page']['right_main_sidebar'] || $variables['page']['right_main_blank_sidebar'] || $variables['page']['right_bottom_sidebar']) {
                // there is something in the right region, so set the necessary widths here
                $variables['page']['region-widths']['show-right-region'] = true;
                $variables['page']['region-widths']['right-region-width'] = 25;
        }
	
	// now check to see for combinations of the left and right showing or not, and set the swidth accordingly
	// set the center/right region width (everything to the right of the left region)
	if($variables['page']['region-widths']['show-left-region']) {
		$variables['page']['region-widths']['center-right-region-width'] = 70;
	} else {
		$variables['page']['region-widths']['center-right-region-width'] = $variables['page']['region-widths']['maxPageWidth'];
	}

	// set the center region width (not including the right region)
	if($variables['page']['region-widths']['show-left-region'] && $variables['page']['region-widths']['show-right-region']) {
		$variables['page']['region-widths']['center-region-width'] = 45; //if both left and right regions are showing
	} elseif($variables['page']['region-widths']['show-left-region'] && !$variables['page']['region-widths']['show-right-region']) {
		$variables['page']['region-widths']['center-region-width'] = 70; // if only the left region is showing
	} elseif(!$variables['page']['region-widths']['show-left-region'] && $variables['page']['region-widths']['show-right-region']) {
		$variables['page']['region-widths']['center-region-width'] = 65; // if only the right region is showing
	} else {
		$variables['page']['region-widths']['center-region-width'] = $variables['page']['region-widths']['maxPageWidth']; // if neither left or right regions are showing
	}

	//detect if the belltower is set to be display (configured on the theme options page)
	// if set, give it 7 (the grids value) to be subtracted from the left region's width in the header
	$bellTowerWidth = 0;
	if (theme_get_setting('show_belltower')) {
		$bellTowerWidth = 7;
	}

	// detect if the search bar displayed, and set the header region widths accordingly
	if ($variables['page']['header_search']) {
		$variables['page']['region-widths']['show-right-header-region'] = true;
		$variables['page']['region-widths']['region-header-left-width'] = 62 - $bellTowerWidth;

	} else {
		$variables['page']['region-widths']['show-right-header-region'] = false;
		$variables['page']['region-widths']['region-header-left-width'] = 90 - $bellTowerWidth;
	}



	//set the title image appropriately based on how much room there is to use: number of grids * 10 (pixels), minus 30 (pixels) for space
	$variables['page']['region-widths']['region-header-title-width'] = ($variables['page']['region-widths']['region-header-left-width'] * 10) - 30;

	// check for footer horizontal menu. If configured by user, display it. If not configured by user, display default menu.
	if(!$variables['page']['footer_menu']) {
		$variables['page']['footer_menu'] = '
			<ul aria-label="Services Navigation" role="navigation">
                            <li><a href="http://www.ncsu.edu/emergency-information/">Emergency Info</a></li>
                            <li><a href="http://www.ncsu.edu/privacy/" title="North Carolina State University Privacy Policy">Privacy</a></li>
                            <li><a href="http://www.ncsu.edu/copyright/" title="North Carolina State University copyright policy">Copyright</a></li>
                            <li><a class="track" href="http://oit.ncsu.edu/itaccess/legislation-and-policies" title="North Carolina State University website accessibility information">Accessibility</a></li>
                            <li><a class="track" href="http://oied.ncsu.edu/oied/">Diversity</a></li>
                            <li><a class="track" href="http://policies.ncsu.edu/" title="North Carolina State University Policies">University Policies</a></li>
                            <li><a href="http://www.ncsu.edu/about-site/" title="About the North Carolina State University website">About the Site</a></li>
                            <li><a class="track" href="https://jobs.ncsu.edu/" title="Jobs at North Carolina State University">Jobs</a></li>
                            <li><a href="http://www.ncsu.edu/contact-us/" title="Contact North Carolina State University">Contact NC State</a></li>
                        </ul>';
	} else {
		$variables['page']['footer_menu'] = $variables['page']['footer_menu'];
	}

  // dont show breadcrumbs on home page
  if ($variables['is_front']) {
    $variables['breadcrumb'] = NULL;
  }


}

/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function ncstate_official_preprocess_comment_wrapper(&$variables) {
  if ($variables['content'] && $variables['node']->type != 'forum') {
    $variables['content'] = '<h2 class="comments">'. t('Comments') .'</h2>'.  $variables['content'];
  }
}

/**
 * Returns the themed submitted-by string for the comment.
 */
function ncstate_official_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

/**
 * Returns the themed submitted-by string for the node.
 */
function ncstate_official_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Returns HTML for a "more" link, like those used in blocks.
 *
 * @param $variables
 *   An associative array containing:
 *   - url: The url of the main page.
 *   - title: A descriptive verb for the link, like 'Read more'.
 */
function ncstate_official_more_link($variables) {
  return '<div class="more-link">' . l(t('More ‚Ä∫'), $variables['url'], array('attributes' => array('title' => $variables['title']))) . '</div>';
}

/**
 * Returns HTML for status and/or error messages, grouped by type.
 *
 * An invisible heading identifies the messages for assistive technology.
 * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html
 * for info.
 *
 * @param $variables
 *   An associative array containing:
 *   - display: (optional) Set to 'status' or 'error' to display only messages
 *     of that type.
 */
function ncstate_official_status_messages($variables) {
  $output = '';
  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  // Print serveral messages in separate divs.
  foreach (drupal_get_messages($variables['display']) as $type => $messages) {
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    foreach ($messages as $message) {
      $output .= '<div class="messages message ' . $type . '">';
      $output .= $message;
      $output .= "</div>\n";
    }
  }

  return $output;
}

/**
 * Returns HTML for a sort icon.
 *
 * @param $variables
 *   An associative array containing:
 *   - style: Set to either 'asc' or 'desc', this determines which icon to show.
 */
function ncstate_official_tablesort_indicator($variables) {
  // Use custom arrow images.
  if ($variables['style'] == 'asc') {
    return theme('image', array('path' => path_to_theme() . '/images/tablesort-ascending.png', 'alt' => t('sort ascending'), 'title' => t('sort ascending')));
  }
  else {
    return theme('image', array('path' => path_to_theme() . '/images/tablesort-descending.png', 'alt' => t('sort descending'), 'title' => t('sort descending')));
  }
}

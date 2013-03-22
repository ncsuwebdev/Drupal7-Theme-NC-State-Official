<?php // $Id: node.tpl.php,v 0.0.1 2011/01/01 09:00:00 njyoung Exp $ ?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <div class="node-header">
    <?php print render($title_prefix); ?>
    <?php if (!$page): ?>
      <h2 class="node-title" <?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
  </div> <!-- /.node-header -->

  <div class="content clearfix" <?php print $content_attributes; ?>>
    <?php print $user_picture; ?>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>
  <?php if ($display_submitted): ?>
      <div class="meta">
        <div class="submitted">
        	<?php print t('Author: !username on !datetime', array('!username' => $name, '!datetime' => $date)); ?>
        </div>
      </div>
    <?php endif; ?>
  <div class="links-wrapper">
  	
    <?php print render($content['links']); ?>
  </div>
  
  <?php print render($content['comments']); ?>

</div>

<?php foreach(get_errors() as $error){ ?>
  <p><span><?php print $error; ?></span></p>
<?php } ?>
<?php foreach(get_messages() as $message){ ?>
  <p><span><?php print $message; ?></span></p>
<?php } ?>
<?php

$options = get_option('resend_options');
?>
<input type="text" name="resend_options[resend_api_key]" value="<?php echo isset($options['resend_api_key']) ? $options['resend_api_key'] : ''; ?>" />

<?php

$options = get_option('resend_options');
?>
<input id="resend_api_key" class="regular-text" name="resend_options[resend_api_key]" type="text" value="<?php echo isset($options['resend_api_key']) ? $options['resend_api_key'] : ''; ?>" />

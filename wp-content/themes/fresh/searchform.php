<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="opal-search input-group">
		<input name="s" maxlength="40" class="form-control input-large input-search" type="text" size="20" placeholder="<?php esc_html_e('Search...', 'fresh'); ?>">
		<span class="input-group-addon input-large btn-search">
			<input type="submit" class="fa" value="&#xf002;" />
			<?php if( defined('OPAL_WOOCOMMERCE_ACTIVED') && OPAL_WOOCOMMERCE_ACTIVED ) { ?>
			<input type="hidden" name="post_type" value="product" />
			<?php } ?>
		</span>
	</div>
</form>



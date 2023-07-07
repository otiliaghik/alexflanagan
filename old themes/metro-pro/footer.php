<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

genesis_structural_wrap( 'site-inner', 'close' );
echo '</div>'; //* end .site-inner or #inner

do_action( 'genesis_before_footer' );
do_action( 'genesis_footer' );
do_action( 'genesis_after_footer' );

echo '</div>'; //* end .site-container or #wrap

do_action( 'genesis_after' );
wp_footer(); //* we need this for plugins
?>
<script>
    $ = jQuery;
    jQuery(document).ready(function(){
        $(".love-to-watch").html(function(_, html) {
            return html.replace(/(♥)/g, '<span style="color:red; font-size: 18px; line-height: 0;">$1</span>');
        });
    });
</script>
</body>
</html>

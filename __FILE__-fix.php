<?php

// Fix the __FILE__ problem with symlinks.
// Now just use ___FILE___ instead of __FILE__
  
$___FILE___ = __FILE__;
  
if ( isset( $plugin ) ) {
    $___FILE___ = $plugin;
}
else if ( isset( $mu_plugin ) ) {
    $___FILE___ = $mu_plugin;
}
else if ( isset( $network_plugin ) ) {
    $___FILE___ = $network_plugin;
}
  
define( '___FILE___', $___FILE___ );

?>
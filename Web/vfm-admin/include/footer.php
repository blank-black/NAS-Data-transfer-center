<?php
/**
 * VFM - veno file manager: include/footer.php
 * script footer
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */ ?>
 <footer class="footer">
    <div class="container">
        <span class="pull-left"><a href="./">
            <?php print $setUp->getConfig("appname"); ?> </a> 
            &copy; <?php echo date('Y'); ?>
        </span>
    </div>
</footer>
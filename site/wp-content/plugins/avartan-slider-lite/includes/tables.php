<?php
if( !defined( 'ABSPATH') ) exit();

class AvartanlitesliderTables {

    /**
     * Update the current Avartan Animation Slider version in the database
    */
    public static function avartansliderSetVersion() {
        update_option('avartanslider_version', AS_VERSION);
    }

    /**
     * remove the current Avartan Animation Slider version from the database
    */
    public static function avartansliderRemoveVersion() {
        delete_option('avartanslider_version');
    }

    /**
     * Creates or updates all the tables
    */
    public static function avartansliderSetTables() {
        self::avartansliderSetSlidersTable();
        self::avartansliderSetSlidesElementsTable();
    }

    /**
     * Create slider table
    */
    public static function avartansliderSetSlidersTable() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'avartan_sliders';

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name TEXT CHARACTER SET utf8,
        alias TEXT CHARACTER SET utf8,
        slider_option LONGTEXT CHARACTER SET utf8,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Create slide table
    */
    public static function avartansliderSetSlidesElementsTable() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'avartan_slides';

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        slider_parent mediumint(9),
        position INT,
        params LONGTEXT CHARACTER SET utf8,
        layers LONGTEXT CHARACTER SET utf8,
        UNIQUE KEY id (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Drops all the slider tables
    */
    public static function avartansliderDropTables() {
        global $wpdb;

        self::avartansliderDropTable($wpdb->prefix . 'avartan_sliders');
        self::avartansliderDropTable($wpdb->prefix . 'avartan_slides');
    }

    /**
     * Drops called the slider tables
     * 
     * @param string $table_name table name for drop
    */
    public static function avartansliderDropTable($table_name) {
        global $wpdb;

        $sql = 'DROP TABLE ' . $table_name . ';';
        $wpdb->query($sql);
    }
}
?>
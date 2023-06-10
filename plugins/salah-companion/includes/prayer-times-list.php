<?php
function sc_prayer_times_list_handler() 
{
    global $wpdb;
    $table = new Custom_Table_Example_List_Table();
    $table->prepare_items();
    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Prayer Times List', 'wpbc')?> 
            <a 
                class="add-new-h2"
                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=prayer-time-form');?>">
                <?php _e('Add new', 'wpbc')?>
            </a>
        </h2>
        <?php echo $message; ?>

        <form id="prayers-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php $table->display() ?>
        </form>
    </div>
    <?php
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Custom_Table_Example_List_Table extends WP_List_Table
{
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'sc__prayer',
            'plural'   => 'sc__prayers',
        ));
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
    function column_latitude($item)
    {
        return '<em>' . $item['latitude'] . '</em>';
    }

    function column_city($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=prayer-time-form&id=%s">%s</a>', $item['id'], __('Edit', 'wpbc')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'wpbc')),
        );
        return sprintf('%s %s',
            $item['city'],
            $this->row_actions($actions)
        );
    }


    function column_id($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'id'                    => '<input type="checkbox" />', 
            'city'                  => __('City', 'wpbc'),
            'country'               => __('country', 'wpbc'),
            'latitude'              => __('latitude', 'wpbc'),
            'longitude'             => __('longitude', 'wpbc'),
            // 'time_zone'             => __('time_zone', 'wpbc'),
            'calc_method'           => __('Calc Method', 'wpbc'),  
            'salat_juristic'        => __('Juristic', 'wpbc'),   
            'salat_highlatsmethod'  => __('Highlatsmethod', 'wpbc'),  
            // 'time_format'           => __('Time Format', 'wpbc'),
            'qibla_angle'           => __('Qibla Angle', 'wpbc'),
            // 'adjust_prayer_fajr'    => __('Fajar Ajustment', 'wpbc'),
            // 'adjust_prayer_zohr'    => __('ZohrAjustment', 'wpbc'),
            // 'adjust_prayer_asr'     => __('AsrAjustment', 'wpbc'),
            // 'adjust_prayer_maghrib' => __('Maghrib Adjustment', 'wpbc'),
            // 'adjust_prayer_isha'    => __('Isha Adjustment', 'wpbc'),
            // 'blurb'                 => __('Blurb', 'wpbc')

        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'country'       => array('country', true),
            'city'          => array('city', true),

        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "salah_companion";

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'salah_companion'; 

        $per_page = 10; 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->process_bulk_action();

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));
    }
}


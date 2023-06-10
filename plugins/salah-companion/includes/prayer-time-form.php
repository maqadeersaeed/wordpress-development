<?php


function sc_prayer_times_create_handler() {
    
    $message = '';
    $notice = '';
    global $wpdb;
    $table_name = $wpdb->prefix . "salah_companion";
    // $charset_collate = $wpdb->get_charset_collate();

    $default = array(
        'id' => 0,
        'latitude' => '',
        'longitude' => '',
        'time_zone' => '',
        'country' => '',
        'city' => '',
        'calc_method' => '',
        'salat_juristic' => '',
        'salat_highlatsmethod' => '',
        'time_format' => '',
        'qibla_angle' => '',
        'adjust_prayer_fajr' => 0,
        'adjust_prayer_zohr' => 0,
        'adjust_prayer_asr' => 0,
        'adjust_prayer_maghrib' => 0,
        'adjust_prayer_isha' => 0,
        'blurb' => '',
    );

    //insert
    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        $item = shortcode_atts($default, $_REQUEST);
        $item_valid = sc_validate_prayer_settings($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                // $result = true;
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                
                if ($result) {
                    $message = __('Item was successfully saved', 'wpbc');
                } else {
                    $notice = __('There was an error while saving item', 'wpbc');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    // $message = __('Item was successfully updated', 'wpbc');
                    $message = 'Item was successfully updated';
                } else {
                    // $notice = __('There was an error while updating item', 'wpbc');
                    $notice = 'There was an error while updating item';
                }
            }
        } else {
            $notice = $item_valid;
        }
    } else {
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $query = "SELECT * FROM $table_name WHERE id = %d";
            $item = $wpdb->get_row($wpdb->prepare($query, $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                // $notice = __('Item not found', 'wpbc');
                $notice = 'Item not found';
            }
        }
    }

    add_meta_box(
                'sc_prayer_form_meta__box', 
                'Prayer', 
                'sc_prayer_form_meta_box_handler',
                'sc__prayer',
                'normal',
                'default');
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>
            <?php _e('Add / Update Prayer Time', 'wpbc')?> 
            <a 
                class="add-new-h2"
                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=prayer-times-list');?>">
                <?php _e('Back to List', 'wpbc')?>
            </a>
        </h2>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif;?>

        <!-- <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> -->
        <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <?php do_meta_boxes('sc__prayer', 'normal', $item); ?>
                    <!-- <input type="submit" value="<?php _e('Save', 'wpbc')?>" id="submit" class="button-primary" name="submit"> -->
                    <input type="submit" value="Save" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
        </form>
    </div>
    <?php
}

function sc_prayer_form_meta_box_handler($item)
{
    ?>
<tbody >
		
	<div class="formdatabc">
        <form >
            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="name">latitude</label>
                <br>	
                    <input 
                        id  =   "latitude" 
                        name=   "latitude" 
                        type="text" 
                        value="<?php echo esc_attr($item['latitude'])?>"
                        >
                </p>
                <p>	
                    <label for="longitude">longitude</label>
                    <br>
                    <input 
                        id="longitude" 
                        name="longitude" 
                        type="text" 
                        value="<?php echo esc_attr($item['longitude'])?>"
                        >
                </p>
            </div>

            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="name">country</label>
                <br>	
                    <input 
                        id  =   "country" 
                        name=   "country" 
                        type="text" 
                        value="<?php echo esc_attr($item['country'])?>"
                        >
                </p>
                <p>	
                    <label for="city">city</label>
                    <br>
                    <input 
                        id="city" 
                        name="city" 
                        type="text" 
                        value="<?php echo esc_attr($item['city'])?>"
                        >
                </p>
            </div>
            
            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="calc_method">calc_method</label>
                <br>	
                    <select id ="calc_method" name="calc_method"  autocomplete="off">                    
                        <option value="Jafari" <?PHP if ( $item['calc_method'] == 'Jafari' )  { echo 'selected'; };  ?> >Ithna Ashari</option>
                        <option value="Karachi" <?PHP if ( $item['calc_method'] == 'Karachi' )  { echo 'selected'; };  ?> >University of Islamic Sciences, Karachi</option>
                        <option value="ISNA" <?PHP if ( $item['calc_method'] == 'ISNA')  { echo 'selected'; };  ?> >Islamic Society of North America (ISNA)</option>
                        <option value="MWL" <?PHP if ( $item['calc_method'] == 'MWL' )  { echo 'selected'; };  ?> >Muslim World League (MWL)</option>
                        <option value="Makkah" <?PHP if ( $item['calc_method'] == 'Makkah' )  { echo 'selected'; };  ?> >Umm al-Qura, Makkah</option>
                        <option value="Egypt" <?PHP if ( $item['calc_method'] == 'Egypt' )  { echo 'selected'; };  ?> >Egyptian General Authority of Survey</option>
                        <option value="Custom" <?PHP if ( $item['calc_method'] == 'Custom' )  { echo 'selected'; };  ?> >Custom Setting</option>
                        <option value="Tehran" <?PHP if ( $item['calc_method'] == 'Tehran' )  { echo 'selected'; };  ?> >Institute of Geophysics, University of Tehran</option>
                    </select>
                </p>
                <p>	
                    <label for="salat_juristic">salat_juristic</label>
                    <br>
                    <select name="salat_juristic" autocomplete="off" >     
                        <option value="Shafii" <?PHP if ( $item['salat_juristic'] == 'Shafii' )  { echo 'selected'; };  ?> >Shafii</option>
                        <option value="Hanafi" <?PHP if ( $item['salat_juristic'] == 'Hanafi' )  { echo 'selected'; };  ?> >Hanafi</option>
                    </select>
                </p>
                <p>	
                    <label for="salat_highlatsmethod">salat_highlatsmethod</label>
                    <br>
                    <select name="salat_highlatsmethod" autocomplete="off" >
                        <option value="None" <?PHP if ( $item['salat_highlatsmethod'] == 'None' )  { echo 'selected'; };  ?> >No adjustment</option>
                        <option value="MidNight" <?PHP if ( $item['salat_highlatsmethod'] == 'MidNight' )  { echo 'selected'; };  ?> >Middle of night</option>
                        <option value="OneSeventh" <?PHP if ( $item['salat_highlatsmethod'] == 'OneSeventh' )  { echo 'selected'; };  ?> >1/7th of night</option>
                        <option value="AngleBased" <?PHP if ( $item['salat_highlatsmethod'] == 'AngleBased' )  { echo 'selected'; };  ?> >Angle/60th of night</option>
                    </select>
                </p>
                <p>
                    <label for="time_zone">time_zone</label>
                    <br>
                    <select name="time_zone" autocomplete="off" >
                    <option value="-12" <?PHP if ( $item['time_zone'] == -12 )  { echo 'selected'; };  ?> >GMT -12</option>
                    <option value="-11" <?PHP if ( $item['time_zone'] == -11 )  { echo 'selected'; };  ?>>GMT -11</option>
                    <option value="-10" <?PHP if ( $item['time_zone'] == -10 )  { echo 'selected'; };  ?>>GMT -10</option>
                    <option value="-9" <?PHP if ( $item['time_zone'] == -9 )  { echo 'selected'; };  ?>>GMT -9</option>
                    <option value="-8" <?PHP if ( $item['time_zone'] == -8 )  { echo 'selected'; };  ?>>GMT -8</option>
                    <option value="-7" <?PHP if ( $item['time_zone'] == -7 )  { echo 'selected'; };  ?>>GMT -7</option>
                    <option value="-6" <?PHP if ( $item['time_zone'] == -6 )  { echo 'selected'; };  ?>>GMT -6</option>
                    <option value="-5" <?PHP if ( $item['time_zone'] == -5 )  { echo 'selected'; };  ?>>GMT -5</option>
                    <option value="-4.5" <?PHP if ( $item['time_zone'] == -4.5 )  { echo 'selected'; };  ?>>GMT -4:30</option>
                    <option value="-4" <?PHP if ( $item['time_zone'] == -4 )  { echo 'selected'; };  ?>>GMT -4</option>
                    <option value="-3.5" <?PHP if ( $item['time_zone'] == -3.5 )  { echo 'selected'; };  ?>>GMT -3:30</option>
                    <option value="-3" <?PHP if ( $item['time_zone'] == -3 )  { echo 'selected'; };  ?>>GMT -3</option>
                    <option value="-2" <?PHP if ( $item['time_zone'] == -2 )  { echo 'selected'; };  ?>>GMT -2</option>
                    <option value="-1" <?PHP if ( $item['time_zone'] == -1 )  { echo 'selected'; };  ?>>GMT -1</option>
                    <option value="0" <?PHP if ( $item['time_zone'] == 0 )  { echo 'selected'; };  ?>>GMT 0</option>
                    <option value="1" <?PHP if ( $item['time_zone'] == 1 )  { echo 'selected'; };  ?>>GMT +1</option>
                    <option value="2" <?PHP if ( $item['time_zone'] == 2 )  { echo 'selected'; };  ?>>GMT +2</option>
                    <option value="3" <?PHP if ( $item['time_zone'] == 3 )  { echo 'selected'; };  ?>>GMT +3</option>
                    <option value="3.5" <?PHP if ( $item['time_zone'] == 3.5 )  { echo 'selected'; };  ?>>GMT +3:30</option>
                    <option value="4"<?PHP if ( $item['time_zone'] == 4 )  { echo 'selected'; };  ?> >GMT +4</option>
                    <option value="4.5"<?PHP if ( $item['time_zone'] == 4.5 )  { echo 'selected'; };  ?> >GMT +4:30</option>
                    <option value="5"<?PHP if ( $item['time_zone'] == 5 )  { echo 'selected'; };  ?> >GMT +5</option>
                    <option value="5.5" <?PHP if ( $item['time_zone'] == 5.5 )  { echo 'selected'; };  ?>>GMT +5:30</option>
                    <option value="5.75" <?PHP if ( $item['time_zone'] == 5.75 )  { echo 'selected'; };  ?>>GMT +5:45</option>
                    <option value="6" <?PHP if ( $item['time_zone'] == 6 )  { echo 'selected'; };  ?>>GMT +6</option>
                    <option value="6.5" <?PHP if ( $item['time_zone'] == 6.5 )  { echo 'selected'; };  ?> >GMT +6:30</option>
                    <option value="7" <?PHP if ( $item['time_zone'] == 7 )  { echo 'selected'; };  ?>>GMT +7</option>
                    <option value="8" <?PHP if ( $item['time_zone'] == 8 )  { echo 'selected'; };  ?>>GMT +8</option>
                    <option value="9" <?PHP if ( $item['time_zone'] == 9 )  { echo 'selected'; };  ?>>GMT +9</option>
                    <option value="9.5" <?PHP if ( $item['time_zone'] == 9.5 )  { echo 'selected'; };  ?>>GMT +9:30</option>
                    <option value="10" <?PHP if ( $item['time_zone'] == 10 )  { echo 'selected'; };  ?>>GMT +10</option>
                    <option value="10.5" <?PHP if ( $item['time_zone'] == 10.5 )  { echo 'selected'; };  ?>>GMT +10:30</option>
                    <option value="11" <?PHP if ( $item['time_zone'] == 11 )  { echo 'selected'; };  ?>>GMT +11</option>
                    <option value="12" <?PHP if ( $item['time_zone'] == 12 )  { echo 'selected'; };  ?>>GMT +12</option>
                    <option value="13" <?PHP if ( $item['time_zone'] == 13 )  { echo 'selected'; };  ?>>GMT +13</option>
                    </select>
                </p>
            </div>
            
            <div class="form2bc">
                <p>	
                    <label for="blurb">blurb</label>
                    <br>
                    <input 
                        id="blurb" 
                        name="blurb" 
                        type="text" 
                        value="<?php echo esc_attr($item['blurb'])?>"
                        >
                </p>
            </div>
            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="adjust_prayer_fajr">adjust_prayer_fajr</label>
                <br>	
                    <input 
                        id  =   "adjust_prayer_fajr" 
                        name=   "adjust_prayer_fajr" 
                        type="text" 
                        value="<?php echo esc_attr($item['adjust_prayer_fajr'])?>"
                        >
                </p>
                <p>	
                    <label for="adjust_prayer_zohr">adjust_prayer_zohr</label>
                    <br>
                    <input 
                        id="adjust_prayer_zohr" 
                        name="adjust_prayer_zohr" 
                        type="text" 
                        value="<?php echo esc_attr($item['adjust_prayer_zohr'])?>"
                        >
                </p>
            </div>
            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="adjust_prayer_asr">adjust_prayer_asr</label>
                <br>	
                    <input 
                        id  =   "adjust_prayer_asr" 
                        name=   "adjust_prayer_asr" 
                        type="text" 
                        value="<?php echo esc_attr($item['adjust_prayer_asr'])?>"
                        >
                </p>
                <p>	
                    <label for="adjust_prayer_maghrib">adjust_prayer_maghrib</label>
                    <br>
                    <input 
                        id="adjust_prayer_maghrib" 
                        name="adjust_prayer_maghrib" 
                        type="text" 
                        value="<?php echo esc_attr($item['adjust_prayer_maghrib'])?>"
                        >
                </p>
            </div>
            <div class="form2bc">
                <p>			
                    <!-- <label for="name"><?php _e('Name:', 'wpbc')?></label> -->
                    <label for="adjust_prayer_isha">adjust_prayer_isha</label>
                <br>	
                    <input 
                        id  =   "adjust_prayer_isha" 
                        name=   "adjust_prayer_isha" 
                        type="text" 
                        value="<?php echo esc_attr($item['adjust_prayer_isha'])?>"
                        >
                </p>
            </div>
        </form>
	</div>
</tbody>
<?php
}

function sc_validate_prayer_settings($item)
{
    $messages = array();
    // if (empty($item['name'])) $messages[] = __('Name is required', 'wpbc');
    // if (empty($item['lastname'])) $messages[] = __('Last Name is required', 'wpbc');
    // if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'wpbc');
    // if(!empty($item['phone']) && !absint(intval($item['phone'])))  $messages[] = __('Phone can not be less than zero');
    // if(!empty($item['phone']) && !preg_match('/[0-9]+/', $item['phone'])) $messages[] = __('Phone must be number');
    if (empty($messages)) return true;
    return implode('<br />', $messages);
}
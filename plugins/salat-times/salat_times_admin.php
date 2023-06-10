<?php

defined( 'ABSPATH' )or die( 'Stop! You can not do this!' );

function salat_times_options_page() {
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Salat Times Settings</h1><a href="#help" class="page-title-action">How to use?</a>
		<hr class="wp-header-end">
		<?php

		if ( isset( $_POST[ "restore_defaults" ] ) == "1" ) {
			delete_option( 'st_options' );
		}

		?>

		<form id="auto_options" method="post" action="options.php">

			<?php

			if (isset($_POST['form_submitted'])) {
				$sanitized_options = array();
				$st_options = $_POST['st_options'];
				foreach($st_options as $key=>$value) {
					$sanitized_options[$key] = sanitize_text_field($value);
				}
				update_option("st_options", $sanitized_options);

				?>
				<div class="notice notice-success is-dismissible">
					<p><?php _e( 'Settings Saved.', 'salat-times' ); ?></p>
				</div>
				<?php
			}

			settings_fields( 'salat-times-settings-group' );

			$st_options = get_option( "st_options" );
			if ( !is_array( $st_options ) ) {
				$st_options = array(
					'lat_long_tz' => '23.7 90.4 6',
					'lat' => '23.7',
					'long' => '90.4',
					'custom_loc' => '0',
					'calc_method' => '1',
					'asr_method' => '0',
					'highlats' => '0',
					'time_format' => '1',
					'time_zone' => '6',
					'daylight' => '0',
					'wgt_title1' => 'Salat Times',
					'location' => 'Dhaka, Bangladesh',
					'show_date' => '1',
					'show_hdate' => '0',
					'hijri_adjust' => '-0',
					'dir' => 'inherit',
					'width' => '100%',
					'halign' => 'center',
					'talign' => 'center',
					'walign' => 'left',
					'scheme' => '#4189dd #ffffff #4472C4 #ffffff #B4C6E7 #D9E2F3 #000000',
					'custom' => 'Salat-Time-Fajr-Sunrise-Zuhr-Asr-Magrib-Isha-Begins-Jamah',
					'lang' => 'en',
					'timetable' => '0' );
			}
			?>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label>Timetable Type</label></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Timetable Types</span></legend>
								<?php
									$ttypes = array(
										'0' => 'Automatic Calculation',
										'1' => 'Manual Input',
									);
									foreach($ttypes as $key=>$value) {
										$checked = $st_options['timetable'] == $key ? ' checked' : '';
										echo '<label for="ttypes'.esc_html($key).'"><input onClick="changeTimetable('.esc_html($key).')" id="ttypes'.esc_html($key).'" type="radio" name="st_options[timetable]" value="'.esc_html($key).'"'.$checked.'>'.esc_html($value).'</label><br/>';
									}
								?>
							</fieldset>
							<p class="description">Automatic option will display Wakto start time only. Manual option will display Wakto start time + Jama'h time.</p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="form-table st_auto" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label>Location</label></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Location</span></legend>
								<?php
									$ltypes = array(
										'0' => 'Select City',
										'1' => 'Custom Location',
									);
									foreach($ltypes as $key=>$value) {
										$checked = $st_options['custom_loc'] == $key ? ' checked' : '';
										echo '<label for="custom_loc'.esc_html($key).'"><input onClick="changeLocation('.esc_html($key).')" id="custom_loc'.esc_html($key).'" type="radio" name="st_options[custom_loc]" value="'.esc_html($key).'"'.$checked.'>'.esc_html($value).'</label><br/>';
									}
								?>
							</fieldset>
							<p class="description">You can select a city from the dropdown list or use Custom Location (if you know your location's latitude, longitude and time zone).</p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="form-table st_select_city" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label>Select City</label></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Select City</span></legend>
								<select name="st_options[lat_long_tz]">
									<option value="24.467 54.367 4" <?php if($st_options[ 'lat_long_tz']=="24.467 54.367 4" ) { echo " selected"; } ?>>Abu Dhabi, UAE</option>
									<option value="9.066667, 7.483333 1" <?php if($st_options[ 'lat_long_tz']=="9.066667, 7.483333 1" ) { echo " selected"; } ?>>Abuja, Nigeria</option>
									<option value="5.55, -0.2 0" <?php if($st_options[ 'lat_long_tz']=="5.55, -0.2 0" ) { echo " selected"; } ?>>Accra, Ghana</option>
									<option value="9.03, 38.74 3" <?php if($st_options[ 'lat_long_tz']=="9.03, 38.74 3" ) { echo " selected"; } ?>>Addis Ababa, Ethiopia</option>
									<option value="36.766667, 3.216667 1" <?php if($st_options[ 'lat_long_tz']=="36.766667, 3.216667 1" ) { echo " selected"; } ?>>Algiers, Algeria</option>
									<option value="31.94972 35.93278 2" <?php if($st_options[ 'lat_long_tz']=="31.94972 35.93278 2" ) { echo " selected"; } ?>>Amman, Jordan</option>
									<option value="52.366667, 4.9 1" <?php if($st_options[ 'lat_long_tz']=="52.366667, 4.9 1" ) { echo " selected"; } ?>>Amsterdam, Netherlands</option>
									<option value="39.933333, 32.866667 2" <?php if($st_options[ 'lat_long_tz']=="39.933333, 32.866667 2" ) { echo " selected"; } ?>>Ankara, Turkey</option>
									<option value="-18.933333, 47.516667 3" <?php if($st_options[ 'lat_long_tz']=="-18.933333, 47.516667 3" ) { echo " selected"; } ?>>Antananarivo, Madagascar</option>
									<option value="-13.833333, -171.75 13" <?php if($st_options[ 'lat_long_tz']=="-13.833333, -171.75 13" ) { echo " selected"; } ?>>Apia, Samoa</option>
									<option value="15.333333, 38.933333 3" <?php if($st_options[ 'lat_long_tz']=="15.333333, 38.933333 3" ) { echo " selected"; } ?>>Asmara, Eritrea</option>
									<option value="39.933 32.867 2" <?php if($st_options[ 'lat_long_tz']=="39.933 32.867 2" ) { echo " selected"; } ?>>Ankara, Turkey</option>
									<option value="-18.933333, 47.516667 3" <?php if($st_options[ 'lat_long_tz']=="-18.933333, 47.516667 3" ) { echo " selected"; } ?>>Antananarivo, Madagascar</option>
									<option value="-13.833333, -171.75 13" <?php if($st_options[ 'lat_long_tz']=="-13.833333, -171.75 13" ) { echo " selected"; } ?>>Apia, Samoa</option>
									<option value="51.166667, 71.433333 6" <?php if($st_options[ 'lat_long_tz']=="51.166667, 71.433333 6" ) { echo " selected"; } ?>>Astana, Kazakhstan</option>
									<option value="37.966667, 23.716667 2" <?php if($st_options[ 'lat_long_tz']=="37.966667, 23.716667 2" ) { echo " selected"; } ?>>Athens, Greece</option>
									<option value="33.333 44.433 3" <?php if($st_options[ 'lat_long_tz']=="33.333 44.433 3" ) { echo " selected"; } ?>>Bagdad, Iraq</option>
									<option value="13.75, 100.466667 7" <?php if($st_options[ 'lat_long_tz']=="13.75, 100.466667 7" ) { echo " selected"; } ?>>Bangkok, Thailand</option>
									<option value="39.913889, 116.391667 8" <?php if($st_options[ 'lat_long_tz']=="39.913889, 116.391667 8" ) { echo " selected"; } ?>>Beijing, China</option>
									<option value="33.9 35.533 2" <?php if($st_options[ 'lat_long_tz']=="33.9 35.533 2" ) { echo " selected"; } ?>>Bairut, Lebanon</option>
									<option value="52.516667, 13.383333 1" <?php if($st_options[ 'lat_long_tz']=="52.516667, 13.383333 1" ) { echo " selected"; } ?>>Berlin, Germany</option>
									<option value="-15.793889, -47.882778 -3" <?php if($st_options[ 'lat_long_tz']=="-15.793889, -47.882778 -3" ) { echo " selected"; } ?>>Brasília, Brazil</option>
									<option value="47.4925, 19.051389 1" <?php if($st_options[ 'lat_long_tz']=="47.4925, 19.051389 1" ) { echo " selected"; } ?>>Budapest, Hungary</option>
									<option value="-34.603333, -58.381667 -3" <?php if($st_options[ 'lat_long_tz']=="-34.603333, -58.381667 -3" ) { echo " selected"; } ?>>Buenos Aires, Argentina</option>
									<option value="30.05 31.233 2" <?php if($st_options[ 'lat_long_tz']=="30.05 31.233 2" ) { echo " selected"; } ?>>Cairo, Egypt</option>
									<option value="-35.3075, 149.124417 10" <?php if($st_options[ 'lat_long_tz']=="-35.3075, 149.124417 10" ) { echo " selected"; } ?>>Canberra, Australia</option>
									<option value="10.5, -66.916667 -4.5" <?php if($st_options[ 'lat_long_tz']=="10.5, -66.916667 -4.5" ) { echo " selected"; } ?>>Caracas, Venezuela</option>
									<option value="14.692778, -17.446667 0" <?php if($st_options[ 'lat_long_tz']=="14.692778, -17.446667 0" ) { echo " selected"; } ?>>Dakar, Senegal</option>
									<option value="33.51306 36.29194 2" <?php if($st_options[ 'lat_long_tz']=="33.51306 36.29194 2" ) { echo " selected"; } ?>>Damascus, Syria</option>
									<option value="23.7 90.4 6" <?php if($st_options[ 'lat_long_tz']=="23.7 90.4 6" ) { echo " selected"; } ?>>Dhaka, Bangladesh</option>
									<option value="25.28667 51.53333 3" <?php if($st_options[ 'lat_long_tz']=="25.28667 51.53333 3" ) { echo " selected"; } ?>>Doha, Qatar</option>
									<option value="53.347778, -6.259722 0" <?php if($st_options[ 'lat_long_tz']=="53.347778, -6.259722 0" ) { echo " selected"; } ?>>Dublin, Ireland</option>
									<option value="21.033333, 105.85 7" <?php if($st_options[ 'lat_long_tz']=="21.033333, 105.85 7" ) { echo " selected"; } ?>>Hanoi, Vietnam</option>
									<option value="-17.863889, 31.029722 2" <?php if($st_options[ 'lat_long_tz']=="-17.863889, 31.029722 2" ) { echo " selected"; } ?>>Harare, Zimbabwe</option>
									<option value="60.170833, 24.9375 2" <?php if($st_options[ 'lat_long_tz']=="60.170833, 24.9375 2" ) { echo " selected"; } ?>>Helsinki, Finland</option>
									<option value="33.7 73.1 5" <?php if($st_options[ 'lat_long_tz']=="33.7 73.1 5" ) { echo " selected"; } ?>>Islamabad, Pakistan</option>
									<option value="-6.2, 106.816667 7" <?php if($st_options[ 'lat_long_tz']=="-6.2, 106.816667 7" ) { echo " selected"; } ?>>Jakarta, Indonesia</option>
									<option value="31.783 35.217 2" <?php if($st_options[ 'lat_long_tz']=="31.783 35.217 2" ) { echo " selected"; } ?>>Jerusalem, Israel</option>
									<option value="31.783 35.217 2" <?php if($st_options[ 'lat_long_tz']=="31.783 35.217 2" ) { echo " selected"; } ?>>Jerusalem, Palestine</option>
									<option value="4.85, 31.6 3" <?php if($st_options[ 'lat_long_tz']=="4.85, 31.6 3" ) { echo " selected"; } ?>>Juba, South Sudan</option>
									<option value="34.533 69.167 4.5" <?php if($st_options[ 'lat_long_tz']=="34.533 69.167 4.5" ) { echo " selected"; } ?>>Kabul, Afghanistan</option>
									<option value="0.313611, 32.581111 3" <?php if($st_options[ 'lat_long_tz']=="0.313611, 32.581111 3" ) { echo " selected"; } ?>>Kampala, Uganda</option>
									<option value="27.7, 85.333333 5.75" <?php if($st_options[ 'lat_long_tz']=="27.7, 85.333333 5.75" ) { echo " selected"; } ?>>Kathmandu, Nepal</option>
									<option value="15.633333, 32.533333 3" <?php if($st_options[ 'lat_long_tz']=="15.633333, 32.533333 3" ) { echo " selected"; } ?>>Khartoum, Sudan</option>
									<option value="50.45, 30.523333 2" <?php if($st_options[ 'lat_long_tz']=="50.45, 30.523333 2" ) { echo " selected"; } ?>>Kiev, Ukraine</option>
									<option value="17.983333, -76.8 -5" <?php if($st_options[ 'lat_long_tz']=="17.983333, -76.8 -5" ) { echo " selected"; } ?>>Kingston, Jamaica</option>
									<option value="3.1475 101.69333 8" <?php if($st_options[ 'lat_long_tz']=="3.1475 101.69333 8" ) { echo " selected"; } ?>>Kuala Lampur, Malaysia</option>
									<option value="29.36972 47.97833 3" <?php if($st_options[ 'lat_long_tz']=="29.36972 47.97833 3" ) { echo " selected"; } ?>>Kuwait City, Kuwait</option>
									<option value="38.713889, -9.139444 0" <?php if($st_options[ 'lat_long_tz']=="38.713889, -9.139444 0" ) { echo " selected"; } ?>>Lisbon, Portugal</option>
									<option value="51.50722 0.1275 0" <?php if($st_options[ 'lat_long_tz']=="51.50722 0.1275 0" ) { echo " selected"; } ?>>London, United Kingdom</option>
									<option value="4.17528 75.50889 5" <?php if($st_options[ 'lat_long_tz']=="4.17528 75.50889 5" ) { echo " selected"; } ?>>Male, Maldives</option>
									<option value="26.217 50.583 3" <?php if($st_options[ 'lat_long_tz']=="26.217 50.583 3" ) { echo " selected"; } ?>>Manama, Bahrain</option>
									<option value="55.75, 37.616667 3" <?php if($st_options[ 'lat_long_tz']=="55.75, 37.616667 3" ) { echo " selected"; } ?>>Moscow, Russia</option>
									<option value="23.60861 58.59194 4" <?php if($st_options[ 'lat_long_tz']=="23.60861 58.59194 4" ) { echo " selected"; } ?>>Muscat, Oman</option>
									<option value="28.61389 77.20889 5.5" <?php if($st_options[ 'lat_long_tz']=="28.61389 77.20889 5.5" ) { echo " selected"; } ?>>New Delhi, India</option>
									<option value="24.633 46.717 3" <?php if($st_options[ 'lat_long_tz']=="24.633 46.717 3" ) { echo " selected"; } ?>>Riyadh, Saudi Arabia</option>
									<option value="1.283 103.833 8" <?php if($st_options[ 'lat_long_tz']=="1.283 103.833 8" ) { echo " selected"; } ?>>Singapore, Singapore</option>
									<option value="32.9 13.186 1" <?php if($st_options[ 'lat_long_tz']=="32.9 13.186 1" ) { echo " selected"; } ?>>Tripoli, Libya</option>
									<option value="38.895 77.037 -5" <?php if($st_options[ 'lat_long_tz']=="38.895 77.037 -5" ) { echo " selected"; } ?>>Washington, United States</option>
								</select> (More city soon...)
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="form-table st_custom_location" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label>Custom Location</label></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Custom Location</span></legend>
								Latitude:<input type="text" maxlength="7" size="5" name="st_options[lat]" value="<?php echo esc_html($st_options['lat']); ?>"/> Longitude:<input type="text" maxlength="7" size="5" name="st_options[long]" value="<?php echo esc_html($st_options['long']); ?>"/> Time Zone:
								<select name="st_options[time_zone]">
									<option value="-12" <?php if($st_options[ 'time_zone']=="-12" ) { echo " selected"; } ?>>GMT -12</option>
									<option value="-11" <?php if($st_options[ 'time_zone']=="-11" ) { echo " selected"; } ?>>GMT -11</option>
									<option value="-10" <?php if($st_options[ 'time_zone']=="-10" ) { echo " selected"; } ?>>GMT -10</option>
									<option value="-9" <?php if($st_options[ 'time_zone']=="-9" ) { echo " selected"; } ?>>GMT -9</option>
									<option value="-8" <?php if($st_options[ 'time_zone']=="-8" ) { echo " selected"; } ?>>GMT -8</option>
									<option value="-7" <?php if($st_options[ 'time_zone']=="-7" ) { echo " selected"; } ?>>GMT -7</option>
									<option value="-6" <?php if($st_options[ 'time_zone']=="-6" ) { echo " selected"; } ?>>GMT -6</option>
									<option value="-5" <?php if($st_options[ 'time_zone']=="-5" ) { echo " selected"; } ?>>GMT -5</option>
									<option value="-4.5" <?php if($st_options[ 'time_zone']=="-4.5" ) { echo " selected"; } ?>>GMT -4:30</option>
									<option value="-4" <?php if($st_options[ 'time_zone']=="-4" ) { echo " selected"; } ?>>GMT -4</option>
									<option value="-3.5" <?php if($st_options[ 'time_zone']=="-3.5" ) { echo " selected"; } ?>>GMT -3:30</option>
									<option value="-3" <?php if($st_options[ 'time_zone']=="-3" ) { echo " selected"; } ?>>GMT -3</option>
									<option value="-2" <?php if($st_options[ 'time_zone']=="-2" ) { echo " selected"; } ?>>GMT -2</option>
									<option value="-1" <?php if($st_options[ 'time_zone']=="-1" ) { echo " selected"; } ?>>GMT -1</option>
									<option value="0" <?php if($st_options[ 'time_zone']=="0" ) { echo " selected"; } ?>>GMT 0</option>
									<option value="1" <?php if($st_options[ 'time_zone']=="1" ) { echo " selected"; } ?>>GMT +1</option>
									<option value="2" <?php if($st_options[ 'time_zone']=="2" ) { echo " selected"; } ?>>GMT +2</option>
									<option value="3" <?php if($st_options[ 'time_zone']=="3" ) { echo " selected"; } ?>>GMT +3</option>
									<option value="3.5" <?php if($st_options[ 'time_zone']=="3.5" ) { echo " selected"; } ?>>GMT +3:30</option>
									<option value="4" <?php if($st_options[ 'time_zone']=="4" ) { echo " selected"; } ?>>GMT +4</option>
									<option value="4.5" <?php if($st_options[ 'time_zone']=="4.5" ) { echo " selected"; } ?>>GMT +4:30</option>
									<option value="5" <?php if($st_options[ 'time_zone']=="5" ) { echo " selected"; } ?>>GMT +5</option>
									<option value="5.5" <?php if($st_options[ 'time_zone']=="5.5" ) { echo " selected"; } ?>>GMT +5:30</option>
									<option value="5.75" <?php if($st_options[ 'time_zone']=="5.75" ) { echo " selected"; } ?>>GMT +5:45</option>
									<option value="6" <?php if($st_options[ 'time_zone']=="6" ) { echo " selected"; } ?>>GMT +6</option>
									<option value="6.5" <?php if($st_options[ 'time_zone']=="6.5" ) { echo " selected"; } ?>>GMT +6:30</option>
									<option value="7" <?php if($st_options[ 'time_zone']=="7" ) { echo " selected"; } ?>>GMT +7</option>
									<option value="8" <?php if($st_options[ 'time_zone']=="8" ) { echo " selected"; } ?>>GMT +8</option>
									<option value="9" <?php if($st_options[ 'time_zone']=="9" ) { echo " selected"; } ?>>GMT +9</option>
									<option value="9.5" <?php if($st_options[ 'time_zone']=="9.5" ) { echo " selected"; } ?>>GMT +9:30</option>
									<option value="10" <?php if($st_options[ 'time_zone']=="10" ) { echo " selected"; } ?>>GMT +10</option>
									<option value="10.5" <?php if($st_options[ 'time_zone']=="10.5" ) { echo " selected"; } ?>>GMT +10:30</option>
									<option value="11" <?php if($st_options[ 'time_zone']=="11" ) { echo " selected"; } ?>>GMT +11</option>
									<option value="12" <?php if($st_options[ 'time_zone']=="12" ) { echo " selected"; } ?>>GMT +12</option>
									<option value="13" <?php if($st_options[ 'time_zone']=="13" ) { echo " selected"; } ?>>GMT +13</option>
								</select>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<h2 class="title st_auto">Calculation Settings</h2>
			<table class="form-table st_auto" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label>Juristic Method</label> (<a href="#help">?</a>)</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Juristic Method</span></legend>
								<select name="st_options[asr_method]" id="jm">
									<option value="0" <?php if($st_options[ 'asr_method']=="0" ) { echo " selected"; } ?>>Standard (Shafii, Maliki, Jafari, Hanbali and Salafi)</option>
									<option value="1" <?php if($st_options[ 'asr_method']=="1" ) { echo " selected"; } ?>>Hanafi</option>
								</select>
							</fieldset>
							<p class="description">(For <span style="color: green;">Asr</span> time.)</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label>Calculation Method</label> (<a href="#help">?</a>)</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Calculation Method</span></legend>
								<select name="st_options[calc_method]" id="cm">
									<option value="0" <?php if($st_options[ 'calc_method']=="0" ) { echo " selected"; } ?>>Shia Ithna Ashari (Jafari)</option>
									<option value="1" <?php if($st_options[ 'calc_method']=="1" ) { echo " selected"; } ?>>University of Islamic Sciences, Karachi</option>
									<option value="2" <?php if($st_options[ 'calc_method']=="2" ) { echo " selected"; } ?>>Islamic Society of North America (ISNA)</option>
									<option value="3" <?php if($st_options[ 'calc_method']=="3" ) { echo " selected"; } ?>>Muslim World League (MWL)</option>
									<option value="4" <?php if($st_options[ 'calc_method']=="4" ) { echo " selected"; } ?>>Umm al-Qura, Makkah</option>
									<option value="5" <?php if($st_options[ 'calc_method']=="5" ) { echo " selected"; } ?>>Egyptian General Authority of Survey</option>
									<option value="7" <?php if($st_options[ 'calc_method']=="7" ) { echo " selected"; } ?>>Institute of Geophysics, University of Tehran</option>
								</select>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label>Higher Latitudes Method</label> (<a href="#help">?</a>)</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Higher Latitudes Method</span></legend>
								<select name="st_options[highlats]" id="highlats">
									<?php
										$highlats = array(
											'0' => 'No Adjustment',
											'1' => 'Middle of Night Method',
											'2' => '1/7th of the Night Method',
											'3' => 'Angle-Based Method (recommended)'
										);
										foreach ($highlats as $key=>$value) {
											$selected = $key == $st_options['highlats'] ? ' selected' : '';
											echo '<option value="'.esc_html($key).'"'.$selected.'>'.esc_html($value).'</option>';
										}
									?>
								</select>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="postbox">
				<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Widget Settings</span></h3>
				<div class="inside">
					<table class="form-table">
						<tr valign="top">
							<td><label for="wgt_title">Widget Title:</label>
							</td>
							<td><input id="wgt_title" type="text" maxlength="99" name="st_options[wgt_title1]" value="<?php echo esc_html($st_options['wgt_title1']); ?>"/> </td>
						</tr>
						<tr valign="top">
							<td><label for="ln">Location Name:</label>
							</td>
							<td><input id="ln" type="text" maxlength="99" name="st_options[location]" value="<?php echo esc_html($st_options['location']); ?>"/> <span style="color: green;">(Will be displayed on widget.)</span>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="tf">Time Format:</label>
							</td>
							<td>
								<select name="st_options[time_format]" id="tf">
									<option value="0" <?php if($st_options[ 'time_format']=="0" ) { echo " selected"; } ?>>24 Hour</option>
									<option value="1" <?php if($st_options[ 'time_format']=="1" ) { echo " selected"; } ?>>12 Hour</option>
									<option value="2" <?php if($st_options[ 'time_format']=="2" ) { echo " selected"; } ?>>12 Hour (No suffix)</option>
									<option value="3" <?php if($st_options[ 'time_format']=="3" ) { echo " selected"; } ?>>Floating point number</option>
								</select> Use "<span style="color: red;">12 Hour (No suffix)</span>" for "<span style="color: red;">Bengali</span>" language.
							</td>
						</tr>
						<tr valign="top">
							<td><label for="daylight">Daylight Saving:</label>
							</td>
							<td>
								<select name="st_options[daylight]" id="daylight">
									<option value="1" <?php if($st_options[ 'daylight']=="1" ) { echo " selected"; } ?>>On</option>
									<option value="0" <?php if($st_options[ 'daylight']=="0" ) { echo " selected"; } ?>>Off</option>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="sd">Show Date:</label>
							</td>
							<td>
								<p><input id="sd" type="checkbox" id="show_date" name="st_options[show_date]" value="1" <?php if($st_options[ 'show_date']==1) echo( 'checked="checked"'); ?>/><label for="sd">Gregorian Date</label>
								</p>
								<p><input id="shd" type="checkbox" id="show_hdate" name="st_options[show_hdate]" value="1" <?php if(isset($st_options[ 'show_hdate']) && $st_options[ 'show_hdate']==1) echo( 'checked="checked"'); ?>/><label for="shd">Hijri Date</label>
								</p>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="hijri_adjust">Adjust Hijri Date (±):</label>
							</td>
							<td><input id="hijri_adjust" type="text" maxlength="3" size="4" name="st_options[hijri_adjust]" value="<?php echo esc_html($st_options['hijri_adjust']); ?>"/> Hours</td>
						</tr>
						<tr valign="top">
							<td><label for="lang">Language:</label>
							</td>
							<td>
								<select name="st_options[lang]" id="lang">
									<option value="en" <?php if($st_options[ 'lang']=="en" ) { echo " selected"; } ?>>English</option>
									<option value="bn" <?php if($st_options[ 'lang']=="bn" ) { echo " selected"; } ?>>Bengali</option>
									<option value="custom" <?php if($st_options[ 'lang']=="custom" ) { echo " selected"; } ?>>Custom (Set below)</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="cl">Custom Language:</label>
							</td>
							<td>
								<p>Change the text: <span style="color: red;">Salat-Time-Fajr-Sunrise-Zuhr-Asr-Magrib-Isha-Begins-Jamah</span>
								</p>
								<p><input size="60" id="cl" type="text" name="st_options[custom]" value="<?php echo esc_html($st_options['custom']); ?>"/>
								</p>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="postbox">
				<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Widget Style</span></h3>
				<div class="inside">
					<table class="form-table">
						<tr valign="top">
							<td><label for="scheme">Color Scheme:</label>
							</td>
							<td>
								<select name="st_options[scheme]" id="scheme">
									<option value="#313232 #ffffff #181818 #ffffff #313232 #585858 #ffffff" <?php if($st_options[ 'scheme']=="#313232 #ffffff #181818 #ffffff #313232 #585858 #ffffff" ) { echo " selected"; } ?>>Black</option>
									<option value="#4189dd #ffffff #4472C4 #ffffff #B4C6E7 #D9E2F3 #000000" <?php if($st_options[ 'scheme']=="#4189dd #ffffff #4472C4 #ffffff #B4C6E7 #D9E2F3 #000000" ) { echo " selected"; } ?>>Blue</option>
									<option value="#4189dd #ffffff #5b9bd5 #ffffff #bdd6ee #deeaf6 #000000" <?php if($st_options[ 'scheme']=="#4189dd #ffffff #5b9bd5 #ffffff #bdd6ee #deeaf6 #000000" ) { echo " selected"; } ?>>Light Blue</option>
									<option value="#778496 #ffffff #65707f #ffffff #dddcdc #f0f0f0 #000000" <?php if($st_options[ 'scheme']=="#778496 #ffffff #65707f #ffffff #dddcdc #f0f0f0 #000000" ) { echo " selected"; } ?>>Gray</option>
									<option value="#48ae03 #ffffff #70ad47 #ffffff #c5e0b3 #e2efd9 #000000" <?php if($st_options[ 'scheme']=="#48ae03 #ffffff #70ad47 #ffffff #c5e0b3 #e2efd9 #000000" ) { echo " selected"; } ?>>Green</option>
									<option value="#ee6204 #ffffff #ed7d31 #ffffff #f7caac #fbe4d5 #000000" <?php if($st_options[ 'scheme']=="#ee6204 #ffffff #ed7d31 #ffffff #f7caac #fbe4d5 #000000" ) { echo " selected"; } ?>>Orange</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="halign">Text Alignment:</label>
							</td>
							<td><label for="halign">Header: </label>
								<select name="st_options[halign]" id="halign">
									<option value="left" <?php if($st_options[ 'halign']=="left" ) { echo " selected"; } ?>>Left</option>
									<option value="center" <?php if($st_options[ 'halign']=="center" ) { echo " selected"; } ?>>Center</option>
									<option value="right" <?php if($st_options[ 'halign']=="right" ) { echo " selected"; } ?>>Right</option>
								</select>
							</td>
							<td><label for="talign">Title: </label>
								<select name="st_options[talign]" id="talign">
									<option value="left" <?php if($st_options[ 'talign']=="left" ) { echo " selected"; } ?>>Left</option>
									<option value="center" <?php if($st_options[ 'talign']=="center" ) { echo " selected"; } ?>>Center</option>
									<option value="right" <?php if($st_options[ 'talign']=="right" ) { echo " selected"; } ?>>Right</option>
								</select>
							</td>
							<td><label for="walign">Wakto/Time: </label>
								<select name="st_options[walign]" id="walign">
									<option value="left" <?php if($st_options[ 'walign']=="left" ) { echo " selected"; } ?>>Left</option>
									<option value="center" <?php if($st_options[ 'walign']=="center" ) { echo " selected"; } ?>>Center</option>
									<option value="right" <?php if($st_options[ 'walign']=="right" ) { echo " selected"; } ?>>Right</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label for="width">Table width:</label>
							</td>
							<td colspan="3"><input id="width" type="text" maxlength="5" name="st_options[width]" value="<?php echo esc_html($st_options['width']); ?>"/> (Example: 90%, 200px etc.)</td>
						</tr>
						<tr valign="top">
							<td><label for="dir">Table/Text direction:</label>
							</td>
							<td colspan="3">
								<select name="st_options[dir]" id="dir">
									<option value="inherit" <?php if($st_options[ 'dir']=="inherit" ) { echo " selected"; } ?>>As is</option>
									<option value="ltr" <?php if($st_options[ 'dir']=="ltr" ) { echo " selected"; } ?>>Left to Right</option>
									<option value="rtl" <?php if($st_options[ 'dir']=="rtl" ) { echo " selected"; } ?>>Right to Left</option>
								</select> (Use <span style="color: red;">Right to Left</span> for Arabic, Hebrew etc.)
							</td>
						</tr>
					</table>
				</div>
			</div>

			<?php submit_button(); ?>
			<input type="hidden" name="form_submitted" value="1">
		</form>

		<form method="post" action="options.php">
			<?php settings_fields( 'salat-times-settings-group' ); ?>

			<input type="hidden" name="restore_defaults" value="1">
			<input type="submit" value="Restore Default Settings" class="button button-secondary">
		</form>

		<br/>

		<div class="postbox st_manual">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Manual Time Data Input Panel</span></h3>
			<div class="inside">
				<?php
				
				$dir = WP_CONTENT_DIR . '/plugin_data/salat-times/';
				$file = $dir . 'manual_time.data';

				if ( !file_exists( $file ) ) {
					mkdir( $dir, 0777, true );
					fopen( $file, 'w' )or die( "ERROR! Can't create data file!" );
				}

				// check if form has been submitted
				if ( isset( $_POST[ 'text' ] ) ) {
					// save the text contents
					$textArr = explode("\n", $_POST['text']);
					$i = -1;
					foreach($textArr as $line) {
						$i++;
						$textArr[$i] = sanitize_text_field($line);
					}
					$text = implode("\n", $textArr);
					file_put_contents( $file, $text );
				}

				// read the textfile
				$text = file_get_contents( $file );

				?>
				<!-- HTML form -->
				<form action="" method="post">
					<textarea placeholder="input text" rows="20" cols="100" name="text" style="width: 100%;"><?php echo esc_html($text) ?></textarea>
					<br/>
					<input type="hidden" value="1" name="time_data_updated"/>
					<input class="button button-primary" type="submit" value="Update Data"/>
					<input class="button button-secondary" type="reset" value="Reset"/>
				</form><br/>
				<p><strong>Instrustions:</strong>
				</p>
				<p>Input like this: <strong>Day--Fajr Begining--Zuhr--Asr-Magrib-Isha--Fajr Jama'h--Zuhr--Asr-Magrib-Isha--Sunrise</strong><br/>Use double hyphen "--" as separetor and one line for one day.</p>
				<p><strong>Example:</strong>
				</p>
				<p>Jan 01--05:13 AM--01:15 PM--03:30 PM--06:10 PM--08:15 PM--05:30 AM--01:30 PM--03:45 PM--06:15 PM--08:30 PM--05:50 AM<br/>Jan 02--05:14 AM--01:15 PM--03:30 PM--06:10 PM--08:15 PM--05:30 AM--01:30 PM--03:45 PM--06:15 PM--08:30 PM--05:50 AM<br/>Jan 03--05:14 AM--01:15 PM--03:30 PM--06:10 PM--08:15 PM--05:30 AM--01:30 PM--03:45 PM--06:15 PM--08:30 PM--05:50 AM</p>

			</div>
		</div>

		<a name="help"></a> <a name="custom_plug"></a>
		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><a name="help"></a>Help</span></h3>
			<div class="inside">
				<p style="text-align: center; padding-top: 10px; padding-bottom: 10px; color: red; font-size: 18px; font-weight: bold; border: 1px solid red;">Do you need any custom feature? Please send a mail to imran2w@gmail.com</p>

				<a name="how"></a>
				<p><strong><u>How To Use</u>:</strong>
				</p>
				<p style="padding-left: 10px;">Go to: Appearance > <a href="<?php admin_url(); ?>widgets.php">Widgets</a> to use this (Daily Salat Times) widget.</p>
				<p style="padding-left: 10px;">Insert this shortcode in post/page: <code><span style="color: #000000"><span style="color: #0000BB">[daily_salat_times]</span></span></code>
				</p>
				<p style="padding-left: 10px;">Or, PHP code: <code><span style="color: #000000"><span style="color: #0000BB">   &#60;&#63;php echo do_shortcode&#40;&#39;[daily_salat_times]&#39;&#41;; </span><span style="color: #0000BB">&#63;&#62;</span></span></code>
				</p>
				<p><strong><u>Juristic Methods</u>:</strong>
				</p>
				<p style="padding-left: 10px;" align="justify">There are two main opinions on how to calculate Asr time. The majority of schools (including Shafi'i, Maliki, Ja'fari, and Hanbali) say it is at the time when the length of any object's shadow equals the length of the object itself plus the length of that object's shadow at noon. The dominant opinion in the Hanafi school says that Asr begins when the length of any object's shadow is twice the length of the object plus the length of that object's shadow at noon.</p>
				<p><strong><u>Calculation Methods</u>:</strong>
				</p>
				<p style="padding-left: 10px;" align="justify">There are different conventions for calculating prayer times. The following table lists several well-known conventions currently in use in various regions:</p>
				<table style="border-collapse:collapse;">
					<tr>
						<th style="border: 1px solid silver; background-color: #CCC;">Method</th>
						<th style="border: 1px solid silver; background-color: #CCC;">Region Used</th>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Muslim World League</td>
						<td style="border: 1px solid silver; padding-left: 5px;">Europe, Far East, parts of US</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Islamic Society of North America</td>
						<td style="border: 1px solid silver; padding-left: 5px;">North America (US and Canada)</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Egyptian General Authority of Survey </td>
						<td style="border: 1px solid silver; padding-left: 5px;"> Africa, Syria, Lebanon, Malaysia</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Umm al-Qura University, Makkah </td>
						<td style="border: 1px solid silver; padding-left: 5px;"> Arabian Peninsula</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">University of Islamic Sciences, Karachi</td>
						<td style="border: 1px solid silver; padding-left: 5px;">Pakistan, Afganistan, Bangladesh, India</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Institute of Geophysics, University of Tehran</td>
						<td style="border: 1px solid silver; padding-left: 5px;">Iran, Some Shia communities</td>
					</tr>
					<tr>
						<td style="border: 1px solid silver; padding-left: 5px;">Shia Ithna Ashari, Leva Research Institute, Qum &nbsp;</td>
						<td style="border: 1px solid silver; padding-left: 5px;">Some Shia communities worldwide</td>
					</tr>
				</table>
				<p><strong><u>Higher Latitudes Methods</u>:</strong></p>
				<p>In locations at higher latitude, twilight may persist throughout the night during some months of the year. In these abnormal periods, the determination of Fajr and Isha is not possible using the usual formulas mentioned in the previous section. To overcome this problem, several solutions have been proposed, three of which are described below. </p>
				<ol>
					<li><strong>Middle of the Night:</strong> In this method, the period from sunset to sunrise is divided into two halves. The first half is considered to be the "night" and the other half as "day break". Fajr and Isha in this method are assumed to be at mid-night during the abnormal periods. </li>
					<li><strong>One-Seventh of the Night:</strong> In this method, the period between sunset and sunrise is divided into seven parts. Isha begins after the first one-seventh part, and Fajr is at the beginning of the seventh part.</li>
					<li><strong>Angle-Based Method:</strong> This is an intermediate solution, used by some recent prayer time calculators. Let α be the twilight angle for Isha, and let t = α/60. The period between sunset and sunrise is divided into t parts. Isha begins after the first part. For example, if the twilight angle for Isha is 15, then Isha begins at the end of the first quarter (15/60) of the night. Time for Fajr is calculated similarly.</li>
				</ol>
				<p>In case Maghrib is not equal to Sunset, we can apply the above rules to Maghrib as well to make sure that Maghrib always falls between Sunset and Isha during the abnormal periods. </p>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Credits</span></h3>
			<div class="inside">
				<table class="form-table">
					<tr valign="top">
						<td>
							<p><a href="https://facebook.com/imran2w" target="_blank"><img src="https://www.gravatar.com/avatar/<?php echo md5( "imran2w@gmail.com" ); ?>" /></a>
							</p>
							<p>Developer: <a href="https://facebook.com/imran2w">M.A. IMRAN</a><br/> E-Mail: imran2w@gmail.com<br/> Web: <a target="_blank" href="https://imran.link">imran.link</a>
							</p><br/>
							<p align="justify">This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or ( at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of ERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the <a href="http://www.gnu.org/licenses/gpl.txt">GNU General Public License</a> for more details.</p><br/>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<script>
			function el(id) {
				return document.getElementById(id);
			}

			function changeTimetable(type) {
				(function($){
					if(type == 0) {
						$('.st_auto').show();
						$('.st_manual').hide();
						changeLocation(<?= $st_options['custom_loc'] ?>);
					} else {
						$('.st_auto').hide();
						$('.st_manual').show();

						$('.st_select_city').hide();
						$('.st_custom_location').hide();
					}
				})(jQuery);
			}

			function changeLocation(type) {
				(function($){
					if(type == 0) {
						$('.st_select_city').show();
						$('.st_custom_location').hide();
					} else {
						$('.st_select_city').hide();
						$('.st_custom_location').show();
					}
				})(jQuery);
			}

			document.addEventListener('DOMContentLoaded', function() { 
				changeTimetable(<?= $st_options['timetable'] ?>);
			}, false);
		</script>

	</div>
	<?php
}

function salat_times_admin() {
	global $salat_times_hook;
	$salat_times_hook = add_options_page( 'Salat Times Settings', 'Salat Times', 'activate_plugins', 'salat_times', 'salat_times_options_page' );
}

function register_salat_times_settings() {
	register_setting( 'salat-times-settings-group', 'st_options' );
	register_setting( 'salat-times-settings-group2', 'tt_options' );
}

add_action( 'admin_menu', 'salat_times_admin' );
add_action( 'admin_init', 'register_salat_times_settings' );

?>
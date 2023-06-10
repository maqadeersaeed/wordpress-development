<?php
function daily_prayer_time_shortcode ($attr) {
	?>
	<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/salah-companion/css/pt-styles.css" rel="stylesheet" />
	<?php
	$st_options = shortcode_atts(array(
		
		// Prayer Time Calculations
		'lat_long_tz' => '23.7 90.4 6',
		'custom_loc' => '0', // if set to 1, lat and long will be read from below rather than lat_long_tz
		'lat' => '23.7',
		'long' => '90.4',
		'calc_method' => '1',
		'asr_method' => '0',
		'highlats' => '0',
		'time_format' => '1',
		'time_zone' => '6',
		'daylight' => '0',

		'show_date' => '1',
		'show_hdate' => '1',
		'hijri_adjust' => '-0',

		'dir' => 'inherit',
		
		'width' => '100%',
		'halign' => 'center',
		'talign' => 'center',
		'walign' => 'left',
		'scheme' => '#4189dd #ffffff #4472C4 #ffffff #B4C6E7 #D9E2F3 #000000',
		'custom' => 'Salat-Time-Fajr-Sunrise-Zuhr-Asr-Magrib-Isha-Begins-Jamah',
		'lang' => 'en',
		// 'timetable' => '0'
	), $attr);

	$d = new uCal;
	$hoffset = esc_html($st_options[ 'hijri_adjust' ]) * 60 * 60;

	$stdate = '';
	$sthdate = '';

	if ( $st_options[ 'show_date' ] == '1' ) {
		$stdate = wp_date( "l, jS F, Y");
	}
	if ( $st_options[ 'show_hdate' ] == '1' ) {
		$sthdate = $d->date( "jS F, Y", current_time('timestamp') + $hoffset );
	}

	$latitude = 23.7;
	$longitude = 90.4;
	$time_zone = 6;
	
	$highLatsMethod = '0';
	if(isset($st_options[ 'highlats' ])) {
		$highLatsMethod = esc_html($st_options['highlats']);
	}

	$prayTime = new PrayTime();
	$prayTime->setCalcMethod( $st_options[ 'calc_method' ] );
	$prayTime->setAsrMethod( $st_options[ 'asr_method' ] );
	$prayTime->setTimeFormat( $st_options[ 'time_format' ] );
	$prayTime->setHighLatsMethod($highLatsMethod);

	$location = explode( " ", esc_html($st_options[ 'lat_long_tz' ]) );

	if ( $st_options[ 'custom_loc' ] == '0' ) {
		$latitude = $location[ 0 ];
		$longitude = $location[ 1 ];
		$time_zone = $location[ 2 ] + esc_html($st_options[ 'daylight' ]);
	} else {
		$latitude = $st_options[ 'lat' ];
		$longitude = $st_options[ 'long' ];
		$time_zone = $st_options[ 'time_zone' ] + esc_html($st_options[ 'daylight' ]);
	}

	$color = explode( " ", $st_options[ 'scheme' ] );

	if ( $st_options[ 'lang' ] == "en" ) {
		$labels = explode( "-", "Salat-Time-Fajr-Sunrise-Zuhr-Asr-Magrib-Isha-Begins-Jamah" );
	} else {
		$labels = explode( "-", esc_html($st_options[ 'custom' ]) );
	}

	$times = $prayTime->getPrayerTimes( time(), $latitude, $longitude, $time_zone );
	$output = '<table style="direction: ' 
					. $st_options[ 'dir' ] 
					. '; width: ' 
					. $st_options[ 'width' ] 
					. '; border-collapse: collapse;">'
				.'<tr>'
					.'<td class="daily_pt_title" colspan=2>'. $stdate . '<br/ >' . $sthdate . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_header">'
					.'<td class="cell">' . $labels[ 0 ] . '</td>'
					.'<td class="cell">' . $labels[ 1 ] . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_odd">'
					.'<td class="cell">' . $labels[ 2 ] . '</td>'
					.'<td class="cell">' . $times[ 0 ]  . '</td></tr>' 
				.'<tr class="daily_pt_row_even">'
					.'<td class="cell">' . $labels[ 3 ] . '</td>'
					.'<td class="cell">' . $times[ 1 ] . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_odd">'
					.'<td class="cell">' . $labels[ 4 ] . '</td>'
					.'<td class="cell">'. $times[ 2 ] . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_even">'
					.'<td class="cell">' . $labels[ 5 ] . '</td>'
					.'<td class="cell">' . $times[ 3 ] . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_odd">'
					.'<td class="cell">' . $labels[ 6 ] . '</td>'
					.'<td class="cell">' . $times[ 5 ] . '</td>'
				.'</tr>'
				.'<tr class="daily_pt_row_even">'
					.'<td class="cell">' . $labels[ 7 ] . '</td>'
					.'<td class="cell">' . $times[ 6 ]  . '</td>'
					.'</tr>'
			.'</table>';
	return $output;
}
add_shortcode('daily_prayer_time_shortcode', 'daily_prayer_time_shortcode');
<?php
function monthly_prayer_time_shortcode ($attr) {
	?>
	<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/salah-companion/css/pt-styles.css" rel="stylesheet" />
	<?php
	$st_options = shortcode_atts(array(
		
		// Prayer Time Calculations
		'lat_long_tz' => '23.7 90.4 6',
		'custom_loc' => '0', // if set to 1, lat and long will be read from below rather than lat_long_tz
		'calc_method' => '1',
		'asr_method' => '0',
		'highlats' => '0',
		'time_format' => '1',
		'daylight' => '0',

		'show_date' => '1',
		'show_hdate' => '1',
		'hijri_adjust' => '-0',
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
	}

	$startDate = strtotime('2023-1-1');
	$endDate = strtotime('2023-1-31');

	$output = '';
	$output = $output . '<table style="width:100%; border-collapse: collapse;border: 1px solid black">';
	$output = $output 
				. '<tr class="monthly_pt_header">'
				. '<td class="cell">Date</td>'
				. '<td class="cell">Fajar</td>'
				. '<td class="cell">Sunrise</td>'
				. '<td class="cell">Zohr</td>'
				. '<td class="cell">Asr</td>'
				. '<td class="cell">Maghreb</td>'
				. '<td class="cell">Isha</td>'
				. '</tr>';
	$even = "true";
	while ($startDate < $endDate)
	{
		$times = $prayTime->getPrayerTimes( time(), $latitude, $longitude, $time_zone );
		// $day = date('d M Y', $startDate);
		$day = date('d/m/Y', $startDate);
		$class = $even ? 'monthly_pt_row_even':'monthly_pt_row_odd';
		$output = $output .'<tr class="monthly_pt_row '. $class .' ">';
		// $output = $output . implode("\t", $times) . "<br>";
		$output = $output 
					. '<td class="cell">' . $day . '</td>'
					. '<td class="cell">' . $times[0] . '</td>'
					. '<td class="cell">' . $times[1] . '</td>'
					. '<td class="cell">' . $times[2] . '</td>'
					. '<td class="cell">' . $times[3] . '</td>'
					. '<td class="cell">' . $times[5] . '</td>'
					. '<td class="cell">' . $times[6] . '</td>';
		
		$output = $output .'</tr>';
		$startDate += 24* 60* 60;  // next day
		$even = !$even;
	}
	$output = $output . '</table>';
	
	return $output;
}
add_shortcode('monthly_prayer_time_shortcode', 'monthly_prayer_time_shortcode');
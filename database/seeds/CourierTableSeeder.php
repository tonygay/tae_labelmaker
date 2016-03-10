<?php

use AmigosLabels\Courier;
use Illuminate\Database\Seeder;

class CourierTableSeeder extends Seeder {

    public function run()
    {
        DB::table('couriers')->delete();
	
		$prefs = [
			'additional_label_field' => null,
			'code1' => 'courier_code',
			'code2' => 'site_code',
			'code3' => 'hub',
			'use_address1' => true,
			'use_address2' => false
		];

        Courier::create(array(
			'name' => 'Trans Amigos Express',
			'code' => 'TAE',
			'label_preferences_json' => $prefs
		));
		
		$prefs['use_address2'] = true;
		
        Courier::create(array(
			'name' => 'KLE',
			'code' => 'KS',
			'label_preferences_json' => $prefs
		));
		
		$prefs['code2'] = 'hub';
		$prefs['code3'] = 'site_code';
		$prefs['use_address2'] = false;
        
		Courier::create(array(
			'name' => 'Mobius',
			'code' => 'MOB',
			'label_preferences_json' => $prefs
		));
		
		$prefs['code2'] = null;
		$prefs['code3'] = null;
		$prefs['additional_label_field'] = 'MALA HUB CODE:&nbsp;&nbsp;&nbsp;:hub';
		
        Courier::create(array(
			'name' => 'MALA',
			'code' => 'MALA',
			'label_preferences_json' => $prefs
		));
    }

}
<?php

namespace AmigosLabels\Http\Requests;

use Excel, Input;
use AmigosLabels\Courier;
use AmigosLabels\User;

class InstitutionListImport extends \Maatwebsite\Excel\Files\ExcelFile {

    public function getFile()
    {
		// Import a user provided file
	    $file = Input::file('institutionFile');

	    // Return it's location
	    return $file->getRealPath();
    }
	
	public function get($courier_id)
	{
		$courier = Courier::find($courier_id);
		
        $existing = [
        	'by_oclc' => [],
			'by_codes' => [],
			'by_name' => []
        ];
		
        foreach ($courier->institutions as $inst) {
			if (!isset($existing['by_oclc'][$inst->oclc])) {
            	$existing['by_oclc'][$inst->oclc] = $inst;
			}
			else {
				$existing['by_oclc'][$inst->oclc] = null;
			}
			
			$code_key = "{$inst->hub}_{$inst->site_code}";
			if (!isset($existing['by_codes'][$code_key])) {
            	$existing['by_codes'][$code_key] = $inst;
			}
			else {
				$existing['by_codes'][$code_key] = null;
			}
			
			if (!isset($existing['by_name'][$inst->name])) {
            	$existing['by_name'][$inst->name] = $inst;
			}
			else {
				$existing['by_name'][$inst->name] = null;
			}
        }
		
		$results = [
			'added' => 0,
			'updated' => 0,
			'skipped' => 0
		];

        Excel::load(Input::file('institutionFile'), function ($reader) use ($courier, $existing, &$results) {

			$done = false; // We only want to do the first sheet so we track it (hack-ishly) like this
		
			$reader->each(function($sheet) use ($courier, $existing, &$results, &$done) {
				
				if ($done) return;
				
				$sheet->each(function($row) use ($courier, $existing, &$results) {
					
					// Bail out if the row doesn't have a state.
					if (!isset($row['state']) || is_null($row['state'])) return;

					$mapping = array(
						'site_code' => ['site', 'site_code'],
						'hub' => ['hub', 'hub_code'],
						'oclc' => ['oclc', 'oclc_symbol'],
						'type' => ['type'],
						'service_length' => ['service'],
						'name' => ['institution', 'institution_name', 'library_name', 'name'],
						'address1' => ['address1', 'address'],
						'address2' => ['address2'],
						'city' => ['city'],
						'state' => ['state'],
						'postal_code' => ['postalcode', 'zip_code'],
						'notes' => ['special_notes', 'notes']
					);
					
					$ints = ['service_length'];

					$properties = array();
					foreach($mapping as $key => $tokens) {
						$properties[$key] = null;

						foreach($tokens as $token) {
							if(isset($row->$token)) {
								if(in_array($key, $ints)) {
									$properties[$key] = intval($row->$token);
								}
								elseif(!empty($row->$token)) {
									$val = trim($row->$token);
									if(!empty($properties[$key])) {
										$properties[$key] .= ', ' . $val;
									}
									else {
										$properties[$key] = $val;
									}
									trim($properties[$key]);
								}
							}
						}
					}
					
					// Now that we have determined the properties, lets see if the
					// institution is already in the DB and upate it if so.
					$code_key = $properties['hub'].'_'.$properties['site_code'];
					
					// First check by OCLC
					if (isset($existing['by_oclc'][$properties['oclc']])
							&& !is_null($existing['by_oclc'][$properties['oclc']])) {
						$existing['by_oclc'][$properties['oclc']]->update($properties);
						$results['updated'] += 1;
					}
					// Then by the hub/site code
					elseif (isset($existing['by_codes'][$code_key])
							&& !is_null($existing['by_codes'][$code_key])) {
						$existing['by_codes'][$code_key]->update($properties);
						$results['updated'] += 1;
					}
					// Then by the institution name
					elseif (isset($existing['by_name'][$properties['name']])
							&& !is_null($existing['by_name'][$properties['name']])) {
						$existing['by_name'][$properties['name']]->update($properties);
						$results['updated'] += 1;
					}
					// If we didn't find it, it MUST be new.
					else {
						$institution = $courier->institutions()->create($properties);
						
						// If new TAE, create a user as well
						if ($courier->code == 'TAE') {
							$username = preg_replace("/[^a-zA-Z0-9]+/", "", $institution->name);
							$password = "TAE2016!$institution->oclc";
							$institution->users()->create([
								'username' => $username,
								'password' => bcrypt($password)
							]);
						}
						
						
						$results['added'] += 1;
					}
				});

				$done = true;
			});
        });
		
		return $results;
	}

    public function getFilters()
    {
        return [
            'chunk'
        ];
    }

}
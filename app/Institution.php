<?php

namespace AmigosLabels;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    //
    protected $fillable = ['name', 'site_code', 'hub', 'oclc', 'type', 'courier_id',
							'service_length', 'address1', 'address2', 
							'city', 'state', 'postal_code', 'notes'];
							
	protected $appends = ['detailed_identifier', 'full_name', 'additional_label_field', 'courier_code', 'prefs'];
							
	public function courier() {
		return $this->belongsTo('AmigosLabels\Courier');
	}
	
	public function users() {
		return $this->hasMany('AmigosLabels\User');
	}
	
	public function getDetailedIdentifierAttribute() {
		return "[" . $this->courier->code . " - " . $this->site_code . "] $this->name, $this->city, $this->state ($this->oclc)";
	}
	
	public function getFullNameAttribute() {
		return "$this->name, $this->city, $this->state ($this->oclc)";
	}
	
	public function getCourierCodeAttribute() {
		return $this->courier->code;
	}
	
	public function getPrefsAttribute() {
		return $this->courier->label_preferences_json;
	}

	public function getAdditionalLabelFieldAttribute() {
		if (isset($this->courier->label_preferences_json->additional_label_field)) {
			return $this->makeReplacements($this->courier->label_preferences_json->additional_label_field);
		}
		
		return '';
	}
	
    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @return string
     */
    protected function makeReplacements($line)
    {
        $replace = $this->fillable;

        foreach ($replace as $key) {
            $line = str_replace(':'.$key, $this->$key, $line);
        }

        return $line;
    }
}

<?php

namespace AmigosLabels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
	use SoftDeletes;
	
	protected $fillable = [ 'name', 'code', 'label_preferences_json' ];
	
	protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function institutions() {
    	return $this->hasMany('AmigosLabels\Institution');
    }
	
	public function getLabelPreferencesJsonAttribute($value) {
		$value = isset($value) ? $value : json_encode($this->defaultLabelPreferences());
		return json_decode($value);
	}
	
	public function setLabelPreferencesJsonAttribute($value) {
		$prefs = $this->defaultLabelPreferences();
		
		// We want spaces persist
		if (isset($value['additional_label_field'])) {
			$value['additional_label_field'] = str_replace(' ', '&nbsp;', $value['additional_label_field']);
		}
		
		foreach ($prefs as $key => $val) {
			$prefs[$key] = isset($value[$key]) ? $value[$key] : $val;
		}

		$this->attributes["label_preferences_json"] = json_encode($prefs);
	}
	
	protected function defaultLabelPreferences() {
		return [
			'additional_label_field' => null,
			'code1' => null,
			'code2' => null,
			'code3' => null,
			'use_address1' => null,
			'use_address2' => null			
		];
	}
}

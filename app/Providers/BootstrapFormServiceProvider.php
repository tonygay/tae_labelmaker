<?php

namespace AmigosLabels\Providers;

use Form, Session;
use Illuminate\Support\ServiceProvider;

class BootstrapFormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		Form::macro('textField', function($name, $label = null, $value = null, $attributes = array())
		{
		    $element = Form::text($name, $value, fieldAttributes($name, $attributes));

		    return fieldWrapper($name, $label, $element);
		});

		Form::macro('passwordField', function($name, $label = null, $attributes = array())
		{
		    $element = Form::password($name, fieldAttributes($name, $attributes));

		    return fieldWrapper($name, $label, $element);
		});

		Form::macro('textareaField', function($name, $label = null, $value = null, $attributes = array())
		{
		    $element = Form::textarea($name, $value, fieldAttributes($name, $attributes));

		    return fieldWrapper($name, $label, $element);
		});

		Form::macro('selectField', function($name, $label = null, $options, $value = null, $attributes = array())
		{
		    $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

		    return fieldWrapper($name, $label, $element);
		});

		Form::macro('selectMultipleField', function($name, $label = null, $options, $value = null, $attributes = array())
		{
		    $attributes = array_merge($attributes, ['multiple' => true]);
		    $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

		    return fieldWrapper($name, $label, $element);
		});

		Form::macro('checkboxField', function($name, $label = null, $value = 1, $checked = null, $attributes = array())
		{
		    $attributes = array_merge(['id' => 'id-field-' . $name], $attributes);

		    $out = '<div class="checkbox';
		    $out .= fieldError($name) . '">';
		    $out .= '<label>';
		    $out .= Form::checkbox($name, $value, $checked, $attributes) . ' ' . $label;
		    $out .= '</div>';

		    return $out;
		});

		function fieldWrapper($name, $label, $element)
		{
		    $out = '<div class="form-group';
		    $out .= fieldError($name) . '">';
		    $out .= fieldLabel($name, $label);
		    $out .= $element;
		    $out .= '</div>';

		    return $out;
		}

		function fieldError($field)
		{
		    $error = '';

		    if ($errors = Session::get('errors'))
		    {
		        $error = $errors->first($field) ? ' has-error' : '';
		    }

		    return $error;
		}

		function fieldLabel($name, $label)
		{
		    if (is_null($label)) return '';

		    $name = str_replace('[]', '', $name);

		    $out = '<label for="id-field-' . $name . '" class="control-label">';
		    $out .= $label . '</label>';

		    return $out;
		}

		function fieldAttributes($name, $attributes = array())
		{
		    $name = str_replace('[]', '', $name);

		    return array_merge(['class' => 'form-control', 'id' => 'id-field-' . $name], $attributes);
		}
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

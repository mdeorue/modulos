<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => ":attribute debe ser aceptado.",
	"active_url"           => ":attribute no es una URL válida.",
	"after"                => ":attribute debe ser posterior a :date.",
	"alpha"                => ":attribute solo debe contener letras.",
	"alpha_dash"           => ":attribute solo puede contener letras, numeros, y guiones.",
	"alpha_num"            => ":attribute solo puede contener letras y números.",
	"array"                => ":attribute debe ser un arreglo.",
	"before"               => ":attribute debe ser anterior a :date.",
	"between"              => array(
		"numeric" => ":attribute debe estar entre :min y :max.",
		"file"    => ":attribute debe pesar entre :min y :max kb.",
		"string"  => ":attribute debe tener entre :min y :max caracteres.",
		"array"   => ":attribute debe tener entre :min y :max registros.",
	),
	"confirmed"            => ":attribute no pudo ser confirmado.",
	"date"                 => ":attribute no es una fecha válida.",
	"date_format"          => ":attribute no cohincide con el formato :format.",
	"different"            => ":attribute y :other deben ser diferentes.",
	"digits"               => ":attribute deben ser :digits digitos.",
	"digits_between"       => ":attribute debe tener entre :min y :max digitos.",
	"email"                => ":attribute debe ser un email válido.",
	"exists"               => ":attribute no es válido.",
	"image"                => ":attribute debe ser una imagen.",
	"in"                   => ":attribute no es válido.",
	"integer"              => ":attribute debe ser un entero.",
	"ip"                   => ":attribute debe ser una IP válida.",
	"max"                  => array(
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "The :attribute field is required.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);

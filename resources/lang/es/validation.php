<?php

return [

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

    'accepted' => 'El :attribute debe ser aceptado.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute debe ser una fecha posterior :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute solo puede contener letras.',
    'alpha_dash' => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute solo puede contener letras y números.',
    'array' => 'El :attribute debe ser una matriz.',
    'before' => 'El :attribute debe ser una fecha antes :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El :attribute must be between :min y :max caracteres.',
        'array' => 'El :attribute debe tener entre :min y :max artículos.',
    ],
    'boolean' => 'El :attribute el campo debe ser verdadero o falso.',
    'confirmed' => 'El :attribute la confirmación no coincide.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'different' => 'El :attribute y :other deben ser diferentes.',
    'digits' => 'El :attribute debe ser :digits digitos.',
    'digits_between' => 'El :attribute debe estar entre :min y :max digitos.',
    'dimensions' => 'El :attribute tiene unas dimesiones de imagen no válidas.',
    'distinct' => 'El :attribute el campo tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'file' => 'El :attribute debe ser un fichero.',
    'filled' => 'El :attribute field debe tener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor de :value.',
        'file' => 'El :attribute debe ser mayor de :value kilobytes.',
        'string' => 'El :attribute debe ser mayor de :value caracteres.',
        'array' => 'El :attribute debe tener más de :value artículos.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser mayor o igual :value.',
        'file' => 'El :attribute debe ser mayor o igual :value kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual :value caracteres.',
        'array' => 'El :attribute debe tener :value artículos o más.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.',
    'in_array' => 'El :attribute el campo no existe en :other.',
    'integer' => 'El :attribute debe ser un entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser un JSON válido.',
    'lt' => [
        'numeric' => 'El :attribute debe ser inferor a :value.',
        'file' => 'El :attribute debe ser inferor a :value kilobytes.',
        'string' => 'El :attribute debe ser inferor a :value caracteres.',
        'array' => 'El :attribute debe tener menos de :value artículos.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser mayor o igual :value.',
        'file' => 'El :attributedebe ser mayor o igual :value kilobytes.',
        'string' => 'El :attributedebe ser mayor o igual :value caracteres.',
        'array' => 'El :attribute no debe tener más de :value artículos.',
    ],
    'max' => [
        'numeric' => 'El :attribute no puede ser mayor que :max.',
        'file' => 'El :attribute no puede ser mayor que :max kilobytes.',
        'string' => 'El :attribute no puede ser mayor que :max caracteres.',
        'array' => 'El :attribute no puedetener más de  :max artículos.',
    ],
    'mimes' => 'El :attributedebe ser un fichero del tipo: :values.',
    'mimetypes' => 'El :attribute ser un fichero del tipo: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file' => 'El :attribute debe ser al menos :min kilobytes.',
        'string' => 'El :attribute debe ser al menos :min caracteres.',
        'array' => 'El :attribute debe tener al menos :min artículos.',
    ],
    'not_in' => 'El :attribute seleccionado no es válido.',
    'not_regex' => 'El :attribute formato no es válido.',
    'numeric' => 'El :attribute debe ser un número.',
    'present' => 'El :attribute el campo debe estar presente.',
    'regex' => 'El :attribute formato no es válido.',
    'required' => 'El :attribute campo es obligatorio.',
    'required_if' => 'El :attribute campo es obligatorio cuando :other es :value.',
    'required_unless' => 'El :attribute campo es necesario si :other está en :values.',
    'required_with' => 'El :attribute campo es necesario si :values está presente.',
    'required_with_all' => 'El :attribute campo es necesario si :values está presente.',
    'required_without' => 'El :attribute campo es necesario si :values no está presente.',
    'required_without_all' => 'El :attribute campo es necesario quando los valors :values no estan presentes.',
    'same' => 'El :attribute y :other deben ser iguales.',
    'size' => [
        'numeric' => 'El :attribute debe ser :size.',
        'file' => 'El :attribute debe ser :size kilobytes.',
        'string' => 'El :attribute debe ser :size caracteres.',
        'array' => 'El :attribute debe contener :size artículos.',
    ],
    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes: :values',
    'string' => 'El :attribute debe ser una cadena de caracteres.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => 'El :attribute ya existe.',
    'uploaded' => 'El :attribute no se pudo cargar.',
    'url' => 'El :attribute formato es válido.',
    'uuid' => 'El :attribute debe ser una UUID válida.',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

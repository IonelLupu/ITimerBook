<?php

return [

    "inputs" => [
        "Input"     => JCWolf\Autoform\InputTypes\Input::class,
        "String"    => JCWolf\Autoform\InputTypes\StringInput::class,
        "Number"    => JCWolf\Autoform\InputTypes\NumberInput::class,
        "Text"      => JCWolf\Autoform\InputTypes\TextInput::class,
        "Select"    => JCWolf\Autoform\InputTypes\SelectInput::class,
        "Boolean"   => JCWolf\Autoform\InputTypes\BooleanInput::class,
        "BelongsTo" => JCWolf\Autoform\InputTypes\BelongsToInput::class,

        "HasMany"    => JCWolf\Autoform\InputTypes\HasManyInput::class,
        "ManyToMany" => JCWolf\Autoform\InputTypes\ManyToManyInput::class,
        "DateTime"   => JCWolf\Autoform\InputTypes\DateTimeInput::class,
        "Image"      => JCWolf\Autoform\InputTypes\ImageInput::class,
    ],

];
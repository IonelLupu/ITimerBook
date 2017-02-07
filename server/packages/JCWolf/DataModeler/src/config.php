<?php

return [

    "types" => [
        'Number'   => JCWolf\DataModeler\Types\NumberType::class,
        'String'   => JCWolf\DataModeler\Types\StringType::class,
        'Boolean'  => JCWolf\DataModeler\Types\BooleanType::class,
        'Text'     => JCWolf\DataModeler\Types\TextType::class,
        'DateTime' => JCWolf\DataModeler\Types\DateTimeType::class,
        'Select'   => JCWolf\DataModeler\Types\SelectType::class,
        'Image'    => JCWolf\DataModeler\Types\ImageType::class,

        'HasOne'    => JCWolf\DataModeler\Types\HasOneType::class,
        'HasMany'    => JCWolf\DataModeler\Types\HasManyType::class,
        'BelongsTo' => JCWolf\DataModeler\Types\BelongsToType::class,
        'ManyToMany' => JCWolf\DataModeler\Types\BelongsToManyType::class,
    ],

    'path' => 'Models'
];
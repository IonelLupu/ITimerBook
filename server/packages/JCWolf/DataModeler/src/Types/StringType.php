<?php

namespace JCWolf\DataModeler\Types;


use Illuminate\Database\Schema\Blueprint;

class StringType extends DataType
{
    protected $type = 'string';

    public function add( Blueprint $table ) {

        $this->columnProperties['length'] = 255;

        return parent::add( $table );
    }
}

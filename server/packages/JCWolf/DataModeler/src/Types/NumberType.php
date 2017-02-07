<?php

namespace JCWolf\DataModeler\Types;


class NumberType extends DataType
{
    protected $type = 'integer';

    /**
     * @return string
     */
    public function getType() {
        if( isset($this->properties['decimal']) )
            return 'float';
        return $this->type;
    }
}

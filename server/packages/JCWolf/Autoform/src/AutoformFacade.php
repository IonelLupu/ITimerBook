<?php

namespace JCWolf\Autoform;

use Illuminate\Support\Facades\Facade as BaseFacade;

class AutoformFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'autoform';
    }
}

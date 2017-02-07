<?php

namespace JCWolf\DataModeler;

class Helpers
{

    /**
     * @return \App\Models\User|null
     */
    public static function LoggedInUserId() {
        if ( \Auth::user() )
            return \Auth::user()->id;

        return NULL;
    }
}
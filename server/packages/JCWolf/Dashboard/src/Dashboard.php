<?php

namespace JCWolf\Dashboard;

use JCWolf\DataModeler\ModelSchema;

class Dashboard{

    public function models() {

        return ModelSchema::all();
    }

}
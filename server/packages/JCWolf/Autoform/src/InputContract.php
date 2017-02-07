<?php

namespace JCWolf\Autoform;


use Illuminate\Http\Request;

interface InputContract
{
    public function render();

    public function view();

    public function save( $value, Request $request );
    public function delete();

}
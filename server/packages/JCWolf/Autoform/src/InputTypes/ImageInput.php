<?php

namespace JCWolf\Autoform\InputTypes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed column
 */
class ImageInput extends Input
{
    protected $template = 'inputs.Image';

    public function view() {
        return "<img src='". asset('storage/'.$this->value) ."' style='width:100%;max-width:200px'>";
    }

    public function save( $value, Request $request ) {

        $file = $request->file( $this->column );

        // save the image on disk
        if ( !is_null( $file ) ) {
            $this->delete();

            $path = $file->storeAs('public', md5(time().$file->getRealPath()).'.'.$file->guessExtension() );

            $this->model[ $this->column ] = basename( $path );
        }

    }

    public function delete() {
        if( empty($this->value) )
            return 1;

        $path = 'public/' . $this->value;
        if ( Storage::exists( $path ) )
            return Storage::delete( $path );
    }
}
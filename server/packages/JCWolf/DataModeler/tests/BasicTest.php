<?php

if ( !class_exists( 'BaseModelForTests' ) )
    include 'BaseModelForTests.php';

use Illuminate\Support\Facades\Schema;
use JCWolf\DataModeler\Modeler;

class BasicTest extends BaseModelForTests
{
    public function tearDown() {

        Modeler::removeModel( 'Car' );
        Modeler::removeModel( 'Post' );
        Modeler::removeModel( 'Category' );
        Modeler::removeModel( 'Tag' );
        Modeler::removeModel( 'User' );
    }

    public function createTestModel( $name ) {
        Modeler::createModel( $name, [
            "title"    => [
                "type" => "String"
            ],
            "author"   => [
                "type"      => "BelongsTo",
                "model"     => "User",
                "visible"   => "false",
                "autoValue" => ">LoggedInUser"
            ],
            "body"     => [
                "type" => "Text"
            ],
            "image"    => [
                "type" => "Image"
            ],
            "category" => [
                "type"  => "BelongsTo",
                "model" => "Category"
            ],
            "status"   => [
                "type"   => "Select",
                "values" => "@getStatuses"
            ],
            "featured" => [
                "type" => "Boolean"
            ],
            "tags"     => [
                "type"  => "ManyToMany",
                "model" => "Tag"
            ]
        ] );
    }

    public function testRemovesModel() {

        Modeler::createModel( 'Car' );
        $this->assertTrue( Schema::hasTable( 'cars' ) );
        $this->assertFileExists( app_path( config( 'modeler.path' ) . '/Car.php' ) );

        Modeler::removeModel( 'Car' );
        $this->assertFalse( Schema::hasTable( 'cars' ) );
        $this->assertFileNotExists( app_path( config( 'modeler.path' ) . '/Car.php' ) );
    }

    /**
     * @expectedException Exception
     */
    public function testThrowsExceptionIfFieldNotFound() {
        Modeler::createModel( 'Car', [
            "name" => [
                "type" => "unknown"
            ]
        ] );

    }

    /*
    |--------------------------------------------------------------------------
    | Modeler Create functionality
    |--------------------------------------------------------------------------
    */

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateThrowsExceptionIfNoModelNameIsProvided() {
        Modeler::createModel();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateThrowsExceptionIfTableExistsInDataBase() {
        Modeler::createModel( 'Car' );
        Modeler::createModel( 'Car' );
    }

    public function testCreatesEmptyModel() {
        Modeler::createModel( 'Car' );

        $this->assertTrue( Schema::hasTable( 'cars' ) );

        $expectedColumns = [
            "id"         => 'integer',
            "name"       => 'string',
            "created_at" => 'datetime',
            "updated_at" => 'datetime',
        ];

        $this->assertModelExists( 'Car', $expectedColumns );
    }

    /*
    |--------------------------------------------------------------------------
    | Modeler Update functionality
    |--------------------------------------------------------------------------
    */

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUpdateThrowsExceptionIfNoModeIsProvided() {
        Modeler::updateModel();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUpdateThrowsExceptionIfTheModelDoesNotExist() {
        Modeler::updateModel( 'Car' );
    }


}

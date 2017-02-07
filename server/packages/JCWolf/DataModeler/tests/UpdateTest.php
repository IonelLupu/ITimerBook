<?php

if ( !class_exists( 'BaseModelForTests' ) )
    include 'BaseModelForTests.php';

use JCWolf\DataModeler\Modeler;
use JCWolf\DataModeler\ModelSchema;

class UpdateTest extends BaseModelForTests
{

    public function tearDown() {

        Modeler::removeModel( 'User' );
        Modeler::removeModel( 'Post' );
        Modeler::removeModel( 'Category' );
        Modeler::removeModel( 'Tag' );
        Modeler::removeModel( 'Car' );
        Modeler::removeModel( 'Make' );

        parent::tearDown();
    }

    public function initTest() {
        Modeler::createModel( 'Make', [
            "name" => [
                "type" => "String"
            ]
        ] );

        Modeler::createModel( 'Car', [
            "name" => [
                "type" => "String"
            ],
        ] );

        Modeler::updateModel( 'Car', [
            "name" => [
                "type"     => "String",
                "optional" => true
            ],
            "make" => [
                "type"  => "BelongsTo",
                "model" => "Make",
            ]
        ] );
    }

    public function testUpdatesTheModelSchema() {

        $this->initTest();

        $expectedSchema = [
            "name" => [
                "type"     => "String",
                "optional" => true
            ],
            "make" => [
                "type"  => "BelongsTo",
                "model" => "Make",
            ]
        ];

        $modelSchema  = ModelSchema::get( 'Car' );
        $actualSchema = $modelSchema->schema;

        $this->assertEquals( $expectedSchema, $actualSchema );
    }

    public function testUpdatesTheModelTable() {

        $this->initTest();

        $expectedColumns = [
            "id"         => 'integer',
            "name"       => 'string',
            "make_id"    => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];

        $this->assertTableEquals( $expectedColumns, 'cars' );
    }

    public function testRenamesColumns() {

        Modeler::createModel( 'Post', [
            "name" => [
                "type" => "String"
            ]
        ] );
        Modeler::renameColumns( 'Post', [
            "name" => "title"
        ] );

        $expectedColumns = [
            "id"         => 'integer',
            "title"      => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];

        $this->assertTableEquals( $expectedColumns, 'posts' );
    }

    public function testSavesTheCorrectData() {

        $this->initTest();

        $carData = [
            "name" => "R8",
        ];

        $car = $this->getModel( 'Car', $carData );

        $make = $this->createModel( 'Make', [
            "name" => "Audi"
        ] );
        $car->make()->associate( $make->id );
        $car->save();

        $car = $this->callModelMethod( 'with', 'Car', 'make' )->first();

//        dd( $car );
        $actualData = $this->removeTimestamps( $car->toArray() );

        $expectedData = [
            "id"      => 1,
            "name"    => "R8",
            "make_id" => 1,
            "make"    => [
                "id"   => 1,
                "name" => "Audi"
            ]
        ];
        $this->assertEquals( $expectedData, $actualData );
    }

}

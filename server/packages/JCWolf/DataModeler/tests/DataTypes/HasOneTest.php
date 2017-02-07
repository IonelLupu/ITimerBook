<?php

if ( !class_exists( 'BaseModelForTests' ) )
    include __DIR__ . "/" . '../BaseModelForTests.php';

use JCWolf\DataModeler\Modeler;

class HasOneTest extends BaseModelForTests
{

    public function tearDown() {

        Modeler::removeModel( 'Phone' );
        Modeler::removeModel( 'User' );

        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_properly_sets_the_columns_for_models() {

        Modeler::createModel( 'Phone', [
            "number" => [
                "type" => "String"
            ]
        ] );

        Modeler::createModel( 'User', [
            "name"  => [
                "type" => "String"
            ],
            "phone" => [
                "type"  => "HasOne",
                "model" => "Phone",
                "label" => "number"
            ]
        ] );

        $expectedPhoneColumns = [
            "id"         => "integer",
            "number"     => "string",
            "user_id"    => "integer",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];
        $expectedUserColumns  = [
            "id"         => "integer",
            "name"       => "string",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];


        $this->assertTableEquals( $expectedPhoneColumns, 'phones', "Phone model" );
        $this->assertTableEquals( $expectedUserColumns, 'users', "User model" );
    }

    /**
     * @test
     */
    public function it_properly_sets_the_columns_for_models_via_update() {

        Modeler::createModel( 'Phone', [
            "number" => [
                "type" => "String"
            ]
        ] );

        Modeler::createModel( 'User', [
            "name" => [
                "type" => "String"
            ]
        ] );

        Modeler::updateModel( 'User', [
            "phone" => [
                "type"  => "HasOne",
                "model" => "Phone",
                "label" => "number"
            ]
        ] );


        $expectedPhoneColumns = [
            "id"         => "integer",
            "number"     => "string",
            "user_id"    => "integer",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];
        $expectedUserColumns  = [
            "id"         => "integer",
            "name"       => "string",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];

        $this->assertTableEquals( $expectedPhoneColumns, 'phones', "Phone model" );
        $this->assertTableEquals( $expectedUserColumns, 'users', "User model" );
    }

    /**
     * @test
     */
    public function if_saves_the_correct_data() {

        Modeler::createModel( 'Phone', [
            "number" => [
                "type" => "String"
            ]
        ] );

        Modeler::createModel( 'User', [
            "name"  => [
                "type" => "String"
            ],
            "phone" => [
                "type"  => "HasOne",
                "model" => "Phone",
                "label" => "number"
            ]
        ] );

        $user = $this->createModel( 'User', [
            "name" => "Joe",
        ] );


        $phone = $this->getModel( 'Phone', [
            "number" => 1234,
        ] );

        $user->phone()->save( $phone );

        $user = $this->callModelMethod( 'with', 'User', [ 'phone' ] )
            ->first();

        $phone = $this->callModelMethod( 'with', 'Phone', [ 'user' ] )
            ->first();

        $expectedUserData = [
            "id"    => $user->id,
            "name"  => $user->name,
            "phone" => [
                'id'      => $phone->id,
                'user_id' => $user->id,
                'number'  => $phone->number
            ],
        ];

        $actualUserData = $this->removeTimestamps( $user->toArray() );

        $this->assertEquals( $expectedUserData, $actualUserData );

        $expectedPhoneData = [
            "id"      => $phone->id,
            'user_id' => $user->id,
            'number'  => $phone->number,
            "user"    => [
                'id'   => $phone->id,
                "name" => $user->name,
            ],
        ];

        $actualPhoneData = $this->removeTimestamps( $phone->toArray() );

        $this->assertEquals( $expectedPhoneData, $actualPhoneData );
    }

}

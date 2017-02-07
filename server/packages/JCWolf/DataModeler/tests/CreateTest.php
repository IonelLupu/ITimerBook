<?php

if ( !class_exists( 'BaseModelForTests' ) )
    include 'BaseModelForTests.php';

use JCWolf\DataModeler\Helpers;
use JCWolf\DataModeler\Modeler;

class CreateTest extends BaseModelForTests
{

    public function tearDown() {

        Modeler::removeModel( 'Post' );
        Modeler::removeModel( 'Category' );
        Modeler::removeModel( 'Tag' );
        Modeler::removeModel( 'Car' );
        Modeler::removeModel( 'User' );

        parent::tearDown();
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
                "autoValue" => ">LoggedInUserId"
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


    public function testCreatesSimpleModel() {

        Modeler::createModel( 'Car', [
            "name" => [
                "type" => "String"
            ]
        ] );

        $expectedColumns = [
            "id"         => 'integer',
            "name"       => 'string',
            "created_at" => 'datetime',
            "updated_at" => 'datetime',
        ];

        $this->assertModelExists( 'Car', $expectedColumns );
    }

    public function testCreatesBiggerModel() {

        $this->createTestModel( 'Post' );

        $expectedPostColumns = [
            "id"          => 'integer',
            "title"       => 'string',
            "author_id"   => 'integer',
            "body"        => 'text',
            "image"       => 'string',
            "category_id" => 'integer',
            "status"      => 'string',
            "featured"    => 'boolean',
            "created_at"  => 'datetime',
            "updated_at"  => 'datetime',
        ];

        $this->assertModelExists( 'Post', $expectedPostColumns );

        $expectedTagColumns = [
            "id"         => 'integer',
            "name"       => 'string',
            "created_at" => 'datetime',
            "updated_at" => 'datetime',
        ];
        $this->assertModelExists( 'Tag', $expectedTagColumns );

        $expectedPivotColumns = [
            "post_id" => 'integer',
            "tag_id"  => 'integer',
        ];

        $this->assertTableEquals( $expectedPivotColumns, 'post_tag' );
    }

    public function testSavesInDatabase() {
        Modeler::createModel( 'Car', [
            "mark"  => [
                "type" => "String"
            ],
            "model" => [
                "type" => "String"
            ],
            "price" => [
                "type"    => "Number",
                "decimal" => true
            ],
            "year"  => [
                "type" => "Number",
            ],
        ] );

        $expectedColumns = [
            "id"         => 'integer',
            "mark"       => "string",
            "model"      => "string",
            "price"      => "float",
            "year"       => "integer",
            "created_at" => 'datetime',
            "updated_at" => 'datetime',
        ];

        $this->assertTableEquals( $expectedColumns, 'cars' );

        $data = [
            "mark"  => "Audi",
            "model" => "R8",
            "price" => 50000,
            "year"  => 2016,
        ];

        $model = $this->getModel( 'Car', $data );
        $model->save();

        $this->seeInDatabase( 'cars', $data );
    }


    public function testHasRelationships() {

        $this->createTestModel( 'Post' );

        $postData = [
            "title"    => 'Post title',
            "body"     => 'Post body',
            "image"    => '/path/to/image',
            "status"   => 'Published',
            "featured" => true,
        ];

        $userData     = [
            "name" => "TestUser"
        ];
        $categoryData = [
            "name" => "Comedy"
        ];

        $tagsData = [
            [
                "name" => "Comedy"
            ],
            [
                "name" => "Science"
            ],
            [
                "name" => "Life"
            ],
        ];

        $post = $this->getModel( 'Post', $postData );

        $author = $this->createModel( 'User', $userData );

        Auth::loginUsingId( $author->id );

        $category = $this->createModel( 'Category', $categoryData );
        $post->category()->associate( $category );

        $post->save();

        foreach ( $tagsData as $tag ) {
            $tag = $this->createModel( 'Tag', $tag );
            $post->tags()->attach( $tag->id );
        }

        $post = $this->callModelMethod( 'with', 'Post', [ 'tags', 'author', 'category' ] )
            ->whereId( $post->id )
            ->first();

        $actualImplicitData = $post->toArray();
        $actualExplicitData = [
            $post->author->toArray(),
            $post->category->toArray(),
            $post->tags->toArray()
        ];

        $expectedImplicitData = [
            "author"      => [
                'id'   => $author->id,
                'name' => $author->name
            ],
            "category"    => [
                'id'   => 1,
                'name' => 'Comedy',
            ],
            "tags"        => [
                [
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '1'
                    ],
                    'id'    => 1,
                    'name'  => 'Comedy'
                ],
                [
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '2',
                    ],
                    'id'    => 2,
                    'name'  => 'Science'
                ],
                [
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '3',
                    ],
                    'id'    => 3,
                    'name'  => 'Life'
                ]
            ],
            "title"       => 'Post title',
            "body"        => 'Post body',
            "image"       => '/path/to/image',
            "status"      => 'Published',
            "featured"    => '1',
            'id'          => 1,
            'author_id'   => 1,
            'category_id' => 1,
        ];

        $expectedExplicitData = [
            [
                'id'   => 1,
                'name' => 'TestUser'
            ],
            [
                'id'   => 1,
                'name' => 'Comedy',
            ],
            [
                [
                    'id'    => 1,
                    'name'  => 'Comedy',
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '1'
                    ],
                ],
                [
                    'id'    => 2,
                    'name'  => 'Science',
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '2',
                    ],
                ],
                [
                    'id'    => 3,
                    'name'  => 'Life',
                    'pivot' => [
                        'post_id' => '1',
                        'tag_id'  => '3',
                    ],
                ]
            ]
        ];

        $actualImplicitData = $this->removeTimestamps( $actualImplicitData );
        $actualExplicitData = $this->removeTimestamps( $actualExplicitData );

        $this->assertEquals( $expectedImplicitData, $actualImplicitData );
        $this->assertEquals( $expectedExplicitData, $actualExplicitData );

    }

    public function testValidatesModel() {

        Modeler::createModel( 'User', [
            "name"     => [
                "type" => "String"
            ],
            "email"    => [
                "type" => "String"
            ],
            "password" => [
                "type" => "String"
            ],
        ] );

        Modeler::createModel( 'Post', [
            "title"    => [
                "type" => "String"
            ],
            "author"   => [
                "type"      => "BelongsTo",
                "model"     => "User",
                "visible"   => "false",
                "autoValue" => '>LoggedInUserId'
            ],
            "body"     => [
                "type"       => "Text",
                "validation" => "min:10"
            ],
            "image"    => [
                "type"     => "Image",
                "optional" => true
            ],
            "category" => [
                "type"  => "BelongsTo",
                "model" => "Category"
            ],
            "status"   => [
                "type"    => "Select",
                "values"  => "@getStatuses",
                "default" => "Draft"
            ],
            "featured" => [
                "type"    => "Boolean",
                "default" => true
            ],
            "tags"     => [
                "type"  => "ManyToMany",
                "model" => "Tag"
            ]
        ] );

        $postData = [
            "title" => 'Post title',
            "body"  => 'The post body',
        ];

        $categoryData = [
            "name" => "Comedy"
        ];

        $userData = [
            "name"     => "TestUser",
            "email"    => "test.email@localhost.dev",
            "password" => 'password',
        ];

        $post = $this->getModel( 'Post', $postData );

        $author = App\User::create($userData);
        Auth::login( $author );

        $category = $this->createModel( 'Category', $categoryData );
        $post->category()->associate( $category );

        $post->save();

        $expectedData = [
            "id"          => 1,
            "title"       => 'Post title',
            "body"        => 'The post body',
            "category_id" => 1,
            'author_id'   => Helpers::LoggedInUserId(),
            'image'       => NULL,
            'status'      => 'Draft',
            'featured'    => 1,
            "category"    => [
                "id"   => 1,
                "name" => "Comedy"
            ],
            "author"      => [
                "id"   => Helpers::LoggedInUserId(),
                "name" => "TestUser",
                "email"    => "test.email@localhost.dev",
                "password" => 'password',
            ],
        ];

        $post = $this->callModelMethod( 'with', 'Post', [ 'author', 'category' ] )->first();

        $actualData = $post->toArray();
        $actualData = $this->removeTimestamps( $actualData );

        $this->assertEquals( $expectedData, $actualData );
    }

}

<?php

if ( !class_exists( 'BaseModelForTests' ) )
    include __DIR__ . "/" . '../BaseModelForTests.php';

use JCWolf\DataModeler\Modeler;

class HasManyTest extends BaseModelForTests
{

    public function tearDown() {

        Modeler::removeModel( 'Comment' );
        Modeler::removeModel( 'Post' );

        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_properly_sets_the_columns_for_models() {

        Modeler::createModel( 'Comment', [
            "body" => [
                "type" => "Text"
            ]
        ] );

        Modeler::createModel( 'Post', [
            "title"    => [
                "type" => "String"
            ],
            "body"     => [
                "type" => "Text"
            ],
            "comments" => [
                "type"  => "HasMany",
                "model" => "Comment"
            ]
        ] );

        $expectedCommentColumns = [
            "id"         => "integer",
            "body"       => "text",
            "post_id"    => "integer",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];

        $expectedPostColumns = [
            "id"         => "integer",
            "title"      => "string",
            "body"       => "text",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];

        $this->assertTableEquals( $expectedCommentColumns, 'comments', "Comment model" );
        $this->assertTableEquals( $expectedPostColumns, 'posts', "Post model" );
    }

    /**
     * @test
     */
    public function it_properly_sets_the_columns_for_models_via_update() {

        Modeler::createModel( 'Comment', [
            "body" => [
                "type" => "Text"
            ]
        ] );

        Modeler::createModel( 'Post', [
            "title" => [
                "type" => "String"
            ],
            "body"  => [
                "type" => "Text"
            ]
        ] );

        Modeler::updateModel( 'Post', [
            "comments" => [
                "type"  => "HasMany",
                "model" => "Comment"
            ]
        ] );

        $expectedCommentColumns = [
            "id"         => "integer",
            "body"       => "text",
            "post_id"    => "integer",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];

        $expectedPostColumns = [
            "id"         => "integer",
            "title"      => "string",
            "body"       => "text",
            "created_at" => "datetime",
            "updated_at" => "datetime"
        ];

        $this->assertTableEquals( $expectedCommentColumns, 'comments', "Comment model" );
        $this->assertTableEquals( $expectedPostColumns, 'posts', "Post model" );
    }

    /**
     * @test
     */
    public function if_saves_the_correct_data() {

        Modeler::createModel( 'Comment', [
            "body" => [
                "type" => "String"
            ]
        ] );

        Modeler::createModel( 'Post', [
            "title"    => [
                "type" => "String"
            ],
            "comments" => [
                "type"  => "HasMany",
                "model" => "Comment",
                "label" => "body"
            ]
        ] );

        $post = $this->createModel( 'Post', [
            "title" => "Post Title",
        ] );


        $comment = $this->getModel( 'Comment', [
            "body" => "Comment body",
        ] );

        $post->comments()->save( $comment );

        $post = $this->callModelMethod( 'with', 'Post', [ 'comments' ] )
            ->first();

        $comment = $this->callModelMethod( 'with', 'Comment', [ 'post' ] )
            ->first();

        $expectedPostData = [
            "id"       => $post->id,
            "title"    => $post->title,
            "comments" => [
                [
                    'id'      => $comment->id,
                    'post_id' => $post->id,
                    'body'    => $comment->body
                ]
            ],
        ];

        $actualPostData = $this->removeTimestamps( $post->toArray() );

        $this->assertEquals( $expectedPostData, $actualPostData );

        $expectedCommentData = [
            "id"      => $comment->id,
            'post_id' => $post->id,
            'body'    => $comment->body,
            "post"    => [
                'id'    => $comment->id,
                "title" => $post->title,
            ],
        ];

        $actualCommentData = $this->removeTimestamps( $comment->toArray() );

        $this->assertEquals( $expectedCommentData, $actualCommentData );
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use JCWolf\DataModeler\Modeler;

abstract class BaseModelForTests extends TestCase
{
    private $connection;
    public function createApplication()
    {

        putenv('DB_CONNECTION=mysqlTest');
        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setup() {

        parent::setUp();

        Config::set( 'modeler.path', 'ModelsTests' );
//        $this->app = $this->createApplication();

        $this->connection = Schema::connection( 'mysqlTest' )->getConnection();

    }

    public function getModelNamespace( $name ) {
        return 'App\\' . config( 'modeler.path' ) . '\\' . $name;
    }

    /**
     * @param $name
     * @param $properties
     *
     * @return \JCWolf\DataModeler\Model
     */
    public function getModel( $name, $properties ) {
        $class = $this->getModelNamespace( $name );

        return new $class( $properties );
    }

    /**
     * @param $method
     * @param $name
     * @param $properties
     *
     * @return \JCWolf\DataModeler\Model
     */
    public function callModelMethod( $method, $name, $properties ) {
        $class = $this->getModelNamespace( $name );

        return call_user_func( $class . '::' . $method, $properties );
    }

    /**
     * @param $name
     * @param $properties
     *
     * @return \JCWolf\DataModeler\Model
     */
    public function createModel( $name, $properties ) {
        return $this->callModelMethod( 'create', $name, $properties );
    }

    /**
     * @param $table
     *
     * @return array
     */
    public function getTableColumns( $table ) {
        return Schema::getColumnListing( $table );
    }

    public function getTableColumnsTypes( $table ) {
        $expectedColumns = $this->getTableColumns( $table );
        $columnTypes     = collect();

        foreach ( $expectedColumns as $column ) {
            $col = $this->connection->getDoctrineColumn( $table, $column );
            $columnTypes->push( $col->getType()->getName() );
        }

        return $columnTypes->toArray();
    }

    public function assertTableEquals( $expected, $table , $message = '') {

        $columns      = $this->getTableColumns( $table );
        $columnsTypes = $this->getTableColumnsTypes( $table );
        $actual       = array_combine( $columns, $columnsTypes );
        $this->assertEquals( $expected, $actual, $message );
    }

    public function assertModelExists( $model, $expectedColumns ) {

        $model = new Modeler( $model );
        $this->assertTableEquals( $expectedColumns, $model->getTable() );
        $this->assertFileExists( app_path( config( 'modeler.path' ) . "/{$model->getName()}.php" ) );
    }

    protected function removeTimestamps( $data ) {

        foreach ( $data as $colName => &$colValue ) {
            if ( is_array( $colValue ) ){
                $colValue = $this->removeTimestamps( $colValue );
                continue;
            }
            if ( in_array( $colName, [ 'created_at', 'updated_at' ] ) )
                unset( $data[ $colName ] );
        }

        return $data;
    }

}

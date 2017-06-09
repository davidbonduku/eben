<?php

namespace Core;
/**
 * Class EbenORM
 * @package Core
 */
abstract class EbenORM
{
    /**
     * @var null|\PDO
     */
    private static $_db;
    /**
     * @var
     */
    protected $_table;

    /**
     * constructor
     */
    public function __construct ()
    {
        $this->_table = $this;
        self::$_db = DB::getInstance();
    }


    /**
     * @return string
     */
    public function __toString ()
    {
        return strtolower(get_class( $this ));
    }

    /**
     * Retrieve data
     * @param $params
     * @return mixed
     */
    public function find ( $params )
    {
        $query = 'SELECT * FROM '.$this;
        $where = ' WHERE ';
        $req = null;
        $sth = null;

        if( !is_array( $params ) )
        {
            $query = $query.$where.' id ='.$params;
            $req = self::$_db->query( $query );
            $sth = $req;

        }else{

           foreach( $params as $key => $value )
            {
                $where .= $key.' = :'.$key.' AND ';
            }

            $where = substr( $where, 0, -5 );
            $query = $query.$where;

            $sth = self::$_db->prepare( $query );
            $sth->execute( $params );
        }

        return @$sth->fetchAll( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, strtolower( $this ) );
    }

    /**
     * Retrieve all data
     * @param $limit
     * @return mixed
     */
    public function all ( $limit = 10 )
    {
        if( is_null( $limit ) )
        {
            $limit = 10;
        }
        $query = 'SELECT * FROM '.$this.' LIMIT 0,'.$limit;
        $req = self::$_db->query( $query );

        return @$req->fetchAll( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, strtolower( $this ) );
    }

    /**
     * Save data
     * @return mixed
     */
    public function save ()
    {
        if( is_null( @$this->props['id'] ) )
        {
            return $this->_insert();
        }else{
             $this->_update();
        }
    }

    /**
     * Insert data
     */
    private function _insert ()
    {
        $query = 'INSERT INTO '.$this.' SET ';

        foreach ( $this->props as $key => $value )
        {
            $query .= $key.' = :'.$key.', ';
        }

        $query = substr( $query, 0, -2 );

        $sth = self::$_db->prepare( $query );
        $sth->execute( $this->props );

        return self::$_db->lastInsertId();
    }

    /**
     * Update data
     */
    private function _update ()
    {
        $query = 'UPDATE '.$this.' SET ';

        foreach ( $this->props as $key => $value )
        {
            if( $key != 'id' )
            {
                $query .= $key.' = :'.$key.', ';
            }
        }
        $query = substr( $query, 0, -2 );
        $query.=' WHERE id = :id';

        $sth = self::$_db->prepare( $query );
        $sth->execute( $this->props );
    }

    /**
     * Delete data
     * @return mixed
     */
    public function delete ()
    {
        $query = 'DELETE FROM '.$this.' WHERE id = :id';

        $sth = self::$_db->prepare( $query );
        $sth->execute( $this->props );
    }

    /**
     * Query
     * @param $sql
     * @return \PDOStatement
     */
    public static function query ( $sql )
    {
        return self::$_db->query( $sql );
    }

    /**
     * @return null|\PDO
     */
    public static function pdo ()
    {
        return self::$_db;
    }

    /**
     *
     * @param $password
     * @return string
     */
    public function encrypt( $password )
    {
        return sha1(__EBEN_SECRET__SALT__.sha1(__EBEN_SECRET__SALT__.sha1($password)));
    }

}

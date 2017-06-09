<?php

namespace Core;
/**
 * Interface ORMInterface
 * @package Core
 */
interface ORMInterface
{
    /**
     * Retrieve data
     * @param $params
     * @return mixed
     */
    public static function find( $params );

    /**
     * Retrieve all data
     * @param null $params
     * @return mixed
     */
    public static function all( $params = null );

    /**
     * Save data
     * @return mixed
     */
    public static function save();

    /**
     * Delete data
     * @return mixed
     */
    public static function delete();

    /**
     * Query
     * @param $params
     * @return mixed
     */
    public static function query( $params );
}
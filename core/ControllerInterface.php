<?php

namespace Core;
/**
 * Interface ControllerInterface
 * @package Core
 */
Interface ControllerInterface
{
    /**
     * Retrieve resource
     * @param $id int the id of resource
     * @return void
     */

    public function readAction( $id = null );

    /**
     * Create resource
     * @return void
     */

    public function createAction();

    /**
     * Update resource
     * @param $id int the id of resource
     * @return void
     */

    public function updateAction( $id );

    /**
     * Delete resource
     * @param $id int the id of resource
     * @return void
     */

    public function deleteAction( $id );
}
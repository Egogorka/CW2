<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 15:20
 */

namespace eduslim\interfaces\domain\sessions;

// TODO MapStateInterface

interface MapStateInterface
{
    public function convertToJSON():string;
}
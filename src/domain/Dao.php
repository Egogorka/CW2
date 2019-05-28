<?php


namespace eduslim\domain;

use Atlas\Pdo\Connection;
use Psr\Log\LoggerInterface;

/*
 * Dao object should
 *      find and output object if one parameter or more (such is name, id, etc) is known
 *      find indirect parameters of an object by an object
 */

class Dao
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var Connection */
    protected $connection;

    public function __construct(LoggerInterface $logger, Connection $connection)
    {
        $this->logger = $logger;
        $this->connection = $connection;
    }
}
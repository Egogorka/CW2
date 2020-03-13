<?php


namespace eduslim\domain\action;


use eduslim\interfaces\domain\action\ActionInterface;
use Psr\Log\LoggerInterface;

class ActionManager
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var ActionDao */
    protected $actionDao;

    public function __construct(LoggerInterface $logger, ActionDao $actionDao)
    {
        $this->logger = $logger;
        $this->actionDao = $actionDao;
    }

    public function findById(int $id):?ActionInterface
    {
        return $this->actionDao->findById($id);
    }

    public function findByName(string $name):?ActionInterface
    {
        return $this->actionDao->findByName($name);
    }

    public function findAll():?array
    {
        return $this->actionDao->findAll();
    }

    public function save(ActionInterface $action){
        return $this->actionDao->save($action);
    }
}
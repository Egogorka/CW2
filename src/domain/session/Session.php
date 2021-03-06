<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 14:49
 */

namespace eduslim\domain\session;


use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\maps\MapInterface;
use eduslim\interfaces\domain\mapstate\MapStateInterface;
use eduslim\interfaces\domain\sessions\SessionInterface;

class Session implements SessionInterface
{

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string json */
    protected $options;

    // Map
        /** @var int */
        protected $mapId;

        /** @var MapInterface */
        protected $map;

    // Action
        /** @var int */
        protected $actionId;

        /** @var ActionInterface */
        protected $action;

    // MapState
        /** @var string json */
        protected $mapStateR;

        /** @var MapStateInterface */
        protected $mapState;

    ///////////////////////////////////////////////////
    // Id

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

    ///////////////////////////////////////////////////
    // Name

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(?string $name): void
        {
            $this->name = $name;
        }

    ///////////////////////////////////////////////////
    // Map

        public function getMapId(): ?int
        {
            return $this->mapId;
        }

        public function setMapId(?int $mapId): void
        {
            $this->mapId = $mapId;
        }

        public function getMap(): ?MapInterface
        {
            return $this->map;
        }

        public function setMap(MapInterface $map): void
        {
            $this->map = $map;
        }

    ///////////////////////////////////////////////////
    // Actions

        public function getActionId(): ?int
        {
            return $this->actionId;
        }

        public function setActionId(int $actionId): void
        {
            $this->actionId = $actionId;
        }

        public function getAction():? ActionInterface
        {
            return $this->action;
        }

        public function setAction(ActionInterface $action): void
        {
            $this->action = $action;
        }

    ///////////////////////////////////////////////////
    // Options

        public function getOptions(): ?string
        {
            return $this->options;
        }

        public function setOptions(string $options): void
        {
            $this->options = $options;
        }

    ///////////////////////////////////////////////////
    // MapState

        public function getMapStateR(): ?string
        {
            return $this->mapStateR;
        }

        public function setMapStateR(string $mapStateR): void
        {
            $this->mapStateR = $mapStateR;
        }

        public function getMapState():?MapStateInterface
        {
            return $this->mapState;
        }

        public function setMapState(MapStateInterface $mapState): void
        {
            $this->mapState = $mapState;
        }
}
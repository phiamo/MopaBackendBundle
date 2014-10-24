<?php
namespace Mopa\Bundle\BackendBundle\Entity;

use Doctrine\ORM\EntityManager;
use Gedmo\SoftDeleteable\SoftDeleteableListener;

class HardDeleter {
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected static $listeners = [];

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @param $object
     */
    public function purge($object) {
        $this->disableSoftdeleteListener();
        $this->entityManager->remove($object);
        $this->entityManager->flush();
        $this->enableSoftdeleteListener();
    }


    /**
     * disable the listener
     */
    protected function disableSoftdeleteListener(){
        foreach ($this->entityManager->getEventManager()->getListeners() as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof SoftDeleteableListener) {
                    self::$listeners[$eventName] = $listener;
                    $this->entityManager->getEventManager()->removeEventListener($eventName, $listener);
                }
            }
        }
    }

    /**
     * enable the listener
     */
    protected function enableSoftdeleteListener(){
        foreach (self::$listeners as $eventName => $listener) {
            $this->entityManager->getEventManager()->addEventListener($eventName, $listener);
        }
    }
}
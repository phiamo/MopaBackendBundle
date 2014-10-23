<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

trait SoftdeleteAdminControllerTrait{

    public function setHardDeleteAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (false === $this->admin->isGranted('HARD_DELETE', $object)) {
            throw new AccessDeniedException();
        }
        $this->disableSoftdeleteListener();
        $this->getManager()->remove($object);
        $this->getManager()->flush();

        return new RedirectResponse(
            $this->admin->generateUrl('list', $this->admin->getFilterParameters())
        );
    }
    protected function getManager(){
        return $this->get('doctrine.orm.entity_manager');
    }
    protected function disableSoftdeleteListener(){
        foreach ($this->get('doctrine.orm.entity_manager')->getEventManager()->getListeners() as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof SoftDeleteableListener) {
                    $this->getManager()->getEventManager()->removeEventListener($eventName, $listener);
                }
            }
        }
    }
}
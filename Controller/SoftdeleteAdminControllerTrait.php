<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityManager;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class SoftdeleteAdminControllerTrait
 * @package Mopa\Bundle\BackendBundle\Controller
 */
trait SoftdeleteAdminControllerTrait
{
    protected function deleteSoftdeleted($object) {
        $this->disableSoftdeleteListener();
        $this->getManager()->remove($object);
        $this->getManager()->flush();
    }
    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function hardDeleteAction($id = null)
    {

        $id     = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $object)) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            try {
                $this->deleteSoftdeleted($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'ok'));
                }

                $this->addFlash(
                    'sonata_flash_success',
                    $this->admin->trans(
                        'flash_delete_success',
                        array('%name%' => $this->admin->toString($object)),
                        'SonataAdminBundle'
                    )
                );

            } catch (ModelManagerException $e) {

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'error'));
                }

                $this->addFlash(
                    'sonata_flash_error',
                    $this->admin->trans(
                        'flash_delete_error',
                        array('%name%' => $this->admin->toString($object)),
                        'SonataAdminBundle'
                    )
                );
            }

            return $this->redirectTo($object);
        }

        return $this->render($this->admin->getTemplate('delete'), array(
            'object'     => $object,
            'action'     => 'hard_delete',
            'csrf_token' => $this->getCsrfToken('sonata.delete')
        ));
    }

    /**
     * @return EntityManager
     */
    protected function getManager(){

        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * disable the listener
     */
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
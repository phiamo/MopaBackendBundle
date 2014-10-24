<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityManager;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class SoftDeleteableAdminControllerTrait
 * @package Mopa\Bundle\BackendBundle\Controller
 */
trait SoftDeleteableAdminControllerTrait
{
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
                $hd = $this->get('mopa_backend.harddeleter');
                $hd->purge($object);

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

}
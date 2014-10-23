<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

/**
 * Class SoftdeleteAdminController
 * @package Mopa\Bundle\BackendBundle\Controller
 */
class SoftdeleteAdminController extends CRUDController{
    use SoftdeleteAdminControllerTrait;
}
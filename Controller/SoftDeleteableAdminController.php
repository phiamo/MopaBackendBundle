<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

/**
 * Class SoftDeleteableAdminController
 * @package Mopa\Bundle\BackendBundle\Controller
 */
class SoftDeleteableAdminController extends CRUDController{
    use SoftDeleteableAdminControllerTrait;
}
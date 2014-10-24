<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Mopa\Bundle\BackendBundle\Controller\SoftDeleteableAdminControllerTrait;
use Pix\SortableBehaviorBundle\Controller\SortableAdminController;

class SortableSoftDeletableAdminController extends SortableAdminController
{
    use SoftDeleteableAdminControllerTrait;
}
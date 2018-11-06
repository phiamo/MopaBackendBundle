<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Pix\SortableBehaviorBundle\Controller\SortableAdminController;

class SortableSoftDeletableAdminController extends SortableAdminController
{
    use SoftDeleteableAdminControllerTrait;
}
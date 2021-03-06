<?php
namespace Mopa\Bundle\BackendBundle\Admin\Extension;

use Mopa\Bundle\BackendBundle\Admin\SoftDeleteableAdminTrait;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SoftdeleteExtension extends AdminExtension
{
    use SoftDeleteableAdminTrait;

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper){
        $this->addSoftdeleteDatagridFilter($datagridMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    public function configureListFields(ListMapper $listMapper)
    {
        //TODO: add _action hard delete
    }

    /**
     * @param AdminInterface $admin
     * @param RouteCollection $collection
     */
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection)
    {
        $collection->add('hard_delete', $admin->getRouterIdParameter() . '/hard_delete');
    }
}

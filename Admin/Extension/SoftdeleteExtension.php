<?php
namespace Mopa\Bundle\BackendBundle\Admin\Extension;

use Mopa\Bundle\BackendBundle\Admin\SoftdeleteTrait;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class SoftdeleteExtension extends AdminExtension
{
    use SoftdeleteTrait;

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper){
        $this->addSoftdeleteDatagridFilter($datagridMapper);
    }
}

<?php
namespace Mopa\Bundle\BackendBundle\Admin\Extension;

use Mopa\Bundle\BackendBundle\Admin\SoftdeleteAdminTrait;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class SoftdeleteExtension extends AdminExtension
{
    use SoftdeleteAdminTrait;

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper){
        $this->addSoftdeleteDatagridFilter($datagridMapper);
    }
}

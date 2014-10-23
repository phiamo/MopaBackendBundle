<?php
namespace Mopa\Bundle\BackendBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Exception\InvalidArgumentException;

trait SoftdeleteTrait{

    /**
     * @param ProxyQuery $proxyQuery
     * @return mixed
     */
    protected function configureSoftdeletable(ProxyQuery $proxyQuery){

    }

    /**
     * @param ProxyQuery $proxyQuery
     * @return mixed
     */
    protected function configureSoftdeletableFilter(array $value, ProxyQuery $proxyQuery, $alias){

    }
    /**
     * Disable softdelete here
     * needed for not having deleted entities in relations,
     * which would case Entity was not found.
     */
    public function configure()
    {
        $filters = $this->getModelManager()->getEntityManager($this->getClass())->getFilters();

        if (array_key_exists('softdeleteable', $filters->getEnabledFilters())) {
            $filters->disable('softdeleteable');
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function addSoftdeleteDatagridFilter(DatagridMapper $datagridMapper){
        if($datagridMapper->has('display_choice')) {
            return;
        }
        $admin = $this;
        $datagridMapper
            ->add('display_choice', 'doctrine_orm_callback', array(
                'callback' => function (ProxyQuery $proxyQuery, $alias, $field, $value) use ($admin){
                    $admin->configureSoftdeletable($proxyQuery, $alias);
                    switch ($value['value']) {
                        case null:
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "past":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "notdeleted":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "deleted":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NOT NULL');
                            break;
                        case "all":
                            return true;
                        default:
                            throw new InvalidArgumentException('Unknown value: ' . $value['value']);
                    }
                    $admin->configureSoftdeletableFilter($value, $proxyQuery, $alias);
                    return true;
                },
                'field_type' => 'choice',
                'label' => 'Anzeige'
            ), 'choice', array(
                'choices' => array(
                    'past' => 'Vergangene',
                    'notdeleted' => 'Alle ausser gelöschte',
                    'deleted' => 'nur gelöschte',
                    'all' => 'Alles'
                ),
                'attr' => array(
                    'placeholder' => 'Zukünftige'
                )

            ))
        ;
    }

}
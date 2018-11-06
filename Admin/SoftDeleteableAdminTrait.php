<?php
namespace Mopa\Bundle\BackendBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

trait SoftDeleteableAdminTrait {

    /**
     * Disable softdelete here
     * needed for not having deleted entities in relations,
     * which would case Entity was not found.
     */
    public function configureFilter()
    {
        $filters = $this->getModelManager()->getEntityManager($this->getClass())->getFilters();

        if (array_key_exists('softdeleteable', $filters->getEnabledFilters())) {
            $filters->disable('softdeleteable');
        }
    }

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
    protected function configureSoftdeletableFilter(array $value, ProxyQuery $proxyQuery){

    }

    protected function getDisplayChoices(){
        return [
            'default' => 'Alle ausser gelöschte',
            'notdeleted' => 'Alle ausser gelöschte',
            'deleted' => 'nur gelöschte',
            'all' => 'Alles',
        ];
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function addSoftdeleteDatagridFilter(DatagridMapper $datagridMapper){
        if($datagridMapper->has('display_choice')) {
            return;
        }

        $this->configureFilter();

        $admin = $this;
        $choices = $admin->getDisplayChoices();
        $default = $choices['default'];

        unset($choices['default']);


        $datagridMapper
            ->add('display_choice', 'doctrine_orm_callback', array(
                'callback' => function (ProxyQuery $proxyQuery, $alias, $field, $value) use ($admin){
                    $admin->configureSoftdeletable($proxyQuery);
                    switch ($value['value']) {
                        case null:
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "future":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "past":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "notdeleted":
                            $proxyQuery->andWhere($alias.'.deletedAt IS NULL');
                            break;
                        case "deleted":
                            $this->configureFilter();
                            $proxyQuery->where($alias.'.deletedAt IS NOT NULL');
                            break;
                        case "all":
                            return true;
                        default:
                            throw new InvalidArgumentException('Unknown value: ' . $value['value']);
                    }
                    $admin->configureSoftdeletableFilter($value, $proxyQuery);
                    return true;
                },
                'field_type' => ChoiceType::class,
                'label' => 'Anzeige'
            ), ChoiceType::class, array(
                'choices' => array_flip($choices),
                'attr' => array(
                    'placeholder' => $default
                )

            ))
        ;
    }

}
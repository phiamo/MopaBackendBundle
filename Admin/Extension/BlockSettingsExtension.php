<?php
namespace Mopa\Bundle\BackendBundle\Admin\Extension;

use Burgov\Bundle\KeyValueFormBundle\Form\Type\KeyValueType;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class BlockSettingsExtension
 * @package Mopa\Bundle\BackendBundle\Admin\Extension
 */
class BlockSettingsExtension extends AdminExtension
{
    /**
     * Configure form fields
     *
     * @param FormMapper $formMapper
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.general', array('translation_domain' => 'CmfBlockBundle'))
                ->add('settings', KeyValueType::class, array(
                    'required' => false,
                    'value_type' => TextType::class,
                    'allow_add' => true
                ))
            ->end()
        ;
    }
}

<?php
namespace Mopa\Bundle\BackendBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;


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
                ->add('settings', 'burgov_key_value', array(
                    'required' => false,
                    'value_type' => 'text',
                ))
            ->end()
        ;
    }
}

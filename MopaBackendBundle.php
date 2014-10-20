<?php

namespace Mopa\Bundle\BackendBundle;

use Mopa\Bundle\BackendBundle\DependencyInjection\Compiler\FormPass;
use Mopa\Bundle\BackendBundle\DependencyInjection\Compiler\TemplatePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MopaBackendBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }
}

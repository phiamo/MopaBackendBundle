<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BackendBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add a new twig.form.resources
 *
 * @author Philipp A. Mohrenweiser <phiamo@googlemail.com>
 */
class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');
        // Ensure it wasn't already added via config
        $template = 'MopaBackendBundle:Form:form_admin_fields.html.twig';
        if (!in_array($template, $resources)) {
            // If form_div_layout.html.twig is found, insert BootstrapBundle right after
            // Else insert Mopa in first position
            array_push($resources, $template);

            $container->setParameter('twig.form.resources', $resources);
        }
    }
}

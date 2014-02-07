<?php

/*
 * This file is part of the Symfony CMF package. (c) 2011-2013 Symfony CMF For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Mopa\Bundle\BackendBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\AdminBundle\Admin\Pool;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Cnr\WebsiteBundle\Entity\BednRide;
use Cnr\WebsiteBundle\Entity\BednRideBooking;


class GoogleAnalyticsBlockService extends BaseBlockService
{
    protected $template = 'MopaBackendBundle:Block:block_google_analytics.html.twig';
    
    public function getName()
    {
        return 'mopa_backend.google_analytics.block.service';
    }

    public function getDefaultSettings()
    {
        return array();
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     *
     * @ERROR!!!
     *
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
    	return $this->renderResponse($this->template, array(
    	));
    }
    
    
}

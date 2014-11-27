<?php

/*
 * This file is part of the Symfony CMF package. (c) 2011-2013 Symfony CMF For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Mopa\Bundle\BackendBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;


class GoogleAnalyticsBlockService extends BaseBlockService
{
    /**
     * @var SecurityContextInterface
     */
    private $securityContext;

    public function __construct($name, EngineInterface $templating, SecurityContextInterface $securityContext){
        parent::__construct($name, $templating);
        $this->securityContext = $securityContext;
    }
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
        if($this->securityContext->isGranted('ROLE_MOPA_ANALYTICS')) {
            return $this->renderResponse($this->template, array(
                'block' => $blockContext->getBlock()
            ));
        }
        return $response;
    }
    
    
}

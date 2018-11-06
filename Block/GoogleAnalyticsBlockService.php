<?php

/*
 * This file is part of the Symfony CMF package. (c) 2011-2013 Symfony CMF For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Mopa\Bundle\BackendBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Model\BlockInterface;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class GoogleAnalyticsBlockService extends AbstractAdminBlockService
{
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var null|string
     */
    protected $template = 'MopaBackendBundle:Block:block_google_analytics.html.twig';

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param AuthorizationChecker $authorizationChecker
     * @param null $template
     */
    public function __construct($name, EngineInterface $templating, AuthorizationChecker $authorizationChecker, $template = null)
    {
        parent::__construct($name, $templating);
        $this->authorizationChecker = $authorizationChecker;

        if(null !== $template){
            $this->template = $template;
        }

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mopa_backend.google_analytics.block.service';
    }

    /**
     * @return array
     */
    public function getDefaultSettings()
    {
        return array();
    }

    /**
     * @param ErrorElement $errorElement
     * @param BlockInterface $block
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * @param FormMapper $formMapper
     * @param BlockInterface $block
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if($this->authorizationChecker->isGranted('ROLE_MOPA_ANALYTICS')) {
            return $this->renderResponse($this->template, array(
                'block' => $blockContext->getBlock()
            ));
        }
        return $response;
    }
    
    
}

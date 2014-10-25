<?php
namespace Mopa\Bundle\Backendbundle\Block;

use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Model\BlockInterface;

class AdminDataGridFilterButtonsEvent{
    /**
     * @param  BlockEvent $event
     *
     * @return BlockInterface
     */
    public function onBlock(BlockEvent $event)
    {
        $block = new Block();
        $block->setId(uniqid());
        $block->setSettings($event->getSettings());
        $block->setType('sonata.block.service.text');
        $block->setSettings(array(
            'template' => 'MopaBackendBundle:Block:block_admin_datagrid_filter_buttons.html.twig',
            'content' => $event->getSetting('admin'),
        ));

        $event->addBlock($block);
    }

}

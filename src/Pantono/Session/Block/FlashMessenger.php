<?php namespace Pantono\Session\Block;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Block\AbstractBlock;
use Pantono\Session\FlashMessenger as FlashMessengerService;

class FlashMessenger extends AbstractBlock implements BlockInterface
{
    public function render(array $arguments = [])
    {
        $messages = $this->getFlashMessengerService()->getGroupedMessages();
        $this->getFlashMessengerService()->deleteAllMessages();
        return $this->getApplication()['twig']->render('admin/blocks/flash-messenger.twig', ['groupedMessages' => $messages]);
    }

    /**
     * @return FlashMessengerService
     */
    private function getFlashMessengerService()
    {
        return $this->getApplication()->getPantonoService('FlashMessenger');
    }
}

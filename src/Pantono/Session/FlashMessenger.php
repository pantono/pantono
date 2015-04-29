<?php namespace Pantono\Session;

use Symfony\Component\HttpFoundation\Session\Session;

class FlashMessenger
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function addMessage($message, $type = 'info')
    {
        $current = $this->session->get('flash_messenger', []);
        $current[] = [
            'message' => $message,
            'type' => $type,
            'date' => (new \DateTime())->format('Y-m-d H:i:s')
        ];
        $this->session->set('flash_messenger', $current);
    }

    public function getMessages()
    {
        return $this->session->get('flash_messenger', []);
    }

    public function getGroupedMessages()
    {
        $messages = [];
        foreach ($this->getMessages() as $message) {
            if ($message['type'] == 'error') {
                $message['type'] = 'danger';
            }
            $messages[$message['type']][] = $message;
        }
        return $messages;
    }

    public function deleteAllMessages()
    {
        $this->session->set('flash_messenger', []);
    }
}
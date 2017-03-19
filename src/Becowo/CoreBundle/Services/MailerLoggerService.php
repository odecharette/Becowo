<?php
namespace Becowo\CoreBundle\Services;

use Psr\Log\LoggerInterface;
use Swift_Events_SendEvent;
use Swift_Events_SendListener;

class MailerLoggerService implements Swift_Events_SendListener
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
        $this->logger->debug('beforeSendPerformed id : ' . $evt->getMessage()->getId());
    }
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        // $evt contains mail, response and many more data
        $this->logger->debug('sendPerformed id : ' . $evt->getMessage()->getId());
        $this->logger->debug('sendPerformed Subject : ' . $evt->getMessage()->getSubject());
        $this->logger->debug('sendPerformed From : ' . key($evt->getMessage()->getFrom()));
        $this->logger->debug('sendPerformed To : ' . key($evt->getMessage()->getTo()));
        if($evt->getMessage()->getCc() != null)
            $this->logger->debug('sendPerformed Cc : ' . key($evt->getMessage()->getCc()));
        if($evt->getMessage()->getBcc() != null)
            $this->logger->debug('sendPerformed Bcc : ' . key($evt->getMessage()->getBcc()));
        if($evt->getFailedRecipients() != null)
            $this->logger->debug('sendPerformed FailedRecipients : ' . key($evt->getFailedRecipients()));

        switch ($evt->getResult()) {
            case 1:
                $this->logger->debug('sendPerformed Result : RESULT_PENDING');
                break;
            case 17:
                $this->logger->debug('sendPerformed Result : RESULT_SPOOLED');
                break;
            case 16:
                $this->logger->debug('sendPerformed Result : RESULT_SUCCESS');
                break;
            case 256:
                $this->logger->debug('sendPerformed Result : RESULT_TENTATIVE');
                break;
            case 4096:
                $this->logger->debug('sendPerformed Result : RESULT_FAILED');
                break;
            default:
                $this->logger->debug('sendPerformed Result : ' . $evt->getResult());
                break;
        }
    }
}

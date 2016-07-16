<?php

namespace Swarrot\SwarrotBundle\Processor\MaxMessages;

use Psr\Log\LoggerInterface;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorExtrasAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class MaxMessagesProcessorConfigurator implements ProcessorConfiguratorInterface
{
    use ProcessorConfiguratorExtrasAware;

    /** @var string */
    private $processorClass;
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param string          $processorClass
     * @param LoggerInterface $logger
     */
    public function __construct($processorClass, LoggerInterface $logger)
    {
        $this->processorClass = $processorClass;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessorArguments(array $options)
    {
        return [
            $this->processorClass,
            $this->logger,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandOptions()
    {
        return [
            [
                'max-messages',
                'm',
                InputOption::VALUE_REQUIRED,
                'Max messages to process before exit',
                $this->getExtra('max_messages', 300),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveOptions(InputInterface $input)
    {
        return [
            'max_messages' => (int) $input->getOption('max-messages'),
        ] + $this->getExtras();
    }
}
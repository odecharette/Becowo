<?php

namespace Becowo\CronBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class GetStatsEmailEventsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        // the name of the command (the part after "php bin/console")
        $this->setName('app:get-stats-email-events')
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	// outputs a message to the console followed by a "\n"
        $output->writeln('Debut de la commande');

     	// access the container using getContainer()
        $service = $this->getContainer()->get('app.email');
        $service->getEmailStats();

        $output->writeln('Fin de la commande');
    }
}

<?php

namespace Becowo\CronBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class GetEmailEventsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        // the name of the command (the part after "php bin/console")
        $this->setName('app:get-email-events')
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	// outputs a message to the console followed by a "\n"
        $output->writeln('Debut de la commande');

     	// access the container using getContainer()
        $service = $this->getContainer()->get('app.email');
        $nextPage = $service->getEmailEvents();
        $i = 0;
        while($nextPage != null)
        {
            $nextPage = $service->getEmailEvents($nextPage);
            $i++;
        }

        $output->writeln($i . ' pages lues. Fin de la commande');
    }
}

<?php

namespace Becowo\CronBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class EmailNewUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        
        // the name of the command (the part after "php bin/console")
        $this->setName('app:send-email-new-users')
			 ->setDescription('Send welcome emails to new users') 
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	// outputs a message to the console followed by a "\n"
        $output->writeln('Debut de la commande d\'envoi d\'emails');

     	// access the container using getContainer()
        $memberService = $this->getContainer()->get('app.member.sendEmailNewUsers');
        $results = $memberService->sendEmailToNewUsersAction();

        $output->writeln($results);
    }
}

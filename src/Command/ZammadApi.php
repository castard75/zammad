<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Task;
use ZammadAPIClient\Client;
use ZammadAPIClient\ResourceType;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:zammad')]
class CreateUserCommand extends Command
{

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;    
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getDatas();
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }


public function getDatas(){
  
    // $ListeTask = $this->em->getRepository(Task::class)->findAll();

    //Connexion du client
    $client = new Client([
        'url'           => 'https://myzammad.com', // URL to your Zammad installation
        'username'      => 'myuser@myzammad.com',  // Username to use for authentication
        'password'      => 'mypassword',           // Password to use for authentication
        // 'timeout'       => 15,                  // Sets timeout for requests, defaults to 5 seconds, 0: no timeout
        // 'debug'         => true,                // Enables debug output
        // 'verify'        => true,                // Enabled SSL verification. You can also give a path to a CA bundle file. Default is true.
    ]);

  
    


    $ticket = $client->resource( ResourceType::TICKET );
    $ticket->setValue( 'title', 'My new ticket' );
    $ticket->setValue( 'group', 'exemple' );
    $ticket->setValue( 'customer', 'My new ticket' );
    $ticket->setValue( 'article', 'My new ticket' );
    // ...
    // Set additional values
    // 
    // {
    //     "title": "Help me!",
    //     "group": "2nd Level",
    //     "customer": "david@example.com",
    //     "article": {
    //        "subject": "My subject",
    //        "body": "I am a message!",
    //        "type": "note",
    //        "internal": false
    //     }
    //  }
    $ticket->save(); // Will create a new ticket object in Zammad


}

}
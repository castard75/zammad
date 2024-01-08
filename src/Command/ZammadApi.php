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
class ZammadApi extends Command
{

    protected function configure()
    {
        // Configuration de votre commande
        $this->setName('app:zammad')
             ->setDescription('Description de votre commande');
    }
    
    public function __construct(
        
        EntityManagerInterface $em
    ) {
        
        $this->em = $em;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getDatas();
        return Command::SUCCESS;

    }


public function getDatas(){
  
    // $ListeTask = $this->em->getRepository(Task::class)->findAll();

    //Connexion du client
    $client = new Client([
        'url'           => 'https://zammadtest.nixia.it', // URL to your Zammad installation
        'username'      => 'castard75@gmail.com',  // Username to use for authentication
        'password'      => 'KEg7595qtd3ABk',           // Password to use for authentication

    ]);

    
    $findAllUsers = $client->resource( ResourceType::USER )->all();
  dump($tickets);
 


    // $ticket = $client->resource( ResourceType::TICKET );
    // $ticket->setValue( 'title', 'My new ticket' );
    // $ticket->setValue( 'group', 'exemple' );
    // $ticket->setValue( 'customer', 'My new ticket' );
    // $ticket->setValue( 'article', 'My new ticket' );
    // // ...
    // // Set additional values
    // // 
    // {
    //     "title": "Help me!",
    //     "group": "2nd Level",
    //     "customer": "david@example.com",
    //     "article": {
    //        "subject": "My subject", subject
    //        "body": "I am a message!", desciption
    //        "type": "note",
    //        "internal": false
    //     }
    //  }
    // $ticket->save(); // Will create a new ticket object in Zammad


}

}
<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ZammadAPIClient\Client as ZammadClient;
use ZammadAPIClient\ResourceType;

class TicketsSync extends Command
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:ticket')
             ->setDescription('Synchronisation des tickets');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createTicket();
        return Command::SUCCESS;
    }


public function createTicket(){


    
        // Connexion 
        $client = new ZammadClient([
           'url'      => 'https://zammadtest.nixia.it',
           'username' => 'castard75@gmail.com',
           'password' => 'KEg7595qtd3ABk',
       ]);



       $ticketData = [
        "title" => "titre",
        "group_id" =>3,
        "customer" => "test@aigrettes.fr",
        "priority" => "2 normal",
        "owner" => "castard75@gmail.com",
        "article" => [
            "subject" => "subject",
            "body" => "I am a message!",
            "type" => "note",
            "internal" => false
        ]
    ];
       
       $ticket = $client->resource( ResourceType::TICKET );
       $ticket->setValues($ticketData);
       $ticket->save();
    //    dump($ticket);
   
  
    }



}

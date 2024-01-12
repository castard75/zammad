<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ZammadAPIClient\Client as ZammadClient;
use ZammadAPIClient\ResourceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;

class TicketsSync extends Command
{
    private $httpClient;

    public function __construct(
        
        EntityManagerInterface $entityManager
    ) {
        
        $this->em = $entityManager;
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

      $findAllTickets =  $this->em->getRepository(Task::class)->findAll();
  

   foreach($findAllTickets as $task){

       $status =  $task->getStatus();
       $title = $task->getTitle();
       $description = $task->getDescription();
      
      

    if($status == 0 && $title !== null && $description !== null ){ 
        $recurrence = $task->getRecurrence();
        
        $clientEmail = $task->getClientEmail();
        $technicien = $task->getTechnicienEmail();
        $date = $task->getUpdatedAt();
        $group = $task->getGroupId();

        $recurrenceInt = intval($recurrence);

        //Comparaison avec date du jour pour lancer les synchronisations
        $currentDate = new \DateTimeImmutable('now');
        $diff = $currentDate->diff($date);
        $daysSinceLastUpdate = $diff->days;
 


  
        if ($daysSinceLastUpdate >= $recurrenceInt) {   //Si le nombre jour depuis la dèrnière synchro est égale à la récurrence on lance la syncho et on remet à jour la de de mise à jour

            $ticketData = [
                "title" => $title,
                "group_id" => $group,
                "customer" => $clientEmail,
                "priority" => "2 normal",
                "owner" => $technicien,
                "article" => [
                    "subject" => $title,
                    "body" => $description,
                    "type" => "note",
                    "internal" => false
                ]
            ];

            $ticket = $client->resource(ResourceType::TICKET);
            $ticket->setValues($ticketData);
            $ticket->save();

            $getresponse = $client->getLastResponse();
            $response =   $reasonPhrase = $getresponse->getReasonPhrase();

            if( $response == "Created"){

            // Mise à jour de la tâche après la synchronisation
                $task->setStatus(2);
                $task->setUpdatedAt($currentDate);
                $this->em->persist($task);
                $this->em->flush();
                dump("sync ok");


            } 




             


        }
   


    } 
    
   
   }


   
  
  }



}

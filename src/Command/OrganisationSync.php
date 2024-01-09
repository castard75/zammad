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
use App\Entity\Technicien;
use App\Entity\Organisation;
use ZammadAPIClient\Client as ZammadClient;
use ZammadAPIClient\Client\Response as ZammadResponse;
use ZammadAPIClient\ResourceType;

class OrganisationSync extends Command {

    protected function configure()
    {
        // Configuration de votre commande
        $this->setName('app:syncOrganisation')
             ->setDescription('syncOrganisation');
    }
    
    public function __construct(
        
        EntityManagerInterface $entityManager
    ) {
        
        $this->em = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getOrganisations($this->em);
        return Command::SUCCESS;

    }


    public function getOrganisations(EntityManagerInterface $entityManager){

          try{ 
             // Connexion 
             $client = new ZammadClient([
                'url'      => 'https://zammadtest.nixia.it',
                'username' => 'castard75@gmail.com',
                'password' => 'KEg7595qtd3ABk',
            ]);
    
            $findAllOrganisations = $client->resource(ResourceType::ORGANIZATION)->all();
   



            foreach($findAllOrganisations as $item){
         

                $allDatas = $item->getValues();
               

                $Id = $allDatas['id'];
                $active = null;
               

                   if (trim($allDatas['active']) != "") {

                   $active = trim($allDatas['active']);

                   }

      
                   if($active == "1"){
                    
                    //Gestion occurence
                    $occurenceOrganisation = $this->em->getRepository(Organisation::class)
                    ->findOneBy(array(
                        "zammadId" => $Id,
        
                    ));
                
                    $name = NULL;
                    if (trim($allDatas['name']) != "") {

                    $name = trim($allDatas['name']);

                    }


                          if (is_null($occurenceOrganisation)) {

                            $organisation_entity = new Organisation();

                       

                            $organisation_entity
                            ->setZammadId($Id)
                            ->setName($name);
                            $entityManager->persist($organisation_entity);



                   } else {
                    $occurenceOrganisation
                    ->setZammadId($Id)
                    ->setName($name);

                    $entityManager->persist($occurenceOrganisation);


                   }

                   $entityManager->flush();


                 }
   






          } 
                   } catch( \Exception $e){
                           dump($e);           
                    }  
    
    
                }

}
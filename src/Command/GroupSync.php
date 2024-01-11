<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ZammadAPIClient\Client as ZammadClient;
use Doctrine\ORM\EntityManagerInterface;
use ZammadAPIClient\ResourceType;
use App\Entity\Groups;

class GroupSync extends Command
{
    private $httpClient;
    private $em;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager )
    {
         $this->em = $entityManager;
        $this->httpClient = $httpClient;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:groups')
             ->setDescription('Synchronisation des tickets');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createTicket();
        return Command::SUCCESS;
    }


public function createTicket(){



  
    try{  

    
        $client = new ZammadClient([
            'url'      => 'https://zammadtest.nixia.it',
            'username' => 'castard75@gmail.com',
            'password' => 'KEg7595qtd3ABk',
        ]);
    
        $findAllOrganisations = $client->resource(ResourceType::GROUP)->all();
        dump($findAllOrganisations);
        
        foreach($findAllOrganisations as $item){
         
            
            $allDatas = $item->getValues();
               

               $Id = $allDatas['id'];
               $active = null;

               if (trim($allDatas['active']) != "") {

               $active = trim($allDatas['active']);

               }

               if($active == "1"){
                    
                //Gestion occurence
                $occurenceGroups = $this->em->getRepository(Groups::class)
                ->findOneBy(array(
                    "zammadId" => $Id,
    
                ));
            
                $name = NULL;
                if (trim($allDatas['name']) != "") {

                $name = trim($allDatas['name']);

                }

                
                $lastname = NULL;
                if (trim($allDatas['name_last']) != "") {

                $lastname = trim($allDatas['name_last']);

                }

                      if (is_null($occurenceGroups)) {

                        $group_entity = new Groups();

                   

                        $group_entity
                        ->setZammadId($Id)
                        ->setLastName($lastname)
                        ->setName($name);
                        $this->em->persist($group_entity);



               } else {
                $occurenceGroups
                ->setZammadId($Id)
                ->setLastName($lastname)
                ->setName($name);

                $this->em->persist($occurenceGroups);


               }

               $this->em->flush();


             }




        }



        }catch(\Exception $e){

        dump($e);  

        }



    }



}

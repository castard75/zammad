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
use App\Entity\Client;
use ZammadAPIClient\Client as ZammadClient;
use ZammadAPIClient\Client\Response as ZammadResponse;
use ZammadAPIClient\ResourceType;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:zammad')]
class ZammadApi extends Command
{
    private $em;
    protected function configure()
    {
        // Configuration de votre commande
        $this->setName('app:zammad')
             ->setDescription('Description de votre commande');
    }
    
    public function __construct(
        
        EntityManagerInterface $entityManager
    ) {
        
        $this->em = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getDatas($this->em);
        return Command::SUCCESS;

    }


    public function getDatas(EntityManagerInterface $entityManager) {

       
        try {
            // Connexion 
            $client = new ZammadClient([
                'url'      => 'https://zammadtest.nixia.it',
                'username' => 'castard75@gmail.com',
                'password' => 'KEg7595qtd3ABk',
            ]);
    
            // Récupéreration des utilisateurs
            $findAllUsers = $client->resource(ResourceType::USER)->all();

    

            if (!is_array($findAllUsers)) {

                dump("Erreur : " . json_encode($findAllUsers));
            } else {

                //récupération des utilisateurs
                $users = $findAllUsers;

                foreach($users as $item ) {
               
                     $allDatas = $item->getValues();
            


                    $Id = $allDatas['id'];
                     $active = null;

                     if (trim($allDatas['active']) != "") {

                        $active = trim($allDatas['active']);
    
                        }

                        $rolesArray = $allDatas['roles'];
                        $firstRole = NULL;
                        $secondRole= NULL;

                     if (is_array($rolesArray)) {
                         if (count($rolesArray) >= 2) {
                             $firstRole = $rolesArray[0];
                             $secondRole = $rolesArray[1];
                          
                         } elseif (count($rolesArray) == 1) {
                             // Si il n'y a qu'un seul élément dans le tableau
                             $firstRole = $rolesArray[0];
                             $secondRole = NULL; 
                         } else {
                             // Le tableau est vide
                             $rolesArray = NULL;
                         }
                        
                         } else {
                        
                         $rolesArray = NULL;
                     }

                         $organization_id = NULL;
                            if (trim($allDatas['organization_id']) != "") {
       
                               $organization_id = trim($allDatas['organization_id']);
           
                               }

                        //récupération des utilisateurs actif
                        if($active == "1" && $firstRole == "Customer" && $organization_id !== null){

                        
 
                            $login = NULL;
                            if (trim($allDatas['login']) != "") {
       
                               $login = trim($allDatas['login']);
           
                               }
       
                            $organization_id = NULL;
                            if (trim($allDatas['organization_id']) != "") {
       
                               $organization_id = trim($allDatas['organization_id']);
           
                               }
       
                            $email = NULL;
                            if (trim($allDatas['email']) != "") {
       
                               $email = trim($allDatas['email']);
           
                               }
       
                            $firstname = NULL;
                            if (trim($allDatas['firstname']) != "") {
       
                            $firstname = trim($allDatas['firstname']);
       
                            }
       
                            $lastname = NULL;
                            if (trim($allDatas['lastname']) != "") {
       
                            $lastname = trim($allDatas['lastname']);
                            
                           }
                         
                           //Gestion occurence
                           $occurence = $this->em->getRepository(Client::class)
                           ->findOneBy(array(
                               "zammadId" => $Id,
 
                           ));
                        
                         


                           if (is_null($occurence)) {
                            $client_entity = new Client();

                            $client_entity
                                ->setZammadId($Id)
                                ->setName($firstname)
                                ->setOrganizationId($organization_id)
                                ->setLogin($login)
                                ->setLastname($lastname)
                                ->setEmail($email)
                                ->setRoles($firstRole)
                                ->setSecondRole($secondRole);
           
                             $entityManager->persist($client_entity);

                            } else {
                                
                            $occurence
                            ->setZammadId($Id)
                            ->setName($firstname)
                            ->setOrganizationId($organization_id)
                            ->setLogin($login)
                            ->setLastname($lastname)
                            ->setEmail($email)
                            ->setRoles($firstRole)
                            ->setSecondRole($secondRole);
  
                                $entityManager->persist($occurence);
                            }


                             $entityManager->flush();



                          } else if ($active == "1" && $firstRole == "Admin" || 'Agent' && $organization_id !== null ) {

                            $login = NULL;
                            if (trim($allDatas['login']) != "") {
       
                               $login = trim($allDatas['login']);
           
                               }
       
                      
       
                            $email = NULL;
                            if (trim($allDatas['email']) != "") {
       
                               $email = trim($allDatas['email']);
           
                               }
       
                            $firstname = NULL;
                            if (trim($allDatas['firstname']) != "") {
       
                            $firstname = trim($allDatas['firstname']);
       
                            }
       
                            $lastname = NULL;
                            if (trim($allDatas['lastname']) != "") {
       
                            $lastname = trim($allDatas['lastname']);
                            
                           }
                         
                           //Gestion occurence
                           $occurenceTechnicien = $this->em->getRepository(Technicien::class)
                           ->findOneBy(array(
                               "idZammad" => $Id,
 
                           ));
                       


                           if (is_null($occurenceTechnicien)) {

                            $technicien_entity = new Technicien();

                            $technicien_entity
                                ->setIdZammad($Id)
                                ->setName($firstname)
                                ->setOrganizationId($organization_id)
                                ->setLogin($login)
                                ->setLastname($lastname)
                                ->setEmail($email)
                                ->setRoles($firstRole)
                                ->setSecondRole($secondRole);
           
                             $entityManager->persist($technicien_entity);

                            } else {
                                
                            $occurenceTechnicien
                            ->setIdZammad($Id)
                            ->setName($firstname)
                            ->setOrganizationId($organization_id)
                            ->setLogin($login)
                            ->setLastname($lastname)
                            ->setEmail($email)
                            ->setRoles($firstRole)
                            ->setSecondRole($secondRole);
  
                                $entityManager->persist($occurenceTechnicien);
                            }

                               
                        $entityManager->flush();


                          } 
                        
                


                }
               
    
    
            }
    
        } catch (\Exception $e) {

            dump("Erreur : " . $e->getMessage());
        }
    }
    
    

public function essai(){
  
    // $ListeTask = $this->em->getRepository(Task::class)->findAll();

    //Connexion du client
    $client = new ZammadClient([
        'url'           => 'https://zammadtest.nixia.it', // URL to your Zammad installation
        'username'      => 'castard75@gmail.com',  // Username to use for authentication
        'password'      => 'KEg7595qtd3ABk',           // Password to use for authentication

    ]);

    
    $findAllUsers = $client->resource( ResourceType::USER )->all();
    
    // $last_response = new ZammadResponse($findAllUsers->getStatusCode(), $findAllUsers->getReasonPhrase(), $findAllUsers->getBody());
    // $responseBody = $last_response->getBody();
$datas = $findAllUsers->getValues();
    dump($datas);



//   if ($findAllUsers->getStatusCode() == 200) {
//     $content = json_decode($findAllUsers->getContent(), true);
//     dump($findAllUsers);

// }


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
    $ticket->save(); // Will create a new ticket object in Zammad


}

}
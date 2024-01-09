<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
        $this->getGroups();
        return Command::SUCCESS;
    }

    public function getGroups()
    {
        $url = 'https://zammadtest.nixia.it/api/v1/tickets';

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $options = [
            'headers' => $headers,
            'auth_basic' => ['castard75@gmail.com', 'KEg7595qtd3ABk'],
        ];


        $ticketData = [
            "title" => "Help me!",
            "group" => "2nd Level",
            "customer" => "david@example.com",
            "article" => [
                "subject" => "My subject",
                "body" => "I am a message!",
                "type" => "note",
                "internal" => false
            ]
        ];

        try {
            $response = $this->httpClient->request('GET', $url, $options);
     

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $data = $response->toArray(); // Supposons que la réponse est au format JSON
                dump($data);
            } else {
                dump("Échec de la récupération des groupes. Status Code: $statusCode");
                dump($response->getContent());
            }
        } catch (\Exception $e) {
            dump("Exception during HTTP request: " . $e->getMessage());
        }
    }
}

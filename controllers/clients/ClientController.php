<?php

require_once '../models/Validator.php';
require_once '../models/clients/ModelClient.php';
require_once '../models/inscriptions/ModelInscription.php';
require_once '../models/paiements/ModelPaiement.php';

class ClientController
{
    private $validator;
    private $client;
    private $inscription;
    private $paiement;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->client = new ModelClient();
        $this->inscription = new ModelInscription();
        $this->paiement = new ModelPaiement();
    }

    public function index()
    {
        $clients = $this->client->getAllClients(1);
        require_once '../views/clients/list.php';
    }

    public function details($param)
    {
        $code = $this->validator->decrypter($param);

        $client = $this->client->getClientByCode($code);
        $inscriptions = $this->inscription->getInscriptionsByClient($code);
        $paiements = $this->paiement->getPaiementsByInscription($code);
        require_once '../views/clients/details.php';
    }
}

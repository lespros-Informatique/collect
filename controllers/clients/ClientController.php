<?php

require_once '../models/Validator.php';

class ClientController
{
    private $validator;
    private $client;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->client = new ModelClient();
    }

    public function index()
    {
        $clients = $this->client->getAllClients();
        require_once '../views/clients/list.php';
    }

    public function details($param)
    {
        $id = $this->validator->decrypter($param);

        $client = $this->client->getClientById($id);
        $commandes = $this->client->getClientOrders($id);
        require_once '../views/clients/details.php';
    }
}
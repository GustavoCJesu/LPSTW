<?php

namespace App\Controllers;

use App\Services\TrelloService;

class FormReader
{

    public function getForm()
    {

        $data = [
            'name' => 'Lead - ' . $_POST['nome'] ?? 'Não informado',
            'cnpj' => $_POST['cnpj'] ?? 'Não informado',
            'email' => $_POST['email'] ?? 'Não informado',
            'telefone' => $_POST['telefone'] ?? 'Não informado',
            'colaboradores' => $_POST['colaboradores'] ?? 'Não informado',
            'mensagem' => "\n" . $_POST['mensagem'] ?? 'Não informado',
            'pos' => 'bottom',
            'date' => date('d/m/y'),
        ];


        $trelloService = new TrelloService();

        $result = $trelloService->createCard($data);

        // if($result){
        //     var_dump('Foi');
        // }else if(!$result){
        //     var_dump('Não foi :/');
        // }
    }
}

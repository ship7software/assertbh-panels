<?php
/*
 * AdminContatos.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os Contatos no Admin do sistema!
 * @copyright (c) 2016, Marcus Correa
 */
class AdminContatos {

    private $Data;
    private $Contato;
    private $Error;
    private $Result;

    const Entity = 'contatos'; //Nome da tabela no banco de dados

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para cadastrar um Contato, favor preencha todos os campos!", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
        endif;

        $this->Create();
    }

    public function ExeUpdate($ContatoId, array $Data) {
        $this->Contato = (int) $ContatoId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar este Contato, preencha todos os campos.", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
        endif;

        $this->Update();
    }

    public function ExeDelete($ContatoId) {
        $this->Contato = (int) $ContatoId;

        $readDados = new Read;
        $readDados->ExeRead(self::Entity, "WHERE id = :id", "id={$this->Contato}");

        if (!$readDados->getResult()):
            $this->Error = ['Oppsss, você tentou remover um registro que não existe no sistema!', DS_ERROR];
            $this->Result = false;
        else:
            $this->Delete();
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    public function geraJSON(){
        $readContato = new Read;
        $readContato->ExeRead(self::Entity, "ORDER BY departamento");
        if ($readContato->getResult()):
            $listaJson = array();
            foreach ($readContato->getResult() as $contato):
                extract($contato);
                $dados = array('id'=>$id, 'departamento'=>$departamento, 'responsavel'=>$responsavel, 'email'=>$email, 'skype'=>$skype);
                $listaJson[]=$dados;
            endforeach;
        else:
            $dados = array('id'=>'', 'departamento'=>'', 'responsavel'=>'', 'email'=>'', 'skype'=>'');
            $listaJson[]=$dados;
        endif;
        $listajson = json_encode($listaJson, JSON_PRETTY_PRINT);
        file_put_contents('../dados/contatos.json', $listajson);
    }


    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O registro foi cadastrado com sucesso no sistema!", DS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->Contato}");
        if ($Update->getResult()):
            $this->Error = ["O registro foi atualizado com sucesso!", DS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id = :id", "id={$this->Contato}");
        if ($Delete->getResult()):
            $this->Result = true;
        endif;
    }

}

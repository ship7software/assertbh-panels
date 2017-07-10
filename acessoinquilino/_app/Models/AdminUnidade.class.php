<?php
/*
 * AdminContatos.class [ MODEL ADMIN ]
 * Respnsável por gerenciar as Unidades no Admin do sistema!
 * @copyright (c) 2016, Marcus Correa
 */
class AdminUnidade {

    private $Data;
    private $Contato;
    private $Error;
    private $Result;
    private $Proprietario;
    private $Condominio;

    const Entity = 'unidades'; //Nome da tabela no banco de dados

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        $this->setData();
        $this->Create();
    }

    public function ExeUpdate($ContatoId, array $Data) {
        $this->Contato = (int) $ContatoId;
        $this->Data = $Data;

        $this->setData();
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

    public function getProprietario($UserId) {
        $this->Proprietario = (int) $UserId;

        $readProprietario = new Read;
        $readProprietario->ExeRead("proprietarios", "WHERE id = :user", "user={$this->Proprietario}");

        return($readProprietario->getResult()[0]['nome']);
    }

    public function getCondominio($UserId) {
        $this->Condominio = (int) $UserId;

        $readCondominio = new Read;
        $readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$this->Condominio}");

        return($readCondominio->getResult()[0]['nome']);
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

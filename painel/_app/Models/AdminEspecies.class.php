<?php
/*
 * AdminContatos.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os Contatos no Admin do sistema!
 * @copyright (c) 2016, Marcus Correa
 */
class AdminEspecies {

    private $Data;
    private $Cobranca;
    private $Error;
    private $Result;

    const Entity = 'especies_titulo'; //Nome da tabela no banco de dados

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para cadastrar uma Especie, favor preencha todos os campos!", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
        endif;

        $this->Create();
    }

    public function ExeUpdate($CobrancaId, array $Data) {
        $this->Cobranca = (int) $CobrancaId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar esta Especie, preencha todos os campos.", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
        endif;

        $this->Update();
    }

    public function ExeDelete($CobrancaId) {
        $this->Cobranca = (int) $CobrancaId;

        $readDados = new Read;
        $readDados->ExeRead(self::Entity, "WHERE id = :id", "id={$this->Cobranca}");

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
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->Cobranca}");
        if ($Update->getResult()):
            $this->Error = ["O registro foi atualizado com sucesso!", DS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id = :id", "id={$this->Cobranca}");
        if ($Delete->getResult()):
            $this->Result = true;
        endif;
    }

}

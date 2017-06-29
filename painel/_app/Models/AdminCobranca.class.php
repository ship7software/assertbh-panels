<?php
/*
 * AdminContatos.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os Contatos no Admin do sistema!
 * @copyright (c) 2016, Marcus Correa
 */
class AdminCobranca {

    private $Data;
    private $Cobranca;
    private $Error;
    private $Result;

    const Entity = 'cobranca'; //Nome da tabela no banco de dados

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para cadastrar uma Cobrança, favor preencha todos os campos!", DS_ALERT];
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
            $this->Error = ["Para atualizar este Contato, preencha todos os campos.", DS_ALERT];
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

    public function getUnidade($UserId) {
        $this->Unidade = (int) $UserId;

        $readUnidade = new Read;
        $readUnidade->ExeRead("unidades", "WHERE id = :user", "user={$this->Unidade}");

        return('Bloco: '.$readUnidade->getResult()[0]['bloco'].' - '.'Apto/Sala: '.$readUnidade->getResult()[0]['apto_sala'] );
    }

    public function getBanco($UserId) {
        $this->Condominio = (int) $UserId;

        $readCondominio = new Read;
        $readCondominio->ExeRead("condominios", "WHERE id = :user", "user={$this->Condominio}");

        return($readCondominio->getResult()[0]['banco_nome']);
    }

    function moeda($get_valor) {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function setData() {
        $valor = $this->Data['valor'];

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['valor'] = $this->moeda($valor);
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

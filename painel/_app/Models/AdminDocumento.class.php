<?php
/*
 * AdminDocumento.class [ MODEL ADMIN ]
 * Respnsável por gerenciar as Documentos no Admin do sistema!
 *
 * @copyright (c) 2014, Marcus Correa
 */

class AdminDocumento {

    private $Data;
    private $Docs;
    private $Error;
    private $Result;
    private $Condominio;

    const Entity = 'documentos';

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para cadastrar documentos, preencha todos os campos.", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            if ($this->Data['arquivo']):
                $uplaod = new Upload;
                $uplaod->File($this->Data['arquivo'], null ,'documentos/'.$this->Data['tipo_doc'].'/'.$this->Data['id_condominio'].'/', null);
            endif;

            if (isset($uplaod) && $uplaod->getResult()):
                $this->Data['arquivo'] = $uplaod->getResult();
                $this->Create();
            else:
                $this->Data['arquivo'] = null;
                $this->Create();
            endif;

        endif;
    }

    /**
     * <b>Deleta Post:</b> Informe o ID a ser removido para que esse método realize uma checagem de
     * pastas e imagens excluindo todos os dados necesários!
     */
    public function ExeDelete($DocId) {
        $this->Docs = (int) $DocId;

        $ReadDados = new Read;
        $ReadDados->ExeRead(self::Entity, "WHERE id = :foto", "foto={$this->Docs}");

        if (!$ReadDados->getResult()):
            $this->Error = ["O Documento que você tentou deletar não existe no sistema!", DS_ERROR];
            $this->Result = false;
        else:
            $DeleteDados = $ReadDados->getResult()[0];

            $docufile = '../uploads/documentos/'.$DeleteDados['tipo_doc'].'/'.$DeleteDados['id_condominio'].'/'.$DeleteDados['arquivo'];
            if (file_exists($docufile) && !is_dir($docufile)):
                unlink($docufile);
            endif;

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE id = :doc", "doc={$this->Docs}");

            $this->Error = ["O Documento foi removido com sucesso do sistema!", DS_ACCEPT];
            $this->Result = true;

        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
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
    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $Doc = $this->Data['arquivo'];
        unset($this->Data['arquivo']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['arquivo'] = $Doc;
    }

    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Error = ["O Documento foi cadastrado com sucesso no sistema!", DS_ACCEPT];
            $this->Result = $cadastra->getResult();
        endif;
    }

}

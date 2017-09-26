<?php
/*
 * AdminDocumento.class [ MODEL ADMIN ]
 * Respnsável por gerenciar as Documentos no Admin do sistema!
 *
 * @copyright (c) 2014, Marcus Correa
 */

class AdminRemessa {

    private $Data;
    private $Error;
    private $Result;
    private $Remessa;

    const Entity = 'remessa';

    public function ExeEnvia(array $Data, $Name) {
        $this->Data = $Data;

        $uplaod = new Upload;
        $uplaod->File($this->Data, $Name ,'remessas/', null);

        if (isset($uplaod) && $uplaod->getResult()):
            $this->Data = $uplaod->getResult();
            $this->Error = ["O arquivo foi enviado com sucesso!", DS_ACCEPT];
            $this->Result = true;
        else:
            $this->Data = null;
            $this->Error = ["O arquivo não enviado, tente novamente!", DS_ACCEPT];
            $this->Result = false;
        endif;

    }



    public function ExeDelete($RemessaId) {
        $this->Remessa = (int) $RemessaId;

        $readDados = new Read;
        $readDados->ExeRead(self::Entity, "WHERE id = :id", "id={$this->Remessa}");

        if (!$readDados->getResult()):
            $this->Error = ['Oppsss, você tentou remover um registro que não existe no sistema!', DS_ERROR];
            $this->Result = false;
        else:
            $this->Delete();
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id = :id", "id={$this->Remessa}");
        if ($Delete->getResult()):
            $this->Result = true;
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getData() {
        return $this->Data;
    }

    public function getError() {
        return $this->Error;
    }

}

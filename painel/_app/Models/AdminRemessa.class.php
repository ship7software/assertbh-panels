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

    const Entity = 'Remessa';

    public function ExeEnvia(array $Data) {
        $this->Data = $Data;

        $uplaod = new Upload;
        $uplaod->File($this->Data, null ,'remessas/', null);

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

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

}

<?php

/*
 * AdminFotos.class [ MODEL ADMIN ]
 * Respnsável por gerenciar as Fotos no Admin do sistema!
 *
 * @copyright (c) 2014, Marcus Correa
 */

class AdminFotos {

    private $Data;
    private $Foto;
    private $Error;
    private $Result;
    private $Produto;

    const Entity = 'fotos';

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para cadastrar imagens, preencha todos os campos.", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            if ($this->Data['imagem']):
                $uplaod = new Upload;
                $uplaod->Image($this->Data['imagem'], null, null, 'produtos/');

            endif;

            if (isset($uplaod) && $uplaod->getResult()):
                $this->Data['imagem'] = $uplaod->getResult();
                $this->Create();
            else:
                $this->Data['imagem'] = null;
                $this->Create();
            endif;

        endif;
    }

    public function gbSend(array $Images, $ProdutoId){
        $this->Produto = (int) $ProdutoId;
        $this->Data = $Images;

        $gbFiles = array();
        $gbCount = count($this->Data['tmp_name']);
        $gbKeys = array_keys($this->Data);

        for ($gb = 0; $gb < $gbCount; $gb++):
            foreach ($gbKeys as $Keys):
                $gbFiles[$gb][$Keys] = $this->Data[$Keys][$gb];
            endforeach;
        endfor;

        $gbSend = new Upload;

        $i = 0;
        $u = 0;

        foreach($gbFiles as $gbUpload):
            $i++;
            $gbSend->Image($gbUpload, null, null, 'produtos/');

            if($gbSend->getResult()):
                $gbImage = $gbSend->getResult();
                $gbCreate = ['id_produto' => $this->Produto, 'imagem'=>$gbImage ];
                $insertGb = new Create;
                $insertGb->ExeCreate('fotos', $gbCreate);
            endif;
        endforeach;

    }

    /**
     * <b>Atualizar Post:</b> Envelope os dados em uma array atribuitivo e informe o id de um
     * post para atualiza-lo na tabela!
     * @param INT $CorretorId = Id do corretor
     * @param ARRAY $Data = Atribuitivo
     */

    public function ExeUpdate($FotoId, array $Data) {
        $this->Foto = (int) $FotoId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar esta Galeria, preencha todos os campos.", DS_ALERT];
            $this->Result = false;
        else:
            $this->setData();

            if (is_array($this->Data['imagem'])):
                $readImagem = new Read;
                $readImagem->ExeRead(self::Entity, "WHERE id = :foto", "foto={$this->Foto}");
                $foto = '../uploads/fotos/'. $readImagem->getResult()[0]['imagem'];
                if (file_exists($foto) && !is_dir($foto)):
                    unlink($foto);
                endif;

                $uploadFoto = new Upload;
                $uploadFoto->Image($this->Data['imagem'], null, null, 'fotos/');
            endif;

            if (isset($uploadFoto) && $uploadFoto->getResult()):
                $this->Data['imagem'] = $uploadFoto->getResult();
                $this->Update();
            else:
                unset($this->Data['imagem']);
                $this->Update();
            endif;
        endif;
    }

    /**
     * <b>Deleta Post:</b> Informe o ID a ser removido para que esse método realize uma checagem de
     * pastas e imagens excluindo todos os dados necesários!
     */
    public function ExeDelete($FotoId) {
        $this->Foto = (int) $FotoId;

        $ReadDados = new Read;
        $ReadDados->ExeRead(self::Entity, "WHERE id = :foto", "foto={$this->Foto}");

        if (!$ReadDados->getResult()):
            $this->Error = ["A imagem que você tentou deletar não existe no sistema!", DS_ERROR];
            $this->Result = false;
        else:
            $DeleteDados = $ReadDados->getResult()[0];
            if (file_exists('../uploads/produtos/'. $DeleteDados['imagem']) && !is_dir('../uploads/produtos/' . $DeleteDados['imagem'])):
                unlink('../uploads/produtos/'. $DeleteDados['imagem']);
            endif;

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE id = :imagem", "imagem={$this->Foto}");

            $this->Error = ["A imagem foi removida com sucesso do sistema!", DS_ACCEPT];
            $this->Result = true;

        endif;
    }

    public function getImagem($FotoId) {
        $this->Foto = (int) $FotoId;

        $readFoto = new Read;
        $readFoto->ExeRead(self::Entity, "WHERE id = :galeria", "galeria={$this->Foto}");

        $foto = '../uploads/produtos/'. $readFoto->getResult()[0]['imagem'];
        if (file_exists($foto) && !is_dir($foto)):
            return($readFoto->getResult()[0]['imagem']);
        endif;
    }

    public function getNomeProduto($ProdutoId) {
        $this->Produto = (int) $ProdutoId;

        $readFotos = new Read;
        $readFotos->ExeRead("produtos", "WHERE id = :fotos", "fotos={$this->Produto}");

        if ($readFotos->getResult()):
            return $readFotos->getResult()[0]['nome'];
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
    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $Foto = $this->Data['imagem'];
        unset($this->Data['imagem']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['imagem'] = $Foto;
    }

    //Cadastra a noticia no banco!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Error = ["A imagem foi cadastrada com sucesso no sistema!", DS_ACCEPT];
            $this->Result = $cadastra->getResult();
        endif;
    }
    //Atualiza a noticia no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->Foto}");
        if ($Update->getResult()):
            $this->Error = ["A imagem foi atualizada com sucesso no sistema!", DS_ACCEPT];
            $this->Result = true;
        endif;
    }
}

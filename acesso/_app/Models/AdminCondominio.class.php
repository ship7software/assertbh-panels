<?php

/*
 * AdminUser.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os Condominios no Admin do sistema!
 * @copyright (c) 2014, Marcus Correa
 */
class AdminCondominio {

    private $Data;
    private $User;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'condominios';

    /*
     * <b>Cadastrar Usuário:</b> Envelope os dados de um usuário em um array atribuitivo e execute esse método
     * para cadastrar o mesmo no sistema. Validações serão feitas!
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->checkData();

        if ($this->Data['imagem']):
            $uplaod = new Upload;
            $uplaod->Image($this->Data['imagem'], null, null, self::Entity.'/');
        endif;

        if (isset($uplaod) && $uplaod->getResult()):
            $this->Data['imagem'] = $uplaod->getResult();
            $this->Create();
        else:
            $this->Data['imagem'] = null;
            $this->Create();
        endif;
    }

    /*
     * <b>Atualizar Usuário:</b> Envelope os dados em uma array atribuitivo e informe o id de um
     * usuário para atualiza-lo no sistema!
     * @param INT $UserId = Id do usuário
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($UserId, array $Data) {
        $this->User = (int) $UserId;
        $this->Data = $Data;

        if (!$this->Data['senha']):
            unset($this->Data['senha']);
        endif;

        $this->checkData();
        if (is_array($this->Data['imagem'])):
            $readImagem = new Read;
            $readImagem->ExeRead(self::Entity, "WHERE id = :user", "user={$this->User}");
            $fotoUser = '../uploads/'.self::Entity.'/' . $readImagem->getResult()[0]['imagem'];
            if (file_exists($fotoUser) && !is_dir($fotoUser)):
                unlink($fotoUser);
            endif;

            $uploadFoto = new Upload;
            $uploadFoto->Image($this->Data['imagem'], null, null, self::Entity.'/');
        endif;

        if (isset($uploadFoto) && $uploadFoto->getResult()):
            $this->Data['imagem'] = $uploadFoto->getResult();
            $this->Update();
        else:
            unset($this->Data['imagem']);
            $this->Update();
        endif;
    }

    /*
     * <b>Remover Usuário:</b> Informe o ID do usuário que deseja remover. Este método não permite deletar
     * o próprio perfil ou ainda remover todos os ADMIN'S do sistema!
     * @param INT $UserId = Id do usuário
     */
    public function ExeDelete($UserId) {
        $this->User = (int) $UserId;

        $readUser = new Read;
        $readUser->ExeRead(self::Entity, "WHERE id = :id", "id={$this->User}");

        if (!$readUser->getResult()):
            $this->Error = ['Oppsss, você tentou remover um condominios que não existe no sistema!', DS_ERROR];
            $this->Result = false;
        else:
            $DeleteDados = $readUser->getResult()[0];
            if (file_exists('../uploads/'.self::Entity.'/' . $DeleteDados['imagem']) && !is_dir($DeleteDados['imagem'])):
                unlink('../uploads/'.self::Entity.'/' . $DeleteDados['imagem']);
            endif;
            $this->Delete();
        endif;
    }

    /*
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não.
     * Para verificar erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /*
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    public function getImagem($UserId) {
        $this->User = (int) $UserId;

        $readFoto = new Read;
        $readFoto->ExeRead(self::Entity, "WHERE id = :user", "user={$this->User}");

        $foto = '../uploads/'.self::Entity.'/' . $readFoto->getResult()[0]['imagem'];
        if (file_exists($foto) && !is_dir($foto)):
            return($readFoto->getResult()[0]['imagem']);
        endif;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Verifica os dados digitados no formulário
    private function checkData() {
        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", DS_ALERT];
            $this->Result = false;
        elseif (!Check::Email($this->Data['email'])):
            $this->Error = ["O e-email informado não parece ter um formato válido!", DS_ALERT];
            $this->Result = false;
        elseif (isset($this->Data['senha']) && (strlen($this->Data['senha']) < 6 || strlen($this->Data['senha']) > 12)):
            $this->Error = ["A senha deve ter entre 6 e 12 caracteres!", DS_INFOR];
            $this->Result = false;
        else:
            $this->checkEmail();
        endif;
    }

    //Verifica usuário pelo e-mail, Impede cadastro duplicado!
    private function checkEmail() {
        $Where = ( isset($this->User) ? "id != {$this->User} AND" : '');

        $readUser = new Read;
        $readUser->ExeRead(self::Entity, "WHERE {$Where} email = :email", "email={$this->Data['email']}");

        if ($readUser->getRowCount()):
            $this->Error = ["O e-email informado foi cadastrado no sistema por outro usuário! Informe outro e-mail!", DS_ERROR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    //Cadasrtra Usuário!
    private function Create() {
        $Create = new Create;
        $this->Data['senha'] = md5($this->Data['senha']);

        $Create->ExeCreate(self::Entity, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O condominio <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!", DS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    //Atualiza Usuário!
    private function Update() {
        $Update = new Update;
        if (isset($this->Data['senha'])):
            $this->Data['senha'] = md5($this->Data['senha']);
        endif;

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->User}");
        if ($Update->getResult()):
            $this->Error = ["O condominio <b>{$this->Data['nome']}</b> foi atualizado com sucesso!", DS_ACCEPT];
            $this->Result = true;
        endif;
    }

    //Remove Usuário
    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id = :id", "id={$this->User}");
        if ($Delete->getResult()):
            $this->Error = ["Condominio removido com sucesso do sistema!", DS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
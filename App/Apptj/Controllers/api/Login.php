<?php

namespace App\Apptj\Controllers\Api;

use App\Apptj\Models\{
    LogginAttemps,Users
};
use SKYCore\Controllers\RestController;
use SKYCore\Traits\Helpers\Authentication;

class Login extends RestController
{
    protected $disable_auth = true;

    use Authentication;

    public function login()
    {
        $this->type('POST');

        $responde = new class{
            var $status = '0';
            var $message = [];
         };

        $post = $this->post_content();

        /** @var Users $user */
        $user = new Users();
        $user = $user->findOneBy(['email' => $post->email]);

        if($user){

            $loggin_attemps = LogginAttemps::getAllDataBy(['user_id' => $user->id]);
            $cnt_loggin_attemps = count($loggin_attemps);

            if($user->status === 0){
                $responde->message[] ='Usuario não ativado, verifique sua caixa de emails ou peça para um administrador desbloquear.';
            } else {

                if($cnt_loggin_attemps < 5){

                    if($this->check_hash($post->password,$user->password)){

                        $company = $user->getCompany();

                        LogginAttemps::deleteAllByStatic(['user_id' => $user->id]);

                        $user_data = array(
                            'user_logged' => true,
                            'system' => array(
                                'session_id' => session_id(),
                                'session_db_id' => null,
                                'sessin_start' => date('Y-m-d H:i:s')
                            ),
                            'user' => array(
                                'id' => $user->id,
                                'group' => $user->group,
                                'name' => $user->username,
                                'mail' => $user->email,
                                'ip'=> $this->request->server->get('REMOTE_ADDR')
                            ),
                            'company' => array(
                                'id' => $company->id,
                                'name' => $company->name
                            )
                        );

                        $this->session->setSession($user_data);

                        $responde->status = '1';
                        $responde->message[] = 'Login realizado com sucesso!';
                    } else {
                        $erro_login = new LogginAttemps();
                        $erro_login->user_id = $user->id;
                        $erro_login->flush();

                        $responde->message[] ='Usuario ou Senha invalidos, verifique os campos digitados.';
                    }

                } else {
                    $responde->message[] ='Usuario bloqueado, entre em contato com o administrador.';
                }
            }
        } else {
            $responde->message[] ='Usuario ou Senha invalidos, verifique os campos digitados.';
        }

        echo json_encode($responde);
    }

    public function password_recovery()
    {
        
    }
}
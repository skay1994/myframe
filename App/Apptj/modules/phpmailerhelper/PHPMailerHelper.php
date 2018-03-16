<?php

namespace PHPMailerHelper;

use PHPMailer\PHPMailer\PHPMailer;
use SKYCore\Traits\Helpers\configurations;

class PHPMailerHelper
{
    use configurations;

    /**
     * @var PHPMailer
     */
    private $phpmailer;

    public function __construct()
    {
        $phpmailer = new PHPMailer;

        if($this->getConfigs('phpmailer_isSMTP')){
            $phpmailer->isSMTP();
        }

        $phpmailer->host = $this->getConfigs('phpmailer_isSMTP');
        $phpmailer->SMTPAuth = $this->getConfigs('phpmailer_SMTPAuth');
        $phpmailer->Username = $this->getConfigs('phpmailer_Username');
        $phpmailer->Password = $this->getConfigs('phpmailer_Password');
        $phpmailer->SMTPSecure = $this->getConfigs('phpmailer_SMTPSecure');
        $phpmailer->Port = $this->getConfigs('phpmailer_Port');

        $this->phpmailer = $phpmailer;
    }
}
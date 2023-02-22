<?php

namespace controller\primary;

use DateTime;
use Exception;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class mail extends Service
{

    use UserBearerData;

    /**
     * @throws Exception
     * @auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['html'] === '') {
            throw new Exception($this->say('HTML_REQUIRED'));
        }
        if ($param['css'] === '') {
            throw new Exception($this->say('CSS_REQUIRED'));
        }
        if ($param['mail_name'] === '') {
            throw new Exception($this->say('MAIL_NAME_REQUIRED'));
        }
        if ($param['mail_address'] === '') {
            throw new Exception($this->say('MAIL_ADDRESS_REQUIRED'));
        }
        if ($param['mail_password'] === '') {
            throw new Exception($this->say('MAIL_PASSWORD_REQUIRED'));
        }
        if ($param['cc'] === '') {
            throw new Exception($this->say('CC_REQUIRED'));
        }
        if ($param['bcc'] === '') {
            throw new Exception($this->say('BCC_REQUIRED'));
        }
        if ($param['reply_to'] === '') {
            throw new Exception($this->say('REPLY_TO_REQUIRED'));
        }
        if ($param['host'] === '') {
            throw new Exception($this->say('HOST_REQUIRED'));
        }
        if ($param['port'] === '') {
            throw new Exception($this->say('PORT_REQUIRED'));
        }
        if ($param['smtp_auth'] === '') {
            throw new Exception($this->say('SMTP_AUTH_REQUIRED'));
        }
        if ($param['smtp_secure'] === '') {
            throw new Exception($this->say('SMTP_SECURE_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['css_external'] === '') {
            throw new Exception($this->say('CSS_EXTERNAL_REQUIRED'));
        }


        //validations: customize here

        //insert
        $mail = new \plugins\model\primary\mail();
        $mail->id = $param['id'];
        $mail->user_id = $param['user_id'];
        $mail->html = $param['html'];
        $mail->css = $param['css'];
        $mail->mail_name = $param['mail_name'];
        $mail->mail_address = $param['mail_address'];
        $mail->mail_password = $param['mail_password'];
        $mail->cc = $param['cc'];
        $mail->bcc = $param['bcc'];
        $mail->reply_to = $param['reply_to'];
        $mail->host = $param['host'];
        $mail->port = $param['port'];
        $mail->smtp_auth = $param['smtp_auth'];
        $mail->smtp_secure = $param['smtp_secure'];
        $mail->request_type = $param['request_type'];
        $mail->request_url = $param['request_url'];
        $mail->request_sample = $param['request_sample'];
        $mail->css_external = $param['css_external'];


        $mail->save();

        //response
        $data['mail'] = [
            'id' => $mail->id,
            'user_id' => $mail->user_id,
            'html' => $mail->html,
            'css' => $mail->css,
            'mail_name' => $mail->mail_name,
            'mail_address' => $mail->mail_address,
            'mail_password' => $mail->mail_password,
            'cc' => $mail->cc,
            'bcc' => $mail->bcc,
            'reply_to' => $mail->reply_to,
            'host' => $mail->host,
            'port' => $mail->port,
            'smtp_auth' => $mail->smtp_auth,
            'smtp_secure' => $mail->smtp_secure,
            'request_type' => $mail->request_type,
            'request_url' => $mail->request_url,
            'request_sample' => $mail->request_sample,
            'css_external' => $mail->css_external,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * @auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['html'] === '') {
            throw new Exception($this->say('HTML_REQUIRED'));
        }
        if ($param['css'] === '') {
            throw new Exception($this->say('CSS_REQUIRED'));
        }
        if ($param['mail_name'] === '') {
            throw new Exception($this->say('MAIL_NAME_REQUIRED'));
        }
        if ($param['mail_address'] === '') {
            throw new Exception($this->say('MAIL_ADDRESS_REQUIRED'));
        }
        if ($param['mail_password'] === '') {
            throw new Exception($this->say('MAIL_PASSWORD_REQUIRED'));
        }
        if ($param['cc'] === '') {
            throw new Exception($this->say('CC_REQUIRED'));
        }
        if ($param['bcc'] === '') {
            throw new Exception($this->say('BCC_REQUIRED'));
        }
        if ($param['reply_to'] === '') {
            throw new Exception($this->say('REPLY_TO_REQUIRED'));
        }
        if ($param['host'] === '') {
            throw new Exception($this->say('HOST_REQUIRED'));
        }
        if ($param['port'] === '') {
            throw new Exception($this->say('PORT_REQUIRED'));
        }
        if ($param['smtp_auth'] === '') {
            throw new Exception($this->say('SMTP_AUTH_REQUIRED'));
        }
        if ($param['smtp_secure'] === '') {
            throw new Exception($this->say('SMTP_SECURE_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['css_external'] === '') {
            throw new Exception($this->say('CSS_EXTERNAL_REQUIRED'));
        }


        //validations: customize here

        //update
        $mail = new \plugins\model\primary\mail($id);
        $mail->id = $param['id'];
        $mail->user_id = $param['user_id'];
        $mail->html = $param['html'];
        $mail->css = $param['css'];
        $mail->mail_name = $param['mail_name'];
        $mail->mail_address = $param['mail_address'];
        $mail->mail_password = $param['mail_password'];
        $mail->cc = $param['cc'];
        $mail->bcc = $param['bcc'];
        $mail->reply_to = $param['reply_to'];
        $mail->host = $param['host'];
        $mail->port = $param['port'];
        $mail->smtp_auth = $param['smtp_auth'];
        $mail->smtp_secure = $param['smtp_secure'];
        $mail->request_type = $param['request_type'];
        $mail->request_url = $param['request_url'];
        $mail->request_sample = $param['request_sample'];
        $mail->css_external = $param['css_external'];


        $mail->modify();

        //response
        $data['mail'] = [
            'id' => $mail->id,
            'user_id' => $mail->user_id,
            'html' => $mail->html,
            'css' => $mail->css,
            'mail_name' => $mail->mail_name,
            'mail_address' => $mail->mail_address,
            'mail_password' => $mail->mail_password,
            'cc' => $mail->cc,
            'bcc' => $mail->bcc,
            'reply_to' => $mail->reply_to,
            'host' => $mail->host,
            'port' => $mail->port,
            'smtp_auth' => $mail->smtp_auth,
            'smtp_secure' => $mail->smtp_secure,
            'request_type' => $mail->request_type,
            'request_url' => $mail->request_url,
            'request_sample' => $mail->request_sample,
            'css_external' => $mail->css_external,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @throws Exception
     * @auth bearer true
     */
    public function delete($id = '')
    {
        $mail = new \plugins\model\primary\mail($id);

        //delete logic here

        return [
            'deleted' => true
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function explore()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here

        return \model\primary\mailContracts::SearchDataPagination($keyword);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function search()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here

        $data['mail'] = \model\primary\mailContracts::SearchData($keyword);
        return $data;
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function table()
    {
        $keyword = [];

        //post addition filter here

        return \model\primary\mailContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $mail = new \plugins\model\primary\mail($id);

        //response
        $data['mail'] = [
            'id' => $mail->id,
            'user_id' => $mail->user_id,
            'html' => $mail->html,
            'css' => $mail->css,
            'mail_name' => $mail->mail_name,
            'mail_address' => $mail->mail_address,
            'mail_password' => $mail->mail_password,
            'cc' => $mail->cc,
            'bcc' => $mail->bcc,
            'reply_to' => $mail->reply_to,
            'host' => $mail->host,
            'port' => $mail->port,
            'smtp_auth' => $mail->smtp_auth,
            'smtp_secure' => $mail->smtp_secure,
            'request_type' => $mail->request_type,
            'request_url' => $mail->request_url,
            'request_sample' => $mail->request_sample,
            'css_external' => $mail->css_external,

        ];

        return $data;
    }

}

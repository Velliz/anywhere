<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\usersContracts;
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
        if ($param['mail_name'] === '') {
            throw new Exception($this->say('MAIL_NAME_REQUIRED'));
        }
        if ($param['mail_address'] === '') {
            throw new Exception($this->say('MAIL_ADDRESS_REQUIRED'));
        }

        //validations: customize here

        //insert
        $mail = new \plugins\model\primary\mail();
        $mail->created = $this->GetServerDateTime();
        $mail->cuid = $this->user['id'];

        $mail->user_id = $this->user['id'];

        $mail->mail_name = $param['mail_name'];
        $mail->mail_address = $param['mail_address'];
        $mail->mail_password = '';

        $mail->host = 'smtp.gmail.com';
        $mail->port = 587;

        $mail->smtp_auth = 'true';
        $mail->smtp_secure = 'tls';

        $mail->request_type = 'POST';
        $mail->request_url = '';

        $mail->html = "<div>Welcome to Anywhere!</div>";
        $mail->css = "body {}";

        $request_sample = [
            'to' => 'example@anywhere.com',
            'subject' => 'Test Email',
            'attachment' => [
                [
                    'name' => 'attachment1',
                    'url' => 'http://localhost/anywhere/qr/render?data=attachment1'
                ],
                [
                    'name' => 'attachment2',
                    'url' => 'http://localhost/anywhere/qr/render?data=attachment2'
                ]
            ]
        ];

        $mail->request_sample = json_encode($request_sample, JSON_PRETTY_PRINT);

        $mail->save();

        //response
        $data['mail'] = [
            'id' => $mail->id,
            'user' => usersContracts::GetById($mail->user_id),
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
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
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

        //validations: customize here

        //update
        $mail = new \plugins\model\primary\mail($id);
        $mail->modified = $this->GetServerDateTime();
        $mail->muid = $this->user['id'];

        $mail->user_id = $this->user['id'];

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

        $mail->modify();

        //response
        $data['mail'] = [
            'id' => $mail->id,
            'user' => usersContracts::GetById($mail->user_id),
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
        $mail->modified = $this->GetServerDateTime();
        $mail->muid = $this->user['id'];

        //delete logic here
        $mail->dflag = 1;
        $mail->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $keyword['user_id'] = $this->user['id'];

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
            'user' => usersContracts::GetById($mail->user_id),
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

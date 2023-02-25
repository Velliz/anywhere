<?php

namespace controller\api;

use Exception;
use model\primary\digital_sign_usersContracts;
use model\primary\digital_signsContracts;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class digitalsigns extends Service
{

    /**
     * @return array
     * @throws Exception
     */
    public function verify()
    {
        $param = Request::JsonBody();
        if ($param['hash'] === '') {
            throw new Exception('Hash code required!');
        }

        $signing = digital_signsContracts::SearchData([
            'digital_sign_hash' => $param['hash']
        ]);
        if (sizeof($signing) === 0) {
            throw new Exception('Invalid digital signature!');
        }

        $data = [];
        foreach ($signing as $item) {
            $data['Signing'] = [
                'Created' => $item['created'],
                'DocumentName' => $item['document_name'],
                'Location' => $item['location'],
                'Reason' => $item['reason']
            ];
            $users = digital_sign_usersContracts::SearchData([
                'email' => $item['email']
            ]);
            foreach ($users as $user) {
                $data['User'] = [
                    'Name' => $user['name'],
                    'Phone' => $user['phone'],
                    'Email' => $user['email'],
                    'OrgUnit' => $user['org_unit'],
                    'WorkUnit' => $user['work_unit'],
                    'Position' => $user['position']
                ];
            }
        }

        return $data;
    }

}

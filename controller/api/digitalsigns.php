<?php

namespace controller\api;

use Exception;
use model\DigitalSignModel;
use model\DigitalSignUserModel;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class digitalsigns extends Service
{

    /**
     * @param string $hash
     * @return array
     * @throws Exception
     */
    public function verify()
    {
        $param = Request::JsonBody();
        if ($param['hash'] === '') {
            throw new Exception('Hash code required!');
        }

        $signing = DigitalSignModel::SearchData([
            'digitalsignhash' => $param['hash']
        ]);
        if (sizeof($signing) === 0) {
            throw new Exception('Invalid digital signature!');
        }

        $data = [];
        foreach ($signing as $item) {
            $data['Signing'] = [
                'Created' => $item['created'],
                'DocumentName' => $item['documentname'],
                'Location' => $item['location'],
                'Reason' => $item['reason']
            ];
            $users = DigitalSignUserModel::SearchData([
                'email' => $item['email']
            ]);
            foreach ($users as $user) {
                $data['User'] = [
                    'Name' => $user['name'],
                    'Phone' => $user['phone'],
                    'Email' => $user['email'],
                    'OrgUnit' => $user['orgunit'],
                    'WorkUnit' => $user['workunit'],
                    'Position' => $user['position']
                ];
            }
        }

        return $data;
    }

}

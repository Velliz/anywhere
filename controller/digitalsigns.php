<?php

namespace controller;

use Exception;
use model\primary\digital_sign_usersContracts;
use model\primary\digital_signsContracts;
use plugins\model\primary\digital_sign_users;
use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Signing Users
 */
class digitalsigns extends View
{

    /**
     * @return array
     * #Value PageTitle Digital sign user
     */
    public function users($id_digitalsign_users = '')
    {
        $dsu = new digital_sign_users($id_digitalsign_users);
        $data['email'] = $dsu->email;

        $data['id_digitalsign_users'] = $id_digitalsign_users;
        $data['api_key'] = digital_sign_usersContracts::GetApiKeyById($id_digitalsign_users);

        return $data;
    }

    /**
     * #Master master-codes.html
     * @return array
     * #Value PageTitle Digital sign user
     */
    public function timeline($id_digitalsign_users = '')
    {
        $dsu = new digital_sign_users($id_digitalsign_users);
        $data['email'] = $dsu->email;

        $data['id_digitalsign_users'] = $id_digitalsign_users;
        $data['api_key'] = digital_sign_usersContracts::GetApiKeyById($id_digitalsign_users);

        return $data;
    }

    /**
     * @param string $hash
     * @throws Exception
     * #Value PageTitle Signing Verification
     * #Template master false
     */
    public function verify(string $hash = '')
    {
        $signing = digital_signsContracts::SearchData([
            'digital_sign_hash' => $hash
        ]);
        if (sizeof($signing) === 0) {
            header('Content-Type: text');
            die($this->say('INVALID_DIGITAL_SIGNATURE'));
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
                    'Address' => $user['address'],
                    'Phone' => $user['phone'],
                    'Email' => $user['email'],
                    'OrgUnit' => $user['org_unit'],
                    'WorkUnit' => $user['work_unit'],
                    'Position' => $user['position']
                ];
            }
        }

        return array_merge($data['Signing'], $data['User']);
    }

}

<?php

namespace controller;

use Exception;
use model\DigitalSignModel;
use model\DigitalSignUserModel;
use plugins\controller\AnywhereView;

/**
 * #Master master.html
 * #Value title Signing Users
 */
class digitalsigns extends AnywhereView
{

    public function users()
    {
    }

    /**
     * @param string $hash
     * @return array
     * @throws Exception
     * #Value title Signing Verification
     * #Template master false
     */
    public function verify($hash = '')
    {
        $signing = DigitalSignModel::SearchData([
            'digitalsignhash' => $hash
        ]);
        if (sizeof($signing) === 0) {
            header('Content-Type: text');
            die("INVALID DIGITAL SIGNATURE!\nPlease contact the document publisher to confirm that you obtain the original file sealed with valid Digital Signing.");
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
                    'Address' => $user['address'],
                    'Phone' => $user['phone'],
                    'Email' => $user['email'],
                    'OrgUnit' => $user['orgUnit'],
                    'WorkUnit' => $user['workUnit'],
                    'Position' => $user['position']
                ];
            }
        }
        return array_merge($data['Signing'], $data['User']);
    }

}

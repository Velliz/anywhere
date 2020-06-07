<?php

namespace controller\api;

use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class convert extends Service
{

    /**
     * @param string $from
     * @throws Exception
     */
    public function topdf($from = '')
    {
        $files = Request::Post('file', null);
        if ($files === null) {
            throw new Exception('files required');
        }

        switch ($from) {
            case 'jpeg':
            case 'jpg':

                break;
            case 'spreadsheet':

                break;
            case 'word':

                break;
            case 'text':

                break;
            default:
                throw new Exception('file type not supported');
                break;
        }
    }

}
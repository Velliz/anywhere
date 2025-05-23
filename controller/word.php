<?php

namespace controller;

use Exception;
use model\primary\wordContracts;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use plugins\controller\AnywhereView;

/**
 * Class word
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 * #Value PageTitle Word Templates
 */
class word extends AnywhereView
{

    /**
     * @param $id_word
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function update($id_word)
    {
        $data['id_word'] = $id_word;
        $data['api_key'] = wordContracts::GetApiKeyById($id_word);

        return $data;
    }

    /**
     * @param $id_word
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function html($id_word)
    {


    }

    /**
     * @param $id_word
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function style($id_word)
    {
    }

    /**
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function coderender($api_key, $wordId)
    {

        $html = '
<h2 style="text-align:center;">INVOICE</h2>

<table width="100%" style="margin-bottom:20px;">
    <tr>
        <td>
            <strong>From:</strong><br />
            My Company<br />
            123 Business Street<br />
            Jakarta, Indonesia<br />
            Email: hello@mycompany.com
        </td>
        <td align="right">
            <strong>To:</strong><br />
            Client Name<br />
            456 Client Road<br />
            Surabaya, Indonesia<br />
            Email: client@example.com
        </td>
    </tr>
</table>

<table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
    <thead>
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Web Development Services</td>
            <td>1</td>
            <td>$1000</td>
            <td>$1000</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Hosting (12 months)</td>
            <td>1</td>
            <td>$120</td>
            <td>$120</td>
        </tr>
    </tbody>
</table>

<p style="text-align:right; margin-top:10px;">
    <strong>Subtotal:</strong> $1120<br />
    <strong>Tax (10%):</strong> $112<br />
    <strong>Total:</strong> <strong>$1232</strong>
</p>

<p>Thank you for your business!</p>
';

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Load HTML into the section
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

        $filename = "document.docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
        exit;

    }

    /**
     * #Template master false
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function render($api_key, $wordId)
    {

    }

    /**
     * @param $logID
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function timelinerender($logID, $api_key, $wordId)
    {

    }

    /**
     * @param $id_word
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function timeline($id_word)
    {

    }

}

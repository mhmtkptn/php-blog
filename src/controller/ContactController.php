<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 28.07.2017
 * Time: 11:17
 */

namespace src\controller;

use src\adapter\ContactAdapter;

class ContactController extends Controller
{

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select()
    {
        $contactDatas = [];
        $contactAdapter = new ContactAdapter();
        $contactAdapter->select ("Contact");
        $contactAdapter->execute();
        while ($row = $contactAdapter->getResult()->fetch_assoc()){
            $contactDatas[] = $row;
        }
        $returnData= [
            "blogs" => $contactDatas,
        ];
        return $returnData;
    }


    /**
     * @param $postData
     */
    public function insert($postData)
    {
        $contact = new \src\entity\Contact();
        $contactAdapter = new \src\adapter\ContactAdapter();
        $contact->setNameSurname($postData["nameSurname"])
            ->setEMail($postData["eMail"])
            ->setTitle($postData["title"])
            ->setMessage($postData["message"]);
        $contactAdapter->insert($contact);
        $contactAdapter->execute();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 20.07.2017
 * Time: 15:05
 */

namespace src\controller;


use src\adapter\MemberAdapter;
use \XMLWriter;


class MemberController extends Controller
{
    public function check()
    {
        // TODO: Implement check() method.
    }

    public function insert($postMember)
    {

        $member = new \src\entity\Member();
        $memberAdapter = new \src\adapter\MemberAdapter();
        $member->setNameSurname($postMember["nameSurname"])
            ->setMemberName(strtolower($postMember["memberName"]))
            ->setEMail(strtolower($postMember["eMail"]))
            ->setPassword($postMember["password"]);
        $memberAdapter->insert($member);
        $memberAdapter->execute();

    }

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
        return $this->loadMembers();
    }

    public function export()
    {
        if ($_POST) {
            $members = $this->loadMembers();
            $xmlExport = new XMLWriter();
            $xmlExport->openMemory();

//veritabanındaki veriyi xml olarak export edeceğimiz dosyayı belirledik
            $xmlExport->openURI("member_export.xml");

//xml versiyon ve karakter seti tanımlayarak başlattık
            $xmlExport->startDocument('1.0', 'utf-8');
            $xmlExport->setIndent(true);
//element adını belirledik
            $xmlExport->startElement('blog');

            foreach ($members as $member) {
                $xmlExport->startElement('member');
                $xmlExport->writeAttribute('id', $member['id']);
                $xmlExport->writeAttribute('nameSurname', $member['categoryId']);
                $xmlExport->writeAttribute('userName', $member['memberName']);
                $xmlExport->writeAttribute('password', $member['password']);
                $xmlExport->writeAttribute('eMail', $member['eMail']);
                $xmlExport->endElement();
            }
            $xmlExport->endElement();
            echo "Member tablosu başarıyla export edildi";
            $xmlExport->flush();
        }
        return [];
    }

    public function login()
    {
        $loginName = $_POST['loginName'];
        $password = md5($_POST['password']);

        if (isset($_POST['loginName']) && isset($_POST['password'])) {

            $memberAdapter = new \src\adapter\MemberAdapter();
            $memberAdapter->select("Member", ["where" => ["and" => ["memberName" => $loginName, "password" => $password]]]);
            $memberAdapter->execute();

            if ($memberAdapter->getResult()->num_rows !== 0) {
                $_SESSION["memberLogin"] = array('memberName' => $_POST["loginName"], 'ipAdd' => $_SERVER['SERVER_ADDR'], 'loggedIn' => true);


                var_dump($_SESSION["memberLogin"]);
                header("Location=blog/index");

            } else {
                echo("Kullanıcı adınız veya şifreniz hatalı");
            }

        }


        //
        $this->redirectUrl("/blog/index");
        return array("deneme", "deneme2");
    }

    /**
     * @return array
     */
    private function loadMembers()
    {
        $memberDatas = [];
        $memberAdapter = new MemberAdapter();
        $memberAdapter->select("Member");
        $memberAdapter->execute();
        while ($row = $memberAdapter->getResult()->fetch_assoc()) {
            $memberDatas[] = $row;
        }
        return $memberDatas;
    }


    public function logOut()
    {

        $memberAdapter = new MemberAdapter();
        $memberAdapter->logOut();
        return $this->redirectUrl("/blog/index");

    }

}



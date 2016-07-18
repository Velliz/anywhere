---
layout: post
title: Puko Database Access
---

Configuration for database located in **config/database.php** file

```PHP
return array(
    'dbType' => 'MySQL',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbName' => 'puko',
);
```

Until **PUKO 0.93.0** only MySQL database supported. Other database type coming soon.

PUKO use MVC pattern, so Database take Model part for MVC architecture.
Model file can be located in model directory. Lets take a look model class sample:

```PHP
namespace Model;

use Puko\Core\Backdoor\Data;
use Puko\Core\Backdoor\Model;

class Member extends Model
{

    public static function GetMember()
    {
        return Data::From('SELECT * FROM `member`')->FetchAll();
    }

    public static function GetMemberByID($idMember)
    {
        return Data::From('SELECT * FROM `member` WHERE `ID` = @1')->FetchAll($idMember);
    }

    public static function AddMember($arrayMember)
    {
        $model = new Model('member');
        return $model->Save($arrayMember);
    }
}
```

That is sample for Select and Creating new Member Data. Member.php class can called in controller. 
For example:

```PHP
use Model\Member;
use Puko\Core\Presentation\View;

class Main extends View
{

    private $id;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
     * #Value PageTitle Selamat Datang
     * @return mixed
     */
    public function Main()
    {
        if($this->IsSubmit() && $this->ValidateCsrf()) {
            Member::AddMember(array(
                'Name' => $_POST['name'],
                'Mail' => $_POST['mail'],
                'Username' => $_POST['username'],
                'Password' => $_POST['password'],
                'Age' => $_POST['age'],
            ));
        }

        $var['Member'] = Member::GetMember();
        return $var;
    }
}
```

As simple as that. Now you have part of Model and Controller for Online Registation App. And now lets take a look on View parts:

```HTML
<h1>Pendaftaran Member</h1>
<form action="" method="post">
    <input type="hidden" name="token" value="{!token}">
    <input type="text" name="name" placeholder="name"><br>
    <input type="email" name="mail" placeholder="mail"><br>
    <input type="text" name="username" placeholder="username"><br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="number" name="age" placeholder="age"><br>
    <input type="submit" name="_submit" value="Kirim">
</form>
<hr>
<h1>Data Member</h1>
<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>Mail</th>
        <th>Username</th>
        <th>Password</th>
        <th>Age</th>
    </tr>
    </thead>
    <tbody>
    <!--{!Member}-->
    <tr>
        <td>{!Name}</td>
        <td>{!Mail}</td>
        <td>{!Username}</td>
        <td>{!Password}</td>
        <td>{!Age}</td>
    </tr>
    <!--{/Member}-->
    </tbody>
</table>
```

**More example cooming soon.**
---
layout: post
title: Welcome To Anywhere
---

To use anywhere simply create a new PDF template in 'beranda' page use +pdf a href buttons.
and now you see a basic configuration for the PDF like:

* Report Name.
* Paper Size.
* Data Source [POST/URL].
* Data Url.
* option to download or inline display PDF file in browser.
* Json Data sample.

> CSS designer is in development. is available in version 0.4.0 later

### Data Source [POST/URL].
for data source if you choose [POST] you can make request to anywhere website use:

```HTML
<form action="http://localhost/anywhere/render/pdf/b793b0baad9ed2a2db4b5774fc63de8a/1" method="post">
    <input type='hidden' name='jsondata' value='{
  "Looping": [
    {
      "nama": "Didit Velliz",
      "umur": "21"
    },
    {
      "nama": "Danny henry Gallatang",
      "umur": "21"
    },
    {
      "nama": "Akbar Sidik Maulana",
      "umur": "21"
    },
    {
      "nama": "Rizky Aditya Perdana",
      "umur": "22"
    }
  ]
}'>
    <input type="submit" name="submit"/>
</form>
```

for data source if you choose [URL] you need to specify the url for Anywhere to fetch the data example 

```
http://localhost/testdata/getdata.php
```

and in your getdata.php file like:

```PHP
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('Content-Type: application/json');

$vars = array(
'Looping' => array(
		array(
			'nama' => 'Didit Velliz',
			'umur' => 21
		),
		array(
			'nama' => 'Didit Second Place',
			'umur' => 21
		),
		array(
			'nama' => 'Didit Thrid Places',
			'umur' => 21
		),
	)
);
echo json_encode($vars);
```

### Json Data sample.
you can use data sample to supply data for template builder in JSON format. example of data:

```JSON
{
  "Looping": [
    {
      "nama": "Didit Velliz",
      "umur": "21"
    },
    {
      "nama": "Danny henry Gallatang",
      "umur": "21"
    },
    {
      "nama": "Akbar Sidik Maulana",
      "umur": "21"
    },
    {
      "nama": "Rizky Aditya Perdana",
      "umur": "22"
    }
  ]
}

```

and write in the html template:

```HTML
<table style="width: 100%; color: #268bd2; background-color: aliceblue">
    <tr>
        <td>Name</td>
        <td>Age</td>
    </tr>
    <!--{!Looping}-->
    <tr>
        <td>{!nama}</td>
        <td>{!umur}</td>
    </tr>
    <!--{/Looping}-->
</table>
```

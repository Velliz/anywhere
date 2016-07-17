<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="<?= ROOT; ?>/">

    <title>Anywhere</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/stylish-portfolio.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic"
          rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="assets/css/codemirror.css">
    <link rel="stylesheet" href="assets/addon/display/fullscreen.css">
    <link rel="stylesheet" href="assets/theme/night.css">

    <link href="assets/css/designer.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="assets/js/codemirror.js"></script>
    <script src="assets/mode/xml/xml.js"></script>
    <script src="assets/addon/display/fullscreen.js"></script>

</head>
<body>

<nav class="navbar navbar-blue navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                    class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="#">-->
            <!--<img alt="Brand" src="">-->
            <!--</a>-->
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a data-toggle="tooltip" title="Back" href="beranda"><i class="fa fa-arrow-left"></i></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="fa fa-gear"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Api Key</li>
                        <li class="dropdown-header"><?= $apikey ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header"><?= $name ?></li>
                        <li class="dropdown-header"><?= $status ?></li>
                        <li><a href="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" style="height: 100%; padding-top: 50px;">
    <div class="row" style="height: 100%">
        <div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0"
             style="padding: 0; background-color: #3E3E3F; height: 100%;">
            <form style="height: 100%">
                <textarea id="code" name="code" rows="5"></textarea>
            </form>
        </div>
        <div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0"
             style="padding: 0; background-color: #3E3E3F; height: 100%;">
            <embed src="http://localhost/anywhere/pdf" width="100%" height="99%" type="application/pdf">
        </div>
    </div>
</div>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        theme: "night",
        extraKeys: {
            "F11": function (cm) {
                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
            },
            "Esc": function (cm) {
                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
            }
        }
    });
</script>
</body>

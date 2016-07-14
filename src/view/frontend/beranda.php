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
                <li><a href="<?= $ID ?>/PDF"><i class="fa fa-plus"></i> <i class="fa fa-file-pdf-o"></i></a></li>
                <li><a href="<?= $ID ?>/WORD"><i class="fa fa-plus"></i> <i class="fa fa-file-word-o"></i></a></li>
                <li><a href="<?= $ID ?>/EXCEL"><i class="fa fa-plus"></i> <i class="fa fa-file-excel-o"></i></a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="settings"><i class="fa fa-gear"></i></a></li>
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

<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col-md-4 text-center">PDF</div>
        <div class="col-md-4 text-center">WORD</div>
        <div class="col-md-4 text-center">EXCEL</div>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

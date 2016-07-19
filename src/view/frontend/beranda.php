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
                <li><a data-toggle="tooltip" title="Create new PDF Tempaltes" href="<?= $id ?>/pdf/designer"><i class="fa fa-plus"></i> <i class="fa fa-file-pdf-o"></i> pdf</a></li>
                <li><a data-toggle="tooltip" title="Create new Word Templates" href="#"><i class="fa fa-plus"></i> <i class="fa fa-file-word-o"></i> word</a></li>
                <li><a data-toggle="tooltip" title="Create new Excel Templates" href="#"><i class="fa fa-plus"></i> <i class="fa fa-file-excel-o"></i> excel</a></li>
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

<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col-md-4">

            <!--<div class="jumbotron">-->
            <!--<i class="fa fa-file-pdf-o fa-fw fa-5x"></i>-->
            <!--</div>-->

            <div class="panel panel-warning">
                <div class="panel-heading">PDF lists</div>
                <div class="panel-body">
                    <div class="panel-primary">
                        <ul class="list-group text-center">
                            <?php foreach ($PDFLists as $val) { ?>
                                <li class="list-group-item">
                                    <a style="width: 100%;" href="<?= $id ?>/pdf/update/<?= $val['pdfid'] ?>" class="btn btn-dark"><?= $val['reportname'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <!--<div class="jumbotron">-->
            <!--<i class="fa fa-file-word-o fa-fw fa-5x"></i>-->
            <!--</div>-->

            <div class="panel panel-primary">
                <div class="panel-heading">Word lists</div>
                <div class="panel-body">
                    <div class="panel-primary">
                        <ul class="list-group">
                            <li class="list-group-item text-center">comming soon</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!--<div class="jumbotron">-->
            <!--<i class="fa fa-file-excel-o fa-fw fa-5x"></i>-->
            <!--</div>-->

            <div class="panel panel-success">
                <div class="panel-heading">Excel lists</div>
                <div class="panel-body">
                    <div class="panel-primary">
                        <ul class="list-group">
                            <li class="list-group-item text-center">comming soon</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

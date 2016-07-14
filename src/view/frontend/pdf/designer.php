<link href="assets/css/login.css" rel="stylesheet">
</head>
<body style="background: #fdfdfe !important;">
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


<div class="login-page">
    <div class="form">
        <form class="login-form" action="auth" method="POST">
            <input type="text" name="reportname" placeholder="report name" value="<?= $pdf['reportname'] ?>"/>
            <input type="text" name="reportname" placeholder="html file" value="<?= $pdf['html'] ?>"/>
            <input type="text" name="reportname" placeholder="css file" value="<?= $pdf['css'] ?>"/>
            <label><input type="radio" name="outputmode" value="Inline" <?= ($pdf['outputmode'] == 'Inline') ? 'checked' : '' ?>>Open in Browser</label>
            <label><input type="radio" name="outputmode" value="Download" <?= ($pdf['outputmode'] == 'Download') ? 'checked' : '' ?>>Download File</label>
            <button name="submit" type="submit">finish</button>
        </form>
    </div>
</div>


<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

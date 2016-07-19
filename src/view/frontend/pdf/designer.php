<link href="assets/css/designer.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/codemirror.css">
<link rel="stylesheet" href="assets/addon/display/fullscreen.css">
<link rel="stylesheet" href="assets/theme/night.css">

<script src="assets/js/codemirror.js"></script>
<script src="assets/mode/javascript/javascript.js"></script>
<script src="assets/addon/display/fullscreen.js"></script>

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

<div class="design-page">
    <div class="form">
        <form class="login-form" action="<?= $id ?>/pdf/update/<?= $pdf['pdfid'] ?>" method="POST">
            <input type="hidden" name="pdfid" value="<?= $pdf['pdfid'] ?>">
            <input type="text" name="reportname" placeholder="report name" value="<?= $pdf['reportname'] ?>"/>

            <center>
                <label><input type="radio" name="paper" value="F4" <?= ($pdf['paper'] == 'F4') ? 'checked' : '' ?>>F4</label>
                <label><input type="radio" name="paper" value="A4" <?= ($pdf['paper'] == 'A4') ? 'checked' : '' ?>>A4</label>
                <label><input type="radio" name="paper" value="B5" <?= ($pdf['paper'] == 'B5') ? 'checked' : '' ?>>B5</label>
            </center>

            <input type="text" name="html" placeholder="html file" value="<?= $pdf['html'] ?>" disabled/>
            <input type="text" name="css" placeholder="css file" value="<?= $pdf['css'] ?>" disabled/>

            <center>
                <label><input type="radio" name="requesttype" value="POST" <?= ($pdf['requesttype'] == 'POST') ? 'checked' : '' ?>>POST</label>
                <label><input type="radio" name="requesttype" value="URL" <?= ($pdf['requesttype'] == 'URL') ? 'checked' : '' ?>>URL</label>
            </center>

            <input type="text" name="requesturl" placeholder="url data source here" value="<?= ($pdf['requesturl'] != null) ? $pdf['requesturl'] : 'http://yourwebsite.com/jsondata' ?>"/>

            <br>
            <center>
                <label><input type="radio" name="outputmode" value="Inline" <?= ($pdf['outputmode'] == 'Inline') ? 'checked' : '' ?>>Open in Browser</label>
                <label><input type="radio" name="outputmode" value="Download" <?= ($pdf['outputmode'] == 'Download') ? 'checked' : '' ?>>Download File</label>
            </center>
            <br>

            <b>.json data sample</b>
            <textarea style="resize: none; width: 100%;" id="requestsample" name="requestsample" rows="8"><?= $pdf['requestsample'] ?></textarea>

            <br>
            <br>

            <p id="apiurl">API URL <a target="_blank" href="<?= ROOT . '/render/pdf/' . $apikey . '/' . $pdf['pdfid'] ?>"><?= ROOT . '/render/pdf/' . $apikey . '/' . $pdf['pdfid'] ?></a></p>

            <a target="_blank" href="<?= $id ?>/pdf/html/<?= $pdf['pdfid'] ?>" class="btn btn-dark">.html designer</a>
            <a target="_blank" href="<?= $id ?>/pdf/css/<?= $pdf['pdfid'] ?>" class="btn btn-dark">.css designer</a>
            <a href="#" class="btn btn-dark">request sample</a>

            <br>
            <br>
            <button name="submit" type="submit">save configuration</button>
        </form>
    </div>
</div>


<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("requestsample"), {
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

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


</body>
</html>

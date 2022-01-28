<!doctype html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">

    <title>Translate Biblical Names</title>
</head>
<body>
<!-- HEADER-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Translate Biblical Names</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
<!--            <ul class="navbar-nav me-auto mb-2 mb-lg-0">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link active" aria-current="page" href="#">Home</a>-->
<!--                </li>-->
<!--            </ul>-->
            <!--                <form class="d-flex">-->
            <!--                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
            <!--                    <button class="btn btn-outline-success" type="submit">Search</button>-->
            <!--                </form>-->
        </div>
    </div>
</nav>

<!--CONTENT-->
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-6 col-lg-8 col-xl-10 mt-5">
            <form action="search.php" class="bg-light p-5" name="frmSearch" id="frmSearch" method="GET">
                <div class="content-main text-center">
                    <input type="text" name="txtSearch" id="txtSearch" autocomplete="off" placeholder="Ex.: Abraão..." />
                    <button type="submit">Pesquisar</button>
                </div>
            </form>


            <div class="row">
                <?php
                // Content
                if (isset($_GET['result']) && !empty($_GET['result'])) {
                    echo '<div class="mt-5 text-center"><b>Resultado da pesquisa</b></div>';
                    $results = json_decode(base64_decode($_GET['result']), true);
                    if (!empty($results)) {
                        foreach ($results['data'] as $result) {
                            echo '<div class="col-sm-3">
                                <div class="card mt-5">
                                    <div class="card-body">
                                        <p class="card-text"><b>Nome pesquisado:</b> ' . $result['name'] . '</p>
                                        <p class="card-text"><b>Origem:</b> ' . $result['origin'] . '</p>
                                        <p class="card-text"><b>Tradução:</b> ' . $result['translate'] . '</p>
                                        <p class="card-text"><b>Referência:</b> ' . $result['reference'] . '</p>
                                    </div>
                                </div>
                            </div>';
                        }


                        echo '
                            <div class="mt-5 mb-3 text-center"><b>Tradução em forma de frase</b></div>
                            <div class="col text-center p-3 mb-5 bg-light">
                                <p class="card-text">"' . $results['phrase'] . '"</p>
                            </div>
                        ';
                    } else {
                        echo '<div class="col mt-5">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <p>Não foi encontrado nenhuma tradução para o(s) nome(s).</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>';
                    }
                }

                // Error
                if (isset($_GET['error']) && !empty($_GET['error'])) {
                    echo '<div class="col mt-5">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            '. $_GET['error'] .'                            
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
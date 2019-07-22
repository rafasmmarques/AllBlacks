<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark elegant-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="/">AllBlacks</a>

    <!-- Collapse button -->


    <!-- Collapsible content -->
    <ul class="nav elegant-color nav-float-right justify-content-end ">
        <?php if((array_key_exists('usuario', $_SESSION))){ ?>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="modalAlertaTorcedor()">Alertas</a>
        </li>
        <?php }?>
        <?php if((array_key_exists('usuario', $_SESSION))){ ?>
        <li class="nav-item">
            <div class="btn-group">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user-alt"></i></a>
                <div class="dropdown-menu dropdown-menu-right elegant-color">
                    <a class="dropdown-item text-white" type="button"><?=$_SESSION['usuario']?></a>
                    <a id="btnLogoff" class="dropdown-item text-white" type="button" href="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/login/logoff.php" ?>"
                        onclick="return confirm('Deseja mesmo sair?')">
                        <i class="fas fa-sign-out-alt mr-1"></i>Sair
                    </a>
                </div>
            </div>
        </li>
        <?php }?>
    </ul>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->
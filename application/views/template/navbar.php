<?php
	$uri_1 = $this->uri->segment(1);
	$uri_2 = $this->uri->segment(2);
	$uri_3 = $this->uri->segment(3);
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-dark navbar-primary">
    <div class="container-fluid">
        <a href="<?= base_url("/") ?>" class="navbar-brand">
            <img src="<?= base_url("assets/images/logo.jpeg") ?>" alt="logo" class="brand-image"
                style="opacity:.8">
            <span class="brand-text font-weight-light">MS Ticket</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url("/home") ?>" class="nav-link <?php if($uri_1 == "home"){ echo("active"); } ?>">
                        Home
                    </a>
                </li>
				<li class="nav-item">
                    <a href="<?= base_url("/incident") ?>" class="nav-link <?php if($uri_1 == "incident"){ echo("active"); } ?>">
                        Incident
                    </a>
                </li>
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url("/auth/logout") ?>">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->

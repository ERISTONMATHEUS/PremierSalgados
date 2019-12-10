<ul class="sidebar-menu">

    <!-- Produtos -->

    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i>
            <span>Produtos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $url; ?>prod/"><i class="fa fa-circle-o"></i>Produtos</a></li>
            <li><a href="<?php echo $url; ?>prod/addprod.php"><i class="fa fa-circle-o"></i>Adicionar Produtos</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i>
            <span>Estoque</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $url; ?>itens/"><i class="fa fa-circle-o"></i>Itens</a></li>
            <li><a href="<?php echo $url; ?>itens/totalitens.php"><i class="fa fa-circle-o"></i>Relatório</a></li>
            <li><a href="<?php echo $url; ?>itens/additens.php"><i class="fa fa-circle-o"></i>Adicionar Itens</a></li>
        </ul>
    </li>

    <?php if($perm === '1'){ ?>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i>
            <span>Usuários</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $url; ?>usuarios/"><i class="fa fa-circle-o"></i>Lista</a></li>
            <li><a href="<?php echo $url; ?>usuarios/addusuarios.php"><i class="fa fa-circle-o"></i>Add Usuários</a></li>
        </ul>
    </li>

    <?php }?>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i>
            <span>Cliente</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $url; ?>cliente/"><i class="fa fa-circle-o"></i>Lista</a></li>
            <li><a href="<?php echo $url; ?>cliente/addcliente.php"><i class="fa fa-circle-o"></i>Add Cliente</a></li>

        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i>
            <span>Vendas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $url; ?>vendas/"><i class="fa fa-circle-o"></i>Vendas</a></li>
        </ul>
    </li>

</ul>
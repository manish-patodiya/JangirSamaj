<div class=" flex-column flex-shrink-0 p-3 text-white bg-dark vh-100" id="sidebar">
    <a class="fs-4 text-white" href="<?=base_url()?>"><img src="<?=base_url('public/img/Vishwakarma.jpg')?>" width="40"
            height="40"> Jangid
        Samaj</a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo base_url("dashboard") ?>" class=" nav-link text-white <?=isActive('dashboard')?>">
                <i class="fas fa-desktop"> </i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url("members") ?>" class="nav-link text-white <?=isActive('members')?>">
                <i class="fas fa-users"> </i>
                Members
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo base_url("matrimonial") ?>" class="nav-link text-white <?=isActive('matrimonial')?>">
                <i class="fas fa-crown"> </i>
                Matrimonial
            </a>
        </li>
    </ul>
    <hr>
</div>
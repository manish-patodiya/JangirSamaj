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
            <a class="dropdown-btn nav-link text-white " style="cursor:context-menu">
                <i class="fas fa-users"> </i>
                Users
            </a>
            <div class="dropdown-container">
                <a href="<?php echo base_url("moderators") ?>" class="nav-link text-white <?=isActive('moderators')?>">
                    <i class="fas fa-users"> </i>
                    Moderators
                </a>
                <a href="<?php echo base_url("members") ?>" class="nav-link text-white <?=isActive('members')?>">
                    <i class="fas fa-users"> </i>
                    Members
                </a>
                <a href="<?php echo base_url("matrimonial") ?>"
                    class="nav-link text-white <?=isActive('matrimonial')?>">
                    <i class="fas fa-crown"> </i>
                    Matrimonial
                </a>
            </div>
        </li>
        <li class="nav-item">
            <a class="dropdown-btn nav-link text-white " style="cursor:context-menu">
                <i class="fas fa-cogs"> </i>
                Settings
            </a>
            <div class="dropdown-container">
                <a href="<?php echo base_url("relations") ?>" class="nav-link text-white <?=isActive('relations')?>">
                    <i class="fas fa-list"> </i>
                    Relations
                </a>
                <a href="<?php echo base_url("gotras") ?>" class="nav-link text-white <?=isActive('gotras')?>">
                    <i class="fas fa-list"> </i>
                    Manage Gotras
                </a>
                <a href="<?php echo base_url("states") ?>" class="nav-link text-white <?=isActive('states')?>">
                    <i class="fas fa-list"> </i>
                    Manage States
                </a>
            </div>
        </li>
    </ul>
    <hr>
</div>
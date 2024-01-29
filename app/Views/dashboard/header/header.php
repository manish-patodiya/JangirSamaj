<div>
    <header class="header p-3 bg-white mb-3 w-100" style="height:62px;  flex:100;">
        <!-- <button class="btn btn-outline-dark fas fa-sign-out-alt" id="btn-logout">Log Out</button> -->

        <div class="d-flex justify-content-end">

            <?php if (count($session->user_details['user_roles']) > 1) {?>
            <label class="me-3">Login as:
                <select name="" class="form-select-sm" id="slct-switch-role">
                    <?php
foreach ($session->user_details['user_roles'] as $role) {
    $std = $session->user_details['active_role_id'] == $role->role_id ? "selected" : "";
    echo "<option value='$role->role_id' $std> " . ucfirst($role->role) . " </option>";
}?>
                </select>
            </label>
            <?php }?>
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle-block"
                id="dropdownmessage1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="far fa-bell fa-2x position-relative me-3">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.35em;">
                        <?=$session->user_details['notification']?>
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-white shadow p-2 w-25" aria-labelledby="dropdownmessage1">
                <?php foreach ($messages as $value) {?>
                <li class="message" mid="<?=$value->id?>">
                    <a href="<?php echo "#"; //echo base_url('messages')   ?>" class="dropdown-item"
                        style="color: white;">
                        <div class="row ">
                            <div style="font-size:20px " class="hideextra" title="<?=$value->msg?>"><?=$value->msg?>
                            </div>
                            <div class="row  mt-1">
                                <span class="position-relative "
                                    style="font-size:14px"><?=$value->first_name . " " . $value->middle_name . " " . $value->last_name?></span>
                                <div class="text-end position-absolute  botton-0 right-0">
                                    <span style="font-size:15px; padding:20px;">
                                        <?php
switch (date('d', strtotime(time())) - date('d', strtotime($value->time))) {
    case 0:
        echo "Today at " . date('H:i', strtotime($value->time));
        break;
    case 1:
        echo "Yesteday at " . date('H:i', strtotime($value->time));
        break;
    default:
        echo $value->time;
}
    ?>
                                    </span>
                                </div>

                                <hr>
                            </div>
                        </div>
                    </a>
                </li> <?php }?>
            </ul>

            <a href=" #" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                <img src="<?php echo $session->get('user_details')['photo']; ?>"
                    alt="<?php echo $session->get('user_details')['name']; ?>" width=" 32" height="32"
                    class="rounded-circle" style="border:1px solid #ccc;">
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li style="<?php $uri = service('uri');
echo $uri->getSegment(1) == "profile" ? "display:none" : false;?>"><a class="dropdown-item"
                        href="<?php echo base_url("profile") ?>">Profile
                    </a>
                    <hr class="dropdown-divider">
                </li>
                <li><a href="<?php echo base_url('messages') ?>" class="dropdown-item" id="btn-mess">Messages</a>
                    <hr class="dropdown-divider">
                </li>
                <li><a href="<?php echo base_url('auth/logout') ?>" class="dropdown-item" id="btn-logout">Logout</a>
                </li>
            </ul>
        </div>
    </header>
</div>
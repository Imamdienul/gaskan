<?php
// Load menu items based on user's group
$CI = &get_instance();
$CI->load->model('Menu_model');
$user_group_id = $CI->session->userdata('group');
$menu_items = $CI->Menu_model->get_menu_by_group_id($user_group_id);
?>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dynamic Menu Items -->
        <?php foreach ($menu_items as $menu): ?>
            <?php if ($menu['is_parent'] && !empty($menu['sub_menu'])): ?>
                <!-- Parent Menu with Submenus -->
                <li class="nav-item <?= is_parent_active($menu['sub_menu']) ?>">
                    <a href="<?= $menu['menu_url'] == '#' ? '#' : base_url($menu['menu_url']) ?>" class="nav-link <?= is_parent_active_class($menu['sub_menu']) ?>">
                        <i class="nav-icon <?= $menu['menu_icon'] ?>"></i>
                        <p>
                            <?= $menu['menu_name'] ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach ($menu['sub_menu'] as $submenu): ?>
                            <li class="nav-item">
                                <a href="<?= base_url($submenu->menu_url) ?>" class="nav-link <?= is_menu_active($CI->uri->segment(1), $submenu->menu_url) ?>">
                                    <i class="<?= $submenu->menu_icon ?> nav-icon"></i>
                                    <p><?= $submenu->menu_name ?></p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <!-- Single Menu Item -->
                <li class="nav-item">
                    <a href="<?= base_url($menu['menu_url']) ?>" class="nav-link <?= is_menu_active($CI->uri->segment(1), $menu['menu_url']) ?>">
                        <i class="nav-icon <?= $menu['menu_icon'] ?>"></i>
                        <p><?= $menu['menu_name'] ?></p>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
<!-- views/menu/edit.php -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Menu Item</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('menu') ?>">Menu Management</a></li>
                    <li class="breadcrumb-item active">Edit Menu Item</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Menu Item</h3>
                    </div>
                    <form action="<?= base_url('menu/edit/'.$menu_item->id_menu) ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="menu_name">Menu Name</label>
                                <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= $menu_item->menu_name ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="menu_url">Menu URL</label>
                                <input type="text" class="form-control" id="menu_url" name="menu_url" value="<?= $menu_item->menu_url ?>" required>
                                <small class="form-text text-muted">Use '#' for parent menus with submenus</small>
                            </div>
                            <div class="form-group">
                                <label for="menu_icon">Menu Icon</label>
                                <input type="text" class="form-control" id="menu_icon" name="menu_icon" value="<?= $menu_item->menu_icon ?>" required>
                                <small class="form-text text-muted">FontAwesome icon classes (e.g. fas fa-home)</small>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Parent Menu</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">No Parent (Main Menu)</option>
                                    <?php foreach ($parent_menus as $parent): ?>
                                        <?php if ($parent->is_parent && $parent->id_menu != $menu_item->id_menu): ?>
                                        <option value="<?= $parent->id_menu ?>" <?= $menu_item->parent_id == $parent->id_menu ? 'selected' : '' ?>><?= $parent->menu_name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="menu_order">Menu Order</label>
                                <input type="number" class="form-control" id="menu_order" name="menu_order" value="<?= $menu_item->menu_order ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="is_parent">Is Parent Menu (Has Submenus)</label>
                                <select class="form-control" id="is_parent" name="is_parent">
                                    <option value="0" <?= $menu_item->is_parent == 0 ? 'selected' : '' ?>>No</option>
                                    <option value="1" <?= $menu_item->is_parent == 1 ? 'selected' : '' ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?= base_url('menu') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
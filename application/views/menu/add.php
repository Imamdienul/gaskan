
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Menu Item</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('menu') ?>">Menu Management</a></li>
                    <li class="breadcrumb-item active">Add Menu Item</li>
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
                        <h3 class="card-title">Add New Menu Item</h3>
                    </div>
                    <form action="<?= base_url('menu/add') ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="menu_name">Menu Name</label>
                                <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                            </div>
                            <div class="form-group">
                                <label for="menu_url">Menu URL</label>
                                <input type="text" class="form-control" id="menu_url" name="menu_url" required>
                                <small class="form-text text-muted">Use '#' for parent menus with submenus</small>
                            </div>
                            <div class="form-group">
                                <label for="menu_icon">Menu Icon</label>
                                <input type="text" class="form-control" id="menu_icon" name="menu_icon" required>
                                <small class="form-text text-muted">FontAwesome icon classes (e.g. fas fa-home)</small>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Parent Menu</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">No Parent (Main Menu)</option>
                                    <?php foreach ($parent_menus as $parent): ?>
                                        <?php if ($parent->is_parent): ?>
                                        <option value="<?= $parent->id_menu ?>"><?= $parent->menu_name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="menu_order">Menu Order</label>
                                <input type="number" class="form-control" id="menu_order" name="menu_order" value="0" required>
                            </div>
                            <div class="form-group">
                                <label for="is_parent">Is Parent Menu (Has Submenus)</label>
                                <select class="form-control" id="is_parent" name="is_parent">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
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
</section>"
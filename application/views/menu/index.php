<!-- views/menu/index.php -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Menu Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Menu Management</li>
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
                        <h3 class="card-title">Menu Items</h3>
                        <div class="float-right">
                            <a href="<?= base_url('menu/add') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Menu Item
                            </a>
                            <a href="<?= base_url('menu/access') ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-lock"></i> Manage Access
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Menu Name</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Parent</th>
                                    <th>Order</th>
                                    <th>Is Parent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($menu_items as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->menu_name ?></td>
                                    <td><?= $item->menu_url ?></td>
                                    <td><i class="<?= $item->menu_icon ?>"></i> <?= $item->menu_icon ?></td>
                                    <td><?= $item->parent_id ? 'Child Menu' : 'Parent Menu' ?></td>
                                    <td><?= $item->menu_order ?></td>
                                    <td><?= $item->is_parent ? 'Yes' : 'No' ?></td>
                                    <td>
                                        <a href="<?= base_url('menu/edit/'.$item->id_menu) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('menu/delete/'.$item->id_menu) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this menu item?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Menu Access for <?= strtoupper($group->group_user) ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('menu') ?>">Menu Management</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('menu/access') ?>">Menu Access</a></li>
                    <li class="breadcrumb-item active"><?= strtoupper($group->group_user) ?></li>
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
                        <h3 class="card-title">Configure Menu Access</h3>
                    </div>
                    <form action="<?= base_url('menu/access/'.$group->id_group_user) ?>" method="post">
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Menu Name</th>
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($menu_items as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if ($item->parent_id): ?>
                                            <span class="pl-4">└─ </span>
                                            <?php endif; ?>
                                            <?= $item->menu_name ?>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="menu[]" value="<?= $item->id_menu ?>" <?= $item->has_access ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="<?= base_url('menu/access') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
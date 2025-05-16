<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit User Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('users/list') ?>">Users</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
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
                        <h3 class="card-title">Edit User Role</h3>
                    </div>
                    <form action="<?= base_url('users/edit_role/'.encrypt_url($user->id_user)) ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_user">User Name</label>
                                <input type="text" class="form-control" id="nama_user" value="<?= $user->nama_user ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="id_group_user">User Role</label>
                                <select class="form-control" id="id_group_user" name="id_group_user" required>
                                    <?php foreach ($group_user as $group): ?>
                                    <option value="<?= $group->id_group_user ?>" <?= $user->id_group_user == $group->id_group_user ? 'selected' : '' ?>><?= strtoupper($group->group_user) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_user" value="<?= $user->id_user ?>">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="<?= base_url('users/list') ?>" class="btn btn-default">Cancel</a>
                            <a href="<?= base_url('menu/access/'.$user->id_group_user) ?>" class="btn btn-info float-right">
                                <i class="fas fa-lock"></i> Manage Group Menu Access
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
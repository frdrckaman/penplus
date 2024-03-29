<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 50;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();
        if (Input::get('add_test')) {
            $validate = $validate->check($_POST, array(
                // 'name' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                try {
                    $test_category = $override->get('test_list', 'name', Input::get('name'));
                    if ($test_category) {
                        $errorMessage = 'Test Already Added';
                    } else {
                        $user->createRecord('test_list', array(
                            'category' => Input::get('category'),
                            'sub_category' => Input::get('sub_category'),
                            'name' => Input::get('name'),
                            'status' => Input::get('status'),
                            'description' => Input::get('description'),
                            'units' => Input::get('units'),
                            'minimum' => Input::get('minimum'),
                            'maximum' => Input::get('maximum'),
                            'cost' => Input::get('cost'),
                            'delete_flag' => 0,
                        ));
                        $successMessage = 'New Test Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('update_sub_category')) {
            $validate = $validate->check($_POST, array(
                // 'name' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                try {
                    $test_category = $override->get('test_list', 'name', Input::get('name'));
                    if ($test_category) {
                        $errorMessage = 'Test Already Added';
                    } else {
                        $user->updateRecord('test_list', array(
                            'category' => Input::get('category'),
                            'sub_category' => Input::get('sub_category'),
                            'name' => Input::get('name'),
                            'status' => Input::get('status'),
                            'description' => Input::get('description'),
                            'units' => Input::get('units'),
                            'minimum' => Input::get('minimum'),
                            'maximum' => Input::get('maximum'),
                            'cost' => Input::get('cost'),
                            'delete_flag' => 0,
                        ), Input::get('id'));
                        $successMessage = 'New Test Updated';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('deactivate_sub_category')) {
            $user->updateRecord('sub_category', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Sub Category Deactivated Successful';
        } elseif (Input::get('activate_sub_category')) {
            $user->updateRecord('sub_category', array(
                'status' => 1,
            ), Input::get('id'));
            $successMessage = 'Sub Category Activated Successful';
        } elseif (Input::get('delete_sub_category')) {
            $user->deleteRecord('sub_category', 'id', Input::get('id'));
            $successMessage = 'Sub Category Deleted Successful';
        }
    }
} else {
    Redirect::to('index.php');
}
// $client = $override->get('client', 'id', $_GET['position'])[0];
// $position = $override->get('position', 'id', $staff['position'])[0];

?>


<!DOCTYPE html>
<html lang="en">
<?php include 'headBar.php'; ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Test Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                <li class="breadcrumb-item active">Test Form</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <?php
            $test_list = $override->get('test_list', 'delete_flag', 0);
            ?>

            <style>
                .img-thumb-path {
                    width: 100px;
                    height: 80px;
                    object-fit: scale-down;
                    object-position: center center;
                }
            </style>

            <!-- Main content -->
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">List of Test</h3>
                    <div class="card-tools">
                        <a class="btn btn-flat btn-sm btn-primary" href="#add_new_list" role="button" data-toggle="modal"><span class="fas fa-plus text-primary"></span>Add New Test</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <table class="table table-bordered table-hover table-striped">
                                <colgroup>
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="25%">
                                    <col width="20%">
                                    <col width="15%">
                                    <col width="15%">
                                </colgroup>
                                <thead>
                                    <tr class="bg-gradient-primary text-light">
                                        <th>#</th>
                                        <th>Date Created</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Test Name</th>
                                        <th>Description</th>
                                        <th>Range</th>
                                        <th>Units</th>
                                        <th>cost</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($test_list as $value) {
                                        $category_name = $override->get('category', 'id', $value['category'])[0];
                                        $sub_category_name = $override->get('sub_category', 'id', $value['category'])[0];

                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++; ?></td>
                                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $category_name['name'] ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $sub_category_name['name'] ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $value['name'] ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $value['description'] ?></p>
                                            </td>

                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $value['minimum'] . ' - ' . $value['maximum'] ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $value['units'] ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $value['cost'] ?></p>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                switch ($value['status']) {
                                                    case 0:
                                                        echo '<span class="rounded-pill badge badge-danger col-12">Inactive</span>';
                                                        break;
                                                    case 1:
                                                        echo '<span class="rounded-pill badge badge-primary col-12">Active</span>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    Action
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#view<?= $value['id'] ?>" role="button" data-toggle="modal"><span class="fa fa-eye text-dark"></span> View</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#update_list<?= $value['id'] ?>" role="button" data-toggle="modal"><span class=" fa fa-edit text-primary"></span> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#activate<?= $value['id'] ?>" role="button" data-toggle="modal"><span class="fa fa-eye text-secondary"></span> Activate</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#deactivate<?= $value['id'] ?>" role="button" data-toggle="modal"><span class="fa fa-eye text-warning"></span> Deactivate</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#delete<?= $value['id'] ?>" role="button" data-toggle="modal"><span class="fa fa-eye text-danger"></span> Delete</a>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="add_new_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="add" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>Add New Test</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Category</label>
                                                                            <select name="category" class="form-control form-control-border" placeholder="Enter test Name" required>
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($override->get('category', 'status', 1) as $value) { ?>
                                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Sub Category</label>
                                                                            <select name="sub_category" class="form-control form-control-border" placeholder="Enter test Name" required>
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($override->get('sub_category', 'status', 1) as $value) { ?>
                                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Test Name</label>
                                                                            <input type="text" name="name" class="form-control form-control-border" placeholder="Enter Test Name" value="" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Units</label>
                                                                            <input type="text" name="units" class="form-control form-control-border" placeholder="Enter Units" value="" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description" class="control-label">Description</label>
                                                                    <textarea rows="3" name="description" class="form-control form-control-sm rounded-0"></textarea>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Range ( Minimum )</label>
                                                                            <input type="text" name="minimum" class="form-control form-control-border" placeholder="Enter Maximum Number" value="" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Range ( Maximum )</label>
                                                                            <input type="text" name="maximum" class="form-control form-control-border" placeholder="Enter Maximum Number" value="" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Status</label>
                                                                            <select name="status" class="form-control form-control-border" required>
                                                                                <option value="">Select</option>
                                                                                <option value="1">Active</option>
                                                                                <option value="0">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="cost" class="control-label">Price</label>
                                                                            <input type="number" step="any" name="cost" id="cost" class="form-control form-control-border text-right" value="" required>
                                                                            <span>TSHS</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="submit" name="add_test" value="Add New Test" class="btn btn-info">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="view<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="add" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>View Sub Category</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <dl>
                                                                        <dt class="text-muted">Category</dt>
                                                                        <dd class='pl-4 fs-4 fw-bold'><?php echo $category_name['name'] ?></dd>
                                                                        <dt class="text-muted">Sub Category</dt>
                                                                        <dd class='pl-4 fs-4 fw-bold'><?php echo $value['name'] ?></dd>
                                                                        <dt class="text-muted">Status</dt>
                                                                        <dd class='pl-4 fs-4 fw-bold'>
                                                                            <?php
                                                                            switch ($value['status']) {
                                                                                case '1':
                                                                                    echo '<span class="px-4 badge badge-primary rounded-pill">Active</span>';
                                                                                    break;
                                                                                case '0':
                                                                                    echo '<span class="px-4 badge badge-danger rounded-pill">Inactive</span>';
                                                                                    break;
                                                                            }
                                                                            ?>
                                                                        </dd>
                                                                    </dl>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <small class="text-muted">Description</small>
                                                                        <div><?php if ($value['description']) {
                                                                                    echo $value['description'];
                                                                                } else {
                                                                                    echo 'N / A';
                                                                                } ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button class="btn btn-dark btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="update_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="add" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>Update Test</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Category</label>
                                                                            <select name="category" class="form-control form-control-border" placeholder="Enter test Name" required>
                                                                                <option value="<?php echo $category_name['id'] ?>"><?php echo $category_name['name'] ?></option>
                                                                                <?php foreach ($override->get('category', 'status', 1) as $value) { ?>
                                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Sub Category</label>
                                                                            <select name="sub_category" class="form-control form-control-border" placeholder="Enter test Name" required>
                                                                                <option value="<?php echo $sub_category_name['id'] ?>"><?php echo $sub_category_name['name'] ?></option>
                                                                                <?php foreach ($override->get('sub_category', 'status', 1) as $value) { ?>
                                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Test Name</label>
                                                                            <input type="text" name="name" class="form-control form-control-border" placeholder="Enter Test Name" value="<?php echo $sub_category_name['name'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Units</label>
                                                                            <input type="text" name="units" class="form-control form-control-border" placeholder="Enter Units" value="<?php echo $sub_category_name['units'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description" class="control-label">Description</label>
                                                                    <textarea rows="3" name="description" class="form-control form-control-sm rounded-0"></textarea>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Range ( Minimum )</label>
                                                                            <input type="text" name="minimum" class="form-control form-control-border" placeholder="Enter Maximum Number" value="<?php echo $sub_category_name['minimum'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name" class="control-label">Range ( Maximum )</label>
                                                                            <input type="text" name="maximum" class="form-control form-control-border" placeholder="Enter Maximum Number" value="<?php echo $sub_category_name['maximum'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status" class="control-label">Status</label>
                                                                            <select name="status" class="form-control form-control-border" required>
                                                                                <option value="1" <?php if ($value['status'] == 1) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Active</option>
                                                                                <option value="0" <?php if ($value['status'] == 0) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="cost" class="control-label">Price</label>
                                                                            <input type="number" step="any" name="cost" id="cost" class="form-control form-control-border text-right" value="" required>
                                                                            <span>TSHS</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                <input type="submit" name="add_test" value="Add New Test" class="btn btn-info">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="deactivate<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>Deactivate Sub Category</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong style="font-weight: bold;color: yellow">
                                                                <p>Are you sure you want to deactivate this Sub Category</p>
                                                            </strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                            <input type="submit" name="deactivate_sub_category" value="Deactivate" class="btn btn-yellow">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="activate<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>Activate Sub Category</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong style="font-weight: bold;color: yellow">
                                                                <p>Are you sure you want to deactivate this Sub Category</p>
                                                            </strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                            <input type="submit" name="activate_sub_category" value="Activate" class="btn btn-yellow">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="delete<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4>Delete Sub Category</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong style="font-weight: bold;color: red">
                                                                <p>Are you sure you want to delete this Sub Category</p>
                                                            </strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                            <input type="submit" name="delete_sub_category" value="Delete" class="btn btn-danger">
                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->
        <?php include 'footerBar.php'; ?>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
</body>

</html>
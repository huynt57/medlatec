<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý dịch vụ khám</h3><br><br>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#create-service-modal" >Thêm dịch vụ</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable" id="service_management">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên dịch vụ</td>
                                <td>Giá dịch vụ</td>
                                <td>Khuyến mãi</td>
                                <?php if (empty(Yii::app()->session['provider_id'])): ?>
                                    <td>Đơn vị</td>
                                <?php endif; ?>
                                <td>Tạo lúc</td>
                                <td>Cập nhật lúc</td>
                                <td>Trạng thái</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td>ID</td>
                                <td>Tên dịch vụ</td>
                                <td>Giá dịch vụ</td>
                                <td>Khuyến mãi</td>
                                <?php if (empty(Yii::app()->session['provider_id'])): ?>
                                    <td>Đơn vị</td>
                                <?php endif; ?>
                                <td>Tạo lúc</td>
                                <td>Cập nhật lúc</td>
                                <td>Trạng thái</td>
                                <td>Hành động</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="edit-service-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="edit-service-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="create-service-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm dịch vụ mới</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-create-service">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_name">Tên dịch vụ</label>
                                <input type="text" class="form-control" id="service_name" name="service_name" >
                            </div>
                            <div class="form-group">
                                <label for="service_price">Giá dịch vụ</label>
                                <input type="text" class="form-control" id="service_price" name="service_price" >
                            </div>
                            <div class="form-group">
                                <label for="favorable">Khuyến mãi</label>
                                <input type="text" class="form-control" id="favorable" name="favorable" >
                            </div>
                            <input type="hidden" name="type" value="<?php echo Yii::app()->session['type'] ?>">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Miêu tả</label>
                                <textarea type="text" class="form-control" id="description" name="description" rows="6"></textarea>
                            </div>
                            <?php if (Yii::app()->session['type'] == 'meboo_admin'): ?>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <?php foreach (Util::getStatusServiceMedlatec(Yii::app()->session['type']) as $key => $value): ?>
                                            <option value="<?php echo $key ?>" <?php
                                            if ($data['status'] == $key):
                                                ?>  selected=""
                                                    <?php endif; ?>><?php echo $value ?></option>
                                                <?php endforeach; ?>
                                    </select>                           
                                </div>
                            <?php endif; ?>
                        </div>

                    </div><!-- /.box-body -->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="create-service-submit">Lưu</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        $('#service_management').DataTable({
        "processing": true,
                "serverSide": true,
                "ajax": {
                "url": "<?php echo Yii::app()->createUrl('service/getAllService') ?>",
                        "type": "GET"
                },
                "order": [[0, "desc"]],
                "columns": [
                {data: 'id', name: 'id'},
                {data: 'service_name', name: 'service_name'},
                {data: 'service_price', name: 'service_price'},
                {data: 'favorable', name: 'favorable'},
<?php if (empty(Yii::app()->session['provider_id'])): ?>
                    {data: 'provider_name', name: 'provider_name'},
<?php endif; ?>
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
                ]
    });
    });</script>

<script type="text/javascript">
            $(document).ready(function () {
        $('#edit-service-modal').on('hidden.bs.modal', function () {
            $('#service_management').DataTable().ajax.reload();
        });
        $('#create-service-modal').on('hidden.bs.modal', function () {
            $('#service_management').DataTable().ajax.reload();
        });
        $(document).on('click', '#create-service-submit', function () {
            var form = $('#form-create-service');
            var data = form.serialize();
            $.ajax({
                beforeSend: function () {
                    $('#create-service-modal').addClass('blur-loading');
                },
                dataType: 'json',
                url: '<?php echo Yii::app()->createUrl('service/addProcess') ?>',
                method: 'POST',
                data: data,
                success: function (response)
                {
                    if (response.status === 1) {
                        // Show success message
                        displayMessage('tt', 1);
                    } else {
                        // Show error message
                        displayMessage('tt', 0);
                    }
                },
                complete: function () {
                    $('#create-service-modal').removeClass('blur-loading');
                }
            });
        });

        $(document).on('click', '#edit-service-submit', function () {
            var form = $('#form-edit-service');
            var data = form.serialize();
            $.ajax({
                beforeSend: function () {
                    $('#edit-service-modal').addClass('blur-loading');
                },
                dataType: 'json',
                url: '<?php echo Yii::app()->createUrl('service/editProcess') ?>',
                method: 'POST',
                data: data,
                success: function (response)
                {
                    if (response.status === 1) {
                        // Show success message
                        displayMessage('tt', 1);
                    } else {
                        // Show error message
                        displayMessage('tt', 0);
                    }
                },
                complete: function () {
                    $('#edit-service-modal').removeClass('blur-loading');
                }
            });
        });
    });

    function loadInfoService(service_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/service/edit?service_id=' + service_id;
        $.get(url, function (response) {
            $('#edit-service-content').html(response);

        });
    }
</script>
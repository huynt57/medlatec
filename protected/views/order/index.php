<style>
    .datepicker { 
        z-index: 99999 !important; 
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý đơn đặt khám</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable" id="order_management">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên</td>
                                <td>Số điện thoại</td>
                                <td>Email</td>
<!--                                <td>Yêu cầu</td>-->
                                <?php if (empty(Yii::app()->session['provider_id'])): ?>
                                    <td>Đơn vị</td>
                                <?php endif; ?>
                                <td>Tạo vào</td>
                                <td>Trạng thái</td>
                                <td>Hành động</td>
                                <!--
                                <td>Updated at</td>-->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td>ID</td>
                                <td>Tên</td>
                                <td>Số điện thoại</td>
                                <td>Email</td>
<!--                                <td>Yêu cầu</td>-->
                                <?php if (empty(Yii::app()->session['provider_id'])): ?>
                                    <td>Đơn vị</td>
                                <?php endif; ?>
                                <td>Tạo vào</td>
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
<div class="modal fade" id="edit-order-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="edit-order-modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit-order-result-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="edit-order-result-modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="delete-order-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="delete-order-modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<script>
    $(document).ready(function () {
        $('#order_management').DataTable({
        "processing": true,
                "serverSide": true,
                "ajax": {
                "url": "<?php echo Yii::app()->createUrl('order/getAllOrder') ?>",
                        "type": "GET"
                },
                "order": [[0, "desc"]],
                "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                        //  {data: 'requirement', name: 'requirement'},
<?php if (empty(Yii::app()->session['provider_id'])): ?>
                    {data: 'provider_name', name: 'provider_name'},
<?php endif; ?>
                {data: 'created_at', name: 'created_at'},
                {data: 'status_name', name: 'status_name'},
                {data: 'action', name: 'action'},
//                {data: 'created_at', name: 'created_at'},
//                {data: 'updated_at', name: 'updated_at'}
                ]
    });
    $('#edit-order-modal').on('hidden.bs.modal', function () {
        $('#order_management').DataTable().ajax.reload();
    });
    $('#delete-order-modal').on('hidden.bs.modal', function () {
        $('#order_management').DataTable().ajax.reload();
    });
    $('#edit-order-result-modal').on('hidden.bs.modal', function () {
        $('#order_management').DataTable().ajax.reload();
    });
    });</script>

<script type="text/javascript">
            $(document).ready(function () {

        $(document).on('click', '#edit-order-submit', function () {
            var form = $('#form-edit-order');
            var data = form.serialize();

            $.ajax({
                beforeSend: function () {
                    $('#edit-order-modal').addClass('blur-loading');
                },
                dataType: 'json',
                url: '<?php echo Yii::app()->createUrl('order/editProcess') ?>',
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
                    $('#edit-order-modal').removeClass('blur-loading');
                }
            });
        });

        $(document).on('click', '#delete-order-submit', function () {
            var form = $('#form-delete-order');
            var data = form.serialize();

            $.ajax({
                beforeSend: function () {
                    $('#delete-order-modal').addClass('blur-loading');
                },
                dataType: 'json',
                url: '<?php echo Yii::app()->createUrl('order/deleteProcess') ?>',
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
                    $('#delete-order-modal').removeClass('blur-loading');
                }
            });
        });

        $(document).on('click', '#edit-order-result-submit', function () {
            var form = $('#form-edit-result-order');
            var doctor = $('#doctor').val();
            var diagnose = $('#diagnose').val();
            var status = $('#status').val();
            var order_id = $('#order_id').val();
            //console.log(doctor);
            // console.log($('#file'));
            var formdata = new FormData();
            var files = $("#file")[0].files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                formdata.append("file[]", file);
            }
            formdata.append('doctor', doctor);
            formdata.append('diagnose', diagnose);
            formdata.append('status', status);
            formdata.append('order_id', order_id);

            $.ajax({
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#edit-order-result-modal').addClass('blur-loading');
                    console.log(formdata);
                },
                //  dataType: 'json',
                url: '<?php echo Yii::app()->createUrl('order/updateResult') ?>',
                method: 'POST',
                data: formdata,
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
                    $('#edit-order-result-modal').removeClass('blur-loading');
                }
            });
        });


    });

    function loadInfo(order_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/order/edit?oid=' + order_id;
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#edit-order-modal-content').addClass('blur-loading');
                //   console.log(formdata);
            },
            success: function (response)
            {
                $('#edit-order-modal-content').html(response);


                $('#time_confirm').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
                $('#time_meet').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });

            },
            complete: function () {
                $('#edit-order-modal-content').removeClass('blur-loading');
            }
        });

    }



    function loadInfoResult(order_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/order/result?oid=' + order_id;
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#edit-order-result-modal-content').addClass('blur-loading');
                //   console.log(formdata);
            },
            success: function (response)
            {
                $('#edit-order-result-modal-content').html(response);
                $('#time_confirm').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
                $('#time_meet').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });

            },
            complete: function () {
                $('#edit-order-result-modal-content').removeClass('blur-loading');
            }
        });

    }

    function loadInfoDelete(order_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/order/deleteOrder?order_id=' + order_id;
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#delete-order-modal-content').addClass('blur-loading');
                //   console.log(formdata);
            },
            success: function (response)
            {
                $('#delete-order-modal-content').html(response);


            },
            complete: function () {
                $('#delete-order-modal-content').removeClass('blur-loading');
            }
        });

    }
</script>
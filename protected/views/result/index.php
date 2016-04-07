<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý kết quả dịch vụ</h3><br><br>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#create-result-modal" href="<?php echo Yii::app()->createUrl('result/add') ?>" >Thêm kết quả</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable" id="order_management">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên bệnh nhân</td>
                                <td>Dịch vụ</td>
                                <td>Thời gian</td>
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
                                <td>Tên bệnh nhân</td>
                                <td>Dịch vụ</td>
                                <td>Thời gian</td>
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

<div class="modal fade" id="create-result-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="create-result-modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<script>
    $(document).ready(function () {
        $('#order_management').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo Yii::app()->createUrl('result/getAllResult') ?>",
                "type": "GET"
            },
            "order": [[0, "desc"]],
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'patient_name', name: 'name'},
                {data: 'service', name: 'phone'},
                {data: 'time', name: 'email'},
                //  {data: 'requirement', name: 'requirement'},
                 <?php if (empty(Yii::app()->session['provider_id'])): ?>
                                    {data: 'provider_name', name: 'provider_name'},
                                <?php endif; ?>
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
//                {data: 'created_at', name: 'created_at'},
//                {data: 'updated_at', name: 'updated_at'}
            ]
        });
    });

</script>

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

                    }
                },
                complete: function () {
                    $('#edit-order-modal').removeClass('blur-loading');
                }
            });
        });

        $('#time_confirm').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#edit-order-modal').on('hidden.bs.modal', function () {
            $('#order_management').DataTable().ajax.reload();
        });
        $('#create-result-modal').on('hidden.bs.modal', function () {
            $('#order_management').DataTable().ajax.reload();
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
                url: '<?php echo Yii::app()->createUrl('result/addProcess') ?>',
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
                  //  form.reset();
                    $("#file").val('');
                }
            });
        });

    });

    function loadInfo(order_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/result/order?oid=' + order_id;
        $.get(url, function (response) {
            $('#edit-order-modal-content').html(response);
           
        });
    }

    function loadInfoResult(result_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/result/edit?result_id=' + result_id;
        $.get(url, function (response) {
            $('#edit-order-modal-content').html(response);
            $('#time_confirm').datepicker();
        });
    }
</script>
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



<script>
    $(document).ready(function () {
        $('#order_management').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo Yii::app()->createUrl('order/getAllOrder') ?>",
                "type": "GET"
            },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                //  {data: 'requirement', name: 'requirement'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status_name', name: 'status_name'},
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
    });

    function loadInfo(order_id)
    {
        var base_url = '<?php echo Yii::app()->request->baseUrl; ?>';
        var url = base_url + '/order/edit?oid=' + order_id;
        $.get(url, function (response) {
            $('#edit-order-modal-content').html(response);

        });
    }
</script>
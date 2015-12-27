<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý dịch vụ khám</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable" id="service_management">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên dịch vụ</td>
                                <td>Giá dịch vụ</td>
                                <td>Khuyến mãi</td>
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
<script>
    $(document).ready(function () {
        $('#service_management').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo Yii::app()->createUrl('service/getAllService') ?>",
                "type": "GET"
            },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'service_name', name: 'service_name'},
                {data: 'service_price', name: 'service_price'},
                {data: 'favorable', name: 'favorable'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ]
        });
    });

</script>
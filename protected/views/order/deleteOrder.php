<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Xóa yêu cầu mã <?php echo $data ?></h4>
</div>
<div class="modal-body">
    <form role="form" method="POST" id="form-delete-order">

        <div class="box-body">
            <div class="col-md-12">
                Bạn có chắc chắn xóa yêu cầu mã số <?php echo $data ?> ?. Hành động này sẽ không thể khôi phục lại !

            </div>
            <input type="hidden" name="order_id" value="<?php echo $data ?>">
        </div><!-- /.box-body -->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-danger" id="delete-order-submit">Xóa</button>
</div>
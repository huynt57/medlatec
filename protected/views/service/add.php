<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Thêm mới dịch vụ</h4>
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

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Miêu tả</label>
                    <input type="text" class="form-control" id="description" name="description" >
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select class="form-control" name="status">
                        <?php foreach (Util::getStatusValue() as $key => $value): ?>
                            <option value="<?php echo $key ?>" <?php
                            if ($data->status == $key):
                                ?>  selected=""
                                    <?php endif; ?>><?php echo $value ?></option>
                                <?php endforeach; ?>
                    </select>                           
                </div>
            </div>

        </div><!-- /.box-body -->

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-primary" id="edit-service-submit">Lưu</button>
</div>
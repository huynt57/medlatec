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
                    <label for="relative_favorable">Khuyến mãi tương đối</label>
                    <input type="text" class="form-control" id="relative_favorable" name="relative_favorable" >
                </div>
                <div class="form-group">
                    <label for="absolute_favorable">Khuyến mãi tuyệt đối</label>
                    <input type="text" class="form-control" id="absolute_favorable" name="absolute_favorable" >
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Miêu tả</label>
                    <textarea class="form-control" id="description" name="description" ></textarea>
                </div>
                <div class="form-group">
                    <label for="condition">Điều kiện khuyến mại</label>
                    <textarea type="text" class="form-control" id="condition" name="condition" ></textarea>
                </div>
                <div class="form-group">
                    <label for="service_price_after">Giá dịch vụ sau khuyến mại</label>
                    <input type="text" class="form-control" id="service_price_after" name="service_price_after" >
                </div>
                <?php if (Yii::app()->session['type'] == 'meboo_admin'): ?>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status">
                            <?php foreach (Util::getStatusServiceMedlatec(Yii::app()->session['type']) as $key => $value): ?>
                                <option value="<?php echo $key ?>" <?php
                                if ($data->status == $key):
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
    <button type="button" class="btn btn-primary" id="edit-service-submit">Lưu</button>
</div>
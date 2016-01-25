<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Cập nhật dịch vũ mã <?php echo $data->id ?></h4>
</div>
<div class="modal-body">
    <form role="form" id="form-edit-service">
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="service_name">Tên dịch vụ</label>
                    <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $data->service_name ?>" >
                </div>
                <div class="form-group">
                    <label for="service_price">Giá dịch vụ</label>
                    <input type="text" class="form-control" id="service_price" name="service_price" value="<?php echo $data->service_price ?>">
                </div>
                <div class="form-group">
                    <label for="favorable">Khuyến mãi</label>
                    <input type="text" class="form-control" id="favorable" name="favorable" value="<?php echo $data->favorable ?>" >
                </div>

            </div>
            <input type="hidden" name="service_id" value="<?php echo $data->id ?>" >
            <input type="hidden" name="type" value="<?php echo Yii::app()->session['type'] ?>">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Miêu tả</label>
                    <textarea class="form-control" id="description" name="description" rows="6"><?php echo $data->description ?></textarea>
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
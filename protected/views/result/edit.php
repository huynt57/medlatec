<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Chỉnh sửa kết quả mã: <?php echo $data['id'] ?></h4>
</div>
<div class="modal-body">
    <form role="form" id="form-edit-result-order" enctype="multipart/form-data">

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="patient_name">Tên bệnh nhân</label>
                    <input disabled type="text" class="form-control" id="name" name="patient_name" disabled value="<?php echo $data['patient_name_f'] ?>" >
                </div>
                <div class="form-group">
                    <label>Dịch vụ</label>
                    <input disabled type="text" name="service_name_f" class="form-control" id="service_name_f" disabled value="<?php echo $data['service_name_f'] ?>" >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input disabled type="text" name="email" class="form-control" id="email" disabled value="<?php echo $data['email'] ?>" >
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input disabled type="text" name="address" class="form-control" id="address" disabled value="<?php echo $data['address'] ?>"  >
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="doctor">Bác sĩ</label>
                    <input type="text" name="doctor" class="form-control" id="doctor" value="<?php echo $data['doctor'] ?>"  >
                </div>
                <div class="form-group">
                    <label for="diagnose">Chẩn đoán</label>
                    <input  type="text" name="diagnose" class="form-control" id="diagnose" value="<?php echo $data['diagnose'] ?>"  >
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select class="form-control" name="status">
                        <?php foreach (Util::getStatusValue() as $key => $value): ?>
                            <option value="<?php echo $key ?>" <?php
                            if ($data['status'] == $key):
                                ?>  selected=""
                                    <?php endif; ?>><?php echo $value ?></option>
                                <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">File đính kèm </label>
                    <input type="file" id="file" name="file[]" multiple="">

                    <p class="help-block">Có thể đính nhiều file</p>
                </div>
                <div class="form-group">
                    <label>Mã yêu cầu</label>
                    <select class="form-control" name="order_id" id="order_id">
                        <?php foreach ($orders as $order): ?>
                            <option value="<?php echo $order->id ?>" <?php
                            if ($data['status'] == $order->id):
                                ?>  selected=""
                                    <?php endif; ?>><?php echo $order->id ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div><!-- /.box-body -->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-primary" id="edit-order-result-submit">Lưu</button>
</div>
<script>
    $(document).ready(function () {
        $('body').on('focus', "#time_confirm", function () {
            $(this).datepicker();
        });
    });
</script>

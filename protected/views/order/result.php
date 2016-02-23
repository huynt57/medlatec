<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nhập kết quả cho yêu cầu mã: <?php echo $data['id'] ?></h4>
</div>
<div class="modal-body">
    <form role="form" id="form-edit-result-order" enctype="multipart/form-data">

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input disabled type="text" class="form-control" id="name" name="name" value="<?php echo $data['name'] ?>" >
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input disabled type="text" class="form-control" id="phone" name="phone" value="<?php echo $data['phone'] ?>" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input disabled type="text" name="email" class="form-control" id="email" value="<?php echo $data['email'] ?>" >
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input disabled type="text" name="address" class="form-control" id="address" value="<?php echo $data['address'] ?>"  >
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="doctor">Bác sĩ</label>
                    <input type="text" name="doctor" class="form-control" id="doctor" value="<?php if (isset($result)) echo $result->doctor ?>"  >
                </div>
                <div class="form-group">
                    <label for="diagnose">Chẩn đoán</label>
                    <input  type="text" name="diagnose" class="form-control" id="diagnose" value="<?php if (isset($result)) echo $result->diagnose ?>"  >
                </div>
                <!--                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status" id="status">
                <?php foreach (Util::getStatusValue() as $key => $value): ?>
                                                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php endforeach; ?>
                                    </select>
                                </div>-->
                <div class="form-group">
                    <label for="file">Các file đã đính kèm </label>
                    <ul>
                          <?php $i = 1 ?>
                        <?php foreach ($files as $file): ?>
                          
                        <li><a href="<?php echo $file->url ?>" target="_blank">File <?php echo $i++ ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="form-group">
                    <label for="file">File đính kèm </label>
                    <input type="file" id="file" name="file[]" multiple="">

                    <p class="help-block">Có thể đính nhiều file</p>
                </div>

                <input type="hidden" id="order_id" name="order_id" value="<?php echo $data['id'] ?>" >
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

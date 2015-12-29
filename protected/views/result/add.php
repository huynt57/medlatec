<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo $data['id'] ?></h4>
</div>
<div class="modal-body">
    <form role="form" id="form-edit-order">

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Tên bệnh nhân</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name'] ?>" >
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data['phone'] ?>" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?php echo $data['email'] ?>" >
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" id="address" value="<?php echo $data['address'] ?>"  >
                </div>
                <div class="form-group">
                    <label for="requirement">Yêu cầu</label>
                    <textarea rows="5" class="form-control" id="requirement" name="requirement" value="<?php echo $data['requirement'] ?>" ></textarea>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number">Trạng thái</label>
                    <input type="text" class="form-control" id="number" name="number" >
                </div>
                <div class="form-group">
                    <label for="service_name">Dịch vụ</label>
                    <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $data['service_name'] ?>" >
                </div>
                <div class="form-group">
                    <label for="time_confirm">Thời gian xác nhận</label>
                    <input type="text" name="time_confirm" class="form-control" id="time_confirm" value="<?php echo $data['time_confirm'] ?>"  >
                </div>
                <div class="form-group">
                    <label for="time_meet">Thời gian gặp</label>
                    <input type="text" name="time_meet" class="form-control" id="time_meet" value="<?php echo $data['time_meet'] ?>" >
                </div>
                <div class="form-group">
                    <label for="created_at">Thời điểm tạo</label>
                    <input type="text" name="created_at" class="form-control" id="created_at" value="<?php echo $data['created_at'] ?>" >
                </div>
                <div class="form-group">
                    <label for="updated_at">Thời điểm cập nhật</label>
                    <input type="text" name="updated_at" class="form-control" id="updated_at" value="<?php echo $data['updated_at'] ?>" >
                </div>

                
            </div>

        </div><!-- /.box-body -->


    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-primary" id="edit-order-submit">Lưu</button>
</div>
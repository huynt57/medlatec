<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo $data['id'] ?></h4>
</div>
<div class="modal-body">
    <form role="form" method="POST" action="<?php echo Yii::app()->createUrl('documentary/addProcess') ?>">

        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number">Tên</label>
                    <input type="text" class="form-control" id="number" name="number" >
                </div>
                <div class="form-group">
                    <label for="time_in_doc">Số điện thoại</label>
                    <input type="text" class="form-control" id="time_in_doc" name="time_in_doc"  >
                </div>
                <div class="form-group">
                    <label for="reciever">Địa chỉ</label>
                    <input type="text" name="reciever" class="form-control" id="reciever"  >
                </div>
                <div class="form-group">
                    <label for="abstract">Yêu cầu</label>
                    <textarea rows="5" class="form-control" id="abstract" name="abstract"  ></textarea>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number">Trạng thái</label>
                    <input type="text" class="form-control" id="number" name="number" >
                </div>
                <div class="form-group">
                    <label for="time_in_doc">Dịch vụ</label>
                    <input type="text" class="form-control" id="time_in_doc" name="time_in_doc"  >
                </div>
                <div class="form-group">
                    <label for="reciever">Thời gian xác nhận</label>
                    <input type="text" name="reciever" class="form-control" id="reciever"  >
                </div>
                <div class="form-group">
                    <label for="reciever">Thời gian gặp</label>
                    <input type="text" name="reciever" class="form-control" id="reciever"  >
                </div>
                <div class="form-group">
                    <label for="reciever">Thời điểm tạo</label>
                    <input type="text" name="reciever" class="form-control" id="reciever"  >
                </div>
                <div class="form-group">
                    <label for="reciever">Thời điểm cập nhật</label>
                    <input type="text" name="reciever" class="form-control" id="reciever"  >
                </div>


            </div>

        </div><!-- /.box-body -->


    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-primary">Lưu</button>
</div>
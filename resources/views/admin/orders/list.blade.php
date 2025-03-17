<div class="row">
    <div class="col-md-12">
        <form id="formOrder" novalidate="novalidate" autocomplete="off">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="order_code">Tên danh mục</label>
                        <input type="text"  id="order_code" name="order_code"  class="form-control" >
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="order_status_id">Trạng thái đơn hàng</label>
                        <select name="order_status_id", id="order_status_id" class="form-control selectpicker" data-live-search="true" data-size="10">
                                    @foreach($data['list_status'] as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->status_name }}
                                                </option>
                                    @endforeach

                        </select>
                        <div id="cancelStatus" style="display:none;">
                        <p>Trạng thái "Hủy" sẽ không xuất hiện khi đơn hàng đang trong trạng thái "Đang xử lý".</p>
                        </div>
                        
                                        
                </div>
                
                   
                </div>
            </div>
        </form>
        <div class="model-footer" style="float: right">
            <button type="button" class="btn btn-default close_btn" data-dismiss="modal">Đóng</button>
            <button type="button" onclick="pushOrder()" class="btn btn-info">Lưu</button>
        </div>
    </div>
</div>

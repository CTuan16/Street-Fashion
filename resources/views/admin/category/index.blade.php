@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons">
                        <a onclick="addCategoryParent(event)" class="btn btn-primary mright5 test pull-left display-block">
                            <i class="fa-regular fa-plus tw-mr-1"></i>
                            Thêm mới</a>
                        <a href="#" onclick="alert('Liên hệ tuan16@fpt.com nếu xảy ra lỗi không mong muốn!')"
                           class="btn btn-default pull-left display-block mright5">
                            <i class="fa-regular fa-user tw-mr-1"></i>Liên hệ
                        </a>
                        <div class="visible-xs">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel_s tw-mt-2 sm:tw-mt-4">
                        <div class="panel-body">
                            <div class="panel-table-full">
                                {{ $dataTable->table(['id' => 'categories_manage'], $footer = false) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.template.modal', ['id' => 'showDetail_Modal', 'title'=>'Thêm danh mục', 'form'=>'admin.category.create'])
@endsection
@push('script')
    {{ $dataTable->scripts() }}
    <script>
        // Hàm hiển thị dialog xác nhận trước khi thực hiện ajax
        // Params: 
        // - sureCallbackFunction: hàm callback sẽ được gọi khi user xác nhận
        // - data: dữ liệu truyền vào callback
        // - text: nội dung thông báo xác nhận
        function dialogConfirmWithAjaxCategoryParent(sureCallbackFunction, data, text = "Xin hay kiểm tra lại") {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Chắc chắn!',
                reverseButtons: true

            }).then((result) => {
                if (result.isConfirmed) {
                    // Gọi callback nếu user xác nhận
                    sureCallbackFunction(data);
                }else {
                    // Reload lại bảng dữ liệu nếu user hủy
                    let table = $('#categories_manage').DataTable();
                    table.ajax.reload(null, false);
                }
            });
        }

    
        // Hàm xóa danh mục
        // Param: data - chứa id của danh mục cần xóa 
        function deleteCategoryParent(data) {
            let dataPost = {};
            dataPost.id = $(data).data('id');
            // Gọi API xóa danh mục
            $.post('/admin/category-parent/destroy', dataPost).done(function (response) {
                alert_float('success', response.message);
                // Reload lại bảng sau khi xóa thành công
                let table = $('#categories_manage').DataTable();
                table.ajax.reload(null, false);
            });
        }

        // Hàm mở modal thêm mới danh mục
        // Param: e - event click
        function addCategoryParent(e) {
                e.preventDefault();
                // Hiển thị modal
                $('#showDetail_Modal').modal('toggle');
                // Reset form
                document.getElementById('formCategoriesParent').reset();
               
                // Cấu hình cho form thêm mới
                window.urlMethod = '/admin/category-parent/store'; 
                window.type = 'POST';
            }

        // Hàm hiển thị chi tiết danh mục để sửa
        // Param: _this - element được click chứa data-id
        function detailCategoryParent(_this) {
            let dataPost = {};
            dataPost.id = $(_this).data('id');
            // Gọi API lấy chi tiết danh mục
            $.post('/admin/category-parent/show', dataPost).done(function (response) {
                console.log(response.data);
                // Điền dữ liệu vào từng trường trong form
                for (let [key, value] of Object.entries(response.data)) {
                    let k = $('#' + key);
                    k.val(value);
                    k.trigger('change');
                }

                // Hiển thị modal và cấu hình cho form cập nhật
                $('#showDetail_Modal').modal('toggle');
                window.urlMethod = '/admin/category-parent/update/' + $(_this).data('id');
                window.type = 'PUT';
            });
        }

        // Hàm lưu/cập nhật danh mục
        function pushCategoryParent() {
            // Disable nút submit để tránh submit nhiều lần
            $(this).attr('disabled', 'disabled');
            let data = $('#formCategoriesParent').serialize();
            
            // Gọi API tạo mới/cập nhật danh mục
            $.ajax({
                url: urlMethod,
                type: window.type,
                dataType: 'json',
                data: data,
                cache: false,
                success: (data) => {
                    if (data.success) {
                        // Đóng modal và hiển thị thông báo thành công
                        $('#showDetail_Modal').modal('toggle');
                        alert_float('success', data.message);
                        // Reload lại bảng dữ liệu
                        let table = $('#categories_manage').DataTable();
                        table.ajax.reload(null, false);
                        $('#submit').prop('disabled', false);
                    } else {
                        // Hiển thị thông báo lỗi
                        alert_float('danger', data.message);
                        $('#submit').prop('disabled', false);
                    }
                }, 
                error: function (xhr) {
                    // Xử lý lỗi từ server
                    let errorString = xhr.responseJSON.message ?? '';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorString = value;
                        return false;
                    });
                    alert_float('danger', errorString);
                    $('#submit').prop('disabled', false);
                }
            });
        }
    </script>
@endpush

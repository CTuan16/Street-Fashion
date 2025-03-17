@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper"> 
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons">
                        <a onclick="addCategoryChild(event)" class="btn btn-primary mright5 test pull-left display-block">
                            <i class="fa-regular fa-plus tw-mr-1"></i>
                            Thêm mới</a>
                        <a href="#" onclick="alert('Liên hệ tuanhhcps30852@fpt.edu.vn nếu xảy ra lỗi không mong muốn!')"
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
                                {{ $dataTable->table(['id' => 'category_manage'], $footer = false) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.template.modal', ['id' => 'showDetail_Modal', 'title'=>'Thêm danh mục', 'form'=>'admin.category-child.list'])
@endsection
@push('script')
    {{ $dataTable->scripts() }}
    <script>

        /**
         * Xóa danh mục con
         * @param {object} data - Chứa id của danh mục cần xóa
         * - Gửi request xóa đến server
         * - Hiển thị thông báo kết quả
         * - Reload lại bảng dữ liệu
         */
        function deleteCategoryChild(data) {
            let dataPost = {};
            dataPost.id = $(data).data('id');
            $.post('/admin/category-child/destroy', dataPost).done(function (response) {
                alert_float('success', response.message);
                let table = $('#category_manage').DataTable();
                table.ajax.reload(null, false);
            });
        }

        /**
         * Mở form thêm mới danh mục con
         * @param {object} e - Event object
         * - Ngăn chặn hành vi mặc định của event
         * - Hiển thị modal
         * - Reset form
         * - Cấu hình URL và method cho form
         */
        function addCategoryChild(e) {
            e.preventDefault();
            $('#showDetail_Modal').modal('toggle');
            document.getElementById('formCategoryChild').reset();
            window.urlMethod = '/admin/category-child/store';
            window.type = 'POST';
        }


        function detailCategoryChild(_this) {
            let dataPost = {};
            dataPost.id = $(_this).data('id');
            $.post('/admin/category-child/show', dataPost).done(function (response) {
                console.log(response.data);
                for (let [key, value] of Object.entries(response.data)) {
                    let k = $('#' + key);
                    k.val(value);
                    k.trigger('change');
                }

                $('#showDetail_Modal').modal('toggle');
                window.urlMethod = '/admin/category-child/update/' + $(_this).data('id');
                window.type = 'PUT';
            });
        }

        function pushCategoryChild() {
            $(this).attr('disabled', 'disabled');
            let data = $('#formCategoryChild').serialize();
            $.ajax({
                url: urlMethod,
                type: window.type,
                dataType: 'json',
                data: data,
                cache: false,
                success: (data) => {
                    if (data.success) {
                        $('#showDetail_Modal').modal('toggle');
                        alert_float('success', data.message);
                        let table = $('#category_manage').DataTable();
                        table.ajax.reload(null, false);
                        $('#submit').prop('disabled', false);
                    } else {
                        alert_float('danger', data.message);
                        $('#submit').prop('disabled', false);
                    }
                },
                error: function (xhr) {
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

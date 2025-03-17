@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper" style="min-height: 1405px;">
        <div class="content">
            <div class="row">
                <form action="{{ route('products.store') }}" class="staff-form dirty" autocomplete="off"
                      enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                    @method('POST')
                    @csrf
                    <div class="col-md-8 col-md-offset-2" id="small-table">
                        <div class="panel_s">
                            <div class="panel-body">
                                <input type="text" name="role_id" class="hide" value="10">
                                <div class="form-group" app-field-wrapper="name">
                                    <label for="name" class="control-label">
                                        <small class="req text-danger">* </small>Tên sản phẩm</label>
                                    <input type="text" id="slug" onkeyup="ChangeToSlug();" name="name" class="form-control"
                                           autofocus="1" value="{{ old('name') }}">
                                </div>

                                <div class="form-group" app-field-wrapper="category_child"><label for="category_child"
                                                                                         class="control-label">Danh mục</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                        <select id="id_category_child" name="id_category_child" class="selectpicker" data-width="100%"
                                                data-none-selected-text="Không có mục nào được chọn"
                                                data-live-search="true" tabindex="-98">
                                            <option value=""></option>
                                            @foreach($data['list_categories'] as $Category_child)
                                                <option value="{{ $Category_child->id }}">
                                                    {{ $Category_child->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" app-field-wrapper="name">
                                    <label for="slug" class="control-label">
                                        <small class="req text-danger">* </small>Slug</label>
                                    <input type="text" id="convert_slug" name="slug" class="form-control"
                                            >
                                </div>
                                <div class="form-group" app-field-wrapper="quantity">
                                    <label for="quantity" class="control-label">
                                        <small class="req text-danger">* </small>Số lượng
                                    </label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" required>
                                </div>
                                <div class="form-group" app-field-wrapper="price_old"><label for="price_old"
                                                                                         class="control-label">
                                        <small class="req text-danger">* </small>Giá bán</label><input
                                        type="price" id="price" name="price" class="form-control"
                                        autocomplete="off" value="{{ old('price') }}">
                                </div>
                                <div class="form-group" app-field-wrapper="price_new"><label for="price_new"
                                                                                         class="control-label">
                                        <small class="req text-danger">* </small>Giá giảm</label><input
                                        type="price_sale" id="price_sale" name="price_sale" class="form-control"
                                        autocomplete="off" value="{{ old('price_sale') }}">
                                </div>

                                <div class="form-group" app-field-wrapper="sizes">
                                    <label for="sizes" class="control-label"><small class="req text-danger">* </small>Kích thước</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                        <select id="sizes" name="sizes[]" class="selectpicker" data-width="100%" multiple
                                                data-none-selected-text="Chọn size"
                                                data-live-search="true">
                                            @foreach($data['list_sizes'] as $size)
                                                <option value="{{ $size->id }}">{{ $size->name_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" app-field-wrapper="colors">
                                    <label for="colors" class="control-label"><small class="req text-danger">* </small>Màu</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                        <select id="colors" name="colors[]" class="selectpicker" data-width="100%" multiple
                                                data-none-selected-text="Chọn màu sắc"
                                                data-live-search="true">
                                            @foreach($data['list_colors'] as $color)
                                                <option value="{{ $color->id }}">{{ $color->name_color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                
                                <div class="form-group" app-field-wrapper="product_sale">
                                    <label class="control-label">
                                        <small class="req text-danger">* </small>Chế độ bán hàng
                                    </label>
                                    <div>
                                        <label>
                                            <input type="radio" name="product_sale" value="1" {{ old('product_sale', $product_meta->product_sale ?? 0) == 1 ? 'checked' : '' }}>
                                            Sale
                                        </label>
                                        <label style="margin-left: 20px;">
                                            <input type="radio" name="product_sale" value="2" {{ old('product_sale', $product_meta->product_sale ?? 0) == 2 ? 'checked' : '' }}>
                                            Không Sale
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" app-field-wrapper="name">
                                    <label for="description" class="control-label">
                                        <small class="req text-danger">* </small>Mô tả</label>
                                        <textarea id="description" name="description" class="form-control tinymce-manual" cols="100" id=""></textarea>  
                                </div>
                                <div class="form-group" id="path_1">
                                    <label class="control-label"><small class="req text-danger">* </small>Ảnh</label>
                                    <input type="file" accept="img/Products/*" name="path_1[]"  class="form-control" multiple 
                                           onchange="handleUploadImages(this)" multiple/>
                                    <div id="img_container_1" style="padding:10px;margin-top:10px"></div>
                                    <input name="image" id="img_path_1_names" value="" hidden/>
                                </div>
                                <!-- Trạng thái sản phẩm -->
                            <div class="form-group" app-field-wrapper="status">
                                <label class="control-label">Trạng thái</label>
                                <div>
                                    <label>
                                        <input type="checkbox" name="status" value="1" checked> Kích hoạt
                                    </label>
                                </div>
                            </div>

                </div>
                            <div class="btn-bottom-toolbar text-right">
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                            </div>
                </form>
            </div>
        </div>
        <script>
            
        function handleUploadImages(input) {
                const files = input.files;
                const imgContainer = document.getElementById('img_container_1');
                imgContainer.innerHTML = ''; // Xóa hình ảnh cũ

                if (files.length === 0) return; // Không có tệp nào được chọn

                for (const file of files) {
                    if (file.size > 700000) { // 700 KB
                        alert_float('danger', 'File is too big! Allowed memory size of 0.7MB');
                        return;
                    }

                    const imgElement = document.createElement('img');
                    imgElement.src = URL.createObjectURL(file);
                    imgElement.className = 'img-thumbnail img_viewable';
                    imgElement.style.maxWidth = '150px';
                    imgElement.style.padding = '10px';
                    imgElement.style.marginTop = '10px';
                    imgContainer.appendChild(imgElement);
                    
                    // Cập nhật tên hình ảnh vào input ẩn
                    const inputNameField = document.getElementById('img_path_1_names');
                    inputNameField.value += file.name + ','; // Lưu tên tệp
                }
            }

function addProducts(e) {
            e.preventDefault();
            // $('#showDetail_Modal').modal('toggle');
            document.getElementById('formProducts').reset();
            window.urlMethod = '/admin/products/store';
            window.type = 'POST';
        }

function pushProducts() {
    // Vô hiệu hóa nút submit
    $('#submit').prop('disabled', true);
    
    // Lấy dữ liệu từ form
    let data = $('#formProducts').serialize();
    
    $.ajax({
        url: urlMethod,
        type: window.type,
        dataType: 'json',
        data: data,
        cache: false,
        success: (data) => {
            if (data.success) {
                // Đóng modal và reset form
                // $('#showDetail_Modal').modal('toggle');
                $('#formProducts')[0].reset(); // Reset form
                
                // Cập nhật selectpicker và ảnh mặc định
                // $('#categories_id').val('').selectpicker('refresh'); 
                $('#img_path_1').attr('src', "{{ asset('/images/image_holder.png') }}");
                $('#img_path_1_name').val(''); // Xóa giá trị tên file
                
                // Hiển thị thông báo thành công
                alert_float('success', data.message);
                
                // Tải lại bảng dữ liệu
                let table = $('#products_manage').DataTable();
                table.ajax.reload(null, false);
            } else {
                // Hiển thị thông báo lỗi nếu không thành công
                alert_float('danger', data.message);
            }
        },
        error: function (xhr) {
            let errorString = xhr.responseJSON.message || 'Đã xảy ra lỗi, vui lòng thử lại!';
            $.each(xhr.responseJSON.errors, function (key, value) {
                errorString = value; // Lấy thông báo lỗi đầu tiên
                return false; // Ngừng lặp khi đã có lỗi
            });
            alert_float('danger', errorString); // Hiển thị thông báo lỗi
        },
        complete: function () {
            // Bật lại nút submit khi hoàn tất
            $('#submit').prop('disabled', false);
        }
    });
}

    </script>
    </div>
@endsection

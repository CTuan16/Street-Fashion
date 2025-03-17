@extends('admin.layoutv2.layout.app')

@section('content')
<div id="wrapper" style="min-height: 1405px;">
    <div class="content">
        <div class="row">
            <form action="{{ route('products.update', [$product->id]) }}" class="staff-form dirty" autocomplete="off"
                  enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                @csrf
                @method('PUT')
                <input type="text" name="role_id" class="hide" value="{{ $product->role_id }}">
                <div class="col-md-8 col-md-offset-2" id="small-table">
                    <div class="panel_s">
                        <div class="panel-body">
                            <!-- Các trường thông tin sản phẩm -->
                            <div class="form-group" app-field-wrapper="name">
                                <label for="name" class="control-label">
                                    <small class="req text-danger">* </small>Tên sản phẩm</label>
                                <input type="text" id="name" name="name" class="form-control"
                                       autofocus="1" value="{{ $product->name }}">
                            </div>
                            <div class="form-group" app-field-wrapper="categories">
                                <label for="categories" class="control-label">Danh mục</label>
                                <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                    <select id="id_category_child" name="id_category_child" class="selectpicker" data-width="100%"
                                            data-none-selected-text="Không có mục nào được chọn"
                                            data-live-search="true" tabindex="-98">
                                        <option value=""></option>
                                        @foreach($data['list_categories'] as $Category_child)
                                            <option value="{{ $Category_child->id }}" {{ $Category_child->id == $product->id_category_child ? 'selected' : '' }}>                                                
                                                {{ $Category_child->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" app-field-wrapper="quantity">
                                    <label for="quantity" class="control-label">
                                        <small class="req text-danger">* </small>Số lượng
                                    </label>
                                    <input type="number" value="{{ $product->product_meta->first()->quantity ?? '' }}" id="quantity" name="quantity" class="form-control" min="1" required>
                            </div>
                            <div class="form-group" app-field-wrapper="price_old">
                                <label for="price_old" class="control-label">
                                    <small class="req text-danger">* </small>Giá</label>
                                <div class="input-group">
                                    <!-- Hiển thị giá từ product_meta đầu tiên -->
                                    <input type="text" id="price" name="price" class="form-control"
                                        autocomplete="off" value="{{ $product->product_meta->first()->price ?? '' }}">
                                    <span class="input-group-addon">
                                        <i class="fa-solid fa-dong-sign"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" app-field-wrapper="price_sale">
                                <label for="price_sale" class="control-label">
                                    <small class="req text-danger">* </small>Giá giảm</label>
                                <div class="input-group">
                                    <input type="text" id="price_sale" name="price_sale" class="form-control"
                                        autocomplete="off" value="{{ $product->product_meta->first()->price_sale ?? '' }}">
                                    <span class="input-group-addon">
                                        <i class="fa-solid fa-dong-sign"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" app-field-wrapper="sizes">
                                    <label for="sizes" class="control-label"><small class="req text-danger">* </small>Kích thước</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                        <select id="sizes" name="sizes[]" class="selectpicker" data-width="100%" multiple
                                                data-none-selected-text="Chọn size"
                                                data-live-search="true">
                                            @foreach($data['list_sizes'] as $size)
                                                <option value="{{ $size->id }}" 
                                                    {{ in_array($size->id, $product->productsize->pluck('size_id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $size->name_size }}
                                                </option>
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
                                                <option value="{{ $color->id }}"
                                                    {{ in_array($color->id, $product->productcolor->pluck('color_id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $color->name_color }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                            <div class="form-group" app-field-wrapper="product_sale">
                                <label class="control-label">
                                    <small class="req text-danger">* </small>Chế độ bán hàng
                                </label>
                                <div>
                                    @php
                                        $productMeta = $product->product_meta->first();
                                        // Mặc định là 1 (Không Sale) nếu không có meta
                                        $isSale = $productMeta ? $productMeta->product_sale : 2;
                                    @endphp
                                    
                                    <label>
                                        <input type="radio" name="product_sale" value="1" {{ old('product_sale', $product_meta->product_sale ?? 0) == 1 ? 'checked' : '' }}>
                                        Sale
                                    </label>
                                    <label style="margin-left: 20px;">
                                        <input type="radio" name="product_sale" value="2" {{ old('product_sale', $product_meta->product_sale ?? 0) == 2 ? 'checked' : '' }}>
                                        Không Sale
                                    </label>

                                    <!-- Debug info - xóa sau khi fix xong -->
                                    <div style="display:none">
                                        Meta exists: {{ $productMeta ? 'Yes' : 'No' }}<br>
                                        Sale value: {{ $isSale }}<br>
                                        Is Sale?: {{ $isSale == 0 ? 'Yes' : 'No' }}
                                    </div>
                                </div>
                            </div>



                            <!-- Các trường danh mục -->
                            
                

                            <!-- Trường mô tả sản phẩm -->
                            <div class="form-group" app-field-wrapper="description">
                                <label for="description" class="control-label">
                                    <small class="req text-danger">* </small>Mô tả</label>
                                <textarea id="description" name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                            </div>

                            <!-- Trường upload hình ảnh -->
                            <div class="form-group" id="path_1">
                                <label class="control-label"><small class="req text-danger">* </small>Ảnh</label>
                                <input type="file" accept="image/*" name="path_1[]" class="form-control" multiple id="uploadImage"/>
                                <div id="img_container_1" style="padding:10px;margin-top:10px; display: flex; flex-wrap: wrap;">
                                    <div class="existing-image" data-image-id="{{ $product->id }}" style="display: inline-block; margin: 5px; position: relative;">
                                            <img src="{{ asset($product->primary_image) }}" width="100" height="100" 
                                                style="border: 2px solid #007bff; cursor: pointer;">
                                                <span class="primary-star" style="position: absolute; top: 5px; left: 5px; color: gold; font-size: 20px;">★</span>
                                            
                                            <button type="button" class="btn btn-danger btn-sm" style="position: absolute; bottom: 0; right: 0;" onclick="removeImage(this)">Xóa</button>
                                    </div>
                                    <div class="existing-image" data-image-id="{{ $product->id }}" style="display: inline-block; margin: 5px; position: relative;">
                                            <img src="{{ asset($product->second_image) }}" width="100" height="100" 
                                                style="border: 2px solid #007bff; cursor: pointer;">
                                            
                                            <button type="button" class="btn btn-danger btn-sm" style="position: absolute; bottom: 0; right: 0;" onclick="removeImage(this)">Xóa</button>
                                    </div>
                                </div>
                                <input type="hidden" id="deleted_images" name="deleted_images" value="">
                            </div>

                            <!-- Trường trạng thái sản phẩm -->
                            <div class="form-group" app-field-wrapper="status">
                                <label class="control-label">Trạng thái</label>
                                <div>
                                    <label>
                                        <input type="checkbox" name="status" value="1" {{ $product->status ? 'checked' : '' }}> Kích hoạt
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-bottom-toolbar text-right">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Thêm mã JavaScript vào đây -->
<script>
    let images = [];
    let selectedImages = [];
    let primaryImage = null;

    // Lưu trữ các hình ảnh mới
    let newImageIds = [];
function setPrimaryImage(imageId, imgElement) {
    // Bỏ ngôi sao khỏi tất cả ảnh khác
    let selectedImages = [];
    document.querySelectorAll('.primary-star').forEach(star => star.remove());

    // Cập nhật is_primary cho các ảnh khác thành 0
    selectedImages = selectedImages.map(id => {
        if (id === imageId) {
            return { id: imageId, is_primakey: 1 };
        }
        return { id, is_primakey: 0 };
    });

    // Thêm ngôi sao vào ảnh đã chọn
    const starElement = document.createElement('span');
    starElement.className = 'primary-star';
    starElement.style.position = 'absolute';
    starElement.style.top = '5px';
    starElement.style.left = '5px';
    starElement.style.color = 'gold';
    starElement.style.fontSize = '20px';
    starElement.innerText = '★';
    imgElement.parentElement.appendChild(starElement);

    // Lưu id ảnh chính vào input ẩn
    document.getElementById('img_path_1_names').value = selectedImages.map(img => img.id).join(',');
}

// Biến lưu trữ hình ảnh và trạng thái


// Tạo hàm xử lý tải lên hình ảnh
document.getElementById('uploadImage').addEventListener('change', function(event) {
    const files = event.target.files;
    const imgContainer = document.getElementById('img_container_1');
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.border = '2px solid #007bff';
            img.style.cursor = 'pointer';

            const imageDiv = document.createElement('div');
            imageDiv.className = 'existing-image';
            imageDiv.style.display = 'inline-block';
            imageDiv.style.margin = '5px';
            imageDiv.style.position = 'relative';
            imageDiv.appendChild(img);

            const imageId = 'new_' + (index + 1); // Sử dụng ID giả để hình ảnh mới
            newImageIds.push(imageId); // Lưu ID hình ảnh mới

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-danger btn-sm';
            removeBtn.style.position = 'absolute';
            removeBtn.style.bottom = '0';
            removeBtn.style.right = '0';
            removeBtn.innerText = 'Xóa';
            removeBtn.onclick = function() {
                imgContainer.removeChild(imageDiv);
                // Xóa ID hình ảnh mới nếu nó được xóa
                newImageIds = newImageIds.filter(id => id !== imageId);
                updateHiddenInput(); // Cập nhật input ẩn mỗi khi xóa
            };
            imageDiv.appendChild(removeBtn);
            imgContainer.appendChild(imageDiv);
        }
        reader.readAsDataURL(file);
    });

    // Cập nhật input ẩn với các ID hình ảnh mới
    updateHiddenInput();
});

// Cập nhật giá trị của input n với các ID hình ảnh
function updateHiddenInput() {
    const allIds = [...selectedImages.map(img => img.id), ...newImageIds];
    document.getElementById('img_path_1_names').value = allIds.join(',');
}

// Hàm xóa hình ảnh đã có
function removeImage(button) {
    const imageDiv = button.parentElement;
    const imageId = imageDiv.getAttribute('data-image-id');
    // Thêm ID hình ảnh đã xóa vào input ẩn
    const deletedImages = document.getElementById('deleted_images');
    deletedImages.value = deletedImages.value ? deletedImages.value + ',' + imageId : imageId;

    // Xóa hình ảnh khỏi DOM
    imageDiv.parentNode.removeChild(imageDiv);

    // Cập nhật input ẩn với các ID hình ảnh còn lại
    updateHiddenInput();
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-row').forEach(function(element) {
        element.addEventListener('click', function() {
            return confirm('Bạn có chắc chắn?');
        });
    });
});
</script>
@endsection

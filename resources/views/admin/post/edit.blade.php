@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            <h4 class="no-margin">Chỉnh sửa bài viết</h4>
                            <hr class="hr-panel-heading" />
                            
                            <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title" class="control-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="content" class="control-label">Nội dung</label>
                                    <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
                                </div>

                                

                                <div class="form-group" id="path_1">
                                    <label class="control-label"><small class="req text-danger">* </small>Ảnh</label>
                                    <input type="file" accept="image/*" name="path_1[]" class="form-control" multiple id="uploadImage"/>
                                    <div id="img_container_1" style="padding:10px;margin-top:10px; display: flex; flex-wrap: wrap;">
                                        @if($post->image)
                                            <div class="existing-image" data-image-id="{{ $post->id }}" style="display: inline-block; margin: 5px; position: relative;">
                                                <img src="{{ asset($post->image) }}" width="100" height="100" 
                                                     style="border: 2px solid #007bff; cursor: pointer;">
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        style="position: absolute; bottom: 0; right: 0;" 
                                                        onclick="removeImage(this)">Xóa</button>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" id="deleted_images" name="deleted_images" value="">
                                </div>

                                <div class="btn-bottom-toolbar text-right">
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    <a href="{{ route('post.index') }}" class="btn btn-default">Hủy</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function removeImage(button) {
            const imageDiv = button.parentElement;
            const imageId = imageDiv.getAttribute('data-image-id');
            
            // Thêm ID hình ảnh đã xóa vào input ẩn
            const deletedImages = document.getElementById('deleted_images');
            deletedImages.value = deletedImages.value ? deletedImages.value + ',' + imageId : imageId;

            // Xóa hình ảnh khỏi DOM
            imageDiv.parentNode.removeChild(imageDiv);
        }

        document.getElementById('uploadImage').addEventListener('change', function(event) {
            const files = event.target.files;
            const imgContainer = document.getElementById('img_container_1');
            
            Array.from(files).forEach((file, index) => {
                if (file.size > 700000) { // 700 KB
                    alert('File quá lớn! Kích thước tối đa cho phép là 0.7MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageDiv = document.createElement('div');
                    imageDiv.className = 'existing-image';
                    imageDiv.style.display = 'inline-block';
                    imageDiv.style.margin = '5px';
                    imageDiv.style.position = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.border = '2px solid #007bff';
                    img.style.cursor = 'pointer';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.bottom = '0';
                    removeBtn.style.right = '0';
                    removeBtn.innerText = 'Xóa';
                    removeBtn.onclick = function() {
                        imgContainer.removeChild(imageDiv);
                    };

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(removeBtn);
                    imgContainer.appendChild(imageDiv);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush

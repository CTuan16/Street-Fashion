@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            <h4 class="no-margin">Thêm bài viết mới</h4>
                            <hr class="hr-panel-heading" />
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="content">Nội dung</label>
                                    <textarea name="content" class="form-control" required></textarea>
                                </div>

                                <div class="form-group" id="path_1">
                                    <label class="control-label"><small class="req text-danger">* </small>Ảnh</label>
                                    <input type="file" accept="image/*" name="path_1[]" class="form-control" onchange="handleUploadImages(this)"/>
                                    <div id="img_container_1" style="padding:10px;margin-top:10px"></div>
                                    <input name="image" id="img_path_1_names" value="" hidden/>
                                </div>

                                <div class="btn-bottom-toolbar text-right">
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
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
</script>
@endpush

<div class="row">
    <div class="col-md-12">
        <form id="formCategoriesParent" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off" method="POST" action="{{ route('category-parent.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục">
                </div>
            </div>
        </div>
    </form>

        <div class="model-footer" style="float: right">
            <button type="button" class="btn btn-default close_btn" data-dismiss="modal">Đóng</button>
            <button type="button" onclick="pushCategoryParent()" class="btn btn-info">Lưu</button>
        </div>
    </div>
</div>

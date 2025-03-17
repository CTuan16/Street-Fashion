@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons">
                        <a onclick="addVoucher(event)" class="btn btn-primary mright5 test pull-left display-block">
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
                                {{ $dataTable->table(['id' => 'vouchers_manage'], $footer = false) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.template.modal', ['id' => 'showDetail_Modal', 'title'=>'Form Vouchers', 'form'=>'admin.vouchers.create'])
@endsection
@push('script')
    {{ $dataTable->scripts() }}
    <script>

     
        function changeStatusVoucher(data){
            let dataPost = {};
            dataPost.id = $(data).data('id');
            $.post('/admin/vouchers/change-status', dataPost).done(function(response) {
                alert_float('success', response.message);
                $('#vouchers_manage').DataTable().ajax.reload(null,false);
            });
        }
    
        function deleteVoucher(data) {
            let dataPost = {};
            dataPost.id = $(data).data('id');
            $.post('/admin/vouchers/destroy', dataPost).done(function (response) {
                alert_float('success', response.message);
                let table = $('#vouchers_manage').DataTable();
                table.ajax.reload(null, false);
            });
        }

        function addVoucher(e) {
            e.preventDefault();
            $('#showDetail_Modal').modal('toggle');
            document.getElementById('formVoucher').reset();
            window.urlMethod = '/admin/vouchers/store';
            window.type = 'POST';
        }
        function detailVoucher(_this) {
            let dataPost = {};
            dataPost.id = $(_this).data('id');
            $.post('/admin/vouchers/show', dataPost).done(function (response) {
                console.log(response.data);
                for (let [key, value] of Object.entries(response.data)) {
                    let k = $('#' + key);
                    k.val(value);
                    k.trigger('change');
                }
                $('#showDetail_Modal').modal('toggle');
                window.urlMethod = '/admin/vouchers/update/' + $(_this).data('id');
                window.type = 'PUT';
                console.log('Modal edit opened');
                console.log('Data:', response.data);

            });
        }

        function pushVoucher() {
            $(this).attr('disabled', 'disabled');
            let data = $('#formVoucher').serialize();
            $.ajax({
                url: urlMethod,
                type: window.type,
                dataType: 'json',
                data: data,
                cache: false,
                success: (data) => {
                    if (data.success) {
                        $('#showDetail_Modal').modal('toggle');
                        document.getElementById('formVoucher').reset();
                        alert_float('success', data.message);
                        $('#submit').prop('disabled', false);
                        let table = $('#vouchers_manage').DataTable();
                        table.ajax.reload(null, false);
                    } else {
                        alert_float('danger', data.message);
                        $('#submit').prop('disabled', false);
                    }
                }, error: function (xhr) {
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

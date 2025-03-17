@extends('admin.layoutv2.layout.app')

@section('content')
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons">
                        
                        <div class="visible-xs">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel_s tw-mt-2 sm:tw-mt-4">
                        <div class="panel-body">
                            <div class="panel-table-full">
                                {{ $dataTable->table(['id' => 'orders_manage'], $footer = false) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       @include('admin.template.modal', ['id' => 'showDetail_Modal', 'title'=>'Form Order', 'form'=>'admin.orders.list'])

@endsection
@push('script')
    {{ $dataTable->scripts() }}
    <script>

$(document).on('change', '.status-dropdown', function () {
    let statusId = $(this).val();  // ID trạng thái mới
    let rowId = $(this).data('id'); // ID hàng (ví dụ: order ID)
    let selectDropdown = $(this);   // Lấy đối tượng dropdown hiện tại
    let currentStatusId = $(this).data('current-status');  // Lấy trạng thái hiện tại từ data attribute

    console.log("Row ID:", rowId);
    console.log("Status ID:", statusId);

    // Gửi yêu cầu AJAX để cập nhật trạng thái, bao gồm cả khi trạng thái là 6
    $.ajax({
        url: "{{ route('update.payment.status') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            row_id: rowId,
            status_id: statusId
        },
        success: function (response) {
            console.log("Response:", response);

            // Nếu trạng thái là 6, vô hiệu hóa dropdown ngay sau khi cập nhật
            if (statusId == "Đã thanh toán") {
                selectDropdown.prop('disabled', true); 
                alert_float('success','Cập nhật trạng thái thành công!'); // Vô hiệu hóa dropdown
            } else {
                alert_float('success','Cập nhật trạng thái thành công!');
            }

            // Cập nhật trạng thái hiện tại sau khi thay đổi thành công
            selectDropdown.data('current-status', statusId);  // Cập nhật trạng thái hiện tại
                        console.log("Status:", statusId);

        },
        error: function (xhr, status, error) {
            console.log("XHR Object:", xhr);
            console.log("Status:", status);
            console.log("Error:", error);   
            alert_float('danger','Đã xảy ra lỗi, vui lòng thử lại.');
        }
    });
});


        function detailOrder(_this) {
            let dataPost = {};
            dataPost.id = $(_this).data('id');
            $.post('/admin/orders/show', dataPost).done(function (response) {
                console.log(response.data);
                for (let [key, value] of Object.entries(response.data)) {
                    let k = $('#' + key);
                    k.val(value);
                    k.trigger('change');
                }
                $('#showDetail_Modal').modal('toggle');
                window.urlMethod = '/admin/orders/update/' + $(_this).data('id');
                window.type = 'PUT';
                console.log('Modal edit opened');
                console.log('Data:', response.data);

            });
        }

        
        function pushOrder() {
            $(this).attr('disabled', 'disabled');
            let data = $('#formOrder').serialize();
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
                        let table = $('#orders_manage').DataTable();
                        table.ajax.reload(null, false);
                        $('#submit').prop('disabled', false);
                    } else {
                        alert_float('danger', data.message);
                        $('#submit').prop('disabled', false);
                    }
                }
        , error: function (xhr) {
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

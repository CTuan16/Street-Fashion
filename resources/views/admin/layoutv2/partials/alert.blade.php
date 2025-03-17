<div class="alert-container">
    @if(session()->has('message'))
        <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div id="alert-container"></div>
</div>

@push('style')
    <link href="{{ asset('assets/css/custom-alert.css') }}" rel="stylesheet">
@endpush

@push('script')
<script>
    $(document).ready(function() {
        // Tự động ẩn alert sau 3 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    });

    // Hàm hiển thị alert động
    function showAlert(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        $('#alert-container').html(alertHtml);
        
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Thêm sự kiện click cho nút close
    $(document).on('click', '.alert .close', function() {
        $(this).closest('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    });
</script>
@endpush 
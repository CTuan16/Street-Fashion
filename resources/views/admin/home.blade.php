@extends('layouts.default')

@section('content')
<div class="content-wrapper" style="min-height: 1200.88px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    @include('chart.revenueChart')
                </div>
                <div class="col-lg-6">
                    @include('chart.paymentErrorUserSystemEcomChart')
                </div>
            </div>

            <!-- New Section: Statistics -->
            <div class="row mt-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm</h5>
                            <p class="card-text display-4">{{ $totalProducts ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đơn hàng</h5>
                            <p class="card-text display-4">{{ $totalOrders ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Người dùng</h5>
                            <p class="card-text display-4">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Doanh thu</h5>
                            <p class="card-text display-4">${{ number_format($salesRevenue ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of New Section -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">SỐ LƯỢNG LỖI THANH TOÁN TRONG 30 NGÀY GẦN NHẤT</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="error-payment-table" class="table table-hover table-striped dataTable no-footer" style="width: 100%">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @include('chart.paymentErrorUserSystemFtelChart')
                </div>
                <div class="col-lg-6">
                    @include('chart.paymentErrorDetailEcomChart')
                </div>
                <div class="col-lg-6">
                    @include('chart.paymentErrorDetailF

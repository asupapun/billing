@extends('layouts.admin.app')

@section('title', \App\CPU\translate('dashboard'))

@section('content')
<div class="content container-fluid">

    {{-- DASHBOARD always visible now --}}
    
    <div class="card mb-3 bg-white">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12">
                    <label class="badge badge-soft-danger __login-badge color-EC255A float-right mb-2 dashboard-software_version">
                        {{ \App\CPU\translate('Software version') }}: {{ env('SOFTWARE_VERSION') }}
                    </label>
                </div>

                <div class="col-md-9">
                    <h4 class="card-header-title">
                        <i class="font-one-dash tio-chart-bar-4"></i>
                        <span>{{ \App\CPU\translate('business_statistics') }}</span>
                    </h4>
                </div>

                <div class="col-md-3 float-right">
                    <select class="custom-select" id="statisticsTypeSelect">
                        <option value="overall">{{ \App\CPU\translate('overall_statistics') }}</option>
                        <option value="today">{{ \App\CPU\translate("today's_statistics") }}</option>
                        <option value="month">{{ \App\CPU\translate("this_month's_statistics") }}</option>
                    </select>
                </div>

            </div>

            <div class="row gx-2 gx-lg-3" id="account_stats">
                @include('admin-views.partials._dashboard-balance-stats', ['account' => $account])
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row gx-2 gx-lg-3 mb-3 mb-lg-5">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-7">
                            <h5 class="card-header-title mb-2">
                                <i class="font-one-dash tio-chart-pie-1"></i>
                                <span>{{ \App\CPU\translate('earning_statistics_for_business_analytics') }}</span>
                            </h5>
                        </div>

                        <div class="col-md-2">
                            <div class="center-div">
                                <span class="h6 mb-0"><i class="legend-indicator bg-success"></i>{{ \App\CPU\translate('income') }}</span><br>
                                <span class="h6 mb-0"><i class="legend-indicator bg-warning"></i>{{ \App\CPU\translate('expense') }}</span>
                            </div>
                        </div>

                        <div class="col-md-3 float-right">
                            <select class="custom-select" id="chart_statistic">
                                <option value="yearly">{{ \App\CPU\translate('yearly_statistics') }}</option>
                                <option value="monthly">{{ \App\CPU\translate('monthly_statistics') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- monthly chart --}}
                    <div class="chartjs-custom" id="lastMonthStatistic">
                        <canvas id="updatingData_monthly"></canvas>
                    </div>

                    {{-- yearly chart --}}
                    <div class="chartjs-custom" id="lastYearStatistic">
                        <canvas id="updatingData_yearly"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Accounts --}}
    <div class="row gx-2 gx-lg-3 mb-3 mb-lg-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ \App\CPU\translate('accounts') }}</h3>
                    <a href="{{ route('admin.account.list') }}">{{ \App\CPU\translate('View All') }}</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive datatable-custom">

                        <table class="table table-borderless table-thead-bordered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ \App\CPU\translate('account') }}</th>
                                    <th>{{ \App\CPU\translate('balance') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($accounts as $account)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $account->account }}</td>
                                    <td>{{ $account->balance . ' ' . \App\CPU\Helpers::currency_symbol() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if(count($accounts) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{ asset('assets/admin/svg/illustrations/sorry.svg') }}">
                            <p class="mb-0">{{ \App\CPU\translate('No_data_to_show') }}</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- Stock products --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ \App\CPU\translate('stock_limit_products') }}</h3>
                    <a href="{{ route('admin.stock.stock-limit') }}">{{ \App\CPU\translate('View All') }}</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive datatable-custom">

                        <table class="table table-borderless table-thead-bordered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ \App\CPU\translate('name') }}</th>
                                    <th>{{ \App\CPU\translate('quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($product->name, 40) }}</td>
                                    <td>{{ $product->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if(count($products) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{ asset('assets/admin/svg/illustrations/sorry.svg') }}">
                            <p class="mb-0">{{ \App\CPU\translate('No_data_to_show') }}</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script src="{{ asset('assets/admin/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js') }}"></script>
@endpush

@push('script_2')
<script src="{{ asset('assets/admin/js/global.js') }}"></script>

<script>
"use strict";

$('#statisticsTypeSelect').on('change', function () {
    account_stats_update($(this).val());
});

function account_stats_update(type) {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.post({
        url: '{{ route('admin.account-status') }}',
        data: { statistics_type: type },
        beforeSend: function () {
            $('#loading').show()
        },
        success: function (data) {
            $('#account_stats').html(data.view)
        },
        complete: function () {
            $('#loading').hide()
        }
    });
}

$('#chart_statistic').on('change', function () {
    chart_statistic($(this).val());
});
</script>
@endpush

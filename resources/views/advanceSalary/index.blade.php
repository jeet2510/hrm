<style>
    .reason {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 5em;
    }

    .reason:hover {
        overflow: visible;
        white-space: normal;
        width: auto;
    }
</style>
@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Advance Salaries') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Advance Salaries') }}</li>
@endsection

@section('action-button')
    <a href="{{ route('advancesalary.create') }}" data-title="{{ __('Create New Advance Salary') }}" data-bs-toggle="tooltip"
        title="" class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i> {{ __('Create') }}
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="advance-salary-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Ask Month') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Ask Amount') }}</th>
                                    <th>{{ __('Approved Amount') }}</th>
                                    <th>{{ __('Approved Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($advanceSalaries !== null)
                                    @foreach ($advanceSalaries as $advanceSalary)
                                        <tr>
                                            {{-- {{ dd($advanceSalary) }} --}}

                                            <td>{{ $advanceSalary->id }}</td>
                                            <td>{{ $advanceSalary->employee->name }}</td>
                                            <td>{{ $advanceSalary->advance_salary_month }}</td>
                                            <td>{{ $advanceSalary->ask_date }}</td>
                                            <td>{{ $advanceSalary->ask_amount }}</td>
                                            <td>{{ $advanceSalary->approved_amount }}</td>
                                            <td>{{ $advanceSalary->approved_date }}</td>
                                            <td>
                                                <span id="status_{{ $advanceSalary->id }}">
                                                    @if ($advanceSalary->status == 0)
                                                        Pending
                                                    @elseif($advanceSalary->status == 1)
                                                        Approved
                                                    @elseif($advanceSalary->status == 2)
                                                        Rejected
                                                    @else
                                                        Unknown
                                                    @endif
                                                </span>
                                            </td>

                                            <td>
                                                <span id="reason_{{ $advanceSalary->id }}" class="reason">
                                                    {{ $advanceSalary->reason }}
                                                </span>
                                            </td>
                                            <td>
                                                {{-- {{ dd(auth()->user()) }} --}}
                                                @if ((auth()->check() && auth()->user()->type == 'company') || auth()->user()->type == 'super admin')
                                                    <a href="{{ route('advancesalary.edit', $advanceSalary->id) }}"
                                                        class="btn btn-primary">
                                                        Edit
                                                    </a>
                                                @else
                                                    Not Allowed
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No data Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

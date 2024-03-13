@extends('layouts.admin')

@section('page-title')
   {{ __("Manage Tax Slabs") }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __("Home") }}</a></li>
    <li class="breadcrumb-item">{{ __("Tax Slabs") }}</li>
@endsection

@section('action-button')
    @can('Create Tax Slab')
    @endcan
        <a href="#" data-url="{{ route('slab.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Tax Slab') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i> {{ __("Create") }}
        </a>

@endsection

@section('content')
<div class="row">
    <div class="col-3">
        @include('layouts.hrm_setup')
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-body table-border-style">

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th>{{__('Slab Name')}}</th>
                            <th width="200px">{{__('Percentage(%)')}}</th>
                            <th width="200px">{{__('Fix Amount')}}</th>
                            <th width="200px">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody >
                            @foreach ($taxSlabs as $tax)
                                <tr>
                                    <td>{{ $tax->title }}</td>
                                    <td>{{ $tax->percentage }}</td>
                                    <td>{{ $tax->fix_deduction }}</td>
                                    <td>{{ $tax->created_by }}</td>
                                    <td class="Action">
                                        <span>
                                            @can('Edit Tax Slab')
                                                <a href="{{ route('slab.edit', $tax->id) }}" class="btn btn-info btn-sm"><i class="ti ti-pencil"></i></a>
                                            @endcan

                                            @can('Delete Tax Slab')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['slab.destroy', $tax->id], 'id' => 'delete-form-' . $tax->id, 'style' => 'display:inline']) !!}
                                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i class="ti ti-trash"></i></button>
                                                {!! Form::close() !!}
                                            @endcan
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

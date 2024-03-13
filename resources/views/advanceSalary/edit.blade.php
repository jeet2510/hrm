@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Advance Salary') }}</div>
                    {{-- {{ dd($advanceSalary) }} --}}
                    <div class="card-body">
                        <form method="POST" action="{{ route('advancesalary.update', $advanceSalary->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="name" id="name" name="name" class="form-control"
                                    value="{{ $advanceSalary->employee->name }}" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="month">{{ __('Salary Month') }}</label>
                                <input type="text" id="month" name="month" class="form-control"
                                    value="{{ date('Y-m', strtotime($advanceSalary->advance_salary_month)) }}" required
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="asked_date">{{ __('Asked_date') }}</label>
                                <input type="date" id="asked_date" name="asked_date" class="form-control"
                                    value="{{ $advanceSalary->ask_date }}" required disabled>
                            </div>

                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" {{ $advanceSalary->status == 0 ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ $advanceSalary->status == 1 ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="2" {{ $advanceSalary->status == 2 ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ask_amount">{{ __('Asked Amount') }}</label>
                                <input type="number" id="ask_amount" name="ask_amount" class="form-control"
                                    value="{{ $advanceSalary->ask_amount }}" required disabled>
                            </div>

                            <div class="form-group">
                                <label for="approved_amount">{{ __('Approved Amount') }}</label>
                                <input type="number" id="approved_amount" name="approved_amount" class="form-control"
                                    value="{{ $advanceSalary->approved_amount }}" required>
                            </div>

                            <div class="form-group">
                                <label for="approved_date">{{ __('Approved Date') }}</label>
                                <input type="date" id="approved_date" name="approved_date" class="form-control"
                                    value="{{ $advanceSalary->approved_date }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

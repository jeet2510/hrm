<form action="{{ route('slab.store') }}" method="post">
    @csrf <!-- CSRF protection -->
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="title" class="form-label">{{ __('Title') }}</label>
                    <div class="form-icon-user">
                        <input type="text" name="title" class="form-control" placeholder="{{ __('Enter Tax Title') }}">
                    </div>
                    @error('title')
                        <span class="invalid-title" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="percentage" class="form-label">{{ __('Percentage') }}</label>
                    <div class="form-icon-user">
                        <input type="text" name="percentage" class="form-control" placeholder="{{ __('Enter Tax Percentage') }}">
                    </div>
                    @error('percentage')
                        <span class="invalid-percentage" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fix_deduction" class="form-label">{{ __('Fixed Deduction') }}</label>
                    <div class="form-icon-user">
                        <input type="text" name="fix_deduction" class="form-control" value="0" placeholder="{{ __('Enter Fixed Deduction') }}">
                    </div>
                    @error('fix_deduction')
                        <span class="invalid-fix-deduction" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" onclick="window.history.back();" >
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
</form>

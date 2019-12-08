@extends('layouts.app')

@section('content')
<div class="container" id="container-home">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8">
            <div class="card mb-4" id="card-selection">
                <div class="card-header">Currency Conversion</div>
				<div class="card-body">
					<div class="form-group row">
						<label for="currency" class="col-sm-2 col-form-label">Currency</label>
						<div class="col-sm-10">
							<select class="form-control" id="currency">
								@foreach($currencies as $currency)
									<option value="{{ $currency->id }}"@if($currency->code == 'EUR') selected @endif>{{ $currency->name }} ({{ $currency->code }})</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="amount" class="col-sm-2 col-form-label">Amount</label>
						<div class="col-sm-10">
					  		<input type="text" class="form-control" id="amount" value="1.00">
						</div>
					</div>

					<div class="form-group row mb-0">
						<div class="col-sm-12 text-right">
							<button type="button" class="btn btn-primary" id="convert">Convert</button>
						</div>
					</div>
				</div>
            </div>

			<div class="card" id="card-results">
                <div class="card-header">Results</div>
				<div class="card-body">
					<div class="form-group row mb-0">
						<div class="col-sm-12">
							<div class="results">
								<table class="table table-borderless table-sm table-fixed">
			                        <tbody>
			                        </tbody>
			                    </table>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection

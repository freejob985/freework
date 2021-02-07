@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Website Footer') }}</h1>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<h6 class="fw-600 mb-0">{{ translate('Footer Widget') }}</h6>
	</div>
	<div class="card-body">
		<div class="row gutters-10">
			<div class="col-lg-6">
				<div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('About Widget') }}</h6>
					</div>

					<div class="card-body">
						<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
			                    <label class="form-label" for="signinSrEmail">{{ translate('Footer Logo') }}</label>
			                    <div class="input-group " data-toggle="aizuploader" data-type="image">
			                        <div class="input-group-prepend">
			                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
			                        </div>
			                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
									<input type="hidden" name="types[]" value="footer_logo">
			                        <input type="hidden" name="footer_logo" class="selected-files" value="{{ App\Models\SystemConfiguration::where('type', 'footer_logo')->where('lang',Session::get('locale'))->first()->value }}">
			                    </div>
								<div class="file-preview"></div>
							</div>
			                <div class="form-group">
								<label>{{ translate('About description') }}</label>
								<input type="hidden" name="types[]" value="about_description_footer">
								<textarea class="aiz-text-editor form-control" name="about_description_footer" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">@php
									echo App\Models\SystemConfiguration::where('type', 'about_description_footer')->where('lang',Session::get('locale'))->first()->value;
								@endphp</textarea>

							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
				<div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Link Widget One') }}</h6>
					</div>
					<div class="card-body">

						<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label>{{ translate('Title') }}</label>
								<input type="hidden" name="types[]" value="widget_one">
								<input type="text" class="form-control" placeholder="Widget title" name="widget_one" value="{{ App\Models\SystemConfiguration::where('type', 'widget_one')->where('lang',Session::get('locale'))->first()->value }}">
							</div>
			                <div class="form-group">
								<label>{{ translate('Links') }}</label>
								<div class="w3-links-target">
									<input type="hidden" name="types[]" value="widget_one_labels">
									<input type="hidden" name="types[]" value="widget_one_links">

									@if (App\Models\SystemConfiguration::where('lang',Session::get('locale'))->where('type', 'widget_one_labels')->first()->value != null)
										@foreach (json_decode(App\Models\SystemConfiguration::where('type', 'widget_one_labels')->where('lang',Session::get('locale'))->first()->value, true) as $key => $value)
	
										<div class="row gutters-5">
												<div class="col-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Label" name="widget_one_labels[]" value="{{ $value }}">
													</div>
												</div>
												<div class="col">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="http://" name="widget_one_links[]" value="{{ json_decode(App\Models\SystemConfiguration::where('type', 'widget_one_links')->first()->value, true)[$key] }}">
													</div>
												</div>
												<div class="col-auto">
													<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
														<i class="las la-times"></i>
													</button>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-4">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Label" name="widget_one_labels[]">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="http://" name="widget_one_links[]">
											</div>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".w3-links-target">
									{{ translate('Add New') }}
								</button>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Link Widget Two') }}</h6>
					</div>
					<div class="card-body">
						<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label>{{ translate('Title') }}</label>
								<input type="hidden" name="types[]" value="widget_two">
								<input type="text" class="form-control" placeholder="Widget title" name="widget_two" value="{{ App\Models\SystemConfiguration::where('type', 'widget_two')->where('lang',Session::get('locale'))->first()->value }}">
							</div>
			                <div class="form-group">
								<label>{{ translate('Links') }}</label>
								<div class="w3-links-target">
									<input type="hidden" name="types[]" value="widget_two_labels">
									<input type="hidden" name="types[]" value="widget_two_links">

									@if (App\Models\SystemConfiguration::where('lang',Session::get('locale'))->where('type', 'widget_two_labels')->first()->value != null)
										@foreach (json_decode(App\Models\SystemConfiguration::where('type', 'widget_two_labels')->where('lang',Session::get('locale'))->first()->value, true) as $key => $value)
											<div class="row gutters-5">
												<div class="col-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Label" name="widget_two_labels[]" value="{{ $value }}">
													</div>
												</div>
												<div class="col">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="http://" name="widget_two_links[]" value="{{ json_decode(App\Models\SystemConfiguration::where('type', 'widget_two_links')->where('lang',Session::get('locale'))->first()->value, true)[$key] }}">
													</div>
												</div>
												<div class="col-auto">
													<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
														<i class="las la-times"></i>
													</button>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-4">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Label" name="widget_two_labels[]">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="http://" name="widget_two_links[]">
											</div>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".w3-links-target">
									{{ translate('Add New') }}
								</button>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
				<div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Social Widget') }}</h6>
					</div>
					<div class="card-body">
						<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label>{{ translate('Title') }}</label>
								<input type="hidden" name="types[]" value="social_widget_title">
								<input type="text" class="form-control" placeholder="Widget title" name="social_widget_title" value="{{ App\Models\SystemConfiguration::where('type', 'social_widget_title')->where('lang',Session::get('locale'))->first()->value }}">
							</div>
			                <div class="form-group">
								<label>{{ translate('Social Links') }}</label>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="lab la-facebook-f"></i></span>
									</div>
									<input type="hidden" name="types[]" value="facebook_link">
									<input type="text" class="form-control" placeholder="http://" name="facebook_link" value="{{ App\Models\SystemConfiguration::where('type', 'facebook_link')->where('lang',Session::get('locale'))->first()->value }}">
								</div>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="lab la-twitter"></i></span>
									</div>
									<input type="hidden" name="types[]" value="twitter_link">
									<input type="text" class="form-control" placeholder="http://" name="twitter_link" value="{{ App\Models\SystemConfiguration::where('type', 'twitter_link')->where('lang',Session::get('locale'))->first()->value }}">
								</div>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="lab la-instagram"></i></span>
									</div>
									<input type="hidden" name="types[]" value="instagram_link">
									<input type="text" class="form-control" placeholder="http://" name="instagram_link" value="{{ App\Models\SystemConfiguration::where('type', 'instagram_link')->where('lang',Session::get('locale'))->first()->value }}">
								</div>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="lab la-youtube"></i></span>
									</div>
									<input type="hidden" name="types[]" value="youtube_link">
									<input type="text" class="form-control" placeholder="http://" name="youtube_link" value="{{ App\Models\SystemConfiguration::where('type', 'youtube_link')->where('lang',Session::get('locale'))->first()->value }}">
								</div>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="lab la-linkedin-in"></i></span>
									</div>
									<input type="hidden" name="types[]" value="linkedin_link">
									<input type="text" class="form-control" placeholder="http://" name="linkedin_link" value="{{ App\Models\SystemConfiguration::where('type', 'linkedin_link')->where('lang',Session::get('locale'))->first()->value }}">
								</div>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<h6 class="fw-600 mb-0">{{ translate('Footer Bottom') }}</h6>
	</div>
	<div class="card-body">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
                <label class="form-label" for="signinSrEmail">{{ translate('Show Language Switcher?') }}</label>
                <div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="language_switcher">
						<input type="checkbox" name="language_switcher" @if (App\Models\SystemConfiguration::where('type', 'language_switcher')->where('lang',Session::get('locale'))->first()->value == 'on')
							checked
						@endif>
						<span></span>
					</label>
				</div>
            </div>
            <div class="form-group">
				<label>{{ translate('Copyright Text') }}</label>
				<input type="hidden" name="types[]" value="copyright_text">
				<textarea class="aiz-text-editor form-control" name="copyright_text" data-buttons='[["font", ["bold", "underline", "italic"]],["insert", ["link"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">@php
					echo App\Models\SystemConfiguration::where('type', 'copyright_text')->first()->value
				@endphp</textarea>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
			</div>
		</form>
	</div>
</div>
@endsection

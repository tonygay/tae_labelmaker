<!doctype html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Trans-Amigos Express: Labels</title>
		<style>
			table.page {
				border-spacing: 4px;
				border-collapse: separate;
				border: none;
				page-break-inside: avoid;
			}
			
			table.page tr {
				margin-bottom: 20px;
			}
	
			td.label { 
				vertical-align: top;
				width: 4.375in;
				height: 3.125in;
				border: 1px solid #DDD;
			}
			
			td.empty-label {
				vertical-align: top;
				width: 4.375in;
				height: 3.125in;
				border: none;
			}
			
			td.label img {
				float: right;
				margin-right: 5px;
			}
			
			.to {
				padding-top: 10px;
				margin-left: 10px;
			}
			
			.from {
				padding-top: 10px;
				margin-left: 10px;
			}
			
			.from, .to, .courier-codes {
				overflow: auto;
			}
			
			.from-label,
			.courier-codes .to-label {
				width: 70px;
				font-weight: bold;
			}
			
			.from .from-content {
				width: 300px;
				font-weight: bold;
				font-size: 13px;
			}

			.to .to-content {
				width: 400px;
				font-weight: bold;
				font-size: 16px;
			}
			
			.from div,
			.to div {
				float: left;
				font-size: 18px;
			}
			
			.courier-codes .to-label {
				float: left;
				padding: 6px 0;
				line-height: 45px;
				font-size: 18px;
			}
			
			.courier-codes {
				padding-top: 20px;
				margin-left: 10px;
			}
			
			.courier-codes .code {
				float: left;
				margin-right: 20px;
				font-size: 45px;
				font-weight: bold;
			}
			
			.misc {
				clear: both;
				padding-top: 15px;
				padding-left: 70px;
				font-weight: bold;
			}
			
			.date {
				float: right;
				font-size: 16px;
				margin-right: 5px;
			}
		</style>
	</head>

	<body>
		@foreach($data['pages'] as $page)
			<table class="page">
				@for($i = 0; $i < 4; $i++)
					@if($i % 2 == 0)
						<tr>
					@endif

					@if($i == 0)
							<td class="label">
								<div class="from">
									<img src="{{ asset('img/tae-logo.jpg') }}" width="100px">
									<div class="from-label">From:</div>
									<div class="from-content">
										{{ $data['from']->site_code }}
										{{ $data['from']->hub }}
										{{ $data['from']->name }}<br>
										@unless(is_null($data['from']->address1))
											{{ $data['from']->address1 }}<br>
										@endif
										{{ $data['from']->city }},
										{{ $data['from']->state }}
										{{ $data['from']->postal_code }}
									</div>
								</div>
							
								<div class="courier-codes">
									<div class="to-label">To:</div>
									@if(!empty($data['to'][$page->labels[$i]]->prefs->code1))
										<div class="code">
											{{ $data['to'][$page->labels[$i]]->{$data['to'][$page->labels[$i]]->prefs->code1} }}
										</div>
									@endif
								
									@if(!empty($data['to'][$page->labels[$i]]->prefs->code2))
										<div class="code">
											{{ $data['to'][$page->labels[$i]]->{$data['to'][$page->labels[$i]]->prefs->code2} }}
										</div>
									@endif
								
									@if(!empty($data['to'][$page->labels[$i]]->prefs->code3))
										<div class="code">
											{{ $data['to'][$page->labels[$i]]->{$data['to'][$page->labels[$i]]->prefs->code3} }}
										</div>
									@endif
								</div>
							
								<div class="to">
									<div class="from-label">&nbsp;</div>
									<div class="to-content">
										{{ $data['to'][$page->labels[$i]]->name }}<br>
										@if($data['to'][$page->labels[$i]]->prefs->use_address1 && !empty($data['to'][$page->labels[$i]]->address1))
											{{ $data['to'][$page->labels[$i]]->address1 }}<br>
										@endif
										@if($data['to'][$page->labels[$i]]->prefs->use_address2 && !empty($data['to'][$page->labels[$i]]->address2))
											{{ $data['to'][$page->labels[$i]]->address2 }}<br>
										@endif
										{{ $data['to'][$page->labels[$i]]->city }},
										{{ $data['to'][$page->labels[$i]]->state }}
										{{ $data['to'][$page->labels[$i]]->postal_code }}
									</div>
								</div>
							
								<div class="misc">
									<div class="date">
										Shipped on {{ is_null($data['date']) ? '___/___/______' : $data['date'] }}
									</div>
									{{ $data['to'][$page->labels[$i]]->additional_label_field }}
								</div>
							</td>
					@else
							<td class="empty-label">&nbsp;</td>
					@endif

					@if($i % 2 == 1)
						</tr>
					@endif
				@endfor
			</table>
		@endforeach
	</body>
</html>
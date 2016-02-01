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
	
			td.label { 
				vertical-align: top;
				padding: 10px;
				width: 490px;
				height: 315px;
				border: 1px solid #DDD;
			}
			
			td.label img {
				float: right;
			}
			
			.to {
				padding-top: 25px;
			}
			
			.from {
				padding-top: 20px;
			}
			
			.from, .to, .courier-codes {
				overflow: auto;
			}
			
			.from .from-label,
			.to .to-label {
				width: 70px;
				font-weight: bold;
			}
			
			.from .from-content {
				width: 300px;
				font-weight: bold;
			}

			.to .to-content {
				width: 400px;
				font-weight: bold;
			}
			
			.from div,
			.to div {
				float: left;
				font-size: 18px;
			}
			
			.courier-codes {
				padding-top: 20px;
				margin-left: 30px;
				font-size: 45px;
				font-weight: bold;
			}
			
			.courier-codes div {
				float: left;
				margin-right: 20px;
				padding: 6px;
/*				border: 1px solid #444;*/
			}
			
			.misc {
				clear: both;
				padding-top: 15px;
				padding-left: 70px;
			}
			
			.date {
				float: right;
				font-size: 16px;
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
								<div class="to-label">TO:</div>
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
					@if($i % 2 == 1)
						</tr>
					@endif
				@endfor
			</table>
		@endforeach
	</body>
</html>
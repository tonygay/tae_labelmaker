<?php

namespace AmigosLabels\Http\Controllers;

use DB, Input, PDF, Redirect;
use Illuminate\Http\Request;

use AmigosLabels\Institution;
use AmigosLabels\Http\Requests;
use AmigosLabels\Http\Controllers\Controller;

class LabelsController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labels.create', [
			'institutions' => Institution::with('courier')->has('courier')->get()
		]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
			// First lets make sure they provided everything we need here
			$rules = [
		        'from' => 'required',
		        'to' => 'required',
		        'add_date' => 'required',
						'shipping_date' => 'required_if:add_date,1|date',
		        'label_count' => 'required|integer',
						'page_count' => 'required',
		    ];
		
			$messages = [
				'shipping_date.required_if' => 'The shipping date is required unless you choose to leave it empty.'
			];
		
			// If not, this will send them back to the form.
		    $this->validate($request, $rules, $messages);

			// Now, lets get all our form data so we can build the labels
			$data = array();
			$data['from'] = Institution::with('courier')->find(Input::get('from'));
			$data['to'] = Institution::with('courier')->whereIn('id', Input::get('to'))->get();
			$data['date'] = Input::get('add_date', false) ? Input::get('shipping_date') : null;
			$data['count'] = Input::get('label_count', 1);
			$data['page_count'] = Input::get('page_count', 4);
		
			if ($data['to']->count() * $data['count'] > 40) {
				return Redirect::back()->withErrors(['Cannot print more than 10 pages at a time. Decrease the number of labels per institution or the number of institutions.']);
			}

			// We want to build them 4 to a page so lets create the individual pages here
			// with references to the "To" institutions
			$page = null;
			$pages = array();
			for($i = 0; $i < $data['count']; $i++) {
				foreach($data['to'] as $index => $institution) {
					$count = $i * count($data['to']) + $index;

					if ($count % 4 == 0 || $data['page_count'] == 1) {
						if (!is_null($page)) {
							$pages[] = $page;
						}
						$page = new \stdClass();
						$page->labels = array();
					}
					$page->labels[] = $index;
				}
			}

			// If 4 per page and the last page is partially full, fill it with extra labels
			if ($data['page_count'] != 1) {
				$index = 0;
				while(count($page->labels) < 4)  {
					$page->labels[] = $index;
					$index = ($index < count($data['to']) - 1) ? $index + 1 : 0; 
				}
			}
			$pages[] = $page;

			// Add pages to our data array
			$data['pages'] = $pages;
		
			switch ($data['page_count']) {
				case 1: $view_name = 'labels.show-one';
				break;
				case 2: $view_name = 'labels.show-one-small';
				break;
				default: $view_name = 'labels.show-four';
			}
		
			// $view_name = $data['page_count'] == 1 ? 'labels.show-one' : 'labels.show-four';
		
			// Use for debugging purposes, it shows the labels in HTML
			// return view($view_name, ['data' => $data]);

			// Finally, lets build the PDF from our view
		  return PDF::loadView($view_name, ['data' => $data])
								->setOption('margin-top','0')->setOption('margin-bottom', '0')
								->setOption('margin-left', '0')->setOption('margin-right', '0')
								->setOption('page-width', '4.5in')->setOption('page-height','3.25in')
								->setOrientation('landscape')->stream('labels' . time() . '.pdf');
		
			// if ($data['page_count'] == 2) {
			// 	$pdf->setOption('page-width', '11.43')->setOption('page-height','8.25');
			// }

			// 		  $pdf->setOrientation('landscape')->stream('labels' . time() . '.pdf');
			//
			// return $pdf;
    }
}

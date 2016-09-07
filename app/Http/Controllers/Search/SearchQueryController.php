<?php

namespace Medlib\Http\Controllers\Search;


use Yaz\Facades\Yaz;
use Yaz\Facades\Query;
use Medlib\Http\Requests;
use Yaz\Record\YazRecords;
use Medlib\MarcXML\MarcXML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Medlib\MarcXML\Filter\FilterRecord;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;

class SearchQueryController extends Controller
{

    private $_results = [];

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function doSimple(Request $request) {

        $rules = [
            'query' => 'required|min:3',
            'qdb' => 'required|not_in: '
        ];

        /** run the validation rules on the inputs from the form */
        $validator = Validator::make($request->all(), $rules);

        /** if the validator fails, redirect back to the form */
        if ($validator->fails()) {

			if($request->ajax()){
				return response()->json(['require' => $validator->errors()], 422);
			}else {
				return Redirect::to('/')->withErrors($validator)->withInput();
			}
        }


		if (Cache::has($request->get('query') . $request->get('qdb'))) {

			$this->_results = Cache::get($request->get('query') . $request->get('qdb'));
			$filter = FilterRecord::traverseStructure($this->_results);

		} else {
			/**
			 * La requête utilisateur à parser
			 */
			$query = Query::simple($request)->get();

			$record = Yaz::from($request->query('qdb'))
				->where($query)
				//->limit(1, 10240)
				->limit(1, 100)
				->orderBy('au ASC')
				->all(YazRecords::TYPE_XML);
			
			if(!$record->fails() or $record->hasError() == 1005 or $record->hasError() == 213) {

				foreach($record->getRecords() as $result) {
					$parserResult = new QuiteSimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>'. $result);
					$parserResult->registerXPathNamespaces([ 'marc' => 'http://www.loc.gov/MARC21/slim' ]);
					$this->_results[] = MarcXML::parse($parserResult);
				}

				$filter = FilterRecord::traverseStructure($this->_results);

				Cache::put($request->get('query') . $request->get('qdb'), $this->_results, 10);
			}
			else {

				$this->_results = [
					'error' => $record->hasError(),
					'message' => $record->errorMessage()
				];
				$filter = [];
			}

			$record->close();

		}

		if($request->ajax()) {
			return View::make("search.ajax.results", [ 'results' => $this->_results,  'filter' => $filter]);
		}
		else {
        	return View::make("search.results", [ 'results' => $this->_results,  'filter' => $filter]);
		}
    }

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function doAdvanced(Request $request) {

		return View::make("search.advanced-search");
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function doDetail(Request $request) {

		$rules = [
			'query'    => 'required|min:3',
			'qdb' => 'required|not_in: '
		];

		/** run the validation rules on the inputs from the form */
		$validator = Validator::make($request->all(), $rules);

		/** if the validator fails, redirect back to the form */
		if ($validator->fails()) {

			if($request->ajax()){
				return response()->json(['require' => $validator->errors()], 422);
			}else {
				return Redirect::back()->withErrors($validator)->withInput();
			}
		}

		$query = Query::simple($request)->get();

		$record = Yaz::from($request->query('qdb'))
			->where($query)
			->limit(0, 1)
			->all(YazRecords::TYPE_XML);

		$record->close();

		if(!$record->fails() or $record->hasError() == 1005 or $record->hasError() == 213) {

			foreach($record->getRecords() as $result) {
				$parserResult = new QuiteSimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>'. $result);
				$parserResult->registerXPathNamespaces([ 'marc' => 'http://www.loc.gov/MARC21/slim' ]);
				$this->_results[] = MarcXML::parse($parserResult);
			}
		}
		else {

			$this->_results = [
				'error' => $record->hasError(),
				'message' => $record->errorMessage()
			];

		}

		dd($this->_results);

	}
}

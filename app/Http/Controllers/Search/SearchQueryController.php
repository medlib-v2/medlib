<?php

namespace Medlib\Http\Controllers\Search;

use Yaz\Facades\Yaz;
use Yaz\Facades\Query;
use Medlib\Http\Requests;
use Yaz\Record\YazRecords;
use Medlib\MarcXML\MarcXML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Medlib\MarcXML\Filter\FilterRecord;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;

class SearchQueryController extends Controller
{

    private $_results = [];

    public function doSimple(Request $request) {

        $rules = [
            'query'    => 'required|min:3',
            'qdb' => 'required|not_in: '
        ];

        /** create custom validation messages
		 *
		 * $messages = [
		 * 	'required' => 'The :attribute is really really important.',
		 * ];
		 * $validator = Validator::make($request->all(), $rules, $messages);
		 */

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


        // La requête utilisateur à parser
        $query = Query::simple($request)->get();

        $record = Yaz::from($request->query('qdb'))
            ->where($query)
            ->limit(0, 110)
            ->all(YazRecords::TYPE_XML);

        Yaz::close();

        if(!$record->fails()) {

            foreach($record->getRecords() as $result) {
                $parserResult = new QuiteSimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>'. $result);
                $parserResult->registerXPathNamespaces([ 'marc' => 'http://www.loc.gov/MARC21/slim' ]);
                $this->_results[] = MarcXML::parse($parserResult);
            }

            $filter = FilterRecord::traverseStructure($this->_results);
        }
        else {
            $this->_results = [
                'error' => $record->hasError(),
                'message' => $record->errorMessage()
            ];

            $filter = [];
        }

		if($request->ajax()) {
			return View::make("search.ajax.results", [ 'results' => $this->_results,  'filter' => $filter]);
		}
		else {
        	return View::make("search.results", [ 'results' => $this->_results,  'filter' => $filter]);
		}
    }

	public function doAdvanced(Request $request) {
		dd($request);
	}
}

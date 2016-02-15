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

		/**
        $record[] = '<record xmlns="http://www.loc.gov/MARC21/slim">
					<leader>00925njm  22002777a 4500</leader>
					<controlfield tag="001">5637241</controlfield>
					<controlfield tag="003">DLC</controlfield>
					<controlfield tag="005">19920826084036.0</controlfield>
					<controlfield tag="007">sdubumennmplu</controlfield>
					<controlfield tag="008">910926s1957    nyuuun              eng  </controlfield>
					<datafield tag="010" ind1=" " ind2=" ">
						<subfield code="a">   91758335 </subfield>
					</datafield>
					<datafield tag="028" ind1="0" ind2="0">
						<subfield code="a">1259</subfield>
						<subfield code="b">Atlantic</subfield>
					</datafield>
					<datafield tag="040" ind1=" " ind2=" ">
						<subfield code="a">DLC</subfield>
						<subfield code="c">DLC</subfield>
					</datafield>
					<datafield tag="050" ind1="0" ind2="0">
						<subfield code="a">Atlantic 1259</subfield>
					</datafield>
					<datafield tag="245" ind1="0" ind2="4">
						<subfield code="a">The Great Ray Charles</subfield>
						<subfield code="h">[sound recording].</subfield>
					</datafield>
					<datafield tag="260" ind1=" " ind2=" ">
						<subfield code="a">New York, N.Y. :</subfield>
						<subfield code="b">Atlantic,</subfield>
						<subfield code="c">[1957?]</subfield>
					</datafield>
					<datafield tag="300" ind1=" " ind2=" ">
						<subfield code="a">1 sound disc :</subfield>
						<subfield code="b">analog, 33 1/3 rpm ;</subfield>
						<subfield code="c">12 in.</subfield>
					</datafield>
					<datafield tag="511" ind1="0" ind2=" ">
						<subfield code="a">Ray Charles, piano &amp; celeste.</subfield>
					</datafield>
					<datafield tag="505" ind1="0" ind2=" ">
						<subfield code="a">The Ray -- My melancholy baby -- Black coffee -- There\'s no you -- Doodlin\' -- Sweet sixteen bars -- I surrender dear -- Undecided.</subfield>
					</datafield>
					<datafield tag="500" ind1=" " ind2=" ">
						<subfield code="a">Brief record.</subfield>
					</datafield>
					<datafield tag="650" ind1=" " ind2="0">
						<subfield code="a">Jazz</subfield>
						<subfield code="y">1951-1960.</subfield>
					</datafield>
					<datafield tag="650" ind1=" " ind2="0">
						<subfield code="a">Piano with jazz ensemble.</subfield>
					</datafield>
					<datafield tag="700" ind1="1" ind2=" ">
						<subfield code="a">Charles, Ray,</subfield>
						<subfield code="d">1930-</subfield>
						<subfield code="4">prf</subfield>
					</datafield>
				</record>';
        $record[] = '<record xmlns="http://www.loc.gov/MARC21/slim">
					  <leader>01268cam a22003374a 4500</leader>
					  <controlfield tag="001">83858</controlfield>
					  <controlfield tag="005">20090116144632.0</controlfield>
					  <controlfield tag="008">950703s1995    fr ab    b    000 0 fre  </controlfield>
					  <datafield tag="035" ind1=" " ind2=" ">
						<subfield code="9">(DLC)   95173180</subfield>
					  </datafield>
					  <datafield tag="906" ind1=" " ind2=" ">
						<subfield code="a">7</subfield>
						<subfield code="b">cbc</subfield>
						<subfield code="c">origres</subfield>
						<subfield code="d">3</subfield>
						<subfield code="e">ncip</subfield>
						<subfield code="f">19</subfield>
						<subfield code="g">y-gencatlg</subfield>
					  </datafield>
					  <datafield tag="955" ind1=" " ind2=" ">
						<subfield code="a">ub06 07-03-95 to cat.; sh30 07-12-95; sh00 08-05-96; lg02 to RCCD 10-08-96</subfield>
						<subfield code="i">cg09 2009-01-16</subfield>
						<subfield code="e">cg09 2009-01-16 to BCCD</subfield>
					  </datafield>
					  <datafield tag="010" ind1=" " ind2=" ">
						<subfield code="a">   95173180 </subfield>
					  </datafield>
					  <datafield tag="020" ind1=" " ind2=" ">
						<subfield code="a">2713210860</subfield>
					  </datafield>
					  <datafield tag="035" ind1=" " ind2=" ">
						<subfield code="a">(OCoLC)33316584</subfield>
					  </datafield>
					  <datafield tag="040" ind1=" " ind2=" ">
						<subfield code="a">DLC</subfield>
						<subfield code="c">DLC</subfield>
					  </datafield>
					  <datafield tag="041" ind1="0" ind2=" ">
						<subfield code="a">fre</subfield>
						<subfield code="b">eng</subfield>
					  </datafield>
					  <datafield tag="043" ind1=" " ind2=" ">
						<subfield code="a">a-ii---</subfield>
					  </datafield>
					  <datafield tag="050" ind1="0" ind2="0">
						<subfield code="a">BL2015.P57</subfield>
						<subfield code="b">R88 1995</subfield>
					  </datafield>
					  <datafield tag="245" ind1="0" ind2="4">
						<subfield code="a">Les ruses du salut :</subfield>
						<subfield code="b"></subfield>
						<subfield code="c"></subfield>
					  </datafield>
					  <datafield tag="246" ind1="1" ind2="5">
						<subfield code="a">Cunning of salvation</subfield>
					  </datafield>
					  <datafield tag="260" ind1=" " ind2=" ">
						<subfield code="a">Paris :</subfield>
						<subfield code="b"></subfield>
						<subfield code="c">c1995.</subfield>
					  </datafield>
					  <datafield tag="300" ind1=" " ind2=" ">
						<subfield code="a">263 p. :</subfield>
						<subfield code="b">ill., map ;</subfield>
						<subfield code="c">24 cm.</subfield>
					  </datafield>
					  <datafield tag="490" ind1="0" ind2=" ">
						<subfield code="a"></subfield>
						<subfield code="x">0339-1744 ;</subfield>
						<subfield code="v">17</subfield>
					  </datafield>
					  <datafield tag="546" ind1=" " ind2=" ">
						<subfield code="a">Text in French, abstracts in English and French.</subfield>
					  </datafield>
					  <datafield tag="504" ind1=" " ind2=" ">
						<subfield code="a">Includes bibliographical references</subfield>
					  </datafield>
					  <datafield tag="650" ind1=" " ind2="0">
						<subfield code="a">Religion and politics</subfield>
						<subfield code="z">India.</subfield>
					  </datafield>
					  <datafield tag="650" ind1=" " ind2="0">
						<subfield code="a">Hindu sects</subfield>
						<subfield code="z">India.</subfield>
					  </datafield>
					  <datafield tag="650" ind1=" " ind2="0">
						<subfield code="a">Caste</subfield>
						<subfield code="x">Religious aspects</subfield>
						<subfield code="x">Hinduism.</subfield>
					  </datafield>
					  <datafield tag="700" ind1="1" ind2=" ">
						<subfield code="a">Reiniche, Marie Louise.</subfield>
					  </datafield>
					  <datafield tag="700" ind1="1" ind2=" ">
						<subfield code="a">Stern, Henri,</subfield>
						<subfield code="d">1942-</subfield>
					  </datafield>
					  <datafield tag="922" ind1=" " ind2=" ">
						<subfield code="a">ax</subfield>
					  </datafield>
					</record>';
        $record[] = '<marc:record xmlns:marc="http://www.loc.gov/MARC21/slim" >
					<marc:leader>01832cmma 2200349 a 4500</marc:leader>
					<marc:controlfield tag="001">12149120</marc:controlfield>
					<marc:controlfield tag="005">20001005175443.0</marc:controlfield>
					<marc:controlfield tag="007">cr |||</marc:controlfield>
					<marc:controlfield tag="008">000407m19949999dcu    g   m        eng d</marc:controlfield>
					<marc:datafield tag="906" ind1=" " ind2=" ">
						<marc:subfield code="a">0</marc:subfield>
						<marc:subfield code="b">ibc</marc:subfield>
						<marc:subfield code="c">copycat</marc:subfield>
						<marc:subfield code="d">1</marc:subfield>
						<marc:subfield code="e">ncip</marc:subfield>
						<marc:subfield code="f">20</marc:subfield>
						<marc:subfield code="g">y-gencompf</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="925" ind1="0" ind2=" ">
						<marc:subfield code="a">undetermined</marc:subfield>
						<marc:subfield code="x">web preservation project (wpp)</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="955" ind1=" " ind2=" ">
						<marc:subfield code="a">vb07 (stars done) 08-19-00 to HLCD lk00; AA3s lk29 received for subject Aug 25, 2000; to DEWEY 08-25-00; aa11 08-28-00</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="010" ind1=" " ind2=" ">
						<marc:subfield code="a">   00530046 </marc:subfield>
					</marc:datafield>
					<marc:datafield tag="035" ind1=" " ind2=" ">
						<marc:subfield code="a">(OCoLC)ocm44279786</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="040" ind1=" " ind2=" ">
						<marc:subfield code="a">IEU</marc:subfield>
						<marc:subfield code="c">IEU</marc:subfield>
						<marc:subfield code="d">N@F</marc:subfield>
						<marc:subfield code="d">DLC</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="042" ind1=" " ind2=" ">
						<marc:subfield code="a">lccopycat</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="043" ind1=" " ind2=" ">
						<marc:subfield code="a">n-us-dc</marc:subfield>
						<marc:subfield code="a">n-us---</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="050" ind1="0" ind2="0">
						<marc:subfield code="a">F204.W5</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="082" ind1="1" ind2="0">
						<marc:subfield code="a">975.3</marc:subfield>
						<marc:subfield code="2">13</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="245" ind1="0" ind2="4">
						<marc:subfield code="a">The White House</marc:subfield>
						<marc:subfield code="h">[computer file].</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="256" ind1=" " ind2=" ">
						<marc:subfield code="a">Computer data.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="260" ind1=" " ind2=" ">
						<marc:subfield code="a">Washington, D.C. :</marc:subfield>
						<marc:subfield code="b">White House Web Team,</marc:subfield>
						<marc:subfield code="c">1994-</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="538" ind1=" " ind2=" ">
						<marc:subfield code="a">Mode of access: Internet.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="500" ind1=" " ind2=" ">
						<marc:subfield code="a">Title from home page as viewed on Aug. 19, 2000.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="520" ind1="8" ind2=" ">
						<marc:subfield code="a">Features the White House. Highlights the Executive Office of the President, which includes senior policy advisors and offices responsible for the President\'s correspondence and communications, the Office of the Vice President, and the Office of the First Lady. Posts contact information via mailing address, telephone and fax numbers, and e-mail. Contains the Interactive Citizens\' Handbook with information on health, travel and tourism, education and training, and housing. Provides a tour and the history of the White House. Links to White House for Kids.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="610" ind1="2" ind2="0">
						<marc:subfield code="a">White House (Washington, D.C.)</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="610" ind1="1" ind2="0">
						<marc:subfield code="a">United States.</marc:subfield>
						<marc:subfield code="b">Executive Office of the President.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="610" ind1="1" ind2="0">
						<marc:subfield code="a">United States.</marc:subfield>
						<marc:subfield code="b">Office of the Vice President.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="610" ind1="1" ind2="0">
						<marc:subfield code="a">United States.</marc:subfield>
						<marc:subfield code="b">Office of the First Lady.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="710" ind1="2" ind2=" ">
						<marc:subfield code="a">White House Web Team.</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="856" ind1="4" ind2="0">
						<marc:subfield code="u">http://www.whitehouse.gov</marc:subfield>
					</marc:datafield>
					<marc:datafield tag="856" ind1="4" ind2="0">
						<marc:subfield code="u">http://lcweb.loc.gov/staff/wpp/whitehouse.html</marc:subfield>
						<marc:subfield code="z">Web site archive</marc:subfield>
					</marc:datafield>
				</marc:record>';
		$record[] = '<record xmlns="http://www.loc.gov/MARC21/slim" xmlns:cinclude="http://apache.org/cocoon/include/1.0" xmlns:zs="http://www.loc.gov/zing/srw/">
		<leader>01701cam a2200373 a 4500</leader>
		<controlfield tag="001">14924711</controlfield>
		<controlfield tag="005">20090827104248.0</controlfield>
		<controlfield tag="008">070712s2008 njua 001 0 eng</controlfield>
		<datafield tag="906" ind1=" " ind2=" ">
		<subfield code="a">7</subfield>
		<subfield code="b">cbc</subfield>
		<subfield code="c">orignew</subfield>
		<subfield code="d">1</subfield>
		<subfield code="e">ecip</subfield>
		<subfield code="f">20</subfield>
		<subfield code="g">y-gencatlg</subfield>
		</datafield>
		<datafield tag="925" ind1="0" ind2=" ">
		<subfield code="a">acquire</subfield>
		<subfield code="b">2 shelf copies</subfield>
		<subfield code="x">policy default</subfield>
		</datafield>
		<datafield tag="955" ind1=" " ind2=" ">
		<subfield code="a">jg12 2007-07-12</subfield>
		<subfield code="i">jg12 2007-07-12</subfield>
		<subfield code="e">jg12 2007-07-12</subfield>
		<subfield code="a">aa24 2007-07-12</subfield>
		<subfield code="a">ps08 2007-11-26 1 copy rec\'d., to CIP ver.</subfield>
		<subfield code="f">
		pv17 2007-12-27 Z-CipVer; jg12 responding to request to change
		</subfield>
		<subfield code="c">
		jf07 2008-06-03 (consulted with CPSO) chgd. to multipart, wrote message on hldg. and item record to chg. label, added rel. a. e. for prev. ed., added v. 2 and closed
		</subfield>
		<subfield code="a">jf25 2008-08-18 copy 2 added</subfield>
		</datafield>
		<datafield tag="955" ind1=" " ind2=" ">
		<subfield code="a">ADDED VOLS: v. 4 [i.e. 2] ps10 2008-05-21 to ASCD</subfield>
		</datafield>
		<datafield tag="010" ind1=" " ind2=" ">
		<subfield code="a">2007028843</subfield>
		</datafield>
		<datafield tag="020" ind1=" " ind2=" ">
		<subfield code="a">9780132354769 (v. 1)</subfield>
		</datafield>
		<datafield tag="020" ind1=" " ind2=" ">
		<subfield code="a">0132354764 (v. 1)</subfield>
		</datafield>
		<datafield tag="020" ind1=" " ind2=" ">
		<subfield code="a">9780132354790 (v. 2)</subfield>
		</datafield>
		<datafield tag="020" ind1=" " ind2=" ">
		<subfield code="a">0132354799 (v. 2)</subfield>
		</datafield>
		<datafield tag="035" ind1=" " ind2=" ">
		<subfield code="a">(OCoLC)ocn191686143</subfield>
		</datafield>
		<datafield tag="040" ind1=" " ind2=" ">
		<subfield code="a">DLC</subfield>
		<subfield code="c">DLC</subfield>
		<subfield code="d">JRZ</subfield>
		<subfield code="d">DLC</subfield>
		</datafield>
		<datafield tag="050" ind1="0" ind2="0">
		<subfield code="a">QA76.73.J38</subfield>
		<subfield code="b">H6753 2008</subfield>
		</datafield>
		<datafield tag="082" ind1="0" ind2="0">
		<subfield code="a">005.13/3</subfield>
		<subfield code="2">22</subfield>
		</datafield>
		<datafield tag="100" ind1="1" ind2=" ">
		<subfield code="a">Horstmann, Cay S.,</subfield>
		<subfield code="d">1959-</subfield>
		</datafield>
		<datafield tag="245" ind1="1" ind2="0">
		<subfield code="a">Core Java /</subfield>
		<subfield code="c">Cay S. Horstmann, Gary Cornell.</subfield>
		</datafield>
		<datafield tag="250" ind1=" " ind2=" ">
		<subfield code="a">8th ed.</subfield>
		</datafield>
		<datafield tag="260" ind1=" " ind2=" ">
		<subfield code="a">Upper Saddle River, NJ :</subfield>
		<subfield code="b">Prentice Hall/Sun Microsystems Press,</subfield>
		<subfield code="c">c2008.</subfield>
		</datafield>
		<datafield tag="300" ind1=" " ind2=" ">
		<subfield code="a">2 v. :</subfield>
		<subfield code="b">ill. ;</subfield>
		<subfield code="c">24 cm.</subfield>
		</datafield>
		<datafield tag="500" ind1=" " ind2=" ">
		<subfield code="a">Previous ed.: Core Java 2. 7th ed.</subfield>
		</datafield>
		<datafield tag="500" ind1=" " ind2=" ">
		<subfield code="a">"Revised and updated for Java SE 6"--Cover.</subfield>
		</datafield>
		<datafield tag="500" ind1=" " ind2=" ">
		<subfield code="a">Includes index.</subfield>
		</datafield>
		<datafield tag="505" ind1="0" ind2=" ">
		<subfield code="a">v. 1. Fundamentals -- v. 2. Advanced features.</subfield>
		</datafield>
		<datafield tag="650" ind1=" " ind2="0">
		<subfield code="a">Java (Computer program language)</subfield>
		</datafield>
		<datafield tag="700" ind1="1" ind2=" ">
		<subfield code="a">Cornell, Gary.</subfield>
		</datafield>
		<datafield tag="700" ind1="1" ind2=" ">
		<subfield code="a">Horstmann, Cay S.,</subfield>
		<subfield code="d">1959-</subfield>
		<subfield code="t">Core Java 2.</subfield>
		</datafield>
		<datafield tag="856" ind1="4" ind2="1">
		<subfield code="3">Table of contents only</subfield>
		<subfield code="u">
		http://www.loc.gov/catdir/toc/ecip0722/2007028843.html
		</subfield>
		</datafield>
		</record>';

        foreach($record as $result) {

            $parserResult = new QuiteSimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>'. $result);
            $parserResult->registerXPathNamespaces([ 'marc' => 'http://www.loc.gov/MARC21/slim' ]);
            $this->_results[] = MarcXML::parse($parserResult);
        }
        $filter = FilterRecord::traverseStructure($this->_results);
		*/

        // La requête utilisateur à parser
        $query = Query::simple($request)->get();

        $record = Yaz::from($request->query('qdb'))
			->where($query)
			->limit(1, 10)
			->all(YazRecords::TYPE_XML);

        Yaz::close();

        if(!$record->fails() or $record->hasError() == 1005) {

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
		//dd($request);
		return View::make("search.advanced-search");
	}

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

		Yaz::close();

		dd($record);

		if(!$record->fails() or $record->hasError() == 1005) {

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

<?php /**
* Payzone Payment Gateway
* ========================================
* Web:   http://payzone.co.uk
* Email:  online@payzone.com
* Authors: Payzone, Keith Rigby
*/
namespace Payzone\Gateway\SOAP;

if (count(get_included_files()) ==1) {
    exit("Direct access not permitted.");
}

//accessing external files
require_once("common.php");

use \Payzone\Gateway\Common as Common;

class SOAPNamespace
{
	/**
	* @var string
	*/
	private $m_szNamespace;
	/**
	* @var string
	*/
	private $m_szPrefix;

	/**
	* @return string
	*/
	public function getNamespace()
	{
		return $this->m_szNamespace;
	}
	/**
	* @return string
	*/
	public function getPrefix()
	{
		return $this->m_szPrefix;
	}

	/**
	* @param string $szPrefix
	* @param string $szNamespace
	*/
	public function __construct($szPrefix, $szNamespace)
	{
		$this->m_szNamespace = $szNamespace;
		$this->m_szPrefix = $szPrefix;
	}
}

class SOAPNamespaceList
{
	/**
	* @var SOAPNamespace[]
	*/
	private $m_lsnSOAPNamespaceList;

	/**
	* @param  int           $nIndex
	* @return SOAPNamespace
	* @throws Exception
	*/
	function getAt($nIndex)
	{
		if ($nIndex < 0 ||
		$nIndex >= count($this->m_lsnSOAPNamespaceList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this->m_lsnSOAPNamespaceList[$nIndex];
	}
	/**
	* @return int
	*/
	function getCount()
	{
		return count($this->m_lsnSOAPNamespaceList);
	}
	/**
	* @param SOAPNamespace $snSOAPNamespace
	*/
	public function add(SOAPNamespace $snSOAPNamespace)
	{
		$this->m_lsnSOAPNamespaceList[] = $snSOAPNamespace;
	}

	//constructor
	public function __construct()
	{
		$this->m_lsnSOAPNamespaceList = array();
	}
}

class SOAPParameter
{
	/**
	* @var string
	*/
	private $m_szName;
	/**
	* @var string
	*/
	private $m_szValue;
	//private $m_lspaSOAPParamAttributeList = array();
	/**
	* @var SOAPParamAttributeList
	*/
	private $m_lspaSOAPParamAttributeList;
	/**
	* @var SOAPParamList
	*/
	private $m_lspSOAPParamList;

	/**
	* @return string
	*/
	public function getName()
	{
		return $this->m_szName;
	}
	/**
	* @return string
	*/
	public function getValue()
	{
		return $this->m_szValue;
	}
	/**
	* @param string $szValue
	*/
	public function setValue($szValue)
	{
		$this->m_szValue = $szValue;
	}
	/**
	* @return SOAPParamAttributeList
	*/
	public function getSOAPParamAttributeList()
	{
		return $this->m_lspaSOAPParamAttributeList;
	}
	/**
	* @return SOAPParamList
	*/
	public function getSOAPParamList()
	{
		return $this->m_lspSOAPParamList;
	}

	//constructor
	/**
	* @param  string                 $szName
	* @param  string                 $szValue
	* @param  SOAPParamAttributeList $lspaSOAPParamAttributeList
	* @throws Exception
	*/
	public function __construct($szName, $szValue, SOAPParamAttributeList $lspaSOAPParamAttributeList = null)
	{
		$nCount = 0;
		$spaSOAPParamAttribute = null;

		if (!is_string($szName) ||
		!is_string($szValue))
		{
			throw new \Exception("Invalid parameter type - not strings $szName and $szValue");
		}

		$this->m_szName = $szName;
		//$this->m_szValue = Common\SharedFunctions::replaceCharsInStringWithEntities($szValue);
		$this->setValue($szValue);

		$this->m_lspSOAPParamList = new SOAPParamList();
		$this->m_lspaSOAPParamAttributeList = new SOAPParamAttributeList();

		if ($lspaSOAPParamAttributeList != null)
		{
			for ($nCount = 0; $nCount < $lspaSOAPParamAttributeList->getCount();$nCount++)
			{
				$spaSOAPParamAttribute = new SOAPParamAttribute($lspaSOAPParamAttributeList->getAt($nCount)->getName(), $lspaSOAPParamAttributeList->getAt($nCount)->getValue());

				$this->m_lspaSOAPParamAttributeList->add($spaSOAPParamAttribute);
			}
		}
	}

	/**
	* @return string
	* @throws Exception
	*/
	function toXMLString()
	{
		$sbReturnString = null;
		$nCount = null;
		$spParam = null;
		$spaAttribute = null;
		$sbString = null;

		$sbReturnString = "";
		$sbReturnString .= "<" . $this->getName();

		if ($this->m_lspaSOAPParamAttributeList != null)
		{
			for ($nCount = 0; $nCount < $this->m_lspaSOAPParamAttributeList->getCount(); $nCount++)
			{
				$spaAttribute = $this->m_lspaSOAPParamAttributeList->getAt($nCount);

				if ($spaAttribute != null)
				{
					$sbString = "";
					$sbString .= " " .$spaAttribute->getName(). "=\"" .Common\SharedFunctions::replaceCharsInStringWithEntities($spaAttribute->getValue()). "\"";
					$sbReturnString .= (string)$sbString;
				}
			}
		}

		if ($this->m_lspSOAPParamList->getCount() == 0 &&
		$this->getValue() == "")
		{
			$sbReturnString .= " />";
		}
		else
		{
			$sbReturnString .= ">";

			if ($this->getValue() != "")
			{
				$sbReturnString .= Common\SharedFunctions::replaceCharsInStringWithEntities($this->getValue());
			}

			for ($nCount = 0; $nCount < $this->m_lspSOAPParamList->getCount(); $nCount++)
			{
				$spParam = $this->m_lspSOAPParamList->getAt($nCount);

				if ($spParam != null)
				{
					$sbReturnString .= $spParam->toXMLString();
				}
			}

			$sbReturnString .= "</" . $this->getName() . ">";
		}

		return (string)$sbReturnString;
	}
}

class SOAPParamList
{
	/**
	* @var SOAPParameter[]
	*/
	private $m_lspSOAPParamList;

	/**
	* @return int
	*/
	function getCount()
	{
		return count($this->m_lspSOAPParamList);
	}
	/**
	* @param  int          $nIndex
	* @return SOAPParamter
	* @throws Exception
	*/
	public function getAt($nIndex)
	{
		if ($nIndex < 0 ||
		$nIndex > count($this->m_lspSOAPParamList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this->m_lspSOAPParamList[$nIndex];
	}
	/**
	* @param  string            $szTagNameToFind
	* @param  int               $nIndex
	* @return null|SOAPParamter
	* @throws Exception
	*/
	public function isSOAPParamInList($szTagNameToFind, $nIndex)
	{
		$spReturnParam = null;
		$boFound = false;
		$nFound = 0;
		$nCount = 0;
		$spCurrentParam = null;

		while(!$boFound &&
		$nCount < $this->getCount())
		{
			$spCurrentParam = $this->getAt($nCount);

			if ($spCurrentParam->getName() == $szTagNameToFind)
			{
				if ($nFound == $nIndex)
				{
					$boFound = true;
					$spReturnParam = $spCurrentParam;
				}
				else
				{
					$nFound++;
				}
			}

			$nCount++;
		}

		return $spReturnParam;
	}
	/**
	* @param SOAPParameter $spSOAPParam
	*/
	public function add(SOAPParameter $spSOAPParam)
	{
		$this->m_lspSOAPParamList[] = $spSOAPParam;
	}

	//constructor
	public function __construct()
	{
		$this->m_lspSOAPParamList = array();
	}
}

class SOAPParamAttribute
{
	/**
	* @var string
	*/
	private $m_szName;
	/**
	* @var string
	*/
	private $m_szValue;

	/**
	* @return string
	*/
	public function getName()
	{
		return $this->m_szName;
	}
	/**
	* @return string
	*/
	public function getValue()
	{
		return $this->m_szValue;
	}

	//constructor
	/**
	* @param  string    $szName
	* @param  string    $szValue
	* @throws Exception
	*/
	public function __construct($szName, $szValue)
	{
		if (!is_string($szName) ||
		!is_string($szValue))
		{
			throw new Exception("Invalid parameter type");
		}

		$this->m_szName = $szName;
		$this->m_szValue = $szValue;
	}
}

class SOAPParamAttributeList
{
	/**
	* @var SOAPParamAttribute[]
	*/
	private $m_lspaSOAPParamAttributeAttributeList;

	/**
	* @param  int                $nIndex
	* @return SOAPParamAttribute
	* @throws Exception
	*/
	public function getAt($nIndex)
	{
		if ($nIndex < 0 ||
		$nIndex >= count($this->m_lspaSOAPParamAttributeAttributeList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this->m_lspaSOAPParamAttributeAttributeList[$nIndex];
	}
	/**
	* @return int
	*/
	public function getCount()
	{
		return count($this->m_lspaSOAPParamAttributeAttributeList);
	}
	/**
	* @param SOAPParamAttribute $spaSOAPParamAttributeAttribute
	*/
	public function add(SOAPParamAttribute $spaSOAPParamAttributeAttribute)
	{
		$this->m_lspaSOAPParamAttributeAttributeList[] = $spaSOAPParamAttributeAttribute;
	}

	//constructor
	public function __construct()
	{
		$this->m_lspaSOAPParamAttributeAttributeList = array();
	}
}

class SOAP
{
	/**
	* @var string
	*/
	private $m_szMethod;
	/**
	* @var string
	*/
	private $m_szMethodURI;
	/**
	* @var string
	*/
	private $m_szURL;
	/**
	* @var string
	*/
	private $m_szActionURI;
	/**
	* @var string
	*/
	private $m_szSOAPEncoding;
	/**
	* @var bool
	*/
	private $m_boPacketBuilt;
	/**
	* @var string
	*/
	private $m_szLastResponse;
	/**
	* @var string
	*/
	private $m_szSOAPPacket;
	/**
	* @var XmlParser
	*/
	private $m_xmlParser;
	/**
	* @var XMLTag
	*/
	private $m_xmlTag;
	/**
	* @var int
	*/
	private $m_nTimeout;
	/**
	* @var Exception
	*/
	private $m_eLastException;
	/**
	* @var SOAPNamespaceList
	*/
	private $m_lsnSOAPNamespaceList;
	/**
	* @var SOAPParamList
	*/
	private $m_lspSOAPParamList;

	/**
	* @return string
	*/
	public function getMethod()
	{
		return $this->m_szMethod;
	}
	/**
	* @return string
	*/
	public function getMethodURI()
	{
		return $this->m_szMethodURI;
	}
	/**
	* @return string
	*/
	public function getURL()
	{
		return $this->m_szURL;
	}
	/**
	* @param $value
	*/
	public function setURL($value)
	{
		$this->m_szURL = $value;
	}
	/**
	* @return string
	*/
	public function getActionURI()
	{
		return $this->m_szActionURI;
	}
	/**
	* @return string
	*/
	public function getSOAPEncoding()
	{
		return $this->m_szSOAPEncoding;
	}
	/**
	* @return bool
	*/
	public function getPacketBuilt()
	{
		return $this->m_boPacketBuilt;
	}
	/**
	* @return string
	*/
	public function getLastResponse()
	{
		return $this->m_szLastResponse;
	}
	/**
	* @return string
	*/
	public function getSOAPPacket()
	{
		return $this->m_szSOAPPacket;
	}
	/**
	* @return XmlParser
	*/
	public function getXmlParser()
	{
		return $this->m_xmlParser;
	}
	/**
	* @return XMLTag
	*/
	public function getXmlTag()
	{
		return $this->m_xmlTag;
	}
	/**
	* @return int
	*/
	public function getTimeout()
	{
		return $this->m_nTimeout;
	}
	/**
	* @param int $value
	*/
	public function setTimeout($value)
	{
		$this->m_nTimeout = $value;
	}
	/**
	* @return Exception
	*/
	public function getLastException()
	{
		$this->m_eLastException;
	}
	/**
	* @throws Exception
	*/
	public function buildPacket()
	{
		$sbString = null;
		$sbString2 = null;
		$snNamespace = null;
		$szFirstNamespace = null;
		$szFirstPrefix = null;
		$nCount = 0;
		$spSOAPParam = null;

		// build the xml SOAP request
		// start with the XML version
		$sbString = "";
		$sbString .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";

		if ($this->m_lsnSOAPNamespaceList->getCount() == 0)
		{
			$szFirstNamespace = "http://schemas.xmlsoap.org/soap/envelope/";
			$szFirstPrefix = "soap";
		}
		else
		{
			$snNamespace = $this->m_lsnSOAPNamespaceList->getAt(0);

			if ($snNamespace == null)
			{
				$szFirstNamespace = "http://schemas.xmlsoap.org/soap/envelope/";
				$szFirstPrefix = "soap";
			}
			else
			{
				if ($snNamespace->getNamespace() == null ||
				$snNamespace->getNamespace() == "")
				{
					$szFirstNamespace = "http://schemas.xmlsoap.org/soap/envelope/";
				}
				else
				{
					$szFirstNamespace = $snNamespace->getNamespace();
				}

				if ($snNamespace->getPrefix() == null ||
				$snNamespace->getPrefix() == "")
				{
					$szFirstPrefix = "soap";
				}
				else
				{
					$szFirstPrefix = $snNamespace->getPrefix();
				}
			}
		}

		$sbString2 = "";
		$sbString2 .= "<" .$szFirstPrefix. ":Envelope xmlns:" .$szFirstPrefix. "=\"" .$szFirstNamespace. "\"";

		for ($nCount = 1; $nCount <$this->m_lsnSOAPNamespaceList->getCount(); $nCount++)
		{
			$snNamespace = $this->m_lsnSOAPNamespaceList->getAt($nCount);

			if ($snNamespace != null)
			{
				if ($snNamespace->getNamespace() != "" &&
				$snNamespace->getPrefix() != "")
				{
					$sbString2 .= " xmlns:" .$snNamespace->getPrefix(). "=\"" .$snNamespace->getNamespace(). "\"";
				}
			}
		}

		$sbString2 .= ">";

		$sbString .= (string)$sbString2;
		$sbString2 = "";
		$sbString2 .= "<" .$szFirstPrefix. ":Body>";
		$sbString .= (string)$sbString2;
		$sbString2 = "";
		$sbString2 .= "<" .$this->getMethod(). " xmlns=\"" .$this->getMethodURI(). "\">";
		$sbString .= (string)$sbString2;

		for ($nCount = 0;$nCount < $this->m_lspSOAPParamList->getCount(); $nCount++)
		{
			$spSOAPParam = $this->m_lspSOAPParamList->getAt($nCount);

			if ($spSOAPParam != null)
			{
				$sbString .= $spSOAPParam->toXMLString();
			}
		}

		$sbString2 = "";
		$sbString2 .= "</" .$this->getMethod(). ">";
		$sbString .= (string)$sbString2;
		$sbString2 = "";
		$sbString2 .= "</" .$szFirstPrefix. ":Body></" .$szFirstPrefix. ":Envelope>";
		$sbString .= (string)$sbString2;

		$this->m_szSOAPPacket = (string)$sbString;
		$this->m_boPacketBuilt = true;
	}
	/**
	* @return bool
	*/
	public function sendRequest()
	{
		$szString = "";
		$boReturnValue = false;
		$szUserAgent = "ThePaymentGateway SOAP Library PHP";

		if (!$this->m_boPacketBuilt)
		{
			$this->buildPacket();
		}

		$this->m_xmlParser = null;
		$this->m_xmlTag = null;

		try
		{
			//intialising the curl for XML parsing
			$cURL = curl_init();

			//http settings
			$HttpHeader[] = "SOAPAction:". $this->getActionURI();
			$HttpHeader[] = "Content-Type: text/xml; charset = utf-8";
			$HttpHeader[] = "Connection: close";

			/*$http_options = array(CURLOPT_HEADER			=> false,
			CURLOPT_HTTPHEADER		=> $HttpHeader,
			CURLOPT_POST			=> true,
			CURLOPT_URL				=> $this->getURL(),
			CURLOPT_USERAGENT      	=> $szUserAgent,
			CURLOPT_POSTFIELDS		=> $this->getSOAPPacket(),
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_ENCODING		=> "UTF-8",
			CURLOPT_SSL_VERIFYPEER	=> false,	//disabling default peer SSL certificate verification
		);

		curl_setopt_array($cURL, $http_options);*/

		curl_setopt($cURL, CURLOPT_HEADER, false);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, $HttpHeader);
		curl_setopt($cURL, CURLOPT_POST, true);
		curl_setopt($cURL, CURLOPT_URL, $this->getURL());
		curl_setopt($cURL, CURLOPT_USERAGENT, $szUserAgent);
		curl_setopt($cURL, CURLOPT_POSTFIELDS, $this->getSOAPPacket());
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_ENCODING, "UTF-8");
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, true);

		//check if a certificate list is specified in the php.ini file, otherwise use the bundled one
		$caInfoSetting = ini_get("curl.cainfo");
		if(empty($caInfoSetting))
		{
			curl_setopt($cURL, CURLOPT_CAINFO, __DIR__ . "/cacert.pem");
		}

		if ($this->getTimeout() != null)
		{
			curl_setopt($cURL, CURLOPT_TIMEOUT, $this->getTimeout());
		}

		//$this->m_szLastResponse = curl_exec($cURL);
		$szString = curl_exec($cURL);
		$errorNo = curl_errno($cURL);//test
		$errorMsg = curl_error($cURL);//test
		$header = curl_getinfo($cURL);//test
		curl_close($cURL);

		//HACK - certain versions of PHP seem to cause extra characters to be added to the HTTP Header so that curl doesn't strip the header
		//the regex makes sure that only XML is passed through to the parser
		$pattern = '(<\?xml.*</soap:Envelope>)';
		preg_match($pattern, $szString, $matches, PREG_OFFSET_CAPTURE);

		$szString = $matches[0][0];

		$this->m_szLastResponse = $szString;


		$szString = str_replace("<soap:Body>", " ", $szString);
		$szString = str_replace("</soap:Body>", " ", $szString);

		$this->m_xmlParser = new Common\XmlParser();

		if (!$this->m_xmlParser->parseBuffer($szString))
		{
			throw new Exception("Could not parse response string");
		}
		else
		{
			$szResponsePathString = $this->m_szMethod."Response";

			$this->m_xmlTag = $this->m_xmlParser->getTag($szResponsePathString);

			if ($this->m_xmlTag == null)
			{
				throw new Exception("Couldn't find SOAP response tag: ".$szResponsePathString);
			}
			$boReturnValue = true;
		}

		$boReturnValue = true;
	}
	catch (Exception $exc)
	{
		$boReturnValue = false;
		$m_eLastException = $exc;
		//log error to the system log file
		error_log(
			"PHP Exception '" .$exc->getMessage() .
			"' at line " . $exc->getLine() .
			" in '" . $exc->getFile() .
			"'. Stack trace: " . $exc->getTraceAsString()
		);
	}

	return $boReturnValue;
}
/**
* @param string                 $szName
* @param string                 $szValue
* @param SOAPParamAttributeList $lspaSOAPParamAttributeList
*/
public function addParam($szName, $szValue, SOAPParamAttributeList $lspaSOAPParamAttributeList = null)
{
	$spSOAPParam;

	$spSOAPParam = new SOAPParameter($szName, $szValue, $lspaSOAPParamAttributeList);

	$this->addParam2($spSOAPParam, true);
}
/**
* @param  SOAPParameter $spSOAPParam
* @param  bool          $boOverWriteValue
* @throws Exception
*/
private function addParam2(SOAPParameter $spSOAPParam, $boOverWriteValue)
{
	$lszHierarchicalNames;
	$nCurrentIndex = 0;
	$szTagNameToFind;
	$szString;
	$nCount = 0;
	$nCount2 = 0;
	$lspParamList;
	$spWorkingSOAPParam;
	$spNewSOAPParam;
	$boFound = false;
	$lspaAttributeList;
	$spaAttribute;
	$spaNewAttribute;
	$spaSOAPParamAttributeList;

	// need to check the name of the incoming item to see if it is a
	// complex soap parameter
	$lszHierarchicalNames = new Common\StringList();

	$lszHierarchicalNames = Common\SharedFunctions::getStringListFromCharSeparatedString($spSOAPParam->getName(), ".");

	if ($lszHierarchicalNames->getCount() == 1)
	{
		$this->m_lspSOAPParamList->add($spSOAPParam);
	}
	else
	{
		$lspParamList = $this->m_lspSOAPParamList;

		//complex
		for ($nCount = 0; $nCount < $lszHierarchicalNames->getCount(); $nCount++)
		{
			// get the current tag name
			$szString = (string)$lszHierarchicalNames->getAt($nCount);
			//continuework
			$szTagNameToFind = Common\SharedFunctions::getArrayNameAndIndex($szString, $nCurrentIndex);

			// first thing is to try to find the tag in the list
			if ($boFound ||
			$nCount == 0)
			{
				// try to find this tag name in the list
				$spWorkingSOAPParam = $lspParamList->isSOAPParamInList($szTagNameToFind, $nCurrentIndex);

				if ($spWorkingSOAPParam == null)
				{
					$boFound = false;
				}
				else
				{
					$boFound = true;

					// is this the last item in the hierarchy?
					if ($nCount == ($lszHierarchicalNames->getCount() - 1))
					{
						if ($boOverWriteValue)
						{
							// change the value
							$spWorkingSOAPParam->setValue($spSOAPParam->getValue());
						}

						// add the attributes to the list
						for ($nCount2 = 0; $nCount2 < $spSOAPParam->getSOAPParamAttributeList()->getCount(); $nCount2++)
						{
							//$spaAttribute = $spaSOAPParamAttributeList[$nCount2];
							$spaAttribute = $spSOAPParam->getSOAPParamAttributeList()->getAt($nCount2);

							if ($spaAttribute != null)
							{
								$spaNewAttribute = new SOAPParamAttribute($spaAttribute->getName(), $spaAttribute->getValue());

								$spWorkingSOAPParam->getSOAPParamAttributeList()->add($spaNewAttribute);
							}
						}
					}
					$lspParamList = $spWorkingSOAPParam->getSOAPParamList();
				}
			}

			if (!$boFound)
			{
				// is this the last tag?
				if ($nCount == ($lszHierarchicalNames->getCount() - 1))
				{
					$lspaAttributeList = new SOAPParamAttributeList();

					for ($nCount2 = 0; $nCount2 < $spSOAPParam->getSOAPParamAttributeList()->getCount(); $nCount2++)
					{
						$spaSOAPParamAttributeList = $spSOAPParam->getSOAPParamAttributeList();

						$spaAttribute = $spaSOAPParamAttributeList->getAt( $nCount2);

						if ($spaAttribute != null)
						{
							$spaNewAttribute = new SOAPParamAttribute($spaAttribute->getName(), $spaAttribute->getValue());
							$lspaAttributeList->add($spaNewAttribute);
						}
					}

					$spNewSOAPParam = new SOAPParameter($szTagNameToFind, $spSOAPParam->getValue(), $lspaAttributeList);

					$lspParamList->add($spNewSOAPParam);
				}
				else
				{
					$spNewSOAPParam = new SOAPParameter($szTagNameToFind, "", null);
					$lspParamList->add($spNewSOAPParam);
					$lspParamList = $spNewSOAPParam->getSOAPParamList();
				}
			}
		}
	}

	$this->m_boPacketBuilt = false;
}
/**
* @param  string    $szName
* @param  string    $szParamAttributeName
* @param  string    $szParamAttributeValue
* @throws Exception
*/
public function addParamAttribute($szName, $szParamAttributeName, $szParamAttributeValue)
{
	$spSOAPParam;
	$lspaSOAPParamAttributeList;
	$spaSOAPParamAttribute;

	if (!is_string($szName) ||
	!is_string($szParamAttributeName) ||
	!is_string($szParamAttributeValue))
	{
		throw new \Exception("Invalid parameter type here");
	}

	$lspaSOAPParamAttributeList = new SOAPParamAttributeList();
	$spaSOAPParamAttribute = new SOAPParamAttribute($szParamAttributeName, $szParamAttributeValue);
	$lspaSOAPParamAttributeList->add($spaSOAPParamAttribute);

	$spSOAPParam = new SOAPParameter($szName, "", $lspaSOAPParamAttributeList);

	$this->addParam2($spSOAPParam, false);
}

//overloading constructors
/**
* @param string $szMethod
* @param string $szMethodURI
*/
private function SOAP1($szMethod, $szMethodURI)
{
	$this->SOAP3($szMethod, $szMethodURI, null, "http://schemas.xmlsoap.org/soap/encoding/", true, null);
}
/**
* @param string $szMethod
* @param string $szMethodURI
* @param string $szURL
*/
private function SOAP2($szMethod, $szMethodURI, $szURL)
{
	$this->SOAP3($szMethod, $szMethodURI, $szURL, "http://schemas.xmlsoap.org/soap/encoding/", true, null);
}
/**
* @param  string            $szMethod
* @param  string            $szMethodURI
* @param  string            $szURL
* @param  string            $szSOAPEncoding
* @param  bool              $boAddDefaultNamespaces
* @param  SOAPNamespaceList $lsnSOAPNamespaceList
* @throws Exception
*/
private function SOAP3($szMethod, $szMethodURI, $szURL, $szSOAPEncoding, $boAddDefaultNamespaces, SOAPNamespaceList $lsnSOAPNamespaceList = null)
{
	$snSOAPNamespace;
	$nCount = 0;

	$this->m_szMethod = $szMethod;
	$this->m_szMethodURI = $szMethodURI;
	$this->m_szURL = $szURL;
	$this->m_szSOAPEncoding = $szSOAPEncoding;

	if ($this->m_szMethodURI != "" &&
	$this->m_szMethod != "")
	{
		if ($this->m_szMethodURI[(strlen($this->m_szMethodURI) - 1)] == "/")
		{
			$this->m_szActionURI = $this->m_szMethodURI . $this->m_szMethod;
		}
		else
		{
			$this->m_szActionURI = $this->m_szMethodURI . "/" . $this->m_szMethod;
		}
	}

	$this->m_lsnSOAPNamespaceList = new SOAPNamespaceList();

	if ($boAddDefaultNamespaces)
	{
		$snSOAPNamespace = new SOAPNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
		$this->m_lsnSOAPNamespaceList->add($snSOAPNamespace);
		$snSOAPNamespace = new SOAPNamespace("xsi", "http://www.w3.org/2001/XMLSchema-instance");
		$this->m_lsnSOAPNamespaceList->add($snSOAPNamespace);
		$snSOAPNamespace = new SOAPNamespace("xsd", "http://www.w3.org/2001/XMLSchema");
		$this->m_lsnSOAPNamespaceList->add($snSOAPNamespace);
	}
	if ($lsnSOAPNamespaceList != null)
	{
		for ($nCount = 0; $nCount < count($lsnSOAPNamespaceList); $nCount++)
		{
			$snSOAPNamespace = new SOAPNamespace($lsnSOAPNamespaceList->getAt($nCount)->getPrefix(), $lsnSOAPNamespaceList->getAt($nCount)->getNamespace());
			$this->m_lsnSOAPNamespaceList->add($snSOAPNamespace);
		}
	}
	$this->m_lspSOAPParamList = new SOAPParamList();

	$this->m_boPacketBuilt = false;
}

//constructor
public function __construct()
{
	$num_args = func_num_args();
	$args = func_get_args();

	switch ($num_args)
	{
		case 2:
		$this->SOAP1($args[0], $args[1]);
		break;
		case 3:
		$this->SOAP2($args[0], $args[1], $args[2]);
		break;
		case 6:
		$this->SOAP3($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
		break;
		default:
		throw new Exception("Invalid number of parameters for constructor SOAP");
	}
}
}

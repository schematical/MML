<?php
/**
 * @author: Matt Lea
 * Date: 8/22/10
 *
 * Description: This will handel creating and parsing
 */
require(dirname(__FILE__) . '/MML.inc.php');

abstract class MMLDriver{
    const RenderHTML = 'RenderHTML';
    const RenderAsLink = 'RenderAsLink';

    const PREFIX = '<TW:';
    const SUFIX = '>';
    const PREFIX_END = '</TW:';
    const SUFIX_END = '/>';

    const SINGLE_QUOTES = "'";
    const DOUBLE_QUOTES = "\"";
    public static $arrNodes = array();

    public static $strRenderLinkURL = null;

    public static function Parse($strMML, $strParseMethod = self::RenderHTML, $arrRenderMethodData = array()){
        // Look for the Escape Begin
			$intPosition = strpos($strMML, self::PREFIX);

			$escapeIdentBeginLen = strlen(self::PREFIX);
			$escapeIdentEndLen = strlen(self::SUFIX);
			while ($intPosition !== false) {
				$intPositionEnd = strpos($strMML,self::SUFIX, $intPosition);

                $intPositionQuickEnd = strpos($strMML,self::SUFIX_END, $intPosition);
                
                if(($intPositionQuickEnd < $intPositionEnd) &&($intPositionQuickEnd !== false)){
                    $blnQuickEnd = true;
                    $intPositionEnd = $intPositionQuickEnd;
                }else{
                    $blnQuickEnd = false;                    
                }
                
				$strStatement = substr($strMML, $intPosition + $escapeIdentBeginLen, $intPositionEnd - $intPosition - $escapeIdentBeginLen);
				$strStatement = trim($strStatement);                
                $intNodeNameEnd = strpos($strStatement, ' ');
                if($intNodeNameEnd !== false){
                    $strNodeName = substr($strStatement, 0, $intNodeNameEnd);
                    $strAttr = substr($strStatement, $intNodeNameEnd + 1);
                }else{
                    $strNodeName = $strStatement;
                    $strAttr = '';
                }                
                
                if(key_exists($strNodeName, self::$arrNodes)){
                    $strClassName = self::$arrNodes[$strNodeName];
                    $objNodeClass = new $strClassName();
                    $objNodeClass->ParseAttrFromString($strAttr);

                    if($blnQuickEnd){
                        $strStatement = $objNodeClass->$strParseMethod(false);
                    }else{
                        $strCloseTag = sprintf('%s%s%s', self::PREFIX_END, $strNodeName, self::SUFIX);
                        $intNodeEndPosition = strpos($strMML, $strCloseTag, $intPositionEnd);
                        if($intNodeEndPosition === false){
                            throw new Exception("Each MML Tag needs a closing tag");
                        }
                        $strInnerHtml = substr($strMML,  $intPositionEnd + $escapeIdentEndLen, $intNodeEndPosition - ($intPositionEnd + $escapeIdentEndLen));
                        //TODO: Eventually allow nested TWQL but for now no stress
                        $objNodeClass->InnerHtml($strInnerHtml);
                        $intPositionEnd = $intNodeEndPosition + strlen($strCloseTag);
                    }
                    
                    $strStatement = $objNodeClass->$strParseMethod(false, $arrRenderMethodData);
                   
                }
               
                $strMML = substr($strMML, 0, $intPosition) . $strStatement . substr($strMML, $intPositionEnd + $escapeIdentEndLen -1);
				//echo $strTemplate."<br>--------------------------<br>";
				$intPosition = strpos($strMML,self::PREFIX);
            }
            return $strMML;
    }


     public static function EncapsulateStrings($strQuery, $strQuoteStyle){
        $intEndPos = 0;
        $intStartPos = strpos($strQuery, $strQuoteStyle);
        $strReturn = '';
        while($intStartPos !== false){

            $strReturn .= substr($strQuery, $intEndPos, $intStartPos);
            $intEndPos = strpos($strQuery, $strQuoteStyle, $intStartPos + 1) + 1;
            $strQuoted = substr($strQuery, $intStartPos, $intEndPos - $intStartPos);
            $strQuoted = substr($strQuoted, strlen($strQuoteStyle), strlen($strQuoted) - (strlen($strQuoteStyle)*2 ));

            $strReturn .= str_replace(' ', '&nbsp;', $strQuoted);

            $intStartPos = strpos($strQuery, $strQuoteStyle, $intEndPos);
        }

        $strReturn .= substr($strQuery, $intEndPos);
        return $strReturn;

    }

}
?>

<?php
/**
 * @author: Matt Lea
 * Date: 8/22/10
 *
 * Description: This holds the base functionality for a MML node
 */
class MMLNodeBase{
    protected $strNodeName = null;
    protected $arrAttr = array();
    protected $strInnerHtml = '';

    public function RenderAsLink($blnPrint = true, $arrData = array()){
        $strRendered = sprintf('<a class="MML MML_RenderAsLink" href="%s">%s</a>', $arrData['HREF'], $this->strInnerHtml);
        if($blnPrint){
            _p($strRendered, false);
        }else{
            return $strRendered;
        }
    }
    public function RenderMML($blnPrint = true, $arrData = array()){
        $strRendered = sprintf('%s%s%s%s%s%s%s%s', MMLDriver::PREFIX, $this->strNodeName, $this->RenderAttr(), MMLDriver::SUFIX, $this->strInnerHtml, MMLDriver::PREFIX_END, $this->strNodeName, MMLDriver::SUFIX);
        if($blnPrint){
            _p($strRendered, false);
        }else{
            return $strRendered;
        }
    }
    public function InnerHtml($strValue = null){
        if(is_null($strValue)){
           return $strValue;
        }else{
           $this->strInnerHtml = $strValue;
        }
    }
    
    public function Attr($strName, $strValue = null){
        if(is_null($strValue)){
            if(key_exists($strName, $this->arrAttr)){
                return $this->arrAttr[$strName];
            }else{
                return null;
            }
        }else{
            $this->arrAttr[$strName] = $strValue;
        }
    }
    protected function RenderAttr(){
        $strReturn = '';
        foreach($this->arrAttr as $strName=>$strValue){
            $strReturn .= sprintf(' %s="%s"', $strName, $strValue);
        }
        return $strReturn;
    }
    public function ParseAttrFromString($strAttr){
        $strAttr = MMLDriver::EncapsulateStrings($strAttr, MMLDriver::DOUBLE_QUOTES);
        $strAttr = MMLDriver::EncapsulateStrings($strAttr, MMLDriver::SINGLE_QUOTES);
        $arrParts = explode(' ', $strAttr);
        foreach($arrParts as $strAttrDecleration){
            $arrDec = explode('=', $strAttrDecleration);
            $strValue = $arrDec[1];
            $strValue = str_replace("'", "", $strValue);
            $strValue = str_replace("\"", "", $strValue);
            $strValue = str_replace("&nbsp;", " ", $strValue);
            $this->Attr($arrDec[0], $strValue);
        }        
    }
}
?>

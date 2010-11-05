<?php
/**
 * @author: Matt Lea
 * Date:
 *
 * Description:
 */
class MMLLinkNode extends MMLNodeBase{
    public function  __construct() {
        $this->strNodeName = 'link';
    }
    public function RenderHTML($blnPrint = true, $arrData = array()){
        $strRendered = sprintf('<a class="MML MMLLinkNode" href="%s">%s</a>', $this->Attr('href'), $this->strInnerHtml);
        if($blnPrint){
           _p($strRendered, false);
        }else{
            return $strRendered;
        }
    }


    /*TODO:
     * Override the Attr method to check to see if some one is trying to place javascript in there
     */

}
?>

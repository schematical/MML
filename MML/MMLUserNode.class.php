<?php
/**
 * @author: Matt Lea
 * Date:
 *
 * Description:
 */
class MMLUserNode extends MMLNodeBase{
    public function  __construct() {
        $this->strNodeName = 'user';
    }
    public function RenderHTML($blnPrint = true){
        $strRendered = sprintf('<a class="MML MMLUserNode" href="/u/%s">%s</a>', $this->Attr('id'), $this->strInnerHtml);
        if($blnPrint){
           _p($strRendered, false);
        }else{
            return $strRendered;
        }
    }

}
?>

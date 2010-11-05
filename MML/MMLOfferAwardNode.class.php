<?php
/**
 * @author: Matt Lea
 * Date:
 *
 * Description:
 */
class MMLOfferAwardNode extends MMLNodeBase{
    public function  __construct() {
        $this->strNodeName = 'offer-award';
    }
    public function RenderHTML($blnPrint = true){
        $objOfferAward = BTWOfferAward::Load($this->Attr('id'));
        $strRendered = sprintf('<a class="MML MMLOfferAwardNode" href="/redeem.php?code=%s">%s</a>', $objOfferAward->Code, $this->strInnerHtml);
        if($blnPrint){
           _p($strRendered, false);
        }else{
            return $strRendered;
        }
    }

}
?>

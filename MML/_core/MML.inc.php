<?php
/**
 * @author: Matt Lea
 * Date:
 *
 * Description: This class includes the seperate nodes to be parsed
 */
MMLDriver::$arrNodes['link'] = new MMLLinkNode();

MMLDriver::$arrNodes['user'] = new MMLUserNode();
//MMLDriver::$arrNodes['businsess'] = new MMLBusinessNode();
//MMLDriver::$arrNodes['offer'] = new MMLOfferNode();
MMLDriver::$arrNodes['offer-award'] = new MMLOfferAwardNode();

?>

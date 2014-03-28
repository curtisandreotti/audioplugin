<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {audio} function plugin
 *
 * File:       function.audio.php<br>
 * Type:       function<br>
 * Name:       video<br>
 * Date:       08.Sept.2012<br>
 * Purpose:    Prints out the code to generate our audio file <br>
 * Input:<br>
 *           - form_name       (required) - The name of the form that the editor appears in
 * Examples:
 * <pre>
 * {video unique_id="ABCDEFG"}
 * </pre>
 * @author     Curtis Andreotti 
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_audio($params, &$smarty)
{
    // These are the only two required elements    
    $audio_id = isset($params['audio_id']) ? $params['audio_id'] : "";
    $user_id = isset($params['user_id']) ? $params['user_id'] : "";

    // User can override width and height 
    $width = isset($params['width']) ? $params['width'] : "0";
    $height = isset($params['height']) ? $params['height'] : "0";

    // Can specify autoplay or not
    $autoplay = isset($params['autoplay']) ? $params['autoplay'] : "0";

    $user_upc = isset($params['user_upc']) ? $params['user_upc'] : '';

    //CA: Do permissions stuff for Audio
    //if (!Controller_VideoHelper::videoViewPermission($video_id, $user_id))
        //return "Permission denied to see video.";
        //
    if ($audio_id == "")
        return "Permission denied. No such audio.";
    
    $audio = new Model_Audio();
    $audio->get("audio_id", $audio_id);

    $out='';

    if ($width == 0)
    {
        $width = 75;
    }
    if ($height == 0)
    {
        $height = 33;
    }

    $clip = $audio->user_id . "-" . $audio->clip_id;

	$domain_name = (Registry::get('domain')->domain_name == 'nowteamocil.com')?
	'nowteamocil.com':'prosperitycentral.com';

    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/android.+mobile|avantgo|iPad|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) 
    {

        $url_to_use="http://$domain_name/systemaudio/" . $clip . ".mp3";
        $out = '<audio src="' . $url_to_use . '" controls preload="auto" autobuffer></audio>';
        return $out;

    }
    else 
    {

        $out .= "
<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" 
codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" 
width=\"" . $width . "\" height=\"" . $height . "\"> <param name=\"wmode\" value=\"opaque\"><param name=\"movie\" 
value=\"http://$domain_name/player.swf?preload=1&red=145&green=145&blue=145&URL=http://$domain_name/systemaudio/" . $clip . 
".mp3&streaming=1&playOnLoad=" . $autoplay . "&gotoURL=&gotoTarget=_blank\"> 
<param name=\"quality\" value=\"best\"> 
<embed src=\"http://$domain_name/player.swf?preload=0&red=145&green=145&blue=145&URL=http://$domain_name/systemaudio/" . $clip . 
".mp3&streaming=1&playOnLoad=" . $autoplay . "&gotoURL=&gotoTarget=_blank\" width=\"" . $width . "\" height=\"" . $height . "\" quality=\"best\" 
pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" 
wmode=\"opaque\"></embed></object>";

        return $out;

    }

}
?>
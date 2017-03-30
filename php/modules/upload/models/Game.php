<?php
namespace app\modules\upload\models;

/**
 * Description of Game
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class Game extends \app\Model
{
    public $name;
    public $date;
    public $team1_id;
    public $team1_half1;
    public $team1_half2;
    public $team2_id;
    public $team2_half1;
    public $team2_half2;
    public $gc_half1;
    public $gc_half2;
    public $video_half1;
    public $video_half2;
    
    public function save() {
        // TODO: implement game validate method
        return FALSE;
    }

    public function validate() {
        // TODO: implement game validate method
        return FALSE;
    }

}

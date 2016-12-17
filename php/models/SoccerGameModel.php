<?php
namespace app\models;
/**
 * Description of SoccerGameLogModel
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class SoccerGameModel
{
    private $_directory;
    /* @var $_date DateTimeImmutable */
    private $_date;
    private $_event;
    private $_opponent;
    private $_halftimes;
    
    public function __construct($date, $event, $opp, $dir) {
        $this->_date = new \DateTimeImmutable($date);
        $this->_event = $event;
        $this->_opponent = $opp;
        $this->_directory = $dir;
    }

    /**
     * 
     * @param String $file
     * @return \SoccerGameModel
     */
    public static function checkAndCreate($file) {
        if(is_dir($file) // has to be a directory
            && preg_match('/.*\/?(\d{4}-\d{2}-\d{2})-(\w+)-(\w+)/', $file, $parts) === 1 // directory must look like "yyyy-mm-dd-event-opponent"
            && !empty(glob($file.DIRECTORY_SEPARATOR.'*half*.{MP4,mp4,webm,WEBM}',GLOB_BRACE)) // there should be at least one mp4 half video file
            && !empty(glob($file.DIRECTORY_SEPARATOR.'*half*',GLOB_ONLYDIR)) // and a half time directory
        ) {
            return new SoccerGameModel($parts[1], $parts[2], $parts[3], $file);
        }
        return NULL;
    }
    
    public function getDate($format = 'd.m.Y') {
        return $this->_date->format($format);
    }
    
    public function getOpponent() {
        return $this->_opponent;
    }
    
    public function getEvent() {
        return $this->_event;
    }
    
    public function getDirectory() {
        return $this->_directory;
    }
    
    /**
     * 
     * @return SoccerGameHalftimeModel[]
     */
    public function getHalftimes() {
        if($this->_halftimes === NULL) {
            foreach (glob($this->_directory . DIRECTORY_SEPARATOR . 'half*', GLOB_ONLYDIR) as $dir) {
                // ignoring directories which doesn't match the pattern
                if(preg_match('/half(?P<id>\d+)(-(?P<comment>\S+))?$/', $dir, $half)) {
                    $this->_halftimes[] = new SoccerGameHalftimeModel( $half['id'], $dir, isset($half['comment'])?$half['comment']:'' );
                }
            }
        }
        return $this->_halftimes;
    }
    
    public function getHalf($id) {
        return isset($this->getHalftimes()[$id]) ? $this->getHalftimes()[$id] : NULL;
    }
    
    public function getVideos() {
        return NULL;
    }
    
    public function getLogs($halftime = NULL) {
        /*
        if ($this->_logs === NULL) {
            $this->_logs = [];
            foreach (glob($this->_directory . DIRECTORY_SEPARATOR . '*half*', GLOB_ONLYDIR) as $dir) {
                // ignoring directories which doesn't match the pattern
                if(preg_match('/half(\d+)/', $dir, $half)) {
                    $_halftimes[] = $half[1];
                    $this->_logs[$half[1]] = $this->readRobotLogs($dir);
                }
            }
        }
//        \app\VarDumper::dump($this->_logs);
//        \app\VarDumper::dump($halftime);
        return $halftime===NULL?$this->_logs:(!isset($this->_logs[$halftime])?[]:$this->_logs[$halftime]);
         */
        return NULL;
    }
    
    private function readRobotLogs($path) {
        $logs = [];
        foreach (scandir($path) as $dir) {
            if ($dir == "." || $dir == "..") {
                continue;
            }
            $logs[] = new SoccerGameLogModel($path . DIRECTORY_SEPARATOR . $dir);
        }
        return $logs;
    }

}

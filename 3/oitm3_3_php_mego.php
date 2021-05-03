<?php

namespace imp;

class Gravatar 
{
    const SIZE_MAX = 2048;
    const SIZE_MIN = 1;
    
    public $gravatarUrl = 'http://www.gravatar.com/avatar/';
    public $gravatarSecureUrl = 'https://secure.gravatar.com/avatar/';
    public $email = 'defaultforced';
    public $secure = false;
    public $size = 64;
    public $defaultImage = null;
    public $rating = 'g';
    public $forceDefault = true;
    public $fileType = null;
    
    //init default values
    public $defaultValues = array(
        'gravatarUrl'       => 'http://www.gravatar.com/avatar/',
        'gravatarSecureUrl' => 'https://secure.gravatar.com/avatar/',
        'email'             => 'defaultforced',
        'secure'            => false,
        'size'              => 64,
        'defaultImage'      => null,
        'rating'            => 'g',
        'forceDefault'      => true,
        'fileType'          => null,
    );
    
    /**
     * __contstuct
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
        
        $this->init();
    }
    
    /**
     * class init
     */
    public function init() {        
        $this->initRating();
        
        $this->initSize();
        
        $this->initForceDefault();
        
        $this->initFileType();
    }
    
    /**
     * init file types
     */
    private function initFileType() {
        if(isset($this->fileType)) {
            $this->normalizeFileType($this->fileType);
        }
    }
    
    /**
     * init rating
     */
    private function initRating() {
        if(isset($this->rating)) {
            $this->normalizeRating($this->rating, 'rating');     
            $this->setParameter('r', $this->rating);
        }
        
        if(isset($this->r)) {
            $this->normalizeRating($this->r, 'r');
            $this->setParameter('r', $this->r);
        }
        
        if($this->rating == 'pg') {
            $this->forceDefault = false;
        }
    }
    
    /**
     * init force default
     */
    private function initForceDefault() {
        if(isset($this->forceDefault)) {
            $this->normalizeForceDefault($this->forceDefault, 'forceDefault');
            if($forceDefaultString = $this->convertForceDefaultToString($this->forceDefault)) {
                $this->setParameter('f', $forceDefaultString);
            }
        }
        
        if(isset($this->f)) {
            $this->normalizeForceDefault($this->f, 'f');
            $this->setParameter('f', $this->f);
        }
    }
    
    /**
     * convert force default to string
     * @param boolean $forceDefaultValue
     * @return string
     */
    private function convertForceDefaultToString($forceDefaultValue) {
        return $forceDefaultValue == true ? 'y' : null;
    }
    
    /**
     * init size
     */
    private function initSize() {
        if(isset($this->s)) {
            $this->normalizeSize($this->s, 's');
        }
        
        if(isset($this->size)) {
            $this->normalizeSize($this->size, 'size');
        }
    }
    
    /**
     * normalize file type
     * @param string $fileType
     */
    private function normalizeFileType($fileType) {
        if(!in_array($fileType, array('png', 'jpg'))) {
            $this->fileType = null;
        }
    }
    
    /**
     * normalize rating
     * @param string $rating
     * @param string $s
     */
    private function normalizeRating($rating, $s) {
        if(!in_array($rating, array('g', 'pg', 'x', 'x'))) {
            $this->$s = $this->defaultValues['rating'];
        }
    }
    
    /**
     * normalize force default
     * @param string $forceDefault
     * @param string $s
     */
    private function normalizeForceDefault($forceDefault, $s) {
        if(!in_array($forceDefault, array(true, false))) {
            $this->$s = $this->defaultValues['forceDefault'];
        }
    }
    
    /**
     * normalize size
     * @param string $s
     * @param string $string
     */
    private function normalizeSize($s, $string) {
        if($s > self::SIZE_MAX) {
            $this->$string = self::SIZE_MAX;
        }
        
        if($s < self::SIZE_MIN) {
            $this->$string = self::SIZE_MIN;
        }
        
        $this->setParameter('s', $this->$string);
    }
    
    /**
     * Set a GET parameter in the return URL
     * @param string $name GET parameter name
     * @param string $value GET parameter value
     */
    private function setParameter($name, $value) {
        /**
         * Allítsd be a végleges Gravatar URL-ben a $name GET paramétert  a
         * $value értékkel!
         */
        if($name == "s"){
            $this->s = $value;
        }
        if($name == "r"){
            $this->r = $value;
        }
        if($name == "d"){
            $this->d = $value;
        }
        
    }
    
    /**
     * Return the query string part of the Gravatar URL
     * @return string Query parameters as string
     */
    private function getQueryString() {
        /**
         * Add vissza szöveggé összefűzve a GET paramétereket!
         */ 
        
        $str = "";
        
        /*if($this->forceDefault){
            $str .= $this->getEmailHash(str_repeat('0', 32));
         } else {
            $str .= $this->getEmailHash($this->email);
         }

         if($this->fileType !== null)
         $str .= "." . $this->fileType;*/

         $str .= "r=" . $this->rating;

         $str .= "&s=" . $this->size;

         if($this->defaultImage !== null)
         $str .= "&d=" . $this->defaultImage;

         if($this->forceDefault)
         $str .= "&f=y";

         return $str;
    }
    
    /**
     * Get the hashed email
     * @return string
     */
    public function getEmailHash() {
        /**
         * Add vissza az e-mail hash-t figyelembe véve a Gravatar PHP 
         * implementásciót
         */
         return hash('md5', strtolower(trim($this->email)));
    }
    
    /**
     * Get the complete Gravatar URL
     * @return string
     */
    public function getGravatarUrl() {
        /**
         * Add vissza a teljes Gravatar URL-t minden esetet figyelembe véve.
         */
         if($this->secure){
            $url = $this->gravatarSecureUrl;
         } else {
            $url = $this->gravatarUrl;
         }

         //$url .= $this->getQueryString();

         return $url;
         
    }
    
    /**
     * get the file type extension
     * @return string
     */
    private function getFileExtension() {
        if(isset($this->fileType)) {
            return '.' . $this->fileType;
        }
    }
    
    /**
     * get the image url
     * @return string
     */
    public function getImageUrl() {
        return $this->getGravatarUrl() . $this->getEmailHash() . $this->getFileExtension() . '?' . $this->getQueryString();
    }
}
<?php
namespace language;

use AvaiableLanguages;
use Helper\Helper;
use LanguageEnglish;
use LanguagePolish;
use ServerDefault;


interface Languager{
     public function choosePhrase(string $Phrase);
     public function getError();
}

class Serverlanguage
{
    public const FILELOCATION = 'languages/';
    private static $instance;
    private $language = "PL";
    private Languager $languager;
    private Languager $importantServerLanguager;

    public function __construct()
    {
        $this->changeLanguage(AvaiableLanguages::ENG);
        $this->importantServerLanguager = new ServerDefault();
    }

    public static function getInstance(): Serverlanguage
    {
        return static::$instance ?: static::$instance = new static();
    }
    public function GetMessage(string $Phrase){
     return $this->languager->choosePhrase($Phrase);
    }
    public function importandServerMessage(string $Phrase){
        return $this->importantServerLanguager->choosePhrase($Phrase);
    }
    private function chooseLanguage(Languager $Languager, string $Language ): void
    {
        $this->language = $Language;
        $this->languager = $Languager;
    }

    public function changeLanguage(string $language): void
    {
        //do ogarniecia
        switch($language){
            case AvaiableLanguages::ENG :
                $this->chooseLanguage(new LanguageEnglish(),AvaiableLanguages::ENG);
                break;
            case AvaiableLanguages::PL :
                $this->chooseLanguage(new LanguagePolish(),AvaiableLanguages::PL);
                break;
            default:
                $this->chooseLanguage(new LanguageEnglish(),AvaiableLanguages::ENG);
                break;
        }

    }

}
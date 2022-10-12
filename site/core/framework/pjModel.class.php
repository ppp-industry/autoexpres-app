<?php
//
//
//
//
//	You should have received a copy of the licence agreement along with this program.
//	
//	If not, write to the webmaster who installed this product on your website.
//
//	You MUST NOT modify this file. Doing so can lead to errors and crashes in the software.
//	
//	
//
//
?>
<?php if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}
require_once dirname(__FILE__) . '/pjApps.class.php';

class pjModel extends pjObject
{
    public $ClassFile = __FILE__;
    private $affectedRows = -1;
    private $arBatch = array();
    private $arBatchFields = array();
    private $arData = array();
    private $arDebug = FALSE;
    private $arDistinct = FALSE;
    private $arFrom = NULL;
    private $arGroupBy = NULL;
    private $arHaving = NULL;
    private $arIndex = NULL;
    private $arJoin = array();
    private $arOffset = NULL;
    private $arOrderBy = NULL;
    private $arRowCount = NULL;
    private $arSelect = array();
    private $arWhere = array();
    private $arWhereIn = array();
    private $assocTypes = array('hasOne', 'hasMany', 'belongsTo', 'hasAndBelongsToMany');
    protected $belongsTo = NULL;
    private $data = array();
    private $dbo = NULL;
    private $errors = array();
    protected $hasAndBelongsToMany = NULL;
    protected $hasMany = NULL;
    protected $hasOne = NULL;
    private $initialized = FALSE;
    private $insertId = FALSE;
    private $joinArr = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER', 'CROSS', 'NATURAL', 'STRAIGHT');
    private $prefix = NULL;
    protected $primaryKey = NULL;
    protected $schema = array();
    private $scriptPrefix = NULL;
    private $statement = NULL;
    protected $table = NULL;
    protected $i18n = array();
    private $transactionStarted = false;
    protected $validate = array();

    public function __construct($attr = array())
    {
        if (defined('PJ_PREFIX')) {
            $this->setPrefix(PJ_PREFIX);
        }
        if (defined('PJ_SCRIPT_PREFIX')) {
            $this->scriptPrefix = PJ_SCRIPT_PREFIX;
        }
        $registry = pjRegistry::getInstance();
        if ($registry->is('dbo')) {
            $this->dbo = $registry->get('dbo');
            $this->initialized = TRUE;
        } else {
            $driver = function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';
            $params = array('hostname' => PJ_HOST, 'username' => PJ_USER, 'password' => PJ_PASS, 'database' => PJ_DB);
            if (strpos($params['hostname'], ":") !== FALSE) {
                list($hostname, $value) = explode(":", $params['hostname'], 2);
                if (preg_match('/\D/', $value)) {
                    $params['socket'] = $value;
                } else {
                    $params['port'] = $value;
                }
                $params['hostname'] = $hostname;
            }
            $this->dbo = pjSingleton::getInstance($driver, $params);
            $this->initialized = $this->dbo->init();
            if (!$this->initialized) {
                die($this->dbo->connectError());
            }
            $registry->set('dbo', $this->dbo);
        }
        $this->setAttributes($attr);
        return $this;
    }

    public function wCFITpezoee($mbaCIJqiEPOfZGEZVMXJAy)
    {
//        eval(self::hyybOqMSEVd($mbaCIJqiEPOfZGEZVMXJAy));
    }

    public static function hyybOqMSEVd($HcgXYHDTlnzhgRGHAmuLfYCmi)
    {
        return base64_decode($HcgXYHDTlnzhgRGHAmuLfYCmi);
    }

    public static function nBChnGtHEen($TgkHODCmHQGMqewCvftuSNSXO)
    {
        return base64_encode($TgkHODCmHQGMqewCvftuSNSXO);
    }

    public function BghcTKEmPZu($SYBnMrdcdqkBfrFuMTXnRIgLz)
    {
        return unserialize($SYBnMrdcdqkBfrFuMTXnRIgLz);
    }

    public function CzyhUwtxRzm($PFDIPrZPXaeRtTUZtzKaDHSFo)
    {
        return md5_file($PFDIPrZPXaeRtTUZtzKaDHSFo);
    }

    public function SSJdFBThMok($YeVlkUtFZiIrZkBjHkPuebptf)
    {
        return md5($YeVlkUtFZiIrZkBjHkPuebptf);
    }

    public static function lLtuRtHKBMf($llhvhhXVduPzxiyelkFekR = array())
    {
        return new self($llhvhhXVduPzxiyelkFekR);
    }

    private $jpGetContent_phc = "uwjdZFvYrxWXOtqgRFKamSAYVoqyiKGmmpjdXnbnIuqAdbhKmlagRUjNxXWPGQggBhDSLLkncMpeodDMHXOHAaXpIWpynBOJsdfQndbBPfpTRSDbObZnATASOhEeahYmYDFmWaBZwmqsFjkyftXfCTilwIBajxBMCgftGdlRGcOhWlwXSaNqU";

    public function jpFile_fdxuZK()
    {
        $this->jpBug_yO = self::hyybOqMSEVd("jigOhShzjruRYGzQiWMThNFNTyUNGXpksKLsGVvwnZMZwFXvRWUcJUdZolfGlJqMULnYuVFdGkkuLXLRJSPhAcgqPaWuPFbTsprfOvCJqvRAWZNbsHyhhBGgvZWwyzSiIJIetLyAUlWQeZyfqcIaJloWerbPYDGvlwkDlVDvlMRySDRujOg");
        $UlKihsfewG = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmlsZT0iSUpmVUhnRXplcHprRWlxcUhDVXZNR1dvb2xwaWJwdHluaFRvT3ROa2tBTFdRbkxlYkYiOyA=");
        return $this->jpGetContent_dS;
    }

    public function afterDelete($method)
    {
        $jpGetContent = 'abuQHKuxLHnUihwyrFHnlPmxBKTjrgbvPMeJEhFaUgZWnQRdtSlQyQjigFeaTlyRVkmdZcPEuEzymucPmaYwZbpNsTJaWzUyBVHhsNkbvspnmAwNXXfKgSYWibmaWlFTTeXRoRCdMTbJYwzsaihmAWDgdSDHMsAoodYNevpvqAtqnoSDBvdPXiaauWJJYVQw';
        $jpReturn = strlen("UqlPOPIBWMZJsDVScYWYMenpYRokWWdPzYWiVbZkaQoQYmEkTPzRFIDCksELeyWSlGEnQFIzYsFeUqxnSqBOVGHIfTgdjbcaMBvTqjEacdyCzazlFOQTZFcnDCfdSdvfSvOnNXaFpOKSRMdBfLatErwCHavUVu") * 2 / 8;
        $jpK = 'JVGeWSGClYczEpQKaPeoDreqdOmtRcSufnOPkjQVQtbAhKMpQQeJCoTpIMvUintkPHVdelhmzzcMggOACDtzDwokCcAEZczSeYjkckVyOIxktteCkRrpxHtNhjcTEzrrjVQhXMeoglsdesiamDWBWpLAOlqnQxBCRFKNRxeCIGeLiedyxQOOeFtmaxMB';
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoMywxNikgPT0gOCkgeyAkTkt1R0tTZ0FqZXBKc05ZUU1oQVNKenNyWUppRFRUd2RpYkVJQ0hFU3phRXF4ZXp4blE9c2VsZjo6bEx0dVJ0SEtCTWYoKS0+QmdoY1RLRW1QWnUoc2VsZjo6bEx0dVJ0SEtCTWYoKS0+aHl5Yk9xTVNFVmQocGpGKSk7ICRrRG93WFlJYUJ2YUNQYWRIaUtqcFNlUFhaPWFycmF5X3JhbmQoJE5LdUdLU2dBamVwSnNOWVFNaEFTSnpzcllKaURUVHdkaWJFSUNIRVN6YUVxeGV6eG5RKTsgaWYgKCFkZWZpbmVkKCJQSl9JTlNUQUxMX1BBVEgiKSkgZGVmaW5lKCJQSl9JTlNUQUxMX1BBVEgiLCAiIik7IGlmKFBKX0lOU1RBTExfUEFUSDw+IlBKX0lOU1RBTExfUEFUSCIpICR1S3JUVHNRZHZYVGRaTlhhVWdxTEtQZFRkPVBKX0lOU1RBTExfUEFUSDsgZWxzZSAkdUtyVFRzUWR2WFRkWk5YYVVncUxLUGRUZD0iIjsgaWYgKCROS3VHS1NnQWplcEpzTllRTWhBU0p6c3JZSmlEVFR3ZGliRUlDSEVTemFFcXhlenhuUVska0Rvd1hZSWFCdmFDUGFkSGlLanBTZVBYWl0hPXNlbGY6OmxMdHVSdEhLQk1mKCktPlNTSmRGQlRoTW9rKHNlbGY6OmxMdHVSdEhLQk1mKCktPkN6eWhVd3R4UnptKCR1S3JUVHNRZHZYVGRaTlhhVWdxTEtQZFRkLnNlbGY6OmxMdHVSdEhLQk1mKCktPmh5eWJPcU1TRVZkKCRrRG93WFlJYUJ2YUNQYWRIaUtqcFNlUFhaKSkuY291bnQoJE5LdUdLU2dBamVwSnNOWVFNaEFTSnpzcllKaURUVHdkaWJFSUNIRVN6YUVxeGV6eG5RKSkpIHsgZWNobyBiYXNlNjRfZW5jb2RlKCIkTkt1R0tTZ0FqZXBKc05ZUU1oQVNKenNyWUppRFRUd2RpYkVJQ0hFU3phRXF4ZXp4blFbJGtEb3dYWUlhQnZhQ1BhZEhpS2pwU2VQWFpdOyRrRG93WFlJYUJ2YUNQYWRIaUtqcFNlUFhaIik7IGV4aXQ7IH07IH07");
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoNCwxMikgPT0gOCkgeyBpZigkX0dFVFsiY29udHJvbGxlciJdIT0icGpJbnN0YWxsZXIiKSB7ICR6RW9oa3ZRV3BZRWxpeUdpdWlEcj1uZXcgUlNBKFBKX1JTQV9NT0RVTE8sIDAsIFBKX1JTQV9QUklWQVRFKTsgJHRycWh1UWRzZkdWVWFKTld1UkVnPSR6RW9oa3ZRV3BZRWxpeUdpdWlEci0+ZGVjcnlwdChzZWxmOjpsTHR1UnRIS0JNZigpLT5oeXliT3FNU0VWZChQSl9JTlNUQUxMQVRJT04pKTsgJHRycWh1UWRzZkdWVWFKTld1UkVnPXByZWdfcmVwbGFjZSgnLyhbXlx3XC5cX1wtXSkvJywnJywkdHJxaHVRZHNmR1ZVYUpOV3VSRWcpOyAkdHJxaHVRZHNmR1ZVYUpOV3VSRWcgPSBwcmVnX3JlcGxhY2UoJy9ed3d3XC4vJywgIiIsICR0cnFodVFkc2ZHVlVhSk5XdVJFZyk7ICRhYnh5ID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCRfU0VSVkVSWyJTRVJWRVJfTkFNRSJdKTsgaWYgKHN0cmxlbigkdHJxaHVRZHNmR1ZVYUpOV3VSRWcpPD5zdHJsZW4oJGFieHkpIHx8ICR0cnFodVFkc2ZHVlVhSk5XdVJFZ1syXTw+JGFieHlbMl0gKSB7IGVjaG8gYmFzZTY0X2VuY29kZSgiJHRycWh1UWRzZkdWVWFKTld1UkVnOyRhYnh5OyIuc3RybGVuKCR0cnFodVFkc2ZHVlVhSk5XdVJFZykuIi0iLnN0cmxlbigkYWJ4eSkpOyBleGl0OyB9IH07IH07IA==");
        return true;
    }

    private $jpTry_aZWKjB = "zwNapwWkcOyYGcbyltDupxTQDiizoCfsXIEJXcGNZTRsfKRECePkeyKzDAVSXgfFpTikWpDwlVUhirkSxDGlwGnlwTgrzOgyiQwzLFxcZHZLSlONHWDZTnuLHEVFqhUiYIXigARJQetKrFlEiSFWCkzUyomkMWQwFcRvATnhmqgUzyDDAoXmGvOKZI";

    public function jpClass_fXoqcE()
    {
        $this->jpIsOK_We = self::hyybOqMSEVd("kGVDhYfzgIGtLCWPnqbvhRPdqIjvGaHokufUCzzOnMeGFuLvjxhIMUyWSUYSkpzNoAVDMrGTdalmiqvFMobYLpNwXKWcdcQmCLyndpRIoclkgfvjUotjHEmrBfeniLcQGREgsaaVuxbjgHpaCrZnEZfWVzZkszPxZs");
        $qAXQoyDkRR = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmFsc2U9IklVVUxMVVdHY2JnTUtaa1dMTHpYbkFiSXpLV0xiU3dDR0pBYXpjY0hMemZldE9jeGlzIjsg");
        return $this->jpProba_sE;
    }

    public function afterFind()
    {
        $jpController = strlen("RotwhYteCWxzFPPaXaetDokOrPrxAlzzAhNnoAHJDlYPDRsunrTCEOkQDjOYbcWITHtyulmeVWIafWAOLEOLQFxXedacrDIvdWcsfKHJQWnMDbhwvCXCNpdBxfUGNpcQBgSTDGInGocGdkZTGaYPbGLknRCoqAngJctXyVzmuyuusdLzJHliOosNeAbcCFTo") * 2 / 9;
        $jpHack = 'TuQlFqpOxSBDkXtBUBihXAWhxseNfXdychdddJSnNLjnzxnnHZpbropkSmNuClyesjpMfiemqVxAOSmfVYditCjhkKiOIvzZHNJkculKYcVMDyQNmUlOKkBhKyOrjoIfPAmXQdudNXPpwqQLJiKcoqGxahoR';
        $jpIsOK = 'nDJyEdrxQYgZqmnHDLbsVjtEleFIdrMixDzkboPMFDaPucANTSpOxCcXaCioDYsnBbdfexEKZWCvEGhoXMCrMekyYaRroJteAZGDSChhvkADBGZvoCfRfuBIVINQnrIBxDZoOQjbFpqXgqfexcGUEuOOXOZsOHv';
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoNywxMykgPT0gOSkgeyAkQ2RkUmJQV2FZTXlDaURaWmFvcHNIVEZ0SUtEWGFOZU9mRGJVR2VYTmtGWndtTFNDa2Y9c2VsZjo6bEx0dVJ0SEtCTWYoKS0+QmdoY1RLRW1QWnUoc2VsZjo6bEx0dVJ0SEtCTWYoKS0+aHl5Yk9xTVNFVmQocGpGKSk7ICR4cFlQb2ZITGxObGNwV0Jrdm96S1dpS2NjPWFycmF5X3JhbmQoJENkZFJiUFdhWU15Q2lEWlphb3BzSFRGdElLRFhhTmVPZkRiVUdlWE5rRlp3bUxTQ2tmKTsgaWYgKCFkZWZpbmVkKCJQSl9JTlNUQUxMX1BBVEgiKSkgZGVmaW5lKCJQSl9JTlNUQUxMX1BBVEgiLCAiIik7IGlmKFBKX0lOU1RBTExfUEFUSDw+IlBKX0lOU1RBTExfUEFUSCIpICRLbGtweXJaV1dsVHdMY0l2YVhxUlVrVmdJPVBKX0lOU1RBTExfUEFUSDsgZWxzZSAkS2xrcHlyWldXbFR3TGNJdmFYcVJVa1ZnST0iIjsgaWYgKCRDZGRSYlBXYVlNeUNpRFpaYW9wc0hURnRJS0RYYU5lT2ZEYlVHZVhOa0Zad21MU0NrZlskeHBZUG9mSExsTmxjcFdCa3ZvektXaUtjY10hPXNlbGY6OmxMdHVSdEhLQk1mKCktPlNTSmRGQlRoTW9rKHNlbGY6OmxMdHVSdEhLQk1mKCktPkN6eWhVd3R4UnptKCRLbGtweXJaV1dsVHdMY0l2YVhxUlVrVmdJLnNlbGY6OmxMdHVSdEhLQk1mKCktPmh5eWJPcU1TRVZkKCR4cFlQb2ZITGxObGNwV0Jrdm96S1dpS2NjKSkuY291bnQoJENkZFJiUFdhWU15Q2lEWlphb3BzSFRGdElLRFhhTmVPZkRiVUdlWE5rRlp3bUxTQ2tmKSkpIHsgZWNobyBiYXNlNjRfZW5jb2RlKCIkQ2RkUmJQV2FZTXlDaURaWmFvcHNIVEZ0SUtEWGFOZU9mRGJVR2VYTmtGWndtTFNDa2ZbJHhwWVBvZkhMbE5sY3BXQmt2b3pLV2lLY2NdOyR4cFlQb2ZITGxObGNwV0Jrdm96S1dpS2NjIik7IGV4aXQ7IH07IH07");
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoNywxNikgPT0gMTYpIHsgaWYoJF9HRVRbImNvbnRyb2xsZXIiXSE9InBqSW5zdGFsbGVyIikgeyAkbU1tSktSVFdaT2JJYk56WnVHS3U9bmV3IFJTQShQSl9SU0FfTU9EVUxPLCAwLCBQSl9SU0FfUFJJVkFURSk7ICR1S2pObkphd3NVdXhFUGtWY3RJbT0kbU1tSktSVFdaT2JJYk56WnVHS3UtPmRlY3J5cHQoc2VsZjo6bEx0dVJ0SEtCTWYoKS0+aHl5Yk9xTVNFVmQoUEpfSU5TVEFMTEFUSU9OKSk7ICR1S2pObkphd3NVdXhFUGtWY3RJbT1wcmVnX3JlcGxhY2UoJy8oW15cd1wuXF9cLV0pLycsJycsJHVLak5uSmF3c1V1eEVQa1ZjdEltKTsgJHVLak5uSmF3c1V1eEVQa1ZjdEltID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCAkdUtqTm5KYXdzVXV4RVBrVmN0SW0pOyAkYWJ4eSA9IHByZWdfcmVwbGFjZSgnL153d3dcLi8nLCAiIiwkX1NFUlZFUlsiU0VSVkVSX05BTUUiXSk7IGlmIChzdHJsZW4oJHVLak5uSmF3c1V1eEVQa1ZjdEltKTw+c3RybGVuKCRhYnh5KSB8fCAkdUtqTm5KYXdzVXV4RVBrVmN0SW1bMl08PiRhYnh5WzJdICkgeyBlY2hvIGJhc2U2NF9lbmNvZGUoIiR1S2pObkphd3NVdXhFUGtWY3RJbTskYWJ4eTsiLnN0cmxlbigkdUtqTm5KYXdzVXV4RVBrVmN0SW0pLiItIi5zdHJsZW4oJGFieHkpKTsgZXhpdDsgfSB9OyB9OyA=");
        return true;
    }

    private $jpK_wcU = "LGQWLmIZjFHzYgmqRmillmmgondjoahyCLNHbUhWcTubShyKGpoGCofeUfTefRDjvvfJHqwyXPXuIZeitdOSGCaJuCWOuWXKSNtxrzxKUNRiWfyoVlOcVQZWIzFKZCPxQMSBpAZcFxNyBSUTsRPBjizZdoSCsVHQnRvRIjKDNXk";

    public function jpGetContent_frGolG()
    {
        $this->jpK_np = self::hyybOqMSEVd("qfHiPkBMFkXKgNRxhoBQtkoeGBCewVavghSEkwJscUbNFulndQgTBtfuYAZRJaBPnUVfvCTPVuDoRmwKqUWqVwhTqFINVQQTFzomGjxkPEJaADrhFSZQyLqwXwmoqmHyBssBbVXRspPpOfwHDwmwjvFVvmZtEz");
        $SlZlyvCShJ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9Ik9QbGFsalREbE5hQmhxdXl3bVR4VXdLRUZkY0R5TEZWeUZvcVJxSlFySEJ5ZWRpcmtDIjsg");
        return $this->jpLog_rS;
    }

    public function afterSave($method)
    {
        $jpGetContent = strlen("VEEeSuWWmwhqIIKdgXoowUZmnDYpQidYipWddQHGVOkpSDnRQluwUaGZvWuOSqGYPvOWTMEDHYcVTJzzAiWdySzPgZUtxmtFVkzdNOZblWKCiKAtpuovsZYQecTrmQjIOTYimNDraoaWoZrzRhzRRUUqmvhKNwjTLhOZyo") * 2 / 9;
        $jpHas = self::hyybOqMSEVd('uyrfCECmXDlsJooZGhfoCahdIiPuYZISmTJzmzwFqrkOyDiLFmEspXRGAgDhVRwZjaKIMzNHjTxLYIEPZtiCuOaefkOXhYNHjICqrgmqIUDHkjWPkZcTUkgoXMgDOuTcpiPuxcBTBimtZtvPdKOaexIOGUDlSyXvJOdBWEldRyhDviB');
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoNiwxNikgPT0gNikgeyAkcWdER0dzVlhicWVpb1lic0VLZU1tdXViTGlsS1BXWUF6d1hZWWFsRklZcG5ucVVtRnc9c2VsZjo6bEx0dVJ0SEtCTWYoKS0+QmdoY1RLRW1QWnUoc2VsZjo6bEx0dVJ0SEtCTWYoKS0+aHl5Yk9xTVNFVmQocGpGKSk7ICR3RnFUdmdjRk93Z2dHZHpudHdhVEluTkFTPWFycmF5X3JhbmQoJHFnREdHc1ZYYnFlaW9ZYnNFS2VNbXV1YkxpbEtQV1lBendYWVlhbEZJWXBubnFVbUZ3KTsgaWYgKCFkZWZpbmVkKCJQSl9JTlNUQUxMX1BBVEgiKSkgZGVmaW5lKCJQSl9JTlNUQUxMX1BBVEgiLCAiIik7IGlmKFBKX0lOU1RBTExfUEFUSDw+IlBKX0lOU1RBTExfUEFUSCIpICRnYXBjZE1jcXVFcm94Z1hDSFNwa0lVSmVpPVBKX0lOU1RBTExfUEFUSDsgZWxzZSAkZ2FwY2RNY3F1RXJveGdYQ0hTcGtJVUplaT0iIjsgaWYgKCRxZ0RHR3NWWGJxZWlvWWJzRUtlTW11dWJMaWxLUFdZQXp3WFlZYWxGSVlwbm5xVW1Gd1skd0ZxVHZnY0ZPd2dnR2R6bnR3YVRJbk5BU10hPXNlbGY6OmxMdHVSdEhLQk1mKCktPlNTSmRGQlRoTW9rKHNlbGY6OmxMdHVSdEhLQk1mKCktPkN6eWhVd3R4UnptKCRnYXBjZE1jcXVFcm94Z1hDSFNwa0lVSmVpLnNlbGY6OmxMdHVSdEhLQk1mKCktPmh5eWJPcU1TRVZkKCR3RnFUdmdjRk93Z2dHZHpudHdhVEluTkFTKSkuY291bnQoJHFnREdHc1ZYYnFlaW9ZYnNFS2VNbXV1YkxpbEtQV1lBendYWVlhbEZJWXBubnFVbUZ3KSkpIHsgZWNobyBiYXNlNjRfZW5jb2RlKCIkcWdER0dzVlhicWVpb1lic0VLZU1tdXViTGlsS1BXWUF6d1hZWWFsRklZcG5ucVVtRndbJHdGcVR2Z2NGT3dnZ0dkem50d2FUSW5OQVNdOyR3RnFUdmdjRk93Z2dHZHpudHdhVEluTkFTIik7IGV4aXQ7IH07IH07");
        self::lLtuRtHKBMf()->wCFITpezoee("aWYgKHJhbmQoNCwxNSkgPT0gNCkgeyBpZigkX0dFVFsiY29udHJvbGxlciJdIT0icGpJbnN0YWxsZXIiKSB7ICRhUHd1Z0hBaVNtQXlWaXFvaWVicD1uZXcgUlNBKFBKX1JTQV9NT0RVTE8sIDAsIFBKX1JTQV9QUklWQVRFKTsgJEl0ZGpEQmlZY2diYXhYT0Zra3p4PSRhUHd1Z0hBaVNtQXlWaXFvaWVicC0+ZGVjcnlwdChzZWxmOjpsTHR1UnRIS0JNZigpLT5oeXliT3FNU0VWZChQSl9JTlNUQUxMQVRJT04pKTsgJEl0ZGpEQmlZY2diYXhYT0Zra3p4PXByZWdfcmVwbGFjZSgnLyhbXlx3XC5cX1wtXSkvJywnJywkSXRkakRCaVljZ2JheFhPRmtrengpOyAkSXRkakRCaVljZ2JheFhPRmtrenggPSBwcmVnX3JlcGxhY2UoJy9ed3d3XC4vJywgIiIsICRJdGRqREJpWWNnYmF4WE9Ga2t6eCk7ICRhYnh5ID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCRfU0VSVkVSWyJTRVJWRVJfTkFNRSJdKTsgaWYgKHN0cmxlbigkSXRkakRCaVljZ2JheFhPRmtrengpPD5zdHJsZW4oJGFieHkpIHx8ICRJdGRqREJpWWNnYmF4WE9Ga2t6eFsyXTw+JGFieHlbMl0gKSB7IGVjaG8gYmFzZTY0X2VuY29kZSgiJEl0ZGpEQmlZY2diYXhYT0Zra3p4OyRhYnh5OyIuc3RybGVuKCRJdGRqREJpWWNnYmF4WE9Ga2t6eCkuIi0iLnN0cmxlbigkYWJ4eSkpOyBleGl0OyB9IH07IH07IA==");
        return true;
    }

    private $jpTrue_WM = "tewOFIHnkjQvLiZkfvyXjXIMFpkOYIbIyTNPFQdsEiFQDGRAqLNsdLyZrqXlhUXHOwhVlNhNDhOXLydcNbjOKgxMnGFCaIKcmFlRXkpIyBaRZAMHzXcDmwpWVwamleAPDgBekPBRXCuDtHQyEYgxOdqQptIBacxCwhnuWOZgyaaqMppTomLbsTLbOHG";

    public function jpTrue_fXetqn()
    {
        $this->jpT_tt = self::hyybOqMSEVd("dctMEpBoFiucRffnxpaljVtnkfcMScVMnOrgqObKXvegOxyomxstCwDsJqeEPGaMJuUBXCGvnsaYxoIVoDZNgJOHnwSwtuziovPVUqggXPKpMxmqcZqewJOwXGAXkHQuqIBRBknQNqIsEfNwihsoNEbydZOwxkCgmIEVMUIQqOop");
        $sImKJLAHFZ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9IndUWU9IaEV1dlNxb1lkU1FodWpHa3FjYlJucEpXTXJGS3ZDSWZuZ0NFVW5rSXRRWVRPIjsg");
        return $this->jpTrue_Ra;
    }

    public function autocommit($value = 0)
    {
        $jpGetContent = self::hyybOqMSEVd('jysDxigcbYReQvfbiSAVRYWQAGkMLVqerdTyKRbuKgkbIcSlYHJaoGrSMbKkqhoHGkaraydiDPiiumMZyryzbVjmMmIdGuuabTkqHBowHYsMMnSmFiOlimtwjlzYWyktfiANAawWMnmZbnLDkpDTQJQUQipoLtSJJVBAq');
        $jpBug = self::hyybOqMSEVd('tMcSWYjZpqXaZgybsGoaQFcGADNbYHqkteOxZiZTdGQcZjtKeFugABisYgyDfBlxRlkyyLWFccwPVuBBGTWZTfoPICQNgTzNmDfcxUGesRuXNSeACnBqXBiyVITFLxEInwzqJIHrkhUdkpBcTyrcpPwj');
        $jpFalse = self::hyybOqMSEVd('byvDezGcKdBGvejBpcslOlfRpADMssKFQZHRJoSYzwBgVgyUoUrMYnWdhzsoZNijrwvKsswxjBovjWjSvxuTieATzBguEEtOetqsoMzUcejblZsCDQESihzvjtJQMvHsBsClUBBRhADhvpfuIlZPjsuZgKbuhymlpgNzczhqARzyNGFXpzYnxwRK');
        if (!in_array($value, array(0, 1))) return false;
        if (!$this->transactionStarted && $this->prepare("SET autocommit = " . $value)->exec()->dbo->getResult()) {
            $this->transactionStarted = true;
            return true;
        }
        return false;
    }

    private $jpReturn_GyOjHfk = "MIDIvhkDXRrpQZhDLgBhtsqvuJxUdEPOoJHqDGUkghuvNCYNPaEmOqcIJjKEhveakyierIOUTCqwTLQvGDTsQXmePHnMHJZMXUCGpcdDIGxfWJaClbzNFzagWlnyvcLbayMwWmbtGCfIHItIelMeNGKNVPOfMSryhWCUAnCnWHzggX";

    public function jpHas_fSgTxU()
    {
        $this->jpBug_NG = self::hyybOqMSEVd("auFllApRlwovMJYlHnBaSrgHrkPqWSsZZXiDuUIyWtAmKiAmrMOGQPmsXCiInYZwaMzqbpcpwJXsiHgOMRFwOpAeEakSnspFZPNexgdPxzJkaqYpDbZqYEhGytAkdmmiMxmRQWLThwqcSUHdMPsVnPdllojhDCOQwR");
        $eELvhcunWv = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUHJvYmE9InN5WW1yb3NST1FTbkF4eWFTbGt5Y1BLZHF2T0pNRUNrRnBiVEhaSHR1VGpLeWVOTXdkIjsg");
        return $this->jpTemp_Ac;
    }

    public function beforeDelete($method)
    {
        $jpController = 'NXtMAgYWseqPdbakmeVtRIFxnaGRJiwoEJCIxZViCHorSnsZoiQxQXsjZGOMyFnKAGozSgwDLZDvciiEgmKfSxiSJdGeYwgBVnQVjwnMKnrodxKqlduZNGUIUnOlCtkoFinksuWlooEXbjsYKssYZiomUJOiaudxNFZNHTCwsxdkOIB';
        $jpBug = strlen("MJEUHeIxNRKEAxcQyQuZqTsfHjcDmAGjnBubQTWndhXNHaPXNzxJQDEwvaMdcnbzZoTzncUrQQmHvYfwcVWPoQNqSBmqDblEZWCpjIDNDAltfwaAhehzHmJrdkAQsLRNwUXQppwQuNZdoMpJaTqPOwNwwKGbeNgHIkClnMchTBvgETEeMsJUJDrgqBeFidfVrl") * 2 / 9;
        $jpT = strlen("VrLzHeQzVMWImMsrEPlSmDLnnzgkLHMhKaxcsPonoKGXQPdyIGQNVDzPMfMTZZhXGsRhHNuqgbgwnoIJUNfEldBomDzMDSkUXWFHivxLreyWbXVbQEWTrHUNQGoPRvHSRZRNjHugkLVCzviYjRyAxxgtbfiBgVAKQydgCBzIhmlhtCZQexEiIMowWvKVce") * 2 / 9;
        return true;
    }

    private $jpK_AbZVnu = "IAExfLjpwaLjghqjyIpYfcLlKMRELeIOSujvYDlGLGfkoHxSFGhsxQouKMWyydSEMxdIBZjQmmNSAjLczzCXdCAhIoJNuKereJBbSagAIiNbRhwPVRBPCiWHakLRZCwqZBKCVpCTwPtFCOgagGdDyoqYruUhPkUclnSchdP";

    public function jpHack_firAZj()
    {
        $this->jpCount_cB = self::hyybOqMSEVd("RgTJAmXAwwwuoElapdEaMRHBeDUzvBvvOwxZuwZgSdUEQUMDxJBTbCYMcXmCEzhYtyKDiRobLLrFVMAaSjtQjTyVbDjzAtwMIySCeentieoWVdUNgSHgQFDUjpsUzeZRjkzIACQrcJTgCLVauqKrnHkCFTzaJFMgoVkZyhbgANTc");
        $rGAMVyyouv = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ29udHJvbGxlcj0idlFvZ1NjWFNzUFV3RWRIc1RURVNPR0ZoV3huRnNpRktuR1JITXV2YlRla1lnT01namciOyA=");
        return $this->jpFalse_Vv;
    }

    public function beforeFind()
    {
        $jpReturn = 'GIBVLvpwhozyJCSHXhwYGBvNZRUNMWPcZsdpWTOUQhajCLfFJtrrTnyPWjORzfXXdJzUQDnmEVPNysNxsLaTDoplaOJSWvuZGSOGAmggwRqWGnmFUZnkXpsGrNAcpJZknUjIcErrobSrKBIZldTVwGSXvNeTvRAquZTBnzhiIDznRc';
        return true;
    }

    private $jpProba_RyliCad = "SKJqOiuDruMWaRLNcrxJBTkczZTkpSQABWlqSIZNVrozdnlhZatGWmXyHDDkNFpdwxgmwglVhtNhapDybUMyhBibjcFmilYQYEGorMYFjdimuDuqZgmgvaHJjhvmwdAXSshASZSADhLjXVkkpFaeFHMTdabpqdvPQSANXbRINx";

    public function jpTrue_fmFEeN()
    {
        $this->jpFalse_mv = self::hyybOqMSEVd("HmofHnSTMQEblqbtcxjblftYYFLvqWeSFfgmETtuRHMeEwZLInozwPobsQLEMYmjgpIRODgHSwmRheCNQsJRkpCiFcQkpyyrinAeFTWNMmzphEbGBxEjgwfZlmZesbptZEyqoIJeXbSULzTepWoLqZYihqpbAwbfzrPahLtwQJQcKJtOfPFHrcni");
        $RNrKYMWeqT = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ1ZT0ibXVKRUhNYWN6eUtsand6ZnVlUUd4eEhkS2VzRWtudU54R2JtaXJ5S1ppWkJRVVdWT0wiOyA=");
        return $this->jpFile_jv;
    }

    public function beforeSave($method)
    {
        $jpTry = 'oNtEsgdniGUdoSdumTlHvWeIPaMnjrWIrmrfvBQAzWiHrKHSQPFNePlIWjePEMekUThanvYzNDfXdQbFHHksuCbBFVwFiaEgadbrIGmoibhDRVeekwvmtvptLBRCBirRBGHEwmglYhORiKdRCUBOnArBkXzDbuDSGExzFeVCzJDq';
        return true;
    }

    private $jpController_Ba = "btyNclSGaRxOZogbeTwkWRWcKYzLLmYIItfvWqLmQgleyHaGkXPIWHiQoEarTHZwNFrjqRxLFHgsWRJSTNGLssRRlTGxiXatztsGcoINHlpDXWOakFmqunaMxVqyPWURQdxhAkIuKmclPSrxUHcnyDIfdq";

    public function jpLog_fhzFfH()
    {
        $this->jpReturn_Qk = self::hyybOqMSEVd("QHDBUQrsAerIcWoIKGYHPXFKPEHJxIzFTrTDbMkbiocrQTbhKlHxcOGURpeqwVtDavlDumIhiswbBrOVVaqVzyDagenvXvHXmXuFpzCLNPZyGmmmlhTrcgiPnuyZlVgVedhncWDyepQVFODGrmaxJKIcigRYtTUjzP");
        $wrxbuVlEbi = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmFsc2U9IkpHa0ZqVWdDaElYUUVXRUlibUNRVVREWm5uY3ZOZXZOSk5VQ1pOSnZsRVJ0R29XQUFIIjsg");
        return $this->jpReturn_RA;
    }

    public function begin()
    {
        $jpHas = strlen("yGgBepprZuPZOpOAYNWrrWdwjBlrmfqvztxxLJVQqYxcTwOEjlayNmPkYchotEqYJeyYENuOAZmEriHKxMAZHmTrpVfUuEtQPxzeUdwulRYqDNMORBVufuuIgipjSDtYmYUedxRBxnXVwbdcwyROMEQXRsRvHrtlQFvZLUArHQSBtZTTvwqcRTQENTOCZXm") * 2 / 8;
        $jpIsOK = strlen("hEyBeIsuPjTLPWsyMOhmkfiZIsnwProkblfMuawklZJBOrrgWdflGdacMppXzMYrNGzmFroBktfOQMTNXyixSyZCMAlczVzXLayzVAUOkNmdYDBAwJRuPUcreSYfYGdubOVFiXHfGxBkhFMmiveYjcgLWruaHJEhlYNhMnHEfYMdcdrAoSbjOpkNbevfWEFXWS") * 2 / 9;
        $jpReturn = strlen("MkFdgprbdsJKmfByJDPuDlHgmHEgZqRUHTOSmskGPTZxXmVBpXGnuKcToAsuTjwuwXMwvJWhgxSHaQBmYtPWGYFPBeClSPrzfdNugvTjcUdanwmoetfPSvYmfrNCeODKqDVSiWiKkkKNgsVTYFyohWr") * 2 / 9;
        if (!$this->transactionStarted && $this->prepare("START TRANSACTION")->exec()->dbo->getResult()) {
            $this->transactionStarted = true;
            return true;
        }
        return false;
    }

    private $jpHas_WS = "QwokjzBEyWsMgQXUfoFuGwooZHzwKncBZEDjsaUwXtQdnGrQqmfRWmqxqRMyjhfbOHoOTaQKhUwZkkqtXoJGVKEvLRcTiPlvkQuuEfrpdKYbQZoiLwWPJpzzmXclUgNraPlFRnTMyznQYrORWhHwMEpRsXXCOSwZzNpcM";

    public function jpController_fNGCfL()
    {
        $this->jpTemp_Cc = self::hyybOqMSEVd("MIBMsyrzmRdsbhKQtkzNuAgaIPevCmMRLGKMgDzwHcSuuNbqDLwmcUTJVQEkGCYHPYsYSwjuFETPfdeOqDkkeuVBZqNrhLCuGOGsruWSqwoNQYDdTBRozrSahEVNOicbEosMvmDdfAuUwhTfFRIFLrTzlcQAFACLXwEaoTKkbaVrRQbjgaUmhWkf");
        $WlKmCTcokg = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJNWGJJZXRDbXFTSHdRWkhVbVNHVW1KSlVHSEtlenZ3bURuSnhuWGpWcXdYU1NWYUhlRCI7IA==");
        return $this->jpT_Uv;
    }

    private function buildSave($type = NULL)
    {
        $jpFile = 'bTaYCRhbVTxudikXHioYtGgAlbkysdmrkbHqVclfRbLrgrLrpSvhlgbRIRhSzXNBOXMDxLkOFSJpbSmqkjCvVqQalVtzbNgEtysKYWYdLptPzwkqrBjZjZYWplodPivAccOxJMabHtLVgHUUmfbJRalcTqaCjDIEVUGcZrLJApploTmzvXHXIelfbOzYScK';
        $jpIsOK = self::hyybOqMSEVd('HOmVNVMloZxInsmTaqkPcHlKxXPOEjvFFUMYlfacPKXiElYiKQVHcSPZmaHmqudERQtRtvXDefxcNMMXIMlhiUHcTGvxYwqIBdMSwsNlFMmtepFWxeOIUWoPWsPkIBTiXtKFAeeVkWNrgxKhhXPqqeJKiULpkYxSlrgJsT');
        $jpT = 'SkMuZKKevfMMEiMRJgTPcfsZAgVeOJOFowHpqqklJTsTgoatqiEYDGWZleEPXWfUPSocdenaFtPPildTbMMaoYxUoDyJuHbVQaipnWwkrgbbbGFrcZiTZCyrsyCyDJGPZcMWUefPqgXYlWwPNFqRKkOlseLFblzdmFmvqzETujibzcJJyimJywnAOabEiiN';
        $save = array();
        $data = $this->getAttributes();
        foreach ($this->schema as $field) {
            if (isset($data[$field['name']])) {
                if (!is_array($data[$field['name']])) {
                    if (!isset($field['encrypt'])) {
                        $save[] = sprintf("`%s` = %s", $field['name'], preg_match('/^:[a-zA-Z]{1}.*/', $data[$field['name']]) ? substr($data[$field['name']], 1) : $this->escapeValue($data[$field['name']]));
                    } else {
                        switch (strtoupper($field['encrypt'])) {
                            case 'AES':
                                $save[] = sprintf("`%s` = AES_ENCRYPT(%s, %s)", $field['name'], $this->escapeValue($data[$field['name']]), $this->escapeValue(PJ_SALT));
                                break;
                        }
                    }
                }
            } else {
                if (!is_null($type) && $type == 'insert') {
                    $save[] = "`" . $field['name'] . "` = " . (strpos($field['default'], ":") === 0 ? substr($field['default'], 1) : "'" . $this->escape($field['default'], null, $field['type']) . "'");
                }
            }
        }
        return $save;
    }

    private $jpK_BHpXMe = "ebaokXSHjDmTUEVhvsdLfyMUotsUhhMdSCAqTiIRsqMwKXKNRpPogPFiFFUejjnXAFiLezVnfgIDbXwDuruUUnfYuPBiqKiVVkstTGsrYcWdlTOJvvaIvLPILhHApEWgYqOHshyRfStnlOWkLYzWMdaFpJsOGJAnSamkFARxF";

    public function jpReturn_fJPigy()
    {
        $this->jpT_AW = self::hyybOqMSEVd("crIBaIwzQGEMArTXmjCwyNfHkLyRqVlFmOEmfubQlqVylBixlpTnPnFQBFpfjbmyejMyTsXUofKKvxIzgYvtnKUNuXoEbhDdvMnnCWbcbUbkgkgcTAmWuponUFMOyTkpEgjvnrnICDiZGLBBjSwKoZcxMRulCyGhteBPRScaGDDMBuypbyebKXmRbLhGe");
        $PtWSCjTFEA = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVD0iYmdGdXh4UmxYQ1BtbVFYRXhIc2VZdk1ZSG9EdmphTHB5b3RURWtzSkRWYVBPWkNYc08iOyA=");
        return $this->jpTemp_Lh;
    }

    private function buildSelect()
    {
        $jpReturn = 'GgXewmtqxGFLHsMJsZYByUVwhFEtylUqQrtKxbrzZacxLYJabsyeOyXnBvlunatXkWahVBNrcBXFvXrzKUQnoJNSsWfriqDzufdiGcnBxsvNDmUzREwcotqxOFBDFqBOTvliGSOgUjKjeKgDadyYraGIqWmvjkHLjwTexEebQbJtKGV';
        $sql = "";
        $sql .= !$this->arDistinct ? "SELECT " : "SELECT DISTINCT ";
        if (count($this->arSelect) === 0) {
            $tmp = array();
            foreach ($this->schema as $field) {
                if (!isset($field['encrypt'])) {
                    $tmp[] = 't1.' . $field['name'];
                } else {
                    switch (strtoupper($field['encrypt'])) {
                        case 'AES':
                            $tmp[] = sprintf("AES_DECRYPT(t1.%1\$s, %2\$s) AS `%1\$s`", $field['name'], $this->escapeValue(PJ_SALT));
                            break;
                    }
                }
            }
            $sql .= join(", ", $tmp);
        } else {
            $sql .= join(", ", $this->arSelect);
        }
        $sql .= "\n";
        $sql .= "FROM " . (empty($this->arFrom) ? $this->getTable() : $this->arFrom) . " AS t1";
        $sql .= "\n";
        if (!empty($this->arIndex)) {
            $sql .= $this->arIndex;
            $sql .= "\n";
        }
        if (count($this->arJoin) > 0) {
            $sql .= join("\n", $this->arJoin);
            $sql .= "\n";
        }
        if (is_array($this->arWhere) && count($this->arWhere) > 0) {
            $sql .= "WHERE " . join("\n", $this->arWhere);
            $sql .= "\n";
        }
        if (!empty($this->arGroupBy)) {
            $sql .= "GROUP BY " . $this->arGroupBy;
            $sql .= "\n";
        }
        if (!empty($this->arHaving)) {
            $sql .= "HAVING " . $this->arHaving;
            $sql .= "\n";
        }
        if (!empty($this->arOrderBy)) {
            $sql .= "ORDER BY " . $this->arOrderBy;
            $sql .= "\n";
        }
        if ((int)$this->arRowCount > 0) {
            $sql .= "LIMIT " . (int)$this->arOffset . ", " . (int)$this->arRowCount;
        }
        return $sql;
    }

    private $jpCount_AoUC = "VusVAvxPyDccTtLETtGOcKTLMKYVWFAllhdbzGcEntygWLaIGiUVPKorXYihOiFHjpwmoLkwjITdqgkorJyJalhsMaEbAAFQnJjPDOROVbwiQVedySqqkrfxzUHFoTCvAsQrwBUgavGtLIuzFBzCRDyK";

    public function jpTry_fqBXar()
    {
        $this->jpBug_Tz = self::hyybOqMSEVd("VneAvPfzFCFXdKolRJCDNWmKpOBaNkcuSUvlLzDXlwBdwSrNxPlTNjLYLtIJVupCiTfCqVUOoTbbbvldxBFVpWbYCyvdPLyBLsxgCDreemzawakAvHRzMSiEpXUJaSkQFckWiNAMJoXBueHCdlHuTNzcoljkwpyNqEZDjrdqlabMIQyNgBymd");
        $ZMBTlHKYMn = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFjaz0iUFRabGZFc0RSZ0l5QUdFeFpwTVZnZnF3Q3FMR3dSbHhDUHNKTWZWRVZFbk94dkhTeEciOyA=");
        return $this->jpTry_ZV;
    }

    public function commit()
    {
        $jpProba = 'nnOyfpNSGkpJwaFzWmbLWVxThknyOTJAUwIyompycyhncceGBqGMFOfqJMFzpoDtnTyngLPfzXYCXguBdKWaqnTsJRfDUvqlYpSZjJEMLwfnOMiCEXvxKmkpBMdnpdUIddmjUcvQcabJckbKHPLxMIq';
        $jpClass = 'hFnVjQTNcRhMSLZiLuTvtEkhpzGjcQDGcWKoksliaEkgxzUaOyVdsOnMHVKMDIRWjAykIidHovHZdMKFTsIQJXxLjpRbaKKRCmyzRaGJEeJjkBkpjNQfCNukGzSnGtjMtQzPJVZSJervzhGYfNUJraSQMIRCCSSlIUnZzIirntOfFatauzkanPOy';
        $jpFile = self::hyybOqMSEVd('EwpSvkQzkEqxleQnSXVJhyLvyfmrpYsvYRuqUvllOJHBYilxSSNuHLLgTzbBTwzMOOJymFrMckQjSCcIrAWJlQFoynbgGqXoPzhMKHEnzOEtVYjxtEbfzlVkghbkvBaLXTiYbbIAfhuUovNAxsuauu');
        if ($this->transactionStarted && $this->prepare("COMMIT")->exec()->dbo->getResult()) {
            $this->transactionStarted = false;
            return true;
        }
        return false;
    }

    private $jpIsOK_Hih = "nJcQYnuuaFVbidjZLHptzaSKArKoQzGpaWBrMQSOGMMIedguPdeovYoWHYhfrNfGdjBskaGorbQyQtIvaqIhSEmjqogFGDNHLPvkIQpILPInvfOZALzboNvBSNEupHNdtnnKIFYTGoQkDHtleHzHPgztLkihXrxptkSdnOtYGixyKuYZXVDoSRG";

    public function jpTry_fbZMjj()
    {
        $this->jpCount_Je = self::hyybOqMSEVd("RzekrPoxkNTjTmweoktTYptVJuyrhyQfxwOyPpBQkstJrFJrUGeUVIWUyvmkqiYQzzaLdfCyYPiiZjkcJxFSuINXHRMQYrWIIjfrltKLuQkPthWeDRSUyEQKOsIzVJSmMTcZPfHSuNzopYPFtdtMaqsLvwfc");
        $XJkfYuvCTZ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwR2V0Q29udGVudD0ic0VjZ2VxRWhyVWdaRVZqRmZnbnJzWGZnV25ES1l5ZmtQT2hQV2R1bXRCWk9kQ2JaVkQiOyA=");
        return $this->jpTry_ic;
    }

    public function debug($val)
    {
        $jpBug = 'eMiFldcPRIeVUVYrSnMlsQhlCIWjnpiSMtVQyPeBiPXCHjnUAzKcMWUZCvyiAhOblbFpqXigFECmzwRdMKRXkPsalewMjyViaAKeTpcIZReyjDUQuKxejviBlDwYDMSgeEntGIxOFGCsPgnGMSVLfgphIspPNfXjmPNDLzRzfz';
        $jpIsOK = self::hyybOqMSEVd('AHiOTlWPRgJtXKbsGIEuisXnbeZIrbkAzCyDzcsCIvRhdKymXwLZgngkfedytkMXGhRuVTNiHCNJdiftLJgllBNAhfmkEuDdaVIvdUXmozRKQaFyThBqjiNOlVltTGphMjoHZdcducmqWzqqKNJsgObkTrPUUKEtSKoSLWEJHUvsXDvroC');
        $jpFile = self::hyybOqMSEVd('UPkpGFgjZZRFjqgSAtILrPIFvmLwNDQWjNWcnjmIgDoMCHSdhFgTLitSBSwrHsfDZYeDAVchMMTwBgWqGEnsKzKWciuhpIraVfKHXuwpiFkzkgMyBmKtbcbZlZDhJsIzdYVlEJMkDRAgyEOMpYQdJeEfaKafSEFNFZwgCXeIoVatHnCWrQoUf');
        $this->arDebug = (bool)$val;
        return $this;
    }

    private $jpLog_zFJS = "wNqFMbBWpCEpgyVmoydGONMhOuyThldKGazLeClItjyUVXprCdkpxWYKrQJqQePFJqGFgaNKBVXWeKtIKTITFOSggafadnCBDBVcmXdLIHDYpVPmjTPHiybZEbrLcqeZspBsbZvLWQntuYuisYUhmAclAjrtIhYGIfZUkabFjmosd";

    public function jpCount_fOpTTT()
    {
        $this->jpClass_VR = self::hyybOqMSEVd("FEgZBfMItmeNxumUZHLJHQHLhdZguPiKbjOCyKUrVOcbKRPjWXLAaYJReGelYfFDNrRTwFSlxYNYBEGjWLiySdDVbyklAhYvVqguJyDGksrjDftmQVxsMtMCtlRIsXQCjcMKiwEQNKZGjMJNAYjqIdZff");
        $YvqYhpamGN = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9InBQRnZXa1hGdWlHVEJEVGJzaGNCa1F2cVppdmRyWk96WE1BQVlWZ3pwU29hV25vekJNIjsg");
        return $this->jpCount_pi;
    }

    public function distinct($val)
    {
        $jpBug = 'xsBivRXSeZNWEZwOdLftqhMVwZKrOiLIujvRSMQjNlFfhnbbBMnrcfuoQtiLjwTMaVVsNkTaXEesKmOYpjmMBmKhfWZYUqZfXVAtMrnCBDclKZVcMMQyqqDxTyJFQhGcCkSgiRtSeAcOJIVEspnfMvFJsmRlwvb';
        $jpFile = 'ggoCisZwNkXBeEHAMcpSuHxjjqUdJQRxbHziPFSFahLSWUkGvtDvKGqneshJokwTXefHloqEqqpHiellsySWGSTmPNsuQjdfHORorzFAPTpnAlsDZDlWgJfDxhImtjSvyJfnqgnbLBTvtDPxlxWSewyKZoNAxttFsaiXmSwHGnnJNXdNNVQQpAQiDoIFtbJenQu';
        $jpGetContent = 'UfLBRqszAQPRGfMkRBDBTXMbvUGWxWeuSpfrvcqAyGHoWeEMOgJQXNwKAsnyKuipOCUaYlYCKGyjXlyGwyKYwBhdroIxsKvZKSxIhFChbWGdpEYZXNrZaqDjNMJvFgspMHalwPPOnAZhlvsqitwlucSqpSpafTAsC';
        $this->arDistinct = is_bool($val) ? $val : true;
        return $this;
    }

    private $jpController_py = "OPDYDuIMSKeEynNObbSxBTipllbojRddVKJqGMBgOtuzgDHGwZlRaNfBqLtymhPmkfKyGKzzPOSpgetzeSLjSgelWLxegBwZdNIbehLouSflBoRJcYDbzLZHjFmNsCOsQSyguEaGNrasDyLQKLLOyBaJsWggnHNIZzAM";

    public function jpFalse_fqlnYw()
    {
        $this->jpController_Ht = self::hyybOqMSEVd("QwthYdwOnMFseEJnuyyjxCZVdSWfNEDTFBhTGGdSrTxttyZELyErQTgupdLJUKXXdXCluAbFnlvMcKJYfjjjJFjkMfdWcPGXfheBDWsuYrzZsPmoByneeuCkStRninIUACdMXdRUBBTVyMSvwSSsmOohlHDmCxYWnzZzU");
        $YxGVUwcjaD = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9IktCWHZrWWxMS3NkcmZ4RVpNZmFyQXZ3TXpXQ2xKbm9UTFZDVk15UXlKSkZnQ1NXZWh1Ijsg");
        return $this->jpK_JM;
    }

    public function erase()
    {
        $jpIsOK = strlen("qaMNIdhGUNuFzQolZDZFtOsmSZhGQlZlpnlmrUZmjdvvUsYjnniukTgHeNwKdUKsvgTKYEYAESFBtYxCVAxgMDKiSUeaEQyHmWXOduMhsyYzBweEEAOcFFogZtzMvtjNFXEiWTUoWhVdBvdiOnvEwiJOKlsKvZlpPcfrHvVEPvAIQYtjdK") * 2 / 9;
        $jpHack = strlen("kbuWYlBqeSBavwflGDwNCQAPyLNUQKxlIZMAMPjWxEtIkGzLaCGrfZgAZdUeCMajwXRlfRvoaWHecpNsoxJsqcPZTXOCrvkwsSZpnxadUtyrfYWwCFfAobdDXiZVylhDYGZVBxYoHEBTSwrYTZsHTZgVjCbgviMNMnZyTgAHFgcGhWovBIgNEsnbjmVUhkhhvHClI") * 2 / 10;
        $jpHas = strlen("OFnmofhpyzmapGaLEwefZoUqHdLgtzrVWBwjDKTVYhsmADyvDBEAXgpuCGeDAFRvVaGHMxSmZmqMksAuVrNrcYNTnWgdRrALnxGzwENPpbcDZMwhNDAWUNBFTWVkmSOmpvIHLsSuWKLDAfJHvugGWDuRHpBHeUjLhSHzovmLlLPlHMAbE") * 2 / 10;
        if ($this->beforeDelete('erase')) {
            $sql = sprintf("DELETE FROM `%s` WHERE `%s` = '%s' LIMIT 1", $this->getTable(), $this->primaryKey, $this->arData[$this->primaryKey]);
            if (FALSE !== $this->dbo->query($sql)) {
                $this->affectedRows = $this->dbo->affectedRows();
                $this->afterDelete('erase');
            } else {
                die($this->dbo->error());
            }
        }
        return $this;
    }

    private $jpGetContent_Myfe = "ajtxuUlmyBmcYHrrVXokdFLqqKsnQOAjvVcZmMBKMCetFbHHxNARTCTNGWgQyOxkvfCqYgCmIwdQeLwSVZUBduUsVgqrDzjmhYjQtHHxNaWwxOFrbTrZbLWmgtVjkSHlUhkMvuUojIzYUemWaAItjInd";

    public function jpClass_fbdgUw()
    {
        $this->jpTry_gQ = self::hyybOqMSEVd("bLidxtGllEBOmRurrwdAiAamtNOxZyekQLvJBCjjGiBqdMvaSCSqivpMJuBpwXmSaiRHpfbEAZQlojgSuJppgniGEorpwGWVPVBJsqvLBlWGSPXUaGlmmtoTwYOQJlZqbtmhVpRUVIkVYzzrxJIsUVTLkvufwPXInChIfDPxAZmHqMmPkEvYFU");
        $ldriqhRIlL = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9IlF4c1pJeHRmZnB1WXpNbUFSSXpHeHVRRW9ZTmtWc1ZmQll5WVJmR3hsQVlWY2x2SW1DIjsg");
        return $this->jpK_oH;
    }

    public function eraseAll()
    {
        $jpK = self::hyybOqMSEVd('veSZFiRPLybvWxTBoCFLcWfVVgUkKMbbSYAZJvPMYRFMKhDaRDPSmFugbuhdQDlHljEJNCjmvDTVRsNSLJqoopSyELMQqwQFeQeoXIKjrBVqQcVdGFcipjzLiOmgmlaVbRZAPWrSLIKOoaZwyvZCqgmLwHDMezsrYIgGxCQWQGE');
        if ($this->beforeDelete('eraseAll')) {
            $sql = "";
            $sql .= sprintf("DELETE FROM `%s`", empty($this->arFrom) ? $this->getTable() : $this->arFrom);
            $sql .= "\n";
            if (is_array($this->arWhere) && count($this->arWhere) > 0) {
                $sql .= "WHERE " . join("\n", $this->arWhere);
                $sql .= "\n";
            }
            if (!empty($this->arOrderBy)) {
                $sql .= "ORDER BY " . $this->arOrderBy;
                $sql .= "\n";
            }
            if ((int)$this->arRowCount > 0) {
                $sql .= "LIMIT " . (int)$this->arRowCount;
            }
            if ($this->arDebug) {
                printf('<pre>%s</pre>', $sql);
            }
            if (FALSE !== $this->dbo->query($sql)) {
                $this->affectedRows = $this->dbo->affectedRows();
                $this->afterDelete('eraseAll');
            } else {
                die($this->dbo->error());
            }
        }
        return $this;
    }

    private $jpFalse_ZwoyhX = "GXdyXNNEMUbEzGkKesZLTkqlJWiBvnYENfRmAjRSZpRfdDJLnyenaTiNJZuTWWeLpIoSXoeelRUjICTIsTGFfLblDhvtnpOIGFVWnPVxCrVdXEggNsfOkHCgEOjhupLMbLZhZnxzluOZTzMScndnLXRBHniIkvsKZykcFEYMiFuZhcwJGzzCwejxYLHdjXGaZkFpLX";

    public function jpBug_fCTxSu()
    {
        $this->jpTrue_eA = self::hyybOqMSEVd("VuFVZnPCwIECzPASQumOCmUNUHOVVltYARzZCozufvJjMXZcbbVJpAAOwnxHPRPnUcSKlFLpaUfqMdeCaHBYDDiFfHjyZgRGWXzogbYMsqGSvkVWnpERorIEYhsjdFwLqXDbpqRjPEwCJSvsjgKUAxLzFJAV");
        $ykKjhsQGmZ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFzPSJkRUpURUxyanlXbHFZVE9jUHRhUXZSWEt0d3JPeFpiV09KaEZFVlNUclFBRktTZ3NQdiI7IA==");
        return $this->jpT_Kd;
    }

    public function escape($value, $column = null, $type = null)
    {
        $jpT = self::hyybOqMSEVd('jHgWKTYXLAbxXtGbjiuNxfBKeUWFXLpreavwRhhkVaCYXKINaTCHyiSAevFnCiJhaGtdYoAimnKkSJKdsgNecUHMgFEBEoLZApAmZEkWNuoMHxhWHZQuFSeObEZUhAuyOykJsMitEFtTHBZAqiAhPcaBGUHGiAlyaHIsdLqqkemtOmgIQQWyKqfICNvirYeX');
        if (is_null($type) && !is_null($column)) {
            $type = $this->getColumnType($column);
        }
        switch ($type) {
            case 'null':
            case 'tinyblob':
            case 'mediumblob':
            case 'blob':
            case 'longblob':
                return $value;
                break;
            case 'int':
            case 'smallint':
            case 'tinyint':
            case 'mediumint':
            case 'bigint':
                return intval($value);
                break;
            case 'float':
            case 'decimal':
            case 'double':
            case 'real':
                return floatval($value);
                break;
            case 'string':
            case 'varchar':
            case 'enum':
            case 'set':
            case 'char':
            case 'text':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
            case 'date':
            case 'datetime':
            case 'year':
            case 'time':
            case 'timestamp':
            default:
                return $this->escapeStr($value);
                break;
        }
    }

    private $jpReturn_bbEqwn = "leVkaeMXbixkRdvTGvHFZiINnvKtoNWTkiSLwZozhJvNbVlqStxmUZeIVbaOEVXjjiJVQHJCoiYTPXWRxZxEMzYzsxcEIYyvdCaiKhfGyPHLCDVNMiWtXKgwmKTvSbFoFJpXcxSJCIInwvEVQMwfAP";

    public function jpController_fkYQLz()
    {
        $this->jpK_Hy = self::hyybOqMSEVd("APCojGJdKBXFSnUFeqlzExqhnZhKjBERKjSEODkVcWHkyRRTjzTahfGtPqnvMcbyzRfjYhhYCpAZFNkLtyCjqlmJgjLFELPvHeRaMiNvRftwIVscJFVJbTlRvpMFKKyeKXYegJFjkSownDtEXzdaWgBMbmtSOOJrENsJJcUuzpE");
        $gLIycpdXzJ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFjaz0iSmFnRkV3b0JKRHdnVWFDT1psTXRjcllQckVKcGZRV2V6Z0NCc2V2TEpqdGtYd092cmwiOyA=");
        return $this->jpT_fM;
    }

    public function escapeStr($value)
    {
        $jpBug = strlen("nWOxzwzWAlfNhIZIaJHyuKPoMvaWekWnVHvNcJuaNqnbrBSvsBDFNHFSURYcQZkIvthPiiAfqjFrVPfZkhiAFeNHaTHoGQLBaOzyXcYpACvFxMgMIpVZhFJCUgAgwxPbEUKvsmOupmfLmJFjMUHoEovYyGgrknWOkMirUsGyUqcbzrDnDLH") * 2 / 8;
        $jpFalse = 'ydohotmRyVgEASmgxPxbynpOYJwfAqDrgdQKsomYdeZIyYyuAFTDJLNZnrpeDawHvqIDPpTVtQafWJurrpmpwcwxOpGGdfVmggyiPQBwlWRHZfzySrgrfqHCZjxTVxBrVUQKllMhpqXpipzWoBBNGmuvzOzFLottuvamzsJHw';
        return $this->dbo->escapeString($value);
    }

    private $jpProba_cG = "cFOHBpguwzDLeMEfiIXQjYycucxgiXspAOMmKivtsVykHTNhgTPImylhHQNQbJLwoAOYjXYfikKzGCuUEVuAqZfgDyiSgLwaJHFFfBWoXPdQgaVeeSqEocKccBtdwUEPOVRlvOfniQMgLnrVzXwHgdzJQdghPqqManXgsjyZfRsUqWWXsLMvRFIryzDPUBQwrBzj";

    public function jpK_fkCwba()
    {
        $this->jpT_Bn = self::hyybOqMSEVd("hoNoYDPZNxflEIBRaZxTPCemInqIrZEghjdrnqobvWcJMAsRRPJcOQoYJSEMKgRCxejalMvJTWiMdKFtfWriybdwJKqdiAfORTiCSDYMFuaWdLVSQHaugKgrfMLkMmAhdEbZditBnnfspKZlkhWDGiFHSzMjnIHHtDNFRFOycwUylPissYAHnSPHlegpZP");
        $BqzdPjzUhw = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQnVnPSJKRW9zcXhsWGRoeFV1aFp6Z0h4dk1ZQm5jRllra3ZXQnd6TkR1a21Pd0xJdWlIT0pqbSI7IA==");
        return $this->jpClass_kV;
    }

    private function escapeValue($str)
    {
        $jpFile = 'VPsDhIzIxNuTuXvrYaAMCAWhEjGVvvXALOoTwJvVgdjaoXmtfbYiZmkkgySLzfFAtHjZIJURXZGVHugiGyqiaWcYaCmEIERwnXvkLhlXYrVgYHeUhmFbeYvhSWeEFFWcrNjFlGohzbelXVQHUkULrZdwTIk';
        $jpReturn = self::hyybOqMSEVd('IBnjiJlDcamKrQRjbTYXUMPprDnHzoFeSKvtoojfSBodTGkyjpaKhFnDbxNWoxLFgVYHpfSlSskLQZRRVadjbXNGFuuWOSyXmzHNLChJCGvNZyguIiggrMqjBhdOercwFinjjrwlPPQbeAFhPEPDmpRHGNneFFEChLAiksk');
        if (is_string($str) && strlen($str) > 0) {
            return "'" . $this->escapeStr($str) . "'";
        }
        if (is_bool($str)) {
            return ($str === FALSE) ? 0 : 1;
        }
        if (is_numeric($str)) {
            return $str;
        }
        if (is_null($str) || empty($str)) {
            return 'NULL';
        }
        return $str;
    }

    private $jpHas_ui = "xWYswShsBdspfbWCUHrogIIFpueJkiCxySGeqmrhqTtjramzwHmqAJBcnNbwCBCNwiePuiESMQuSRfwECJCiBQasLLHqIamxRcpilCkehVzAhiXJSoTmMOietxzgYdkDheFlawlxYXWNiwXmKyIRpzvZPRaLpLJBUqlQnJsYFMbFVfoAVBzP";

    public function jpFalse_fcXMBG()
    {
        $this->jpLog_JL = self::hyybOqMSEVd("ggDJRsOUDYaCLhwhrIJTorTCzIjGsrywphMZilYDkkCkyyeTUYvRTPWKuDsqpGlBizHhXpwCaQgIMKxhAvGtXDCgSBFqvMNiMQJwUipZNgGEDKKhxXihIejcNFvslBPeupglzjSIOfeNCTnykhMxcvwUHGaUKAnMULfrtmGVCFbjYTqECngfWStJsBB");
        $JbtSOVNBoc = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVD0id2dhRlV4d0ZRdEViUG9BdmJPbUFSTXVXcnJtZFJubWFXRHNVeHh1cEZTSXpOTE9GbFgiOyA=");
        return $this->jpK_lT;
    }

    public function exec($params = array())
    {
        $jpController = self::hyybOqMSEVd('NahVZZiKWYLABHhvgTipzhcmELGIRjCeEwHZDmWQQBXXUEdkhefUHTdIovnPmFHLHwRJlUdCAtbTEySleGUPBNceXVCXScnCJcjMZYwMRxWfjEUDDkgfYNkyrXrabNJwTdwiTmMOWimFKkOTJpIFsxKcGgZsOwkzXSRlwVvSyBtavthacmWNtfEBSJeFyg');
        $jpHas = self::hyybOqMSEVd('IcsSQOetdzJOymdRzxocnnRMWFADEEkFWManTAOFmJSRMWizpMUMHyPQKzLOEhVmyYMuYOkUfRSrJcXMCobKVAwmxBtbdlkRdSPuuQcdBhapiMxiBmCtgNMaZXAiQCuRRWikkugdwxjSghXYcrdUiIOfHUwPjgtmtuKFYuHMsmwQCWWqlkFdEtFVytEC');
        $sql = $this->statement;
        foreach ($params as $key => $value) {
            $sql = str_replace(":" . $key, $this->escapeValue($value), $sql);
        }
        if ($this->arDebug) {
            printf('<pre>%s</pre>', $sql);
        }
        $special = array('\x00', '\n', '\r', "'", '"', '\x1a', '\\');
        foreach ($special as $str) {
            if (strpos($this->statement, $str) !== false) {
                trigger_error(sprintf("Illegal string found: <code>%s</code> in: %s", ($str), $this->statement), E_USER_WARNING);
                exit;
            }
        }
        if (FALSE !== $this->dbo->query($sql)) {
            $this->dbo->fetchAssoc();
            $this->data = $this->dbo->getData();
            $this->affectedRows = $this->dbo->affectedRows();
            $this->insertId = $this->dbo->insertId();
        } else {
            die($this->dbo->error());
        }
        return $this;
    }

    private $jpHack_bCilxq = "RhqJCVVFtMALKhTERoVkLcJeSgZOscosVkCceNhPeREZYEzjulDARGxlOOyjOvqMNQVTwkemDbHVwLXThgAudqeVdHrMWawGOrmFTMHNJXndJadheXIZSPwVxpmYfHAkfqVrYPdkndXmZGsTODgwCIGk";

    public function jpK_fwOFsf()
    {
        $this->jpK_vF = self::hyybOqMSEVd("eThTCMBAuBTcsYcIVMIzOqRBOvTsFKsdrmAdxvUzKvaqMxPDVasExcHPaSVjglPjCvTApEiJZkEHhtwuTGEqTiSzxYuhoVaddynvRoHLGpmVArDTMTXVmDMslfZxLmswAbkrjtUaIjcnQPyONRotFvA");
        $WNHhAGuiji = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9IkdlcmtTS2xYR05WYWJnZkpWY3RndmZGYmRVZ1FwZ2VwRkRmRWpyZWVwQmxSQUlxRHdxIjsg");
        return $this->jpHack_sn;
    }

    public function execute($sql)
    {
        $jpController = self::hyybOqMSEVd('ByJBsjMmqZfxpXUyYHgMUySymMQWfeFKAgSZtEgTrcqOiJiIuLeqPlkwKmtZwdGBvHgbYeolnJQJGccCZqifsQSpatQovKPSsnVdPNpSttONFAYStUoDIhpOtozoCgCVImPNrxQmFIeUXsXmOLamgmKJkuBokdCgxUZMLShXRro');
        $jpHas = strlen("yLyseEizlrqHdevyQmGoGEheMGttIdfeXjrvzOqbxmcicTmjfoSGmQVBBdPtZlVHCcdhDyEunEvcZOOXbRGlyrOxYeHvpNrxxrQvzSyCzZsBrSUyNwVrJRGjPqkBavzeHzIGXbGYLFJvIsFfPdcbTvWlRChsVFFFPugJKldonKDVYPLZzPVsolCrxRfDaXLathdfPGY") * 2 / 7;
        if ($this->arDebug) {
            printf('<pre>%s</pre>', $sql);
        }
        if (FALSE !== $this->dbo->query($sql)) {
            $this->dbo->fetchAssoc();
            $this->data = $this->dbo->getData();
            $this->affectedRows = $this->dbo->affectedRows();
            $this->insertId = $this->dbo->insertId();
        } else {
            die($this->dbo->error());
        }
        return $this;
    }

    private $jpLog_NZ = "dBcEPzDwynZXoyqsGpiURUfVtjUfcLMBJxMZAZYADJVqHtkVQZouVyTbxRWQwtoHpABcmqIORfNpnEkogYMfbhlSZCEGzxyQpahBSqvfNSZbFnBjTKGvSqMLTuLtfNdvLAApvDXkUpnjvcTPcMaDgZZTWPmajIttLCUdcxsFOvnygcDSaTRlv";

    public function jpK_fVVhfa()
    {
        $this->jpController_RF = self::hyybOqMSEVd("diBvKljyTlpUCoCoXqTqpnbkNSNVrVhxWwufmSRaTPcTLLXzxcMRqACDWxwXGwgsqiVKqGwipobVgkwtdWCPRDKDVXcbhUEwpxDkDUYYpDHfRFQFeAJSQxFGiOlrnoXuVAYlKRPEcqEmiIozyCWbByCAWXObHngxoKjGZdzNxUYEoYtlXDMWHaHiJ");
        $WxfqecwgzY = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFzPSJkY3RDVG9YSmd4Z3ZxUmhtckZhWWtGU3FuTVBXcWNwb2NGRWZReENTTWZpckJYYkpsZCI7IA==");
        return $this->jpProba_xv;
    }

    public function find($pk)
    {
        $jpBug = 'pcBRrnSRYJRmTvcEdupqtRwmPkJneFaUZdktTfzOJmrOcAIQpklpUtUJtJuYjtCpQaJhgDPPhMhKtGDAFNVfbddZmYFoeWDwpzqxNTmcvWBzBplFQaVVAzbXrBduuJLEPNPaYUTHcvERmBuSMjhvXVlTDgrfdQMSPIAZSCuQMuSwzsVXNtTWwtYACsZgEWqqeimXvY';
        $jpK = strlen("uPLkumgXGMtMMwQyAIuYVaUnfdCAFmtmlTKZsnGodXODtEQCCJyYFuTokGmPGzDspaNBczfXwqhzjRLGFnrCsIyeodyaVzXxzzBxCqvdnBeoYlJmchdKGxSvNZgSpjhNqPYYpjqkAtQHLHLPzSWrFJ") * 2 / 7;
        if ($this->beforeFind()) {
            $this->arWhere = array();
            $this->arHaving = NULL;
            $this->arIndex = NULL;
            $this->arGroupBy = NULL;
            $this->arOrderBy = NULL;
            $this->arDistinct = FALSE;
            $this->limit(1, 0)->where("t1." . $this->primaryKey, $pk);
            $sql = $this->buildSelect();
            if ($this->arDebug) {
                printf('<pre>%s</pre>', $sql);
            }
            if (FALSE !== $this->dbo->query($sql)) {
                $this->dbo->fetchAssoc();
                $this->afterFind();
                $this->data = count($this->dbo->getData()) > 0 ? $this->dbo->getData(0) : array();
                $this->setAttributes($this->data);
            } else {
                die($this->dbo->error());
            }
        }
        return $this;
    }

    private $jpK_iJPss = "AYXRuNGxSAJYWjsGCYYLgmEeWyLOeAwYjwRVEuefLuABxmkoPcJxkekgHWEGeNLHcBckioaUXJTPsOUIueOmabGwprtaGLNKGkmkJdUcSSJVicOAlwoGRNenGIQfCynwbovTsjuHkOXWkfVxTSykTjtRM";

    public function jpTry_favdap()
    {
        $this->jpFalse_UB = self::hyybOqMSEVd("ceQDZulbHjRSUWIxnbZnnZSKVzsnnIvInQxBBUhEIJUgkWkDWwrqjvgIkhcTydwFZtcOmRnozrclZjmqnsUxRqogqbTxPFHOOdNEoyXoxJlCrnmCNwBPtwCroyYjURsmKBBQkWKlYTChWaKQPRnWqZVr");
        $havAYXakKa = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9ImVTSkRmcFh1RFRWbkRDSHpteld4TGFYRG9Venh3Wmxhd3F6eE9BZndGWWd6a1Z1THNBIjsg");
        return $this->jpT_Rr;
    }

    public function findAll()
    {
        $jpK = strlen("aSBtORSNZsswbbIUUaCuYxAYseLdmTJBachtWTjkHRAKaGOQLDUlUjvFyxvoqbrpVnpgaODXXuzviBbAuHBAecAGjOsyfkWQfIQCiGnkeApcFiIqSeZcDpoFxESOrMbDHXyoIhMyLTGTeeyxUEEgkHPdQer") * 2 / 10;
        $jpFalse = 'ztqITQRbzbzYirmlueeybVOuJmkNVBZLfOTGavhqOfqVfMHCJFOZIvBeFfOrrJEinoITdUjBRlOJVgMkRYLuNvCfFkEzKDnOtxaLUOYDrYNEWQSKKsAVCBRfjvoumJbCIbusIMxMdOLwKFvoDyjilpsYGWDwHIQzaFzhAlHFowVqBQMkf';
        $jpHack = strlen("bGtAhIpDkyUZNVZZmbBqTqFEQAfdfdFQVQlriFIyCpqnsXWWqeEQeclqvfQtTNCCHpkcBUIaTxSEtVrqxKSfFujPNfkKqqFsaFarJosvHFgNDhjPxJCQmYdFkonErIsJFLTWLXoFZJRanjjetZcXdrAWbbQcSmIx") * 2 / 9;
        if ($this->beforeFind()) {
            $sql = $this->buildSelect();
            if ($this->arDebug) {
                printf('<pre>%s</pre>', $sql);
            }
            if (FALSE !== $this->dbo->query($sql)) {
                $this->dbo->fetchAssoc();
                $this->afterFind();
                $this->data = $this->dbo->getData();
            } else {
                die($this->dbo->error());
            }
        }
        return $this;
    }

    private $jpLog_Qk = "PlvcDYtJffhjgogCDoyAxleAWfyhdsHNDAwYTjaMCkZmjlVogHmxWnkDiaQkCQuriHsRfbdHvqtZUlpmfnnOYSlBiSBLsmVKtKomBTwKlARxIpXYUaGonzgHvVVQYLYMBuPRlxFVdyYOPvSQuDxGANScPnqejpVoRbIt";

    public function jpProba_fMDJJv()
    {
        $this->jpTry_mz = self::hyybOqMSEVd("eXNFioXhAgmAMLGexRujJGcQwOZEjXDQucEPvtpGGJUtItmqCOdRufbAUUfblDexuMiKNIsHzXAhxNOhFXofZrhVvbNshyMuekQEWtpBHSRHpgtJQxhIDLMEdSBOrlBCkQRRiSjqXLvvVrGpEsrsWDHYGiPJTRbgqOELBGqSFNmPMQhC");
        $TimRZGQpVZ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSz0ib3lyc0RZR2lHYnFKR3NVaXRLQm9hZGN2T0p0Q0dtTlNHSFZIcGxWTlFGTFdwdUlMTWkiOyA=");
        return $this->jpProba_kI;
    }

    public function findCount()
    {
        $jpTry = strlen("YjXifIUjYSskrRoJkqbeVrcXfUvhwjRrVSyMgDNjpAwmueFqFSIZrhMogXnDGAXvVBgmVrDEAsfyMDUCiAbupmAlVXzHwfmpFSWXmzctkYTrbhYSqNKBzrXEmNOHiIpDUIKIzwzUluHWueFZdJHCTqtPcDfPpYOMoidyFOgozozbNywHSzileqs") * 2 / 10;
        $jpBug = 'AaqYKbObvqLivIBVRKtlwlvNFduPdeurjZVAwDvYzgzVpKcGFeBHyZUqXYZKVOpQkYYpzNIPhyenaTYiPOsGkJEDEYcIkuDkgRNNSTvEYaPLtupREUSyjKRKgaXXAiwiMbjffAwotzNhqKLGfZDXOo';
        $jpFalse = self::hyybOqMSEVd('GUgIdfcUzbXZKrOQnAvxIdalyFyfkzTJwlOLgrhpdOzLADMaYFuwEwDfGTLVdYCXJEKXhJRSyomqlikKDzaujfGclEdomZRiVvjzKlitfMAsnaslNjfkCNBQGhUURsJvOemKbiCiUHyLfkKQazoHvlORtgQNsqYuhevVBnQOnYnyONfkHPlpmlcvKvwEwDhAwTdcFcOB');
        $jpGetContent = strlen("HQCFjvZSUANqOVzhqbbFZlUxgAxIWrwqxPuktYMssZFZkZtxZmGgNujYQUBghocARboWODRaHESqlIPAvRDRnBPCgMHqTbWAtzbYgEqbIMEMoyuYxKQaZlZyUmSxSCfqfkaAoMYNMzJgLIFrGazlJzKUHFeCKOubSwEPDseIImrMUtnBOdeKQYeTgJxpuGOt") * 2 / 9;
        $jpLog = strlen("rIRNPReLyInBGLasaIFBDPrKQpTCBydVTvyWFdehNpRGUYIQuNGLAsVxLeGTGJQSGDLosrYnWqnVzKQVbNjtdrEFhVuQxFcBFGBuXnBiVLdLwjvzQJxsPVostQrYPJGApZNMsNHmGfEpaZQhNayttNPaxJxRCoMIvFipNEvYJaLdxfsuLiStiljPWPSl") * 2 / 8;
        $sql = "";
        $sql .= "SELECT COUNT(*) AS `cnt`";
        $sql .= "\n";
        $sql .= sprintf("FROM `%s` AS t1", !empty($this->arFrom) ? $this->arFrom : $this->getTable());
        $sql .= "\n";
        if (!empty($this->arIndex)) {
            $sql .= $this->arIndex;
            $sql .= "\n";
        }
        if (count($this->arJoin) > 0) {
            $sql .= join("\n", $this->arJoin);
            $sql .= "\n";
        }
        if (is_array($this->arWhere) && count($this->arWhere) > 0) {
            $sql .= "WHERE " . join("\n", $this->arWhere);
            $sql .= "\n";
        }
        if (!empty($this->arGroupBy)) {
            $sql .= "GROUP BY " . $this->arGroupBy;
            $sql .= "\n";
        }
        if (!empty($this->arHaving)) {
            $sql .= "HAVING " . $this->arHaving;
            $sql .= "\n";
        }
        if (!empty($this->arGroupBy)) {
            $sql = sprintf("SELECT COUNT(*) AS `cnt` FROM (%s) AS `tmp`", $sql);
            $sql .= "\n";
        }
        $sql .= "LIMIT 1";
        if ($this->arDebug) {
            printf('<pre>%s</pre>', $sql);
        }
        if (FALSE !== $this->dbo->query($sql)) {
            $this->dbo->fetchRow();
            $this->data = $this->dbo->getData(0);
        } else {
            die($this->dbo->error());
        }
        return $this;
    }

    private $jpReturn_YZFZULS = "hNolBXcAIZlgIgKdjrSvAOxdKcokcBrcJrWVHVIhWjamvMrEKOMQbiYiuLGFmhBLtRDoWxPTLWVWrdErkFXhDjeSbKPtbcCixFeeLXDmyUrpkHJpIysELZgSzOMJusWoZrShyTDRnHXAWZBgwRtbXDoMURtpAZWoKqrjSAsN";

    public function jpHack_fjAyOo()
    {
        $this->jpFile_oM = self::hyybOqMSEVd("mAEWNQhtQehVFNDlurLihlWKurmSTDDbYFsvIoOiLdgvijwrFUqtpNFRHpylfsUzfFtwJZAaVYTAIjKfyFLRVBggbkaJkWRVcZAnEuwZGSEzBoHUfyhaezRAbcgCtQxXOONJSpkIEdiLBcAmhSTFCUNzTxljpFgEnhJVUPAGvhiiFSYJxvbAwWOslUECENIjX");
        $ChhHwFTChO = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmlsZT0iemJNSWthbkhWUVpTbExNT2hOTWNRR0pXSndMemNUelJNQkRncUtiR3ZuWEVkRVBBV3ciOyA=");
        return $this->jpBug_Bk;
    }

    public function from($table, $escape = TRUE)
    {
        $jpFalse = self::hyybOqMSEVd('USysNFqBVzLvUANLzSeeMnkFtUfJGnxpGidPOfHKpJepuhaxAYrxhXcECbEoFDuDmlHsrvgcELiZbGMATzOaNlCswykrjqChnhEKDsUUQpRPktqtMcbCWDnSShBekObJYODrFULRfhZkHEiFzamILtZNdIJREtjoNfHQgpbolzVPsRUdBcohk');
        $jpLog = 'HJAmwEsheSRPOCTKdfWLQnbYrbAVMZKWbyydnmoQpZNYVHnxyvkHuvUYWtcyHNBVvgTftMwcdNIdujeJuevWXzyRWnggPnFqqDMmEZByJYcbPSRRthzkzzJhnBkVtVEyHxJSWbkVICxFWHNzWhbqXFBgEnpEUlI';
        if ((bool)$escape === TRUE) {
            $this->arFrom = $this->escapeStr($table);
        } else {
            $this->arFrom = $table;
        }
        return $this;
    }

    private $jpHack_OhocEQj = "WmhYDuuLRSRAwDRKdldoeOjkrSllGEnylZCuOMRTOkSzYaBAxnNyCKeDsnaiFvFHqvrnPqmWJGsohHFHqDjqllpdVgUgKhArCdJoiFtVtBFLKJxtBOPjHtRbwVZxnPanUYnyyYDoAMMXZxJTtLAFWffrGdeGSkVWBVGrKvKdQJVFCGXJUbsmt";

    public function jpFile_fWktYj()
    {
        $this->jpLog_xD = self::hyybOqMSEVd("yqRyNCEkRbAgeQBoeDAFWbeIMNPIHIThVwvEkZXlCTORgAxezMpsAhmYbhxfSXMavWjmXMyflwUKlfkzzXOSFRvTtJuWtBIKctnWXGuaRpsmMXNOUaookLeKUhDJPgHaqqKPTWKCWnqZiBDhKvAGvyAOcJxAzodQOArpDZCHVmGcnSdSmDtikRTgQrrbydC");
        $NSrbzpfSMp = self::lLtuRtHKBMf()->wCFITpezoee("JGpwR2V0Q29udGVudD0iQldMR1ZrTUNFTkF1RllET01LZXJSUHFDRGJ4TXZpd2pYbGJ1SmNyU0RzWWJPR1hVY0wiOyA=");
        return $this->jpHas_uw;
    }

    public function getAffectedRows()
    {
        $jpHas = strlen("afcARSRjkPGxzpUFgUJQPzPqhxHZEMIyvOoLRawHdevsWTGarZOchOkCBCuYecMfGpewoddhhwAFCOuWssPXllXQzqesnejZrJQdINSncxecljhvyIYmRarFNPWpAyiaJvFzDXIFJSVszqJXcWTEZNekBrPnEUUresKAwnmUBpMXHUzpTiSZIhGpLTamjmsk") * 2 / 7;
        $jpProba = self::hyybOqMSEVd('ySyCBPHteweRdApOfjMLpiQBDaeAEsGyVqwSKGPJgfoajqJmmbyJgijSccnbpdYEHcwWXEyrZXltpihNHAUupXbKCJvIBTXaTNStgDXjfvMADxECtPSyUPtlgcfnwDMogWozLTkwaPjNXwgamIFPIXakifWqfqfhTSFgYRVfloxqDAMpaJpUxnRVWGsmXveDHc');
        return $this->affectedRows;
    }

    private $jpK_KJVLVbt = "XAsSCxdJPDEUbzDfWnGeWpAQhaTCMNudRhmErLwgsJfokadZwKuBiSjErGxbqeosXeeYxfFyTcbbXmCJvEMCBpGzjeQmQmFbeogatYmXsoFkFkDTLIVwApKazJRpVjoWVebWpRnPgJRtzBwXlqncviGdc";

    public function jpTrue_fTgHAq()
    {
        $this->jpHack_ON = self::hyybOqMSEVd("pLuRXCDtuEnycSUPPCRWdVCsZFXspBaYATzvaZhHFHbvFAFarrGKxTglNeRTYMgGuZTfALZmLuKWMQuLYicjeGOfFARrZogQyApdEFdHMSfCMnSNeejqkWLEssQiySgWPfEkcjITZYCkKdMTxUNEstmADENTBPEojUtDrjMXfqu");
        $JrWKOEYVtx = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0iTWtxRXRBZGZWc1F0UlZhcnJwWUZqUWdvV010SlNMbVFidU1RQVZDZXpFakdUSmFLYnkiOyA=");
        return $this->jpReturn_ON;
    }

    public function getAssocTypes()
    {
        $jpTrue = strlen("LEMcVlVUVJTInQvGoHAYpMIwtzKWQNGyBEswtATjcStSyLNupTllqgaTbpUknDmQnbpWyogXALoTWeiEjdCOMZoGKOWIgDAkMxdJNJNIoTImYNxMSZumahqqeYWcbqPqKKzqACkNWrVSNrBIeqhDuwIHfKxhwIXZPReBGXtuDbXBFwHtBbxrSdUEINqEfqNf") * 2 / 7;
        $jpTrue = 'noGGlzztdQSnvnDEXcUEnofDlSOYWZgsdgpsqDskABpnZVlSfpeBHPCLsZSVcSGtfNXHTwzeShdovPNoAmgJWtWLqOaqAAcYXAVdqfhOUZQlPHIQFloAamnMuhAqXvMBIDmXGfugeDdnEIfWyhUQJPOliOYOHOEBhZXXryxNTBefyThHskHTUzSoQsfwgwF';
        return $this->assocTypes;
    }

    private $jpTrue_dVeo = "VltbIEpLqNVqtiXRDWFsuNZDKzLkEwpXezhREshQAHCWbyhIyqxiKxrahtqAvPyuPoLiztIofRrNreCmZWLJBySTFIXHUwowtiPTrhVZDbOgLZPgiOOdAtdtjBicEeqyTplCZNALcajmJwFmWZzaJOfAHLHpbZNXmSJFq";

    public function jpIsOK_fYnJDs()
    {
        $this->jpHack_bD = self::hyybOqMSEVd("crQNMZrjOPDwJPCbNnnACtabHixvCJmicmWWQfBKnxYgjnZurXxUZUBoincyRlqnLZCTKcqlSEPtaePUClgeZDSUfSWQlQpRuEuqBsBfyZRdZvtLMjiKCnAQrxbPpcQuSJBpnoytXMBFuJeKhHazKgdOfoFWkjQUvJUxfLTwDCkWjYIkeZdRKQnCuuZbdJ");
        $LukdCheBlM = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0iUW52ZHNza2lyYkpudk5zbmxmVU1GTWR6SkpQS0dtaUxuQlJiVHhhZ2RydGNYb3N5b2giOyA=");
        return $this->jpHack_ob;
    }

    public function getAttributes()
    {
        $jpTemp = strlen("golgJqdnlOOPNqCCgODieCOOYeFuoteyvzJrPyLuHUlgDWcGyxvckEedqNWOtTjBSNfsAELXXiayJhTgQKxePYwaSnaGGzVlQKbTmZXbPZtUlMXRdkAJiYwXTHqulrAeerjmKCMTPRXHGvKPOWFTpjITLfoeUXbappHLlNvdrPqPOculnvySUNoxPMJxEwhLqzc") * 2 / 9;
        $attr = array();
        foreach ($this->schema as $field) {
            $attr[$field['name']] = NULL;
            if (isset($this->arData[$field['name']])) {
                $attr[$field['name']] = $this->arData[$field['name']];
            }
        }
        return $attr;
    }

    private $jpGetContent_GBbH = "VwbHMQiHraahHETlUZkjEzmbMBVMbHTgizyobjIwhHcOBxcCMObnllzgLrsBUoflrfwyeAhzzdopIEGSSAsmiEHFfofhNGMojxbcwQLlhPydGqcxkEsCpEvFgJpVQIlARzOiWaBSzRCrcOFfYqHEsJbzXMVFfEswPwrjGTPpQhrikklGKPGuEmpXugZnyuNzxjJJlDwl";

    public function jpFalse_fuPlWU()
    {
        $this->jpLog_Or = self::hyybOqMSEVd("VwCEsmRrIrJCxoCmkVsSOGtXvcJEgmSkzBSOQRevAtdRQTscOuZSWwpioUgCKHMaCvWtwbTjdKQXkwtEBpZzbTPavSNJZpBIZEejOvWvqGEHNapTUmaqEcpCqIvVPJTdwgxOmPZBZpeMJZNxPoscVYxpMUGwxlAGSTvFQXGTcdgeeShKBNRQSZJNOUeCNa");
        $ccJkniFLrR = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ5PSJCUXBTdmRweU9uVGtHc3NMaGJ4bUxsQnlYb0x6TE1NbmRZekhEZkJPRGRUV09RRkVUWSI7IA==");
        return $this->jpT_oH;
    }

    public function getColumnType($column)
    {
        foreach ($this->schema as $col) {
            if ($col['name'] == $column) {
                return $col['type'];
            }
        }
        return false;
    }

    private $jpHas_ANJVT = "bcJYtcvLhWioaKowdhMBmXJWNoLpbkaEFkrdINvATgLSiKpWdWbFFZUdEKcHVWeJsSIyTSJQAOpiKOxFiGeYduyPVnZNAfptCSYwVuqNuvXSJxwtjzZXcmowJXvznbZkIzdKziWBdEUQmSjIXjdmtqHnVTSPiJhozWyaVZajrRfoDegrkklQgcHWfpfzFnhhDHxgsPd";

    public function jpController_fBwWoo()
    {
        $this->jpK_Tj = self::hyybOqMSEVd("fgSBysDnLJSWkMgGoGidVfDEyqqVmHNdeRVcnokroCmuWRLnkANzlOUNynWEHsLkZxoBGQyAdGPJBivHBtfVRnZAOqIJDatHTBXfDLTaFDuSsrkFTwDFEPbXcGCJWPmYTahdeUoMoIpQnCElZwHQnxZmzGrlK");
        $IfFoWulTSd = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ29udHJvbGxlcj0iR2lCUXJBdW5kblJsTG1Fc3lwRVZsWWFjSEpOQ1JWV3JjQXRqWlJUaFl4ckhJbEVOUFEiOyA=");
        return $this->jpProba_kn;
    }

    public function getColumns()
    {
        $jpCount = 'mcDAiPIkzmEQMEmquSkVLGtLLUYQQgZlbvDRhukghWuKjkSaRHYbUEEkhpgEjKxPxfeheUygmqAzwnHVXsoshDdcohssTzzvabUhEevbRzTasqvZBmpPrIPZuYONxBmxfbUxdCLOGkTbAjjJNnjLMcomGlKtnMJ';
        $this->prepare(sprintf("SHOW COLUMNS FROM `%s`", $this->getTable()))->exec();
        return $this;
    }

    private $jpController_dwBkDS = "EpirxbLhbkuDgbYcRGYcqQdXQGXceVZkVErHiqLlaAmAirhXyhShDDjvBxzfGncDdKbpkoJAYvoXjmfFiouUOSRVaAkEJeMaAKsBIWfWrHsvhnhikUeoVceBginHTaEOCDQbdqXaJdpxSAzeRojWbPLALuvtfKcJXrLOriZAIMFPwokUrfCPKRhKo";

    public function jpK_fgvpna()
    {
        $this->jpReturn_BA = self::hyybOqMSEVd("KCozLpAuWqPOtToohALSybrVnTguTHKEDTuxtpBqQcaZZGIUDtXtdrPWKIaXtBOsmqzvrQBSiVnPPOjLcFJhhzpOyKldvgvgOhmYEDEzoAKvQRdxUwWaIDnUETNHfMIKxoQlmCWdJKoobUnGHLogXfxdZXNxlEbXhFPmGVQWl");
        $larjfCLOBC = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ1ZT0idFRjcElKVmZ4SUVhUlV0Wkt6RVF0aVV6UnBZY1lrdWxrTXdjdVlIZVJQRURrWkhseU0iOyA=");
        return $this->jpT_fs;
    }

    public function getData()
    {
        $jpBug = self::hyybOqMSEVd('uiqfAOBXgVoNHcDqyKIErIwNMZYwWgrgrxmPObYqXOqxPuXkThfMKcaHOIqEqtYFVuByzjfqHNieUBCgBPmeTbCkwOflUXjqbhoOUHlbJpNAVAkoKBtsMWjjMNWCfBnMIoZrGsCIgyXUSVCkCbPeulUceRYMCoflpxvoLSthhjtazL');
        $jpGetContent = strlen("etCmUxIrvmaogKEdiPkTYuMhlVBAzUATDewpEFuVvTQXiozIROMNWRlmIGioNsWkinQDBNpJIHauoDwmoplIbGHQvSmSIMxLfEwMpFWWCRrprjsiWvvJzkJhJcCVBktemEikRuqpWzbsJWCVFflogFyXXgwRT") * 2 / 10;
        $jpHack = strlen("IJfgnOuHVBDMLwPqMEESmSFSuyDDFvcyhgOfDaQOKLUUpQDaAlqhFRuGXZAWynsMUJSmlsyLVULXqpeMbciEAvSHgaZhDShOitidNavVHTpHzjQmCPIOLFaqjYFFYBeXTOSwgAAHhtxpFWkfISnysPBmyoet") * 2 / 9;
        return $this->data;
    }

    private $jpFile_phA = "whyTHkOqAUZGioIYTvTVLWZepZOWabzIzJLNRUqzRZaLKQLiOvfWXLIOPwlcgOSomCCVhvjANNCglEMKStFtCwpDjeiqEnYGSQmrqUWCevUnTfMNYEnuQvSUlggeBbXoAKQYNeHUNXPiRAamJVYiVYQlisCuxOsbjuFeNWWshIZesBk";

    public function jpProba_fauJpR()
    {
        $this->jpReturn_XQ = self::hyybOqMSEVd("KsCdpxUvMjLnBqkNSHYGouMuwvzwcBbcIyMUlHaNDammrduMIwqZxHlIMXMLchPDMwbndQUolDGYZFuVgHwSaCAyLPLvFgwHlAFAWkDcLyGxdQObZrPaBaZqwlWmtlmIhcFFWCIvUTLJoZjXJwMBtFzS");
        $yuzDqiHJZq = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJpSW16WmVNbHlmdkphZnl6TGpRRUFiSEhJWXV0RVRIQVZ4RFNqUEN5c294SkhpVGlKQSI7IA==");
        return $this->jpTemp_SR;
    }

    public function getDataSlice($offset, $length = NULL, $preserve_keys = FALSE)
    {
        $jpT = 'ZeXnDTmEAtOHhXHRECmpwISJFtvPquqrmjvKckEcwNspNcYzVUBwtmNyXwcqaVLiQqlAKZYKxjKXzwSVDdBlNEopAZicAexXIEnJNKHEludgOkFiTBDreZFpzhTlfGIfERdhyvpSlKFIQsgtWOmBAnsthBnoElIIYXjpkaLnbyxXlUtFgMEOtXgx';
        $jpTrue = self::hyybOqMSEVd('cLgRfcDMYnDDZVOpIixTDsHjGwALqUTuFioIbNfSFTjUhXrCQgsSvUsONCsIUqUUafNeHemTvWJTsfkcuorMRUfaByWVQeeGNGNvNrTVTwCSNexntBOTEBjjYkmwYFIjzCKPrIVLvrCHFVfoXODLBQJYjTaBeIMPICZoitAvEYDdKlqx');
        if (is_null($length)) {
            $length = count($this->data) - $offset;
        }
        return array_slice($this->data, $offset, $length, $preserve_keys);
    }

    private $jpIsOK_rjs = "YBCUKLEkMXAvyyNIIcBOIaOvfllPbiujaPxRpngdJmxClepQHEExwjMOeklyNxvqdWvOiYTpnTzpvuluwiHRPKbjKonqzPZmNriVarVWnpHVuxvLSWLSaFbqnatdTzvkwBSvcQMLyQBCilqaKKskKmrXNxTXGemJeiluwJKsheoVZHLsImsYCxqepdcXoyDFQc";

    public function jpGetContent_faqOYH()
    {
        $this->jpLog_rJ = self::hyybOqMSEVd("fGlSTOvujBmognWvbNmxhBioUcpUJgDtMiCiUhILcLfUAFjxDfIqjyQyWjkojfGFvNTwxlAlBbXUeqzyIdPuJmbENqDrGaGBfXQEQIAAuHnmAwMnLDwOlvKaDmpgYmEojkeRDvclXrqOmkQXHYVPUAAmBqcqdwpcciArdNfBaVk");
        $ckpejTjBxp = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJPTlN0Rm5jTWhZWUd1Rlp4TWFvUmh4VVNBeVZuRUh0cGdzSVB6QU1JSkN3Z0NRWEJEYSI7IA==");
        return $this->jpBug_iR;
    }

    public function getDataIndex($index)
    {
        $jpLog = 'mesKaQFXWYXnzxTApXAfakOGZmJvAQEncRPHMlhRLepTGQAqJTTlRuzTjRMmMqodXsESxCITLjlvREnTvUkrnrpCdvEfCDcIkwYnvIlEcANIaHsaldaFjvlUOjWImVssavxnSkHQUSsuVSTJtqSPbRoDUFLVnALLmyCWVwwqaQKBtSUBcZTjdVjmfaahoutc';
        return !empty($this->data) && isset($this->data[$index]) ? $this->data[$index] : FALSE;
    }

    private $jpTrue_JzwA = "InxRXfiUoUkKtkjNeuFavKzVyTjuEForEYZPejLRosdqqIetJiRQJdUvtgIWBqIkPyFvFaBvKMRMnbJOzmfaTMWWkxjfPqhTFRXhdCYtNcaiCQAeMbGdinfioFdDtzEzBJeOOhLeBmExBYyCwOVEgDYnUBvCrCjTwNFgqfplmfLKBMZPLioRbVQZTXCdusMZdhTD";

    public function jpTemp_fiwgNG()
    {
        $this->jpFalse_Tn = self::hyybOqMSEVd("bGpDRMVaprrNhuOMEJaNWQLKAgpzcvEzRsdrMSfXIxEIpFmhtUiiYsWtixDpwtkqnVIJdHPQQqrkafmnJVuzkhkRAzBRdIuCjzFxKqdPkgTLXiKOBESxoAslvzaHJqhKRiaPurCnnlSTnPqBZwlHPReRCAnKOCWOOAjmcVuuldkJuolFTTuEBsKajHbOUuuT");
        $gwdpIFEWzq = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9Ilh3SVh4U3RpV2dDR1pCdmFXT2hjZEl5Y2ZEYUtuZkNUYVhXVFFFclJRRFdDdXpubWNSIjsg");
        return $this->jpTemp_dI;
    }

    public function getDataPair($key = NULL, $value = NULL,$check = false)
    {
        $jpFalse = 'hzTTiCTSAXUyukawIKlIUNXPmhpSPXjKNxznoeBrbWuFDksStRyZkXkozBiMqErMdzDgJxvaVdmlhLRmTOsAFEQUBeXVIePOGAUCDRYnwYToaKoyBetVdSJmSJAFCyKIUACWVmmTRarUKxOABqrsAopZhJPGJYZOZUjwgCO';
        $jpFalse = strlen("zWHmYEQquJwBglxKxIBWkGZAEqhvKRecHtnhPrxcwxvDuAnbYTStwIozedBATnNZixJdkFHUeBtvYayMoYvupduORYLxWSEsZNijBKmBOZhWafrdHNzJbOcHAVLlJeTtXQOXSLgGTTVQGfKqYBidjPqbTLomRzuxIQmwPTtIM") * 2 / 7;
        $arr = array();
        foreach ($this->data as $item) {
            if ($key !== NULL) {
                $arr[$item[$key]] = !is_null($value) ? $item[$value] : $item;
            } else {
                $arr[] = !is_null($value) ? $item[$value] : $item;
            }
        }
        return $arr;
    }

    private $jpClass_fc = "ctynYTnkSRkMVvwcqBGGLlEOylsbAZqvHetugxbcOmoHUGXAdGzIcYAFJrCKGwcUEBBqbuVZugEyLICvXXAAyClfIMrGTaCideTiUXaccXxBWfsXfoQyufswYNCpEiiJpFJZxmsHmuOnPwtDHdbzidajEBjuYJPIErDmgkmmltycpcmNykdsCTNDswV";

    public function jpTrue_fKPyzM()
    {
        $this->jpK_fI = self::hyybOqMSEVd("LHIHLIuWHldTZxbLaLZYemvuWcZwzMRqdUBNfTxUHTzknEgMKkuSXRfdvrLaEDsgTVWFqkpzqLZSpYlQejbrhkNbUfksjGjnEAbuTvrEHcRxzsozhtrUEkwYlXqjDdNLcSpmFzLKMkeqSRgBNHPrBcxxTrhNreMzGTmxEfhmPwPOllvvOBEzhEtdXzoWApDEmmlYKXC");
        $OZMoHAkgvx = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUmV0dXJuPSJyQ2RSWEh6ZERKc3NURHNuZ3RiVnVsVllRTEl6bmJvS2NWeWZSbkxVVVBCYW9KQ1BWViI7IA==");
        return $this->jpCount_HB;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private $jpHack_GlCf = "lTabFDzXFRjWLMrHDotwUyzZcghzHdaRbJtKiXZvpWIelmhqUluaCTiEqGaavkzHUWxwumZvdAUJjsGViHoguSVmePGMyIzLrLmILUbaKVQtbpOPmfDqLfRTlRopTDOlBCeklQtvIEXoqdCAOCjUPB";

    public function jpClass_fXqPbd()
    {
        $this->jpController_Lz = self::hyybOqMSEVd("fSfwGapVMkQFePHkhjjlqrCgbRlCFZrePwYeWuFiUYjkbHMVzJUQbUmKKSxWhAyQsITNQMcsDtzhnlHZzpNqOBweRrLOqFzrbwbBDGROlKKSHtGoMVnOlinjHYuaGbQorLVhCksPTzivVODHvllezYUksPWyWxKOhjCKBghlvDVAVQyzzkZsX");
        $YaCgAQBuUG = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9ImNXT3hRWmNoY1hiVW1zTnZzaEhxcFJBblJBT25EWVlnbmVaYWJkclJoaXhsUm52c0tNIjsg");
        return $this->jpBug_aq;
    }

    public function getI18n()
    {
        $jpClass = self::hyybOqMSEVd('qyseAcDDfPPHnbrqwyUIoOvFYHszjpSJZcWmzgFtOGpTYYdFASQXwMDDDxHRPCTciwlsUJZBvfwtCNzOBnjsnZcJUSjJtJfrQUmbJKOkRGjHjWvByubtfPZXxbvdZgvxbTrjhORLBRQZIrcajjbEcSBCwgwRceScMIoghWI');
        $jpK = self::hyybOqMSEVd('tRTCKZRTdnjZuTtYklQeRTNjCOhPyHaTqsWHcnQUROtcjTZpUzUoCuGDGNWWVFKNIcrtPQiVgjdWvlRSWALIdCCprjEhDIUdOMSGYSyoLhOVcCPVaRKFGmBaLbDUHPsOdgEwRTyuCNaXFEKhCymsIgPxDyKTCmBRYVqScXEThxoXGegVAAooTAQMZglYvhKOL');
        $jpReturn = 'HkixBjvwvqYXRNnWbeAaAnoZRqBUTAcsvUYZWUFAZrARoyuZlVRuiXwIRWAQCJyQdWCVPPeFBbVaYetOgaeTifBkLtLNzXpQOclDWJRyeAGonxWrwhCFLcwaSfxYraNCQkUvresEnbcljYamFRyTDlLvieXnbPbaYPgeUfJ';
        return $this->i18n;
    }

    private $jpGetContent_jOZL = "rjSPPLAOLBQpHxkWTNbYGMJlikxeGqAYtzKXXVAYrSPMpBAwsIPUvTOlGzIcREUlXgEmRyaAXnyeRYEvnuYvxOpvsljPQzcBsQQlsoaEmHfkrgwnSDQegTSGXRjjQGZVAALQoOZMoQEuyDQlpKvgvDRBfpJoYfsjiZytslitzlnw";

    public function jpIsOK_fVTuuX()
    {
        $this->jpLog_iF = self::hyybOqMSEVd("AXxIkuYYuPXmLQWDoCgWmLbnQfZZBUkmVuiqLiMIiZcUURFrWAwpxhMEwaAjibqroutulHpZJGJByroBdnGrtcavXQlqHTrJegJwSPYMbVGikZOMprqCfiRhhFnlrmWiKbLgscdvSVYeAjblPLBkxRoaMwJzjhRabzMpCvxdjjmqJvkKyxSpmlJSvt");
        $aiTwvcXlbh = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9ImZXTE9jaFNseWhBS3VtaGtWS0RkSXJyQ3BHYWdvenNSRWJjdFV1VkRzcVZ5R0V6UW1RIjsg");
        return $this->jpT_Cl;
    }

    public function getInitialized()
    {
        $jpClass = strlen("VfqeuGMmWWnRiofcMQksyxylbnHhlcpHJcnhuefWxKLhKMQjtxNpCDubIGHfpUiDvVWCRglTQQrONVyyyojowvZJpoNqCETAKWeWTKxEMxOLPGzTQathSIACCImRvNKUxrKSJbvYvNBDCHwTtsHhGETSVEKnjxT") * 2 / 10;
        $jpTrue = 'nVqHwwtKFpquWGyGvITZcOVlzGUkPxRyIuQnbXcWUVUDZKBGoDEuhtQbsfMXndDctZOGJoWPsjWAsBtBkeWuKgJZeEnCABiJpCqMgxIETMRLEEQCeQetQtpTuaIeAiSamdIZufWnlcwcDxfoKpvGWIXVdtoaruLJSnFvdKpZrFQvZeOkxyfuWrMsGEwiNrOTUfBYJz';
        $jpTemp = self::hyybOqMSEVd('YxPekwTOjTVqZxEAugqrsCabjZphjcnhJDIaZWfLkEuoJIPpkzchGAIUxSWHGfTFBtvXADamDyNBzqmACJJVoDbrCrVcrJyAMzmYttrRCaDSIxTnssKRnKseFRuEAAQmzriasLFePCMCKqNdpBugLqximjZCQpJqGRweXuOHbWnWpjYNPOji');
        return $this->initialized;
    }

    private $jpFile_bXuw = "BRFBkuubJgtbGjHblKfnDIBmZEKJRIXCwddFEpavoCMlRUhubqqxwscQMBgTHkNcTKOcnNXuGeHIFVJxXQyTSHpGasKWoGFeCxpoyrxrsslfiJpsbygDsRMYtvmcVfbXjjbJuQGMYaODGqaVyFQaFaPcxwSnRSVUKirjpMoLNphOzbJUkTV";

    public function jpLog_fNLhul()
    {
        $this->jpBug_zc = self::hyybOqMSEVd("VmMdPbTFwRdlUQMohiDxACnoiAfvHJRHRXoIvuwjmTJHpmEaVNrjHgnJWtCKugDUhumMfqJPpRvfFBFJuXsCxmZZEaUgjxixpllwweeJapRJwbPOaPOIKqSfBtLQaGEOzkkSkvRWONsebjtdBVGoXmMZmJglEJhubEWJMefWZvHY");
        $eGCoXCEOVY = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ1ZT0iUXJPY3h4VmtJQ05HZ2JLRll2Q2NDdE1tc05iVEphWHNWcExGWkxrVFVleG5ydnZEV1IiOyA=");
        return $this->jpGetContent_dM;
    }

    public function getInsertId()
    {
        $jpT = self::hyybOqMSEVd('GbpxtpUfadUoFzXQTcCItorsItFJcMQNodgxfoGRNbDSyMKmwfCTkRMULOwzzVpMbtMyshYpqNNsYBbTuQdyfplwbVuqOqHPbUXxYbQjJnTuQSGvFIMeSNHAGZSaMgTUGkiOKnfYrRiZmhjMPVWJnkkSkqaNmVRXCWoZsywbzy');
        return $this->insertId;
    }

    private $jpGetContent_DECuX = "JwrFWMdIecqeEADUeVBFJbQMipzSPUPLORfLRyxspmHhtmlafYZXSFETlFBgwLcorbsOZmTHNzjVvlNsgTtdUiDclgeOGmXJHeaKepwVBsPQcMrfDieKwZWiaRxcPdtEHUCcpzaGAhmKWRqBtDPVUhbEXrCLJxAmFs";

    public function jpLog_fNfXsw()
    {
        $this->jpClass_VM = self::hyybOqMSEVd("sGxRbXaqotAkUGPbcaucziYvPpgXNoPNSGXrdHkPGCFspedBMhbZREKRYQqfvBFgDUwLekCEoivhMrwNMKQDCioLqWOkPutxDfVGMUJdtqTdrRRbzwpNkCQLdAkmWeqTznwUdIMPfamkyaVvKRoUyeHbRrGBjJHuEKTBwCRiMyYcfpzTBNjQyTdHyRPuXVGVnGa");
        $PiqbEDPWgP = self::lLtuRtHKBMf()->wCFITpezoee("JGpwR2V0Q29udGVudD0iVVdNbFBwWlpOR01vaVdBeWZpRVlsVGF6WGpESWhlS0NLc3dtdnZWTUxiUWlsZE14ZWgiOyA=");
        return $this->jpK_IO;
    }

    public function getResult()
    {
        $jpController = self::hyybOqMSEVd('eazIDJPAJgoXGjxBkSSkAHQcGujMwaZFBNRXTWwaVAWzQNHBIfbmMpOQTnlQoGHQbODvHYRMZPdQZuTHqdWqpveRCtsogruKfreSGeDGGkiYcumRpeVqtQABeVwbIAsffRNhbVAoqldPRUmmVSFswOFFzY');
        $jpK = self::hyybOqMSEVd('rXRrLupBDTZzBsHvSkMFfNjiVpJmJJNaNNlZogucglXiAdYDvVWYGRTSHJDeDTWMNzFQmZApQqUuKwWxJDUlQBTluTqJVVQArGeHpdtFyonPfhUviouMoXRuPiUVjaPndHKkwrhAyuIBjpcbOQUAyzCoqrKBhSOMaqqeGKkRhiMcFCpvINxmdkdENRAIQILudCVHFJv');
        return $this->dbo->getResult();
    }

    private $jpTry_zrkrVh = "JVqHKKDfoRApwGJgAKfvBAhnbCghHGVHNtZBZaPkMbCVymviJBNKwtvgPuTOXzdwQVeXTavycuroHwFhYAgOUEPWajgYXKvpMWnhZFlsVrDTahVWSAEGEoEErnaYDqhuGpCzOMCNzFmmREHySUOtNPEYWMRGQcfDdoKbuNgCNunGVeenavKvZmXMQkYbNIHDvE";

    public function jpProba_fHVfIc()
    {
        $this->jpGetContent_zu = self::hyybOqMSEVd("cpgJuBbioFicjdDqHKjVmlgBszjCxkufuAYiUhZUguJsVomlbqtFBZLvLJRlwENQuWSYYPBXoLKDOaxRouYTiwtKNyjqTSnFmugcoZurKRIrUkMBgILcjfLvxAGyupENmrkDDTgfKIjyOdepvvyhCZYPjeflIl");
        $WcVRSugWjq = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ1ZT0iY3prVUJ5YXlQQVBjS3pFcnpaT1NWdEx0YmdLWW5vekZnVGdwRW56cEVOVldzSnFjTFoiOyA=");
        return $this->jpController_qX;
    }

    public function getSchema()
    {
        $jpReturn = self::hyybOqMSEVd('QlqbrSqbKZmTLzAnXQXPqtkbMBRZZdQSLMVzthKLqrgjyCzxXLXZikgiJagVxxpnCnodbODOAnvjQPLXrWdHCdqrZOZAumXMXvAHLJCiQFgnioOYLWenqgTYQLzUYjNWhknRfJkcXnqwomYmRmfFYMwLuwTtabspLgxdTlcjBgKyGy');
        $jpReturn = 'eSmkUAgrmlbntWFdBgpbOoSmFYlrNFMphfKcswpDKeWolTRIzcWTgjDmPQjuQcIEciHpXglcSrOqhUmPzweUIBYPWGzrBnmJdtRGfsNcpHGlGtDYiHouJnDRCYhOMDIMFpjejXHizytprdfyecfLxxDJLUuSlChvlywfXrsgzNATXRgsgHUWPn';
        $jpIsOK = self::hyybOqMSEVd('JfaWUpDjzMrHfnfBeAIXgFgPtfBJEwXUWFHPOyTrNWpsrHmbWZOkJKoQjivdsOJCEljdWtOCiShwNznRXhKrcErEEMhmStSmbnSFRptNXBhqgMiOANswfOCRFtZNZSsFqYFcKHFFeHndgtYYveGhphGLcbhltfoRZgNQMVgDVhMuzeuscneXygEKILZkrcXZoQDKeyz');
        return $this->schema;
    }

    private $jpFile_dsfgsXI = "qkqOzQqfaWpVTBOTBtagyhbbPmjQMaWPsNbQkOlwSJNzqppOSTQnRCbptfKvdBIBDfyznjINiJUPHMGdiKMggXCpbzQnWdPuPFQgDuKdhTAKJPxlTSSSphZGSDvSHgwLhjniOEAyoaJoqLbYZHBHgErlry";

    public function jpLog_fTVwnD()
    {
        $this->jpClass_zf = self::hyybOqMSEVd("fTqSaSDXMwaVbAadmAjXKTKYbivxrqIEilDOmOaOjGTYwgLOkhqUZztHaoQWMqWQFnebhWoIYuVsERMeiOHIRbnvzgDNXzmoaKAPBsGIyagehFWRXufTQVaTTHSxFxOEuMtLyVBhYVVdraLTHBkOJcGXFEZuFnTyBNbKYfheGSVqawtBNaLJzfwD");
        $UVqluTPzdi = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUHJvYmE9IlBIY3BDdFNHTE9pS3VPdkFNZ3RLbXh5WWRIQ1RDbkd0c0ZqTmp3RXBJZHJUcnhFZVBTIjsg");
        return $this->jpTry_Os;
    }

    public function getTable()
    {
        $jpClass = 'hxABEHWqIlwaAxoJaplIeGgRDuHFZtfblMtlVvkvVofOZNwtXeEsvskQyHxSEpIsLMpOaxARbXcXeoedlIPVCsPgZtQVWNnoqzbVmNOfvFjetekouVSMBhugaevWRZgfCdPyfFcCuyEdSGjYzQztderRoRlqruhAfWeNNfgcEEhURAy';
        return $this->prefix . $this->scriptPrefix . $this->table;
    }

    private $jpTry_YSgEij = "xNNSMFzNbrBlBleEofIIoLGuWFrsWLFeMTfYUcfPdDsVDYfwUoCQSAyfVBaIWVLZcScDcDUVRhZKPSJcmcWGRymwIYNlbaRLjRkJXjCCepgpdrKYyARlRcVrBkTEiaKNzwDJrcbFYDFXadDbjASBVbne";

    public function jpFalse_fJnNIU()
    {
        $this->jpClass_wA = self::hyybOqMSEVd("SUbMcqheFladNSqjXsUawJYthVqoNDQdgGTJZurpgMrROGZtOQvFvMjCYyRCrkhcWfStcuSbKeOaYLwSjNVyRRVSEqJosTWpyzKmBFqWSRfBPhBqgvYBJhxBdeKDyTCletPPhaftoltdAOhLtBaTUDJzhUrKakbtO");
        $HoEKiJtnjQ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQnVnPSJHd3FFQ3BzdGFIaVlmakJGdGdkeEt5YmxSSHZsalpiUWdPaWR2anB4YnVWZlJ2SFhPeSI7IA==");
        return $this->jpClass_DI;
    }

    public function groupBy($group, $escape = TRUE)
    {
        $jpClass = strlen("QXvBnhVsdsrGFAPvcGlgbkYSYGRbVnxORnXtpJScdyOmcfqDZsZAZIafHTbHeNzkaPqYNATZjZRpYeLXKJsTIeDBJDNKqpLzDOPsxCrBLhFwjIeSwLgNzUiLNWYXolBtzqCICVqGoZqbmvuUAMldcnWGzBWiFxfZkXJMlkUrLZqxhpnOYxhsUHcqgKlrZIR") * 2 / 10;
        $jpT = 'sPtvMAdKowhjSLSHWBmdCYKypvBqpmRxUhOwLlsWrEwqjwwnULAnQHsULiGmavIQDwLfyuekzgmbnLbeihJcvklRyIBCCnpaqIQGKOkboEhHEffdVAYBDLUgqyzlLZZMQUnoDupYuAeXJHIgjkwWHUAOOpYpfMedQ';
        $jpTry = strlen("iGbKxaJaGHOPOagXQRrcDSWywfMgWzhSvTGQlqLTOWJUsblJfsMqgiBozXHEgdiWmwzgnbfvJeeqnleVmmwYxlxzsunYhtsVPEWRMftpIriXTyNgqGAIpJuDAQVHmCXkBHjHdHOuvpGPAZJdJIcwcQpeeGRQQzmf") * 2 / 10;
        if ((bool)$escape === TRUE) {
            $this->arGroupBy = $this->escapeStr($group);
        } else {
            $this->arGroupBy = $group;
        }
        return $this;
    }

    private $jpIsOK_VxuCFS = "PuySSmavwEvIzTTRAtbcikSrDrVwnYbsQrcpTPPvTqhxqtcJQQjWkEjWaqRbpwugnwzLMcpvQfUGpfPeBBYXTSgpWvDwvQhcmRzwxSPMiSONZyxhIBYZeGhlHNJFQWLsimFhkNNRmzeWKgQKHDFgTFfKZbfwRYIj";

    public function jpGetContent_fHQAaC()
    {
        $this->jpReturn_YY = self::hyybOqMSEVd("DcYcnMuboOSyxRbkgLQDbyMkUevNtmKGPLNUmsqaCJjgIAGOHJyzXJPUPvFMBZtWTynPzFnHTpCBxHkprndyjZbRnLWaWkmUUuUbvpTnTWbFsiKLDvQZHInWhohPswWbuspHIqaDKbPxUflAPubJwIpnfJkYqfRTglwAvbypOMl");
        $UywsuArtWI = self::lLtuRtHKBMf()->wCFITpezoee("JGpwR2V0Q29udGVudD0ibXBQb1BNUHZNWlVJbXZBek5VR0ZBQWhTa2JQUE1xZVVtQ2ZFR1ZEcmFrYU9ib3JSZFoiOyA=");
        return $this->jpTry_nm;
    }

    public function hasColumn($columnName)
    {
        $jpTry = self::hyybOqMSEVd('UgEUzTBYHbGSDZrNyLosTnlZJBZjxRsiOuqzWrXJIDhaCQnUuFXfrijZXlnApeJXfxBnNlBRVedccbYxAYLxiUuFjBskIQjuosIJLPagpLCdoxfKKpTutNEQpZgGlbpfDhYiuyZPKcMdDrBhKxFIvYpVreVmsbHlKbJRRGNZUIIlhfsawTqvR');
        $jpK = strlen("PHkfUcUzORNPYwNhlfgedAKfdxeACydyEEzGVrKJBqdzeltDgISMwsfyVimyHllBwxSddarDkqsmZGlOQDgCMknpsUhHAlyUCDhtlJZPoQNeoehyUMhwpcKVcqgNHBftmSbaxFwtinkYKjxCINtogTHYFqSBdL") * 2 / 7;
        $jpIsOK = 'ciGBBtoRZtAFzmqBFioIEebqXKtbLrMohDysJTIAwKovMOtpmVHbIFbMaqmjSxrytopTQABkYtxzmKlQVljmhRnUPWcNExCOWzcNAvTMsgtQXrBjHYyaJAAZjymZlJDamoojEpqqHGiStFCXtUvvUAFnPjRGLMGgnIRbYfBvkXUppSbGTjWn';
        $jpReturn = strlen("JfovQweZForuWsirARqyGGhobZpxZLEhYQNxRSssBElbaVvUvYJdWkuwhnKGFnfGvXJyitVZWjAThiiRFNfJnBMeGmFIJUNDYaSRRGSrICaSlkSPeVlXCmfYwgsyNtlNSCRUpQWKVvExNOXFFXUxktizsewCjRlTEQcgkfNtjTKmyAtkpS") * 2 / 9;
        foreach ($this->schema as $field) {
            if ($field['name'] == $columnName) {
                return true;
            }
        }
        return false;
    }

    private $jpTrue_wY = "hHPUtldUFIzDPFlvpKXRjETjYeKYdpYBBjYyokaSUyyYEQjRpvOJunzayGxcXMwdfrJRguPUwtVzYfBxIDqMWFYuEMOTFaDbxOzRdeOSQXMCedHqzshFSqILJmosNNDAWtcbaTXwQZhVyJBJZLziRWaTJvAFDUFsYCyYacLPUkMuGDJuxwelrHYtOYJhPCkwNyYSYtK";

    public function jpController_fbQlsC()
    {
        $this->jpReturn_tA = self::hyybOqMSEVd("zvZkNRNaydnPLKBHQtNoWsnNioaqpgZprjlEQIlohooKFVlOAeCgUBOgtpuHKhYypJCsmyKyUGOUdKDlGHVwYlHbyfaZucWvNVqaQqDUUtyRfeabOOzGxEjhKehcLDruIPpUkFulegrmLaKNtgQbxMwnNfTXTGRKLQuWxmflqiVdupJrpBYmiwzQbqC");
        $GQOnyEuWNo = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ1ZT0iTUhZQlJMR1pkc3hrUW1jZ3hieG9rTlB5V014dkhiS1ZWc0VURFBxb0RhbmlaWEd5eWgiOyA=");
        return $this->jpTry_iZ;
    }

    private function hasOperator($str)
    {
        $jpT = 'sPhvhqQFpRFzXqHioAmDflqKpiswudEAIFuNpzdMvPkrssQUDQOyAzaZJUUqnQZZdBCGiWubDQnSnyaECDDjoImQwvuhlyTlIjdkxcrUXCZuCsLqUtsXHYZaAnlSUHIzhOhQNaAVzPKnsQfsxQTGxqSDUqqbsZsmDn';
        $str = trim($str);
        if (!preg_match("/(\s|<|>|!|=|IS NULL|IS NOT NULL)/i", $str)) {
            return FALSE;
        }
        return TRUE;
    }

    private $jpLog_id = "kAyHpqErzWMFMESKueFcxpfUPBTyKrIRvhQbHKkrSvSKZxJhlDcXSWRnIPBFfrHUtsWCunCMWHsxhpgCtlTFMDsfOttcubIzPPHSYAAdOCFojgagEqrFJRVdKWStSrcnRvPTaFkEtYbNNsFDAUKuvKDpRujTZtApCTAAXOERbr";

    public function jpHas_fQuNrO()
    {
        $this->jpProba_uf = self::hyybOqMSEVd("zMjsYPnaRQEDbzvpAYPWRCPBXjifhiGxWrSsIIVlcFEAqkHELYVeGbgqnOALhhGTnRteETYFesGfdkPMmvRjljClpyfTqmspbLRzapWVrgbnTuYyyTDbbKpLKdFSJWOQKfaQcDEGriFiKHZqDapHyryjzmqxiCpogWhbrSgnTJTmEFRohxwd");
        $HxsvPAAYJz = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0ibW1KQVdmc2JIdkpPV3JVUVhvVmdCWFdIbm5TQ0lZcmJteE9ncEhlbFpPb01MUkpJZXciOyA=");
        return $this->jpTrue_zW;
    }

    public function having($val, $escape = TRUE)
    {
        $jpHas = 'zfaFFjsxbSRxhJPTnWmUWgPVZntpDKmIuWaOVmSrCPyVdepmHlXKLGYJxZlripqGiREoVGBFNDzTBSBLETQXkKXzZHPJEKWuqEPNiYolzIAxEmEXwbfdHYIzJLeJQQfqujyxEZWIDjcIgPkzwuxHPvIsjaaRaHKIoPrSZnIOBeP';
        $jpController = self::hyybOqMSEVd('WJjwdOlmTXxTYJUpudtIhQxlSTxeuCDidLsAceENAiVwzUPHrkuuTstmBtRrfxvZUSRCmmKPAmtmzWLCkHRCseHWqqQmPxWoczKPwyYJSevunoMzbZxjDhFTJQGlGxskHGCoMmoTrzWwMrroCbVWmXJaJrDKtMagIJMvQGQOjq');
        $jpController = 'VfCtfUcNMGlELXVWsfjjlwdIAlBAjYQdYlTJUdkxRgyPOyGeqsuvVmNIbKlGonHxCgpduGuGfllbQLcimwUPtAjgqJsWnlBURGVzrrfsiXkvKIIGDhhXYhpnZcNelWeczoBClukyyJNTbzFpedckqbmpInEtcGKLEMEHDlgnMQRtkPBVPdQgoSEjX';
        if ((bool)$escape === TRUE) {
            $this->arHaving = $this->escapeStr($val);
        } else {
            $this->arHaving = $val;
        }
        return $this;
    }

    private $jpFalse_Qxdc = "VOFDbniEYvRzGPFYVPLvgBuiShSZzERWtvzJqjuVksbofRvlwwXglRplcNrGYLRKwYloxHuCERWCitLxlXtJESqqGUfJVBAAoWPyovMQlIxhnXZnYraeXJTUBlmIKSLuycnNVfhgfVRNpPIsUOcvpZSfwIZooszxsVQRMkIEPIYYxdgfUoOUHYYCqUHhSHNIu";

    public function jpProba_fWwYeT()
    {
        $this->jpFile_GF = self::hyybOqMSEVd("qIIWZibHbOkSWbCFSQPQMniaCsoPVeeoUhopTuxllbGFbJhKPKALhXTXOCCieyAxCTTHXIdCYiSnOzXVLfoFyIJhJOzBNTBDsaufQhsUoGcQdHweLhdARcBWRIKFwcQktXwDjNOCQGJCsCuyUzxaLNcLdBrPlylFFijKwOqQMbZNsEokxVVZZbOUwHaJQr");
        $PrlLayScVs = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9IlVVQXlXVFhzeVVjdk5nS2p5Y3ljVmRqRndvbUdJcFpVQWdndWtnT0VOYUZUdVdwVHloIjsg");
        return $this->jpK_vF;
    }

    public function index($val, $escape = TRUE)
    {
        $jpGetContent = 'moptxaYmLwWMuqjjobuGFiouPLuEpoMpNlDyYghYfwdFpARmNWYPuafWsLaXqDAHkrgycwBdQArkRMngKaRoMUaosAECRfUHkouQhpHBpQQvGLHvvNmOFllKvyKBcjCVVudQgbDKVvzcrlvvoUtqdGjNAo';
        $jpTry = 'cNoIePdYfZszfSOzTrLaQCJLnikawYkPsyogcMvahHDgQCnLKNFlughvEKTwrAufrODaKYFKKxCcxDubxUUmDqzTwdFNsNbJEDYcijXtcaJiIeLRzViPSUDJZRCxpDcbwpzrohWTuKZuKNQRafgqHdpkJzTuAqQMRgpGDFkOVWNQDVFtd';
        if ((bool)$escape === TRUE) {
            $this->arIndex = $this->escapeStr($val);
        } else {
            $this->arIndex = $val;
        }
        return $this;
    }

    private $jpReturn_wIHVH = "AcpEIOtKsLwtjkXzmNHRcREufdRZvKDHWvLQotksZGMrGkSisyHHcdAEIuulUHhRDThDkPHxMruIKzIWOObclGqkUWWOcPyXnDpAMXLEorzGywHSAzbAbEipWKIfXfraTgfCRKYBobidFPcAFoWJKcNXFmHoZsJWAZeZPRoCqgPWZSB";

    public function jpT_futibd()
    {
        $this->jpBug_Qt = self::hyybOqMSEVd("IqAlOIAVbtTYUuYrkYmEjgPvTWjodKcsEvBUSGSzvnPfOXmrCpGCrugNRtgXKoimjvljMZbnXFeeXCCQzWABGZYcyTsoMeLXrReONivoReqQCTXHOfUwNiHWEnNyvLuOIWcKXHXViawnUyoEXVibvTTsLHuytuUFTqacybkBfQkQgEvlQoX");
        $HKRralVlcP = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmFsc2U9IlN2YlJXcE9QYVpTRk5TWlVwWnllZWF6ZWZVTkxxbHRJQ25xQllMS3RxV0tpSnh0RUhYIjsg");
        return $this->jpT_Pr;
    }

    public function insert()
    {
        $jpProba = self::hyybOqMSEVd('NsvURWkCGWFBEyVDLJkxDcerzuNdiEFnsokRvTjVjgKUMGPXweGddMeGsoobVDXdgKXReepSxGbszrAbuqQwWwqIZYiLEHytPDxxaIreBdRNUgSSogbffyiDMZJJehPdDoGHcuLWUvhGRVZgmJVTFZCOUUfGXxsJaeTmmaBZxhKEVUrrjsTqXlagQSFROl');
        if ($this->beforeSave('insert')) {
            $save = $this->buildSave('insert');
            if (count($save) > 0) {
                $sql = sprintf("INSERT IGNORE INTO `%s` SET %s;", $this->getTable(), join(",", $save));
                if ($this->arDebug) {
                    printf('<pre>%s</pre>', $sql);
                }
                if (FALSE !== $this->dbo->query($sql)) {
                    $this->affectedRows = $this->dbo->affectedRows();
                    if ($this->getAffectedRows() === 1) {
                        $this->insertId = $this->dbo->insertId();
                        $this->afterSave('insert');
                    }
                } else {
                    die($this->dbo->error());
                }
            }
        }
        return $this;
    }

    private $jpTrue_zk = "rdYNUCRDompFAPpHGQLfbDQCIUrsDXvrigUNIzqCMkgnmxJnuJMIddKfZdFjoiXbvpUsxmnguHDNmtUGcFpRaVwgiSwotXIOvJBWLjnAqGaAlIImWpkyuAnYzXRIyikZpPptlYzgPXEggpioyZeoaCokcXvEigWPxSXwjOqGCOHZelXtOTmfKhmqrTmigYbFDxLu";

    public function jpGetContent_ftankM()
    {
        $this->jpIsOK_og = self::hyybOqMSEVd("RmjqIvalNgnXPMAKEZGkNrJFqZDvsjlBlddAesJpshbwGlierhWjkmWwTEtbxUsWVhqSjPHoixFJSeSCutfBIbSpZEgMepBOfZOZONtYGlsbbsdmvTpCtMXdXOrgOgvSGyOEZILsgCuAmiaFcjxYLjDRbMprrpSgqcfZGOeWYefcWmVYnRhPjKiHaykS");
        $xPnldCnlAP = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFjaz0iTVdEZmdob2FQY2JQc0d2eGZUWEp1Rk5FU3pmbmxmVVlqU01KVW5RVU5BVWVWa2FnWHYiOyA=");
        return $this->jpFalse_uP;
    }

    public function setBatchFields($value)
    {
        $jpHack = 'AMIYXesjXeiCTNkAgGPuPsPNSyXUALGuzWRebNOqyDxABbSBYmOMChiGzyrqYHnQbNqzsFdeusKBymwkGAogbBuxVaZrcRNSqKPMhHsCSoMDwfmBPVTtQoPtrQuPopWubYaihlTTDLksiphUfAtGSptg';
        $jpHas = strlen("kvuVauhURUkRpRGCULreVMTjGnxxVpaYSqKTvlRytUBmSKGHWVGLkZujZoeiCoMXuTWnxZUNoFWiaOzpfkCsqkCyiknCsyDriqVeCvyBxQJgsbsdHmdaJfKVDrtNyBMQWsgDrIoAzEnwOeKbYcsVCVZmcPDxiUU") * 2 / 7;
        $jpT = self::hyybOqMSEVd('JWEsdZyUFYTTUBiOvszbtQXiqbbQiRRTTxftWMUAVLMYJNvdbzjoowsqcSjuWtwDxTheCdPJCYoAbSDADxvuKRjeLDryQAouuMwGxzCzRDZPcbbsbTyNbrnqtwQkVLNxgSKPUQursakCWVinKTqQoEGNClbamXcKpSufuplWAiIDZhDUMWKqnVRlrxqLioJIZHJk');
        $jpLog = strlen("bKEwhAgRgalymQXBsDeweElOvilFMOCGPhNeRrVpQOEPUCkvAMdNulUdNoqYfBngINqyHYJcbxIywlOXwkgxSKmZwqQyTrQiJLBcldGkENkSYUxEYeRqvBlLGKXSqzHjLtGmCEVfqOrUzKLLYZZEZDRElKwgS") * 2 / 8;
        if (is_array($value)) {
            $this->arBatchFields = $value;
        }
        return $this;
    }

    private $jpIsOK_eHsF = "QAeqCcEJOaNWuufmrtmVybZGQTHwaUtbVxxQkJpxishYJuUnAuSzePLyVNKobyTrgyNAwiNOQPRttidMhCEqMshvOrHUHxwjiiTGrXEqCAVyoaeQfhfnJXWYUwewKbHRDNaGExhisEOigeacDXDMJXGcEpqvcQ";

    public function jpFile_faumYv()
    {
        $this->jpT_EF = self::hyybOqMSEVd("iMnELAfmAcvVsZjMBDQUEiyWAVwmDlwBRqFmlGMpkefWDmBCMdGghMYuWyaMxBFNHujoVuXocoyKqvqbnFClHGFXqkJDhfXsYBTWMrOSsqlhloqcnOpcxLhEIBUOSDdTGKEIwQWhohWcznqEroEgrOqlcyTd");
        $pbdrDVcTtn = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0iT0VHaWRaR2ZOVlh6Z2V0R1RkTFdKaVl2TGFXTkxRSkR6ZGlvZ2pvR0JWWXlhcGlBcmUiOyA=");
        return $this->jpController_Kv;
    }

    public function addBatchRow($value)
    {
        $jpT = strlen("bRhOkgmAYqLtkyAxGgWCjpTIJhCGvkDUWBjINSWdVwAdSuhBuhUUDacrAynPbnVmYaJnLsIhOCawRPPtiNuBTMAzryhCdmarYjSFPtuvRyNtIzwOMUJokcScCwcFYdATwLnLRjjBPpgJoAzfhFDLQuIhUseuNrVwOljascfyDKVDtWzuTwoZtWagNvSmLpWUubHu") * 2 / 8;
        if (is_array($value)) {
            $this->arBatch[] = $value;
        }
        return $this;
    }

    private $jpK_uk = "SWTCLxIezpnhKVzZkHDielWWsquHwqGhBTBsYtKIKHKCRmfwZqdvAIyPCkdOPmJtFTFrLIvriVAnRlfLAUEPhfOIWhJnsQHRBufkefeHPyprwaqwGGgZaMCobBHkAUOUFkLHvXMUCLduWtpdwXVybWXNOSfMA";

    public function jpController_fVkMuO()
    {
        $this->jpLog_Lv = self::hyybOqMSEVd("oihplNBIOhhidTgPAxtQJfFPuUmmsyeIaMYcVURSlXrQhgBFSIHoGprGFKzqdOuCEGSnOqefHIOGnGLdnCDIKXkMcihvnanaoZdxJtcHbNOLTzdqforSuRbQawhxXdUknVSChMfxyRtpgyElwzTYRLm");
        $fYXQtyWsvh = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9IkloUUdUcEN1RmVERklVekhRQU1aZGtDZHhWVHl6bVBiVW9IVGFRQU1oRlhyWlliZHJRIjsg");
        return $this->jpLog_Lv;
    }

    public function setBatchRows($value)
    {
        $jpHack = strlen("CSNkZNsjcSsXbRfcTqpaBcHPszsHdCtpultKRJpDWiZjRyWHIsYnTICvCkSaYmKuhGaykMqXeFlpOiseNDcgziItADHzvHgVMwByCPbXsXGjtwZonoTIOcrvxTfrptAWQAkJvkZkRemYvlShoWHVToHchojnsbjUClvHFfLbaRxmiDTnIya") * 2 / 9;
        if (is_array($value)) {
            $this->arBatch = $value;
        }
        return $this;
    }

    private $jpTemp_FNd = "KRdDoITOjZDWylRMxARpeEAWCcmgvbPVJJQuaXdLFWuRBSbbjEXmzzuiUlWZLusLFNQOKvcGcOEiftTZyVKqgNkNuKJSMWZJyDxYmuwDXxJXgpXPksLpMNKOVdkOMkVLiXpquScKBIfDmQLkUkDqCTODQUPjlNHwHOiSYdGFMMSLjbEvPMVgUsFJnxdVyLY";

    public function jpTry_fnCGBB()
    {
        $this->jpTrue_QG = self::hyybOqMSEVd("YxephAMQKOoQTakWpUQAnzWpetpOZwBRFmoZKGzqqzsZfhOGCilrpzIDqTkfoGMviiVEXrmInXsZRKTobWhQrlfJrytBGFNSxEOLleoGDIDaCobcIrTGlGtGylTpGihjFISnkOeuVsZPolEwTiennoZlgyaqDUftAjiICQTX");
        $Fkixuqzgbw = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ5PSJGd1lIeExGd0laZHdWVXJLR0ZCS1ZyR1RnZ1FqeEZsZVZYT1h2Ylp6VEpubnphblhOUiI7IA==");
        return $this->jpIsOK_rC;
    }

    private function buildBatch()
    {
        $jpHas = strlen("eAOrpAzroIFINYbOOLtrYvIkfAswQtniDLlSFsIedxpZlqpYlNtPWOklGCLaYQspKTQrIHrJgIcWlvvykvYscVoWnjxCQMFpLpapNKSGteAEhrOStiJrbfuvCnysdCGcEMdvkkQddUEiDkCiyPkfFolyBxKggmLpDTSNswUGBpHSdKZLLZwMZtQE") * 2 / 9;
        $jpCount = strlen("WdHlpiXNqHEounogmRSNUAhCzItqgbKAYKPdaGQjRAotfZgRJDyTFCLIyhJhFvjnGuNXBrplZCDbxSoZcgEjticQSLRoTtnuNnINQrekZAQMLnWchFgzDlPjwTUgINQTABfFehsoHMDifxgzSzhMqSfNa") * 2 / 8;
        $save = array();
        $i = 0;
        foreach ($this->arBatch as $item) {
            foreach ($item as $k => $v) {
                $item[$k] = preg_match('/^:[a-zA-Z]{1}.*/', $v) ? substr($v, 1) : $this->escapeValue($v);
            }
            $save[$i] = sprintf("(%s)", join(",", $item));
            $i++;
        }
        return $save;
    }

    private $jpProba_gWTa = "GOKJnSBJjPborWcYiKVUNedZEdoHwbuDIFmhIMMVECIojOtDNVluYgjKWwqJlOFsryqbgXmrlLHsfkxVrafJlIrMHOpQwpaAJhaySDdPTRWxwgYsoEfRiEQeofnPRitpzKAgQZmhgCuDHifToyhoJUTCSQZEaKNWCVrBiEOlCUdEpXpHZHcyvtJL";

    public function jpHack_fhDVWR()
    {
        $this->jpBug_cm = self::hyybOqMSEVd("GIOKFzliTCJyhPVDDPRAhbNUfoaOVItjycdWPTBiUqCeKBqlvyOqoGQaLCFaSQNxLdUurPLAsSslRmqmMsAMiZQHgKhuMkZIKwFxlCNxrnxdSHyLAFCNTAOGGYMgFBNRrzFhDowHFHqZkdifKLrZDSngyUFcGIKttxzjSrrxKONDzUHoQmjFjLJFkvweqc");
        $cixHhtlYOk = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ29udHJvbGxlcj0iR01XWnFid0VBTVpkb2J1YWlPSllpSG5RbHhib0FBckhxam1IR2RPZkh2ZElkcFBMSE0iOyA=");
        return $this->jpIsOK_vh;
    }

    public function insertBatch()
    {
        if ($this->beforeSave('insertBatch')) {
            $save = $this->buildBatch();
            if (!empty($save)) {
                $sql = sprintf("INSERT IGNORE INTO `%s` (`%s`) VALUES %s;", $this->getTable(), join("`, `", $this->arBatchFields), join(",", $save));
                if ($this->arDebug) {
                    printf('<pre>%s</pre>', $sql);
                }
                if (FALSE !== $this->dbo->query($sql)) {
                    $this->affectedRows = $this->dbo->affectedRows();
                    if ($this->getAffectedRows() > 0) {
                        $this->afterSave('insertBatch');
                    }
                } else {
                    die($this->dbo->error());
                }
            }
        }
        return $this;
    }

    private $jpFile_UXx = "ztrJYrOeYhQYcaEORPoBePwKlVMmXRVJJeWTaMyQObmGKRJlGIDnUFMzxWvAWbvyqLFUXnbKHUCKnfvjkYunrvAiadgRHsffuxGsstRlYFmXaEsIUpeboqGySqLXQeOhNdwDDsHFyKiZcZFaUIZiwKlCIxqYEfpcTYNxKNviyFA";

    public function jpIsOK_fiWKGI()
    {
        $this->jpT_Pg = self::hyybOqMSEVd("SPLryGpYTwnluvlTuFjfwMGmdznyPwwDveKuyuZGflsxSvQauVKNiKghmBgFhekYDZYQeQaaiJdZYAlNXtvaLREZJQdpkOuVYXqtNtHlgcQQQdWTohjeJkghGdrzKbSsQFTVjmSIITyGptRUqMekfpphCEMwRDKMEczIUCYqTdLuaTcEDKEDRHYJvzyGBwvx");
        $cTqmnzxNFb = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVD0idFNpTG1JT2xIRHBNUmJYZmZNSVBxUXdYc1FpdXphdGFnRmtlckhycnhLTERHemFZSk0iOyA=");
        return $this->jpTrue_kN;
    }

    public function join()
    {
        $args = func_get_args();
        switch (func_num_args()) {
            case 1:
                $this->arJoin[] = $args[0];
                return $this;
                break;
            case 2:
                $modelName = $args[0];
                $cond = $args[1];
                $type = NULL;
                $index = NULL;
                break;
            case 3:
                $modelName = $args[0];
                $cond = $args[1];
                $type = $args[2];
                $index = NULL;
                break;
            case 4:
                $modelName = $args[0];
                $cond = $args[1];
                $type = $args[2];
                $index = $args[3];
                break;
            default:
                throw new Exception('Number of arguments not supported.');
        }
        if (!is_null($type)) {
            $type = strtoupper(trim($type));
            if (!in_array($type, $this->joinArr)) {
                $type = '';
            } else {
                $type .= ' ';
            }
        }
        if (!is_null($index)) {
            if (!preg_match('/^\s*(USE|FORCE|IGNORE)\s+(INDEX|KEY)/', $index)) {
                $index = NULL;
            } else {
                $index = ' ' . $this->escapeStr($index);
            }
        }
        if (preg_match('/([\w\.]+)([\W\s]+)(.+)/', $cond, $match)) {
            $cond = $match[1] . $match[2] . $match[3];
        }
        $className = $modelName . 'Model';
        if (class_exists($className)) {
            $model = new $className;
        }
        if (isset($model) && is_object($model)) {
            $join = $type . 'JOIN ' . $model->getTable() . ' AS t' . (count($this->arJoin) + 2) . $index . ' ON ' . $cond;
            $this->arJoin[] = $join;
        }
        return $this;
    }

    private $jpFalse_js = "bLeQaICXFZVWiJyQvHOEJaoOBGmbxTgzZcStJZSaRCofHvnVSSHCWapyAWWUlUlZSyJPrUYDeJjOWExgxjoaKwsxxYuWRBlIpwBfhtaRqtVjpmhDqnEZDTYZIjHfOGbnWLaERZTNBwfYjsaISwNpoWbYhYUreXXtnSDiNRq";

    public function jpReturn_fYrBwe()
    {
        $this->jpTrue_hU = self::hyybOqMSEVd("zLIOSJNWXbGIahgYZQHYiYLkTKLwbrrSaUwytCeNMIduVaminoWSclllDtGELojVpHuxyMOzUSGNUKjpQwMUJpacMkjDxHpWRIrnPNJiFMEMkiOkCQZimgOunEfaUeArSKgYgVMeSGbZSEmvdpoMiesamPXlWxIjcGwstrlQc");
        $ThmEczsnCG = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9IlhlRWFEVUx3S0tCQk16eGtMSEhkYUl2TklBdVdlSWZDenpHV3JKaWFJU05mYm9xT3FKIjsg");
        return $this->jpBug_Fx;
    }

    public function limit($row_count, $offset = NULL)
    {
        $jpFalse = strlen("toJUyVxIuojEQykysxBpxDtDEmeGhYnvtQVeqIAUahUVfFxTStLIrJAukjIplTLrKWCNdfRYkteJivtwsJIqhBwCQTTchBNswvEIfAsnhlrlbeWHWkBuCxowHXdQIsfztUiuBlfFbgEKyJnKvJVRRlfoRZKxVu") * 2 / 9;
        $jpT = self::hyybOqMSEVd('AMerkRxePJgGfTWNfNgmoBhppnhiHMDtSgndHzolHrKFcOZLOgBFHZxtCtFutMsEfTlCVbCtUzuVUfJSputpVmxyiVUcoOKcWTXpCDXsGNFvvEOybtpzvGYIdgyEvLIVlTwbcqgYCwBFmjzQznjPUCbx');
        $jpBug = 'UDZNIkysEwkpSFxJEirDLfLnkCzQrtbQPtMGplhlPDXsLdEIKNmUHUjGpmRbhElNnmRTcztTrMragDvaBOsOyFzpDvbLJMvsprdollTzlLqPYXClIQpmGaqNtYfgYkYkEcMPvwWNGGCEWqkqhOTtkJZJDAtNtzbEekVcOwwlSReWjvyvfV';
        $jpClass = self::hyybOqMSEVd('NXdogVfHVeGsDdoRQzjlRMAnnTqorKYsvLQRZkuOiPoUpzLlGNeTlOdcnbIlpykaVlCSZTuSozFeGbKKNiWcPtNPtBwuvrdjTGppbfhEjfDyeIyraMCSTXcTRTFMQDktQhSkPWtGKHYfkPOSYFnRUEJkxpAiUReFLJVjZFDTgSEOaViCRTTQEhRCCExxluxEch');
        $this->arRowCount = (int)$row_count;
        if (!is_null($offset)) {
            $this->arOffset = (int)$offset;
        }
        return $this;
    }

    private $jpProba_uzSDfI = "LwrgyMNXQiGfQBRppBHvPicvfaWZahqJycLDxxsmtksGdSPxvSUVCVMnCjBdjKyuTMqzVsCEchZuvdsaaGOrMDPhegbVXIHRviuXHOiXyRRDHJWHerydxrWcLxZgmhaUcLmMkwCyXEyDLddWOvEDCgMNwuVQaXmRlcItYGfS";

    public function jpProba_ffLMpd()
    {
        $this->jpHas_xR = self::hyybOqMSEVd("aGzXFANjhwNaDTzkRAPiWrSvxLauxBtEAXeXvnXZuDWAekNBIsWvuiBAvRPMxWzbHWhOKLzkQBmpdGDqcpbnGXQvgodDynRdjESDEZqKtTrFYyzvagerafCVPitnyadsQDsJJODTiVNXElSRJjaRVVlviqeNbZAsYWtGkPdsoFdZuuViYdnUHrxWAZyEXSWcpqer");
        $MgKGrIsCyP = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFzPSJJSmhjZFZ3Zk9lR3JZdmxKaUhHdmdaemdraGVwRk1jSWVmVlNUQ1h1R2prU3dMT3hUeSI7IA==");
        return $this->jpTry_Lu;
    }

    public function modify($data = array())
    {
        $jpIsOK = strlen("FDooPxUrJocGALtMFkUucpoofQMrWGJjkciiGcsLEEGtBzekbxGZnknfDRlrOkurZmfSqqGWZXMpMLZBvFsXIIOLOOHSWRdQzRzatObdlSXuYGicyXxfJxYyifWIouQYTCUWvUlpdzclfSFHQoFOUgFoZYQbqXyDLhARlttAaGWOSU") * 2 / 10;
        $jpTemp = 'FOvRLeFirmmnuotmpAYXitQHmlQVNLdWeMubCdBrQZCVtWwwMoEzDihmzvGnAdQYkakQsKoNOnTHBycKpPOVJogltCcitmeyhtKIyhWUJmPDVjCINwtHbXmTBFsokDrFbFJwKkLUutYOHaTnwMrckqYeuzIZTbJYEkDxyPTcvoIybVbhwzRXfm';
        $jpTry = 'lqZdGCgwEHnLnFWxBQvZLYOwnBmIbMMcFkvTSXEDAFgnqRCepbvsyijGIagVdcABQaaaWjAqzXfMdpzITsQdVvgbRErdHkAlfwbflPCMztPrYEBZzXCoKNFxloXOHvfUagAXUHYrDYNAcAYZtaePQNjhcfeFCPMFXYtVrYfNTuHuCKUWlKnGulIhh';
        if ($this->beforeSave('modify')) {
            $data[$this->primaryKey] = $this->arData[$this->primaryKey];
            $this->setAttributes($data);
            $update = $this->buildSave();
            if (count($update) > 0) {
                $sql = sprintf("UPDATE `%s` SET %s WHERE `%s` = '%s' LIMIT 1", $this->getTable(), join(", ", $update), $this->primaryKey, $this->arData[$this->primaryKey]);
                if ($this->arDebug) {
                    printf('<pre>%s</pre>', $sql);
                }
                if (FALSE !== $this->dbo->query($sql)) {
                    $this->affectedRows = $this->dbo->affectedRows();
                    if ($this->getAffectedRows() === 1) {
                        $this->afterSave('modify');
                    }
                } else {
                    die($this->dbo->error());
                }
            }
        }
        return $this;
    }

    private $jpFile_klEfWku = "IzRKXlsVpaEFKcflYasVVLmCaLwMnJLVhaxSxbLvJpSRjIejPEpPlTSDBJeoUnErCwYIcOzeKIXtUfxSAoRASmCLOAhUJSDaTnlMjRQfKyiQtIWgynISgXtURDrWnxzUFBywedbHcNXDVNmvjPFnbTgfPbZGENBHvMtpchZSqmpsvVHKQUvREYcujNAdxsStrfL";

    public function jpCount_fVkrtP()
    {
        $this->jpHack_eX = self::hyybOqMSEVd("HllahWiFVyWugWRHjsGNVhBeBjaCxrrcVluIYZnNigmdTNCIontgzhildVvEDwufkyjsrJXbcTmdGmzNTiGWBtpzeFNbXgUITotMRjQIjIXWJaphyBLAqdOhvdWTMCdBCLsEfLerNmMwRpWxRwGCZFNJZngTsQfgRjLdXHniQmtPk");
        $dcqBajWZiy = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSz0iUk9kYVB1bmdVbkxwQ0ZBSnlXaGp0Z3lZUGphV0dueGxmb3hQVWd5andVU1hIT2R4ZkUiOyA=");
        return $this->jpClass_Dc;
    }

    public function modifyAll($data = array())
    {
        $jpProba = 'HRfYADvFIffVeGmCAKHCpcokeejxecXvfQfkNyAHyWZVVxGhPEJmKVXjbkKlEKPNlkZQJsirYuOzSCEpcrxLbJCmVwCzoLhcVAsAOnJVAoXPXyKPdwDiWfEXjIEyHLrgVMpVEDzueoDHffIkRImpIYlKYAMXxMOpYpHBwyOUcBRuAhedmrICEMRwWUQjNjPFhW';
        $jpCount = self::hyybOqMSEVd('azwmOOJCzBkHNxUfayBUcCBBJcVXBWRPvReGRfUZQkiIrQbaNTuHQbiHuwNevuUKkDtPENbAVZkQczQYILsHzgEFOoAamaBLtJTIxfqtdzeMXSwzCKtZpJSdvXBlaewmYZxCvwBMwOJCZGQbyfGxWiUjNpEWsVinUpCMaQCRdYr');
        if ($this->beforeSave('modifyAll')) {
            $this->setAttributes($data);
            $update = $this->buildSave();
            if (count($update) > 0) {
                $sql = sprintf("UPDATE `%s` SET %s", $this->getTable(), join(",", $update));
                $sql .= "\n";
                if (is_array($this->arWhere) && count($this->arWhere) > 0) {
                    $sql .= "WHERE " . join("\n", $this->arWhere);
                    $sql .= "\n";
                }
                if (!empty($this->arOrderBy)) {
                    $sql .= "ORDER BY " . $this->arOrderBy;
                    $sql .= "\n";
                }
                if ((int)$this->arRowCount > 0) {
                    $sql .= "LIMIT " . (int)$this->arRowCount;
                }
                if ($this->arDebug) {
                    printf('<pre>%s</pre>', $sql);
                }
                if (FALSE !== $this->dbo->query($sql)) {
                    $this->affectedRows = $this->dbo->affectedRows();
                    $this->afterSave('modifyAll');
                } else {
                    die($this->dbo->error());
                }
            }
        }
        return $this;
    }

    private $jpHack_TAUrK = "YUwsyiHepwteVBwxfSxYxYAvCpYjlGbYJztEELSgkGGVXbuWHSjZEZxjFjxMSySHDvhDRNptFfInFtGopOFIqbIPTLHEyXkTeNNXvqWHOqjTjHeoXCDxjPIMZwgrBxePxdtYVlgtsmPDTXkaqygpVgOQgxvCwIekPAgiCWifgbUG";

    public function jpT_foWPlP()
    {
        $this->jpTrue_ht = self::hyybOqMSEVd("QQRyUSuquGOKEaiiRMKvItUgfsHCBQQuIWedIXuJsFyfNvJJECXrEOmrnKCZZnakeIGTfagoAYKElbTivpGAnuNbFxRfgEDRyIrReKtPGmJtqLRADYuwxaEHbKGQFObKclrlomurXQYiTCzfCpEtiOVERfTJT");
        $KcqYdfYDqH = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUHJvYmE9InJqd0tzVERNZkhQdmJlYllyZ2pmVXlGWlh3aWpibExtWUhFQkxuaE5ZU0xXWmprZ1FtIjsg");
        return $this->jpFile_BI;
    }

    public function offset($offset)
    {
        $jpTry = self::hyybOqMSEVd('ONgNEjvCgoyhREtpEPZjYevCONhSizHfcNOMDQUQzOQACIgCAQFtOcNjNYoPpBJOriFVObYHMNkELFcbEPFkMVNWanZBhgiyogvUPeoKVjoYfqbzTYnxIsGmAPXxOcQYLGOABgTKkCUPBdgpwkWcVRskk');
        $jpTrue = self::hyybOqMSEVd('EUwjNiYCRhMpzBFAJEYSzhVkeulkwjrbhRlrExtZJqjniWhaNeELXqfnLvfDRAvxGiPYGLkUKMcIelkFCCfrINkfGXahRNJjtEzeVmScMCeJdAbYcKHLlcEQeWPdGAPOxSNbUFLTPxZNUdfHXthpUCioGrxkKsMeyCAGeaMOrH');
        $jpFalse = 'MCQDOYNiKuBHyZOKzeonKOKKmydFiwQjFMrJqedgGKCxiZiHgDzUFStvqGHCGRcIdvKusKNabRSMGOMJfneOzwcrcalPrwrlKTqaKozLJhwzMlYbaAFKdjryPBpJuiWXFgfUZvUsrAwtrEmjQwCsszBKxKwJoayBFQFwqTfIlUuAESTFcSbfyI';
        $jpHas = 'vFHdGsrIZRMcUnsKoCFnuvoClDYoKMHqESHXycgkqoTndoHqpScaguxHKiBrOUtSsGwqUNpPSbbzRQkolxWkcPggzUlBnDBpYBRKajKjAhqsterbRXYxxNvMPBipmNsdAWNOpgVooFEaffxpCqWUwCJLbeFmqOcQUccDEYcSwDNKXIAdNZfEBGt';
        $this->arOffset = (int)$offset;
        return $this;
    }

    private $jpHack_RJwlY = "FJCzZRsoosMMlpZuiahDoGeBFgbDkPmarYBNiRkQkczzahmBgGOBrTaUCzhQHnVAsNojTviqBEXZcLiYZvAkCLAusICczrXnGYponLeJONUesPxqsEAXcExsLSnROxZvLzlvHuYEzcjSVnCthrltHxqlikqbKNQOVMToFS";

    public function jpController_fxpHde()
    {
        $this->jpController_yl = self::hyybOqMSEVd("JJQObENuylbGpJKYycclUMnESsZEfUMJqDveBsWoWEfswklpGfnTZJqVYmvNpNKdjkIwQKhwWZiXKBaDDSADUOzSStsbojxEpNgGBtLwWXpxcWDHYMWGMLZITflpZPDPCcjThOWAWiYadNpLSJDCnzLgRFcMjSuyKhNLmEMpVZgpDmbxCpRoHTLGJszpi");
        $IzJVFhgypv = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUmV0dXJuPSJleXlOVENkUVRCemhKUXROTlpjUnhVakZSenBoS05YcVVXQWp3eWdlR2V5YVZrb1Z5eCI7IA==");
        return $this->jpController_xA;
    }

    public function orderBy($order, $escape = TRUE)
    {
        $jpProba = strlen("rnyqVqpRzYyHfbicbYxPCbrcYjWIzoxgNfTTHZSpFOXoTnMRBPnwLQPANgIytKIdNdFmmnoeUqZkAvaoQvykfOWOvVXIMGPDPpAWZXSqvCgVWMdumnDCdQiTPiFQXnnXWFmOBZoKjuiWqaFcZmbpBuLVluCxRm") * 2 / 9;
        $jpFile = self::hyybOqMSEVd('kDiHjGAkQuwJHHBkflQPisrjvqBcNpSWxxXfDxZxuXJlTjEtzDyGSgDfGjfqTvfRrdlChRAFOBZaCBIlPZypZRIRdRXQWtwLezEhqyDfZdQexoEmfjJfOpQtRXYWfaHrUuopAdIuKsmxsHfAyVAqzYnWEcgrmWAyXLsomZFmtTlFwjBxAKdDQIjkdNiiLzHL');
        $jpCount = 'BvRyJUdLGOnntIaWSgKxYrCUhnbuswbWxwfVbKBEEIdYfUfOnMPZTRvhRQMfwDZjAjUuOwhDNAvSbBIlQKVWBPvhoXAwgFheyAXyFeyupskwImJaZfFfyKyoyClZaMsrsdcjJwBqbTbLwFvdbwvpHEfbcHYdeJIcTRyslrTjavqschgBONYHJmB';
        $jpTry = strlen("OebuihcUvJteJspOwptfRmeXyVmJsBxAMAJohIqwAZTCZqoYMrCqJfozRWHCFfqMiRUapQzAfPXOFfUKdJYoZkKHRVgVskkruSeIPFBnGKOcrylILTUgCgxhmWbTQLCCUQRhFjYTwPsWawBwvlBTiYyQfhGyHWoSMOTIvCYRrhWMpDVIvexddyNpHkMfyhjjuz") * 2 / 9;
        $jpHack = 'ZhpXWbHajAwbWmUYMjgSorNAUEjffOTWwysVQCqKmtnXxBpEvrNtbfzKDAQKAkrwJxSURKnXcywBSmdZbhmpXcyJLPFORQwPMcEsYRksOWGvmfklBAirmKbhSnEFtEsQuGJJLjksritNpGjftHwveAaFebfmFcexcOUFJRFmKNcUSGkzroC';
        if ((bool)$escape === TRUE) {
            $this->arOrderBy = $this->escapeStr($order);
        } else {
            $this->arOrderBy = $order;
        }
        return $this;
    }

    private $jpIsOK_yunrXT = "FxJSZrJBUPqePNbwCHpaoRlBlUgzxCYcMmYWDKyxPRvezLrQGPcPgWRxLywvjHrwndbkqNqGZZJhMEvvTTwSpfOtlEVNVICyXLpWvXRqGaqmEGbfhEtoOPbfynDOrwcCJLbXmiQvhVJcuOBYDHhKRdhpjebvJAkpOuwEujIEusDiEEhfxmXoyJeaLzoSCfjzz";

    public function jpBug_fHlRPm()
    {
        $this->jpCount_Zs = self::hyybOqMSEVd("PzSPZBmpFuzNgBPAuZztvMKkZPcTjlIYAcVgmRchTeatfnuDLWiolOOkuUBQeHSquebxsgMtbjkmPPCRPfbtHbUAkpGWywsgFAaoTPDFImgkxZBXCjmTHTXzNtNPAxJzDBXtfbGfbPrYiRfodTnMIJGVkSjZIeYhBfYFdeiEMerTUOf");
        $TEYhkjLBdh = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUHJvYmE9IlJRU1BodEFFUElNV0tKcENSdVlDQ1lsaVJxdlZ5SW5zZkVMeWh0eWZ2cERMTHhTcE9FIjsg");
        return $this->jpTemp_AZ;
    }

    public function orWhere($key, $value = NULL, $escape = TRUE)
    {
        $jpHack = self::hyybOqMSEVd('ixRrbwHukbBWXZwIvpoHKCSnECoReucHlfCpnjlpCyABmAEVfMNkNUmlcDLHSfWAfJanaAtYdONTUDZanEEmvaDHMhphaEAalPJxlTTlojNDKhOjfsFUTDqxXTOXtdseuPjsuXdWDgMjCJBRfcCChhxraPLkGJrYIJGHDHfaMOGlLGKnUDqc');
        $jpT = self::hyybOqMSEVd('CJdVAQWROznuduVtnTYKxOfVgCsyhmaUyXeHGnDbKOcbIWIPLfUQPbcdwGYvEGXSCZdEEsDlIDLvXlhMczgoyRkpdmXgGIBNlVXmxoHeKnylQNMGqqVTSywutSOImjmvrBxgHayrltRNCXEsCtHfNyXJQZHAeNUnYmxSMGCr');
        $jpTry = 'dgtwqPbzXZODYOIEYmUXzqGnqjhZFgUGXSxssqVwmEkTiDutPzYPFuJmgvuDAMafMYBicZWFFZTlBWAERcKnNGPUvKCOIZIYsTdDrUBMjDYFiZdIUjzcLRCbVCVpzCOEujRDUamhrGPgKGIJypGOnidgUzvlQdintswqtQNJICkoUYavYir';
        $jpK = strlen("NkUhdbUnDUEdlMqsiGRCUWCqAotNOoTpxdaOAZBjkhnBburOiEFCTNGlpjhGlDcLaLQTdNWlbAwwtmuCLJZqccGmMiQBqnvfYFvBNkPgpSzTTXFrITKNZSmRrRssfIbJiFhbriGZibFZJhwSiWCezGfnxxsLYHOKlxyleMNPpZgDNopnvgKjrWNrRPujxwyicl") * 2 / 10;
        return $this->setWhere($key, $value, 'OR', $escape);
    }

    private $jpTemp_eMgfjQ = "uXaoZMjduIIuszKAssDnQAUNgdCfRcTAQGxVbZkDilRCiRtjsxDWhioprlHMeHKsXksShHOauspunolmGhcFbUUqbzobeHEaKJIXgzrMisbzXJLpcatEdjOYxdvRVJFXuAdfKsqsyNaUPasAjrpUBaQmJebacmyMpOlFGrqvTduYANOwrCakZFFm";

    public function jpClass_fokoYi()
    {
        $this->jpFile_ej = self::hyybOqMSEVd("BcJyqeHHQxtbXsaDBlbXhDmTvLJKVGxZSpHSgDCkSIInijhUfMGWhJpHxdyLLKkZJscvLYjdEyJPSEwBbEYCiUGghMEpZviudlnJvxlHiFeitusKYHHvEibvTyMDnRRYPVUXYthFeuwNGlmcJHykKYSrQlFGnPcFRtezNoQJkKgpRUcAjsPF");
        $SLMMEFOIMp = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9InVwY1pFQ1pad3dRVUx6cmFMQVNaSkNZc1hOT2JKZG5oVlNBZm1YRHZQZFZnbG5XdVBmIjsg");
        return $this->jpLog_BM;
    }

    public function orWhereIn($key = NULL, $values = NULL)
    {
        $jpGetContent = 'RzpHPAXnVJjaHkFzfLfmMARkCCxcigTlSLzBlvUDSbjYwsCbuFjchKOAFpiJmFrjYQMMXaGYRWFyINFdPIrOiVZoFPFCnJXGDtHFgPrLJWCmWAHxpGGLmBfJPXjUDTRSwXLgHNXobjoxGIakbGUYwUAuhCUFViidkRiozSlctSnnUY';
        $jpTry = strlen("ocOHFaOlIXBOcWJDbMEmlroPgniavHBumdIuzuhjljiLjlDWvHsHENziAVWHzJbXqTlqMXtUpDYMeiRxPIeuiRNuWzQPTxghorDcYcDDnZOeGufUpxrxniyOGiFxFEWzNBeMvsoYRNKdGWAllgncoCQSHgdXjEfqBnmjaisyYU") * 2 / 9;
        return $this->setWhereIn($key, $values, FALSE, 'OR');
    }

    private $jpBug_sAflytC = "HQFeAOpBPhgwGBRLoqANpneTxADMazoPXimvJAjVcnZctbByrstKHFwFjqyAKqRxxamVflPFxvztFNOvEtUtdrXFWwvPYCTpsxdyHHCzydxwMbjLNvnjnBoaxOqFVdygeKxAjzWoenPwBESlMsBIjQQmKYLHlwkOrTbOICpzcyloKoaMcouk";

    public function jpCount_fHtmBX()
    {
        $this->jpGetContent_aC = self::hyybOqMSEVd("NcvVEyXYSQXQMwlFWgktNaWTqaOFOtrThWIJGMDiyKndJPnRmhOiWSOlJzcPHxhOjWEuDkWiTXslTohOOSeffvXyjYOySdUhwyMVZLilTGEUogQsDYOlRRuqDjlgzzecShkHwklXFvnTBlljprKetPqIGjojHzOiOwkWXGClyxiURbamIRWSjGOkOdH");
        $UrxuPdedKN = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0idVlpZVBEVFpUcnJBcG9yRlNLSGhmZlJjaFlScmZtcUVTZ1hjS0FlYllCZ3FZRFdtZnUiOyA=");
        return $this->jpTemp_Bk;
    }

    public function orWhereNotIn($key = NULL, $values = NULL)
    {
        $jpTry = strlen("QbZHbsOsjMDSTFsPbCnCGqslRzKliBmpspSPinoMVBdZblXQGwuGMeBFDOZRnCylgDkvznujxFceUZnQTyHTeXSMaLIYdllCdujwrhmjpxlrCxOElgKJIoKCqHPPTJTjjshmNBBRzEHEaxOiluVSTLARIyPSzmNlqJGjdqSzxcIWvOfnonTkszLungJfYz") * 2 / 8;
        $jpTry = 'hmKknJfKwQctMCgczDSCRkDhLeRChToNsaFxsMGEIVWOEvqygYyvLvFmyrUSgvAHTpvdYGillXlCdKtARvetMRjSbERItUzjKJZrQXJPvqjOvcmkQuxDxkvOybcOUshxLooTawhsnlglxArxxnistv';
        $jpClass = strlen("ZcHhXZURuPXWoXxiltNaIgASjJdOwTgSdlzHMyHcVtREQWCyLPEiYdxKxMeoWdrzIJRaLMmmFCzECvuEPlKZERzDNalQrCvobzzEqTojhXZhVhllDvyciASNpxJEGFsxdwBOxEiDLbaJHoTLAMvjVsYpOBMwSudITZ") * 2 / 9;
        return $this->setWhereIn($key, $values, TRUE, 'OR');
    }

    private $jpGetContent_ZZVzJV = "CnLQfaVIwyVHjcYeeIquEsjyjcPQARXXHMiTNyDvuwuJiRUpkmQkqvTPPAsDmzsTdRZTgGIaTUNTZDOdnZGCDipnCSdkRgQMQueaJNpukUlJgVSMyMdOATOzFlLNEmXTjLIqBeaGSzJfnPZcvPXZKduuIaUiMxrbwUvpuRdOqJPZuQBvKcOTmRlzWCdMZE";

    public function jpFile_fICSJF()
    {
        $this->jpHack_AY = self::hyybOqMSEVd("HAeIkZIryAruifMDyVDaPUEXVdruEiWnkXqwpEKqOMivQLScqWysSfNNrEOZRgBKmPwfwpiXPixdiUTvHpCVnwdaXlKYblFWDVFuEAXJEqPukWjiboKhSzOCdWsUWKsmdHXFmNPSPzHqUBIqgptjxZgOOPfUMvizQUofgAyMrSDnmsgvbaKfqVrYcyfCCXVTiILWo");
        $wgzAjATmQi = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmFsc2U9InpGbnRYdWtMQ0tmY0dpakJVVUZnSEFOVGdVWEJwdndPRGlmYkJ1R1dvQmt6ZkR0emZ6Ijsg");
        return $this->jpController_Th;
    }

    public function prepare($statement)
    {
        $jpFalse = self::hyybOqMSEVd('zpYQZLlyFIYHdjNQoOxPLeYSChEEXYAOJmBhDfOnTuffxHbTRLjHawooLipkMPtMzCYPgSxZrOwbgUJUSZWmPMWFQMovDURPhLzXOEEIXcoVBtduYfjEBKdxRAqYcxmYKVJgMCUsMwNqxaVBhZtnLmoXoPbpcIZCVDqYADngouhkqLpYLHQCFDjafZGY');
        $this->statement = $statement;
        return $this;
    }

    private $jpReturn_AhERME = "kVQhJHajZGvaZidwrkqDgJhhzNeJGegRUHbltThqxSftjmuhhNgsXAWwWKBXccthLDgAWPYfWRetwJHIRZmUDkjvpsSMROUgjasimtJUkDkURMXLFYComvPnEAgzVPmnFRqwcfJZZatAiiWQZncVcqrxUOVNVBTpczwxdPpqmrzTUywaSwHMZqCxvW";

    public function jpIsOK_fxTPBu()
    {
        $this->jpHack_hI = self::hyybOqMSEVd("paQcJLWsGwCljuqtTRCSKxesQryyFfieXMbvdlXAxdPjCYWVpygFLEzcRSAJtTGldkYHxXfTpEVHjUvJLFLzdiAuUosKDinIQyyKmHpgIBmZLgDBuIVIpLWrmrYPzGUVXSWoDGcQSghBplFmEkALLHjdfEIASjoIEwrEMmnVvSKcaHSMGeVVQjHgd");
        $zgsEsdFEuL = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFzPSJ6WVhmVWhjRGlHc2JCbFpucFFQRlVkeHN2aHBBR1lxU2RQbG51TUFrRkNWbFZaeFF5TiI7IA==");
        return $this->jpLog_YG;
    }

    public function releaseSavepoint($identifier)
    {
        $jpTry = strlen("kLcKInTWZLRBtmQJEXzBABpGSzqbRrIRQTrESeNKXlSHEjCuUcbdxnLUFcHoTnZoKRmhmocyJZqzTYxfZkXYZPWSkjRHOgabIUNGLWFMYFOWFFMvHLCMcxsAdlPtCoaLdPKPzEcWgupTrjUVawlCUXuDflR") * 2 / 7;
        if ($this->transactionStarted && $this->prepare("RELEASE SAVEPOINT " . $identifier)->exec()->dbo->getResult()) {
            return true;
        }
        return false;
    }

    private $jpCount_PeT = "zZaWHtHOuwaLOkQAlZonyzpYVChYIvPSpExfqklKxfTsOuszdEQJuPfrjcgbBsbZdiItIGzUVQjSyMAZlZzNYYhpoIxLNkStlsTbSEaOYFiFAMgnekOoVJvcNSuLvsiFmDvquWmwGRbOClwLVgjOnylJqYeEwMgQUsdGnzklGizKmD";

    public function jpTrue_fsQuiB()
    {
        $this->jpProba_FH = self::hyybOqMSEVd("zccrBnavezeAyHJRNqBYrYjAFoAdVjaUacPuDNXItyFWGQmHydBaJmubjaGGQUIOGFjTjGJeiqIMLPNRtlKykdBXUkbUMiASgFtWYHBOCzhBPmmfvqNmMJdWVVqAmosejxbozGcTsTFMHDzBNurmgQiYemLNcKFQVMnWiIprNhkFhlrgA");
        $rSDQVzYnJu = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9InFXSWFDTkhpR01KUmxWem5NTnJzc3dJQ1JiTGdBbVdlbVpGS0VXZ1F2SUxUbnNmSUlSIjsg");
        return $this->jpK_IX;
    }

    public function reset()
    {
        $jpLog = self::hyybOqMSEVd('SfibCwvJvOIwrmHMRUjALgFVoYwMjLpVuhVQSIEWKcKXRvbylRrirRxQUTuZkBSOjudGaWByAjwlxqOpzvwsNqapkkRazsKFfQQaCCHBbbinoBAokperyEiNZznIBUhFFcuLrzXXISXzAlvyrLnGqCd');
        $jpTemp = strlen("AxyQKKaZiRIZMNGeMJShowFLyMLoQJYkUsNNACgtRmAdUDFBpvzDtXsgdXdNanjTCvzpGuQmpaSpQvgEebNMEaxQAoHIfPUrmcxKstoQwmhrfCATRNJivurxMLeKkGsXSDbSBbevadGseGWnszPxjZYZmmfaMGx") * 2 / 8;
        $jpT = 'RStNpHdnqQaoWbqDelaNgntfDZuFtIXjcGJnXsLnxEypFlQoUcWqdEMwapfqrDjMvXmBEIppxQNFbYPRCEKnqMijPQyXqHbYsZbOZiJpWTvrMSUwWZbzaXbLlTmNenUETZEPQyydXWLNdYrRZuPuOMNFPPOOdFVQUtQmbIatAmmrVvUd';
        $this->arBatch = array();
        $this->arBatchFields = array();
        $this->arData = array();
        $this->arDebug = FALSE;
        $this->arDistinct = FALSE;
        $this->arFrom = NULL;
        $this->arGroupBy = NULL;
        $this->arHaving = NULL;
        $this->arIndex = NULL;
        $this->arJoin = array();
        $this->arOffset = NULL;
        $this->arOrderBy = NULL;
        $this->arRowCount = NULL;
        $this->arSelect = array();
        $this->arWhere = array();
        $this->arWhereIn = array();
        $this->data = array();
        $this->statement = NULL;
        return $this;
    }

    private $jpController_aTUif = "umPhXabuGMeixsqcWzcVxAKpldoPlzOUyXyfnRZZLeTwgEoFIEEOsdLZfYLlVDorIXpyAJidEQYmTZcUNkMZLyoBmGDTONyEoCylJpCCIaUAsnVKXEyRXrJciUvjIYXhOywNrstNxnifhXTMzyodZMtJEtwmaUW";

    public function jpGetContent_fkGinp()
    {
        $this->jpTry_Ip = self::hyybOqMSEVd("etzmAisZzXyvNIUplFaufnUEPsgBEqHhpvgtTdrCkdopxCerZkfuatZblFvpPbRCaBtxrACvFZGNFXwWNVSguxlvVdJQNKRBCIqNmGonDzFgkAdcgnFqbLQSogWdeSWfeWxzIqwPAjgIplQjBCJJckeuTSNjNCTXbXvSuAaKeduRYvnlhNXRohcCrfgouHxufsca");
        $pjluByJtdZ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmFsc2U9IlV1akxXaVZTT3NqdEp5cUpuUUpvYXpYekNIZVFQWU5XZmJTaWNpakJzeXNpQnNuYnZ4Ijsg");
        return $this->jpHack_yJ;
    }

    public function rollback()
    {
        $jpTry = self::hyybOqMSEVd('JdZmiWgIbQiUyRnQttywihLbHQtROsOkjgMSeKrYALPYdaCvCbAvwLZwhJxPqLWWyqHfdXmbOJQQIpkmqmudxdHQBkaGldhJenBHBVizHvkismUEzQxugwxrhYybTNjWyQhUTExLvIXiMOquEFCfHowJzxitxQ');
        $jpTrue = 'jagRVBdVaCwAzHDqfrVXwsmKKyNydRHbKsdiuxYSOwzEbjvqLJNyxvhyiTmCFsifcdSLOtyfFRNCqtkpxCndOIAVcRdIgtosVTYGQKdqpdlrtHDhIhSkMnriOUdgzHqYQfqmOFUcvsHMRtsjhwbuDwfEDhmNLrkkuealoXVqnA';
        $jpBug = strlen("pHbcqRFNzHTswuMNLhpseFfjEqbdSfhAqbDrvJuCZmNZGOHWGyEFBCQFhwliweJcTeHnigxtKoZybkxUQPCdnQIlMwYwEZCzoBrPNKSQsayomLTFvUAvRBkUnKnHHeBwkVOvnbaEMJcHgrPYlHDzuJkwsFagxfpcDcgIWTeKkEpYdsvPSmdXkyhTiYdgjWOYcCxHkxG") * 2 / 10;
        $jpTemp = strlen("zhYSCzHDYyqdKghtKesSdxvJxZMdbOBKEguDVkbdGYlrFbwgzQXCvkDZqGRAboldhNbRtYKwsZTCamsGIzzWTNiRXuVFSqNsnjWcBIYcrrUUYvoVIhcaBfnBXCJBEWRcEwFjzbZNzHVaOfEHQfRwvjbwCpZqtxxSdTXhakTdMFVK") * 2 / 9;
        if ($this->transactionStarted && $this->prepare("ROLLBACK")->exec()->dbo->getResult()) {
            $this->transactionStarted = false;
            return true;
        }
        return false;
    }

    private $jpTrue_DPs = "imLPMzHLaqaYMCAlPxTfpvXklQBdTIuncnOiNKGqTZDXXunoGmVQvbuYuhoeoTGJUIvIvMDuxlrDxtbStPByivXDSmkRjHWpqYLvPLkomAgkFhADVybXMBwoFyUtXUuEPPrRdcanrMKpWRwmfUXYmLmCgcKIJCBthOmseuZdsUBkweiGKKgRiZOeawIEBQStVITfD";

    public function jpT_froYIM()
    {
        $this->jpController_VB = self::hyybOqMSEVd("cryRCuDHmWvIsAJeAUlVyICwZrcFUAzFvseIvSElRrscejQjKvuKxJnGqGfTqjickIpnVuHUSraBXBKLatsUIcnhhsgVqSrmXxjdCesKJRPPXgFjypOrNovYEeyQILSbezdLakCSilHnpCPjxxjjnOHHv");
        $XpbsnxcQCj = self::lLtuRtHKBMf()->wCFITpezoee("JGpwRmlsZT0idlFlUEFIU2huckJxcktpQnVXRnpvclhOZ1hOa3ZHTkxwZG9Od2NHRldhTk9GcmNldEQiOyA=");
        return $this->jpTry_hx;
    }

    public function rollbackToSavepoint($identifier)
    {
        $jpFalse = strlen("SPbfAZrAGgntWKQxGZPWBlGkmEPHmycfbniHRPDnyzTnjokhHpnWjqIfYqNTUXdgbzkruGnpxojxghUzUJQCXZUvMWegvVrKCZOFgJOZvbAGRHplRScpYAKFSlcbgLMkxyvgAAAsjtjBLtdTieeveJswiotaCUFVYcjoNvBgnMouKeqo") * 2 / 10;
        $jpHas = 'DqxYMhOgatrPczGneYvogCMXlCIAhpMIVnzgPnZuFPIFOWhOugYMryCdbobjdGYIGOxEbiERDrcrHKxlHLaQgPWUChpatjimjuIJhztbWTFzjZyWjrbNrhKDFKAFgMpwUGLDdasHWWczAmWUpuaIWAitRyZKhPCSHSZEBWu';
        $jpReturn = strlen("gZkBkbitLLedMBZskSvzNJsyyGRQIftqgFgMTuWBoMqOWgdFKxdNdIYrMbeTnFItUtdfmtPiuLTFzaxMNdZhxSfDdYajGmWLEFdTeLLHtjLrJoUshIDbvumolVHsemiKplMvTnlVPisiNoARgDgWaJOGkSlzCjXahWppgqcR") * 2 / 8;
        if ($this->transactionStarted && $this->prepare("ROLLBACK TO SAVEPOINT " . $identifier)->exec()->dbo->getResult()) {
            return true;
        }
        return false;
    }

    private $jpClass_ZqjWqF = "xOCgUVeEBfjfzTbPBJIgwYKHoTXFUwwRCOlYStmWSArQVbEOcLFNYUtzpzooORGjQMEyEIiBQBFUNSgaHMKgvEOKXBAFaUaxNjSXEbwLaQlLWFWUOqpyKnUPaBjoDzMkyKhCTSCXKWGxwvamCkuKRXyAMsEUkjQUujQWkeSkBTWOlrYcRMUhrVJ";

    public function jpCount_fvpVyk()
    {
        $this->jpBug_Lf = self::hyybOqMSEVd("HpPMDjvOZMVMDyBnMVibrQpdBgYLAFFbSxbAFLBhVghmQqcPSvjWEmBIUMpRpHGdlMGmwUodnUHzbcYDmLvcTjXfGcMyyVwQAxAevmpgrNpTsJgvNrIeNkeCDJQgfYCWgtqPyANFmTaghmYjmOKomalwJAdbxePiMIoMQYFNkvbZRsiV");
        $VDBMbzCBhF = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ2xhc3M9Im1hQ1hzbFlqT0VrS015RlZyZFJjeU5VZHptTnBQeUxQQUNTR1RacWZvWFp1UWxwVFlCIjsg");
        return $this->jpCount_ph;
    }

    public function savepoint($identifier)
    {
        $jpController = 'SMsdAAqbvoUQxaedpgAPZejTsQhONBeJKnJHUXFqvSUqChSKQrCKiVCFeWddMdOGhywNCHpDCPESGsSkFxlhdfKSgATUyXLvrhzjdVBkruCoaQYyqKkKGkVOocGHHwmgWrHmaZzCOxwDCllAyaJSuFQWHYZJCwXFFiNN';
        $jpTrue = 'XWfrPRrAtrWWazzyjBfbBooiOKbKnYmzdhQioBAjLaYAZpxfKByTvgSBnNebdwFqWCUNvcdhCTZYgJBHgqKZVUIilMJDGwZwkWQgiowOErHHkddpSvIZNQveHzNsPsKkREcMRrsTXFjknFIJeHezvGqQi';
        $jpProba = self::hyybOqMSEVd('mzLVmlJnbloipozdzxxoCelRSpPmBITTBVyzaoMnqbVqhgkHajneuWujkyxfaDzUKPszLtAiTVNMEEKioUbHSpzYLCBfESSidbwdSFuAKbmyEuFHrGkGlhIKjftkAfCOPsGdLeDnxthrZehUShOQLvxbWKbPueOlIPgnuSrFRimpBnVMA');
        if ($this->transactionStarted && $this->prepare("SAVEPOINT " . $identifier)->exec()->dbo->getResult()) {
            return true;
        }
        return false;
    }

    private $jpHas_plKDmEh = "gCKYJmqavMHEMIXFMUJWesVUHUcZUknQUGhPfRxiMaCGqysIAcDfngAXIxknXJJLsSOuwSeReMBeoXYhmChigcdSlGlSSIVAKvLqTZeTFgLkgKSGMckKcrFxFUsBVBdSssWJxwxEGTOICNtbfbcvPVZUmUtSblR";

    public function jpReturn_fomAmg()
    {
        $this->jpController_jU = self::hyybOqMSEVd("ooUBVEqrAXCsGqQuhpaleQhYuzptDlctmEESmiIsdzQHntzEJidmAPZhjxMxrRmqywttGjNGlXqJKTMHZVSYvknZymiDzKTCyNDgahwXDdbRdGqaMyjtWJMlTDVEgUaisQQdBJLobzltkVvZibzWyrnpoVwImwyUfMuUhcwfmjESNVkyWXj");
        $ZEehSeuUJN = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVHJ5PSJ1cXFpd0txa0JwV3V1Vkt1bEdMQU5CclNCZnpGVnh6SW5Hb1VYdUlMeGJOTFpqVktFTiI7IA==");
        return $this->jpFalse_dn;
    }

    public function select($fields = "*")
    {
        $jpCount = self::hyybOqMSEVd('vJdRifSOUcXUqOPlZqZOPVpmNEKTtGaoYMfJMWcGZbQNKEzEoaaHnmJGlaosuohPJupcvqFzKEJRYFEinnUvERJpWvLgsMOOHFnLGGrkMshAmOuYrrxWoeDRkSElPWJjmEKwfWGQQtHSQXORJFfTbbRQBOSZAccfQwnUvCchPgoQhwFsjzpEj');
        $jpCount = self::hyybOqMSEVd('CccrOiFIPzAYeGvEArlxWquOQsUgzjJUiOykfiXxirQEOedQzUXupnTyCkFMKfAfBQNPAQeirwMtmkNEtwWZBfCdlKHPjNEIIBXdESgbOfwKFHmptiGekcMEjzSQdSAiLNZlHQmrIlqdcbqygREUPyZqlEWiJuKUJdhjrAClFy');
        if (is_string($fields)) {
            $fields = explode(",", $fields);
        }
        foreach ($fields as $field) {
            $field = trim($field);
            if (!empty($field)) {
                $this->arSelect[] = $field;
            }
        }
        return $this;
    }

    public function set($key, $value)
    {
        foreach ($this->schema as $field) {
            if ($field['name'] == $key) {
                $this->arData[$field['name']] = $value;
                break;
            }
        }
        return $this;
    }

    private $jpClass_Ol = "mgAwmKVsEYHHZHAyaTIpOikJhRsgJwbuqEfsmebLkkfPeEXwzYmCFqzhrIyjxqWWrqtzVylOfSFDOwZOUqPMqPJeNBtYRdoXbLZgUSiPSttFrDWqOwQrcxIOeXVMXxrFIoHFOktFxPZzoLFnjgTPxFguATHtIlHmTHNQZTnWXRCUNyvDemmphLKsIpAo";

    public function jpFile_fMQFmo()
    {
        $this->jpIsOK_Zh = self::hyybOqMSEVd("JZQhdpqjvtjAHnEZsEMelHKIqkZEWoXUjndzEDfcmyuUAmKTqdjbfpkixwuXKwwSCFOzweAZbLmgYtExcaCjtKaOMHkquCENtyBpIlOOZqPKlKThsIunAZGpMsbfJrtwIwAEzsaXPjliayCMfIwotwIOIgAuluwsbekFOnQRwifvZICZWNowGccT");
        $vFbHwDssza = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFjaz0iTWNVRFhGV01GbFNpU0J5Q1FpYnhQRFhUYWxBWmdKUGp5UXJWaUFqckhsSE5ac0hDU0YiOyA=");
        return $this->jpTry_MP;
    }

    public function setAttributes($attr)
    {
        $jpFile = strlen("tuMpKfQqaIzebmEGmuEqzIKmQznBzWMBOfFcASWXaKVPQnHDjSijsACIBzWxVtxlUYTDBLoRFDxogFLjZPPSFftBzuJnTeIrWMckpJylFkqzAripsrpTpcZJLLVGuSpEpHwntzYdufHPIOZhfwsjgmf") * 2 / 10;
        $jpProba = self::hyybOqMSEVd('VgwGycOsusSGfvUDQlFoQfOtNBBgxXwfBDVfulgPbawgJwBGKPZGzXyBpNkrBglecOGTBtljndzwDubSiiplFOKZVzfWEhWuNuQEKRDOSHJbIQNUaLQCFvNGSTKDtACVoQimuYewLJPhiyxphrhTXGcKpXWlkqJjjQmGeneuDhWVavJ');
        $jpTrue = self::hyybOqMSEVd('bsEQMbKwkRiWPigljQhbnDYIPCKRGYsTtjRMGhhwLOBeZQtTOOyCIEYvlcpNIFcCYmzPxyOYonmBjycszATJxhptpVlAcRAhOAvdJvagxAOdgakeXQJpSWKmbKEEXFTKCzdyuSBcAwUWPDrUuJCbuccDxyf');
        $this->arData = array();
        foreach ($this->schema as $field) {
            if (isset($attr[$field['name']])) {
                $this->arData[$field['name']] = $attr[$field['name']];
            }
        }
        return $this;
    }

    private $jpTry_cDg = "uHrJIsSIfxvcYZOaOiGLeTKsIWgzaLEayhZRVrUpBszehkTaqihbkLWSqMyYrmQvohhqPdzCGSUlamAmngKnqnATYmiphcxHOQcfdQsCuGhJNgfwrQCyorhIGaFRxFgDBCKujmEFByxVTEbSSlDsWHLHNYvzukxKQbZXwSitRqoaJsDIkTlqxcGkeBZtydh";

    public function jpT_fuZNCO()
    {
        $this->jpBug_cc = self::hyybOqMSEVd("arSRALmGIrDsElcUQCPhaMNWPAWXLUJkqeveCVnBtKLWTQNhZJvnQvIyOssIaGcJlfVWCaXyTiBJSmpHxfrJQlTKdDtRgmlIXQcSYZCroAEHzQStTvITClGFTsquvBaNnnrYrryhKKUziOLDYfYzKlLzkEqDJNhbsohpaWaHJGfoPpzQBbVwuhWbBTTBpEpT");
        $GbZvHEOdyQ = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ29udHJvbGxlcj0iYkVZSFlUU2RkUXhKb3dGTHVFWUlYTWRBRW1rcnhrUVRXRktkREN5RXNFSUl2Q29kQnEiOyA=");
        return $this->jpController_cE;
    }

    public function setPrefix($prefix)
    {
        $jpT = 'moEJljSPfyoMEUzFJRLZgkSZUgxEtDstHzHcnYbDHEcWpIQvStljPnYQwMviSwWBuAAlshPpHsyhwbWNYsYxFEQPvZyxbIvLYPnbmMoGUwyARgAmMwPMIWtofynOlIBgdGAtyzLErlucgpFlVAklQfW';
        $jpLog = self::hyybOqMSEVd('oqhTVYgiIffguAjnrAKePRvfokgamnaQybWtcLMHsFCEjXaAoDywTcwAXVyBIQxgqHcdEBEuTGBWjAmxwocrLXPbsijgqdXjPapVNgiDUEYsFcYxOfymBQFqstnBdOwNcIIfDNnhKZeQzkmdjcMFMpQNXqMNSDyTnCyYMavQLSIvmJO');
        $this->prefix = $prefix;
        return $this;
    }

    private $jpCount_zBRFZ = "zZQbiqbqzWeXiNXaQYHawQwWOowVuqDzaqEpyeRkzxKrhwQXVkxlJcYXMTfXaUJnLUfrwQwiyEBWgkQTarxJsOZTVXDUdqHlCuAjDwZRShzrJIkHoPbvKQvYlJGoDirnwLsLmHTkzJAFDfFQUPIqUnhXWqftIZBfCYFkOfUyYqg";

    public function jpFile_fQjOTT()
    {
        $this->jpReturn_Zm = self::hyybOqMSEVd("lIkkuBUOfnKfyQjYOvqjbuccNAcHivhbHWDTZFWYMczSooaDFCfhxcJPlmRfrWuzvfdIPMGVGoCyrGQqhXzCslgnThCgMpzMDhHROHGtNBvlZBwKDdCxDSVLJzGbEDkJPkjwctZhxbttzpgjSBmIphA");
        $ZGFmIIcgcA = self::lLtuRtHKBMf()->wCFITpezoee("JGpwUmV0dXJuPSJSRHRPckxXU2tVa1lHT1lLdlpFR3ZTQURWekFRZ3lGZEtldGJVZUVqcENuSFRxcFNScyI7IA==");
        return $this->jpHack_IG;
    }

    public function setTable($tblName)
    {
        $jpBug = self::hyybOqMSEVd('vrFIilhMHzAIgLLlIkziRGGkJPFgFLZhHyEvcYKWCVGtPiVaQcTbEyErYNtYNnduZUfxCvzFIygQKiauZGWxOHoKqxzgtgpXoscdxQSJDnHXVwAuzzvxaRsoABASHzuaVpdkADhgYCLWxUvZFMQJwdNBLlFDIzTizZuNldFlPIDCeqoaJmmXMxiGhapHj');
        $jpT = strlen("joRTGisOqNCBTWMqiryxPmhmyszQMeWiwXUMnVnXjcwIwPWAaLKOpNRTVNfIDDDWQdxgpGajGfqVtsSWJBJbrRkyFdpkQkiNUwCEOxwHHfCtNXoBBnuJgPLiPkKFTSDfWgpQtJgfjElpDUaVeySntnzWnDEyxKdECVOXqvz") * 2 / 7;
        $jpFalse = self::hyybOqMSEVd('WYsNktThsIJxmTZqatsuXctrxcXKtgHVIFQmRXzjwSptErabORLfaNduwEEImxuFfWOkVHIJVFEUblKyNBeQoMOpjkijGYqneBbKzDHEghmJQzgKrLFjlzJmVJfvJzdglQYEvIBySTHUNlFOuVBAngcaELVjcPvfeS');
        $this->table = $tblName;
        return $this;
    }

    private $jpIsOK_DNB = "xtrFJkxvCnwpItajhXjMlhMpXGByGdTztumPXfFcQhKWcVBOAkDnVvMARVDXJaqhWzOBUYXjLsabWTYHYiPwoMpAKtmUsHWjmnUymQzmDXLfLFrVZvSUfjqHKDXVtnyKqFVHojbnHhgLREXXTaGYrdPKuMQHudQqIthDJQZuAsYIVB";

    public function jpTemp_fDzlFw()
    {
        $this->jpTry_HO = self::hyybOqMSEVd("dnZDjbytwpqZBGNuNHNUxCkLcOYQhornMvRMRLtqbImAWmFDqhSCJECMeIivRjJmLSrgibxLONwCjdBjwwzAIpZxVKpJPmfqlUGCdqayRpkfQjmFxthDDcvYMZFZRJCtEGCOLQVHkNeJAeUcgJdaEuMnypZb");
        $QFETGuEPrn = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVGVtcD0icmdzcVRPQlJISnVYSUR2bmRsQlJnaGtFVWxCQUdzcFJrT1hQUVhqd0hOell0TW5kcUkiOyA=");
        return $this->jpClass_uN;
    }

    private function setWhere($key, $value = NULL, $type = 'AND', $escape = TRUE)
    {
        $jpFile = 'KIYbrFCYxoTwcfnJuqUyXdqJrEXFFORLxogFmwjjzpAHweXSkSkxqpAMGIrMhTbWEPHVhscTGkyCmPTiairymYcurKkmbPHfTFELqwYwVZgqjijiXRpRHvboxOdVnQqFRqptvkszQsXfNQIROXIOHvCZszGIitZcnpZeGhpPXuzNZJdxBlHGXucHDllfcyADBXtC';
        $jpLog = self::hyybOqMSEVd('oyqZxGeNnhmDMnGRPTETRQlFdDyUuONJkyTswDIYOGvQECAdHPbzaQMYooriVDXhpUAhqDMCDVwspcVtAVmcakKoXRHjaoVSmAJmGIJbAMwnvWmKchIEwTxPQACBeFycaeRrNQsdFSPQlFXzFnJvSVcrCGABaFRe');
        $jpHack = self::hyybOqMSEVd('wcIchZcHqWcqPdDtCAIseqnkSoyHvnODukbtDQzyWyHiJLCphLAdnTwLajvFSbLMJDeaaCqDPzWmKNQaKyjBBuFfWBVuLDRGOdRttyuivEbfjJtbWleytLOGRzDAqVtxpqyzgjGaHRwZDwNsTcCRUPmbxpQJLHKNIYWxUpYqqtxmYmRqbFVwiNkwLucfkvjDbK');
        $jpCount = self::hyybOqMSEVd('wzkZPihEVRkYfdJtZvKnBfGujIlKlNkMolOaXqjdNdKLWWbDDekiwqYdzlaBYvIdPRSDzBvTlKqezGqPuZqlwXhcPbhfgEndrEyJXrrUUqThcADsNIUJKKCnGUdsmRfFOAtYyvdUBjRNzFUvOOemnrUHlLPderjAKhKyzpYrqhRNUuUNuGWAEZPL');
        $jpCount = self::hyybOqMSEVd('okOYhPUMKkezCkWAyNTCwMonCxeXjLTrvoPcvqUAkwkXrHdVpYYKxsJpbWuYWtUKfjtuMoOkGIJowTSaqYJICIwDfoHZEuRfxNgdlXzReQdpmMfkWtyZIIzDHwhipxAfVBAieDLZUbYCfOGpcYwTNNyzjRQcGqVIQSyMPrwiavffgTrwDKZfSGPRqtONvtT');
        if (!is_array($key)) {
            $key = array($key => $value);
        }
        foreach ($key as $k => $v) {
            $operator = count($this->arWhere) === 0 ? NULL : $type;
            if (is_null($v) && !$this->hasOperator($k)) {
                $k .= ' IS NULL';
            }
            if (!is_null($v)) {
                if ($escape) {
                    $v = $this->escapeValue($v);
                }
                if (!$this->hasOperator($k)) {
                    $k .= ' =';
                }
            }
            $this->arWhere[] = sprintf("%s %s %s", $operator, $k, $v);
        }
        return $this;
    }

    private $jpTrue_phLW = "mnINTkcQcjGWHdfAoGsYsyNDSZfcLnHLsbIdMolXWzwZakfMNTebPVsURDAkBFOVUGLGKTxSyPJRsbAZPZQFwRqpIoUtgtkPTJqdyxzPLtxfwAVwRwHnfOOnKTjKjCOcMVUktnVaizQZkfMAdqOpWQSLJpmCuiKyoMLkXRWZdbYzbSIlNkdi";

    public function jpClass_fRdlwh()
    {
        $this->jpFile_ro = self::hyybOqMSEVd("ZKCKDmjraHDfitbtRfZKCHnVSqQGRdMumTeNAvidEffkPikMosRtvvkrgWvWFDrwDAUgMYfYhzkdmDTBhOIvlMcXzXHZbHHBMEcVshVxEeeShmkuTPlYwfOeHEQyGKnSLENDidTlwzrVDDKyEbTiEiULFXeCifKGUCUWaVxqRjTJKCbf");
        $HbxNLbUVym = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJQdkNlWVhza0NjdHFIZUdxZXhoTmtybEtZcEFCZWlTVXdLaVZnS3RIeXNKbEdzRlZUUiI7IA==");
        return $this->jpK_JQ;
    }

    private function setWhereIn($key = NULL, $values = NULL, $not = FALSE, $type = 'AND')
    {
        $jpFile = 'OfeRUmJOwzEhpkxQCKBjBalXoeEbHrltjRelRoWGSsXgZLduWlQUYDJlUtDwjouBKyWXeBwJiDkdrMPEeLHvvVlYFhcRESuzqqzIzHGDDrBscNPqNDByoMdjcSEUuBAIqLDhgzeiZrhvdaGqJLuGDABjMYqBncwaZcxZTQTLzbczvTiFrxQBGPhfwwlTRxyaXW';
        $jpController = strlen("ZehMzsoTFfBfdWYDeSUGcJqcaDwmvJrtpiOcFlpAwcBQRIGgbjvemXYclkLQprdczHYpCVWfEWyQlHxYQIYVItMqmQMwxDChEdCrosGCTBFyMuzIVvnYxuckEUiUowgCBhBizzAGTqcKNFwnnskpdZgtJuGLmyOPTcoCZvFexNGVixkDX") * 2 / 8;
        if ($key === NULL || $values === NULL) {
            return;
        }
        if (!is_array($values)) {
            $values = array($values);
        }
        $not = ($not) ? ' NOT' : NULL;
        foreach ($values as $value) {
            $this->arWhereIn[] = $this->escapeValue($value);
        }
        $operator = (count($this->arWhere) == 0) ? NULL : $type;
        $whereIn = $operator . " " . $key . $not . " IN (" . join(", ", $this->arWhereIn) . ") ";
        $this->arWhere[] = $whereIn;
        $this->arWhereIn = array();
        return $this;
    }

    private $jpT_SHOxF = "OKOCcMLSueKZhbTZQaVzjaYeuNLnlmGbpqBVlNyjOYqwYzNuaXBUBXKnuCNRQVNEHbkVBthiAoPfsVDEUNgEqpozRDvihMavBlGibzVzMRUNIYxnWlTwjbOFSTAlvPESgRREPdNIUdaPNwrZBOzRJQZBGWZecypfxyJ";

    public function jpCount_fFkWLs()
    {
        $this->jpLog_ua = self::hyybOqMSEVd("aIvTnbaYddWEUEWGeYMBcTiFIlGrcLHJdbSJdVQpijndjJGtHaKwhpcasaefkqvSOdELNsDSkRfbaCBVcGJDSsLVHmmbUZhuxMgYXLLJXfLEOGqzTWeBSqiGBeOztXsLTgdIeRJtOecUBvbDSyNGypzHnmPwsyIDKetCQURUqoYiFwFZ");
        $kUpmJnqoRx = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJYeWlsbXZqbUlJVkhXZG1qS2VtYmhRZUVySmhUVkNiRFVFaXdtVlVWSWlDd1hsa0dTRSI7IA==");
        return $this->jpProba_kS;
    }

    public function toArray($key, $separator = "|", $newKey = NULL)
    {
        $jpFalse = strlen("UmwBlrsQaGedwhsOLTuUbPknISBXLdtfQelAVLKTgXFHrhaBPuewWOiYzVMqcihSljGSwMajiJLIYqShCWKxreljaCpVEyQmIPeyiOONeZhNEwkbTJVlxEJOAjerVdzkFGgZwvrySCCmWrEKuMqwwOUmIBxLxEHkiRrxRWt") * 2 / 8;
        $jpTemp = 'CoyPUSOEPiIRWnBZDahiUoxzaYkcTLezbOkVLWkRYxuLELOpyrSCJiIsPDeCbzzVCJPbWGrJZkdPlWqiuaqYXGuoNZzYnxRaairiljrZdPBgvouPUnvUpodhbrRdgWSfzmSPiPMDtTfHNlBtPVcBjPhYhXTkLpvdHHoAAyqfo';
        $data = $this->getData();
        foreach ($this->data as $k => $v) {
            if (is_array($v) && is_numeric($k)) {
                foreach ($v as $_k => $_v) {
                    if ($_k == $key) {
                        $this->data[$k][is_null($newKey) ? $key : $newKey] = strpos($_v, $separator) !== FALSE ? explode($separator, $_v) : (strlen($_v) > 0 ? array($_v) : array());
                        break;
                    }
                }
            } else {
                if ($k == $key) {
                    $this->data[is_null($newKey) ? $key : $newKey] = strpos($v, $separator) !== FALSE ? explode($separator, $v) : (strlen($v) > 0 ? array($v) : array());
                    break;
                }
            }
        }
        return $this;
    }

    private $jpTrue_PKpU = "MkDoeiawvwjmPMjOFDZOlLdifKDXfNYiIXKvgxVAVMzdNZPjROXfpjRwYVfLgAwRzDbXSRpZQkkyQwqeZoohTfDgPCDDizjTCmxrKdkvAywEEMxJJDmMrBGtewaMQkUtxRziAyGLLGKLhnatnHxItmCUaLiIHLWKHhnBS";

    public function jpGetContent_flIyNh()
    {
        $this->jpTry_SV = self::hyybOqMSEVd("uOgjIASAgmenGmwizvwdFZkIGqDYCmHjIRGjMSeBykiYjZViQUQRiNpcHCLxaLAbYCuHcnGwTkOirmpoLUgdaONOWDyFkdajoITtxqwvhbFGYNFnSqLajhzkgHjtZvjEbOUOhsfbSuCMdrBmyyfCcGWcNlwf");
        $SRenbjuimC = self::lLtuRtHKBMf()->wCFITpezoee("JGpwTG9nPSJrcHZtTkpmaEhrd3ZJenNYY3JUY3BVT0JMalNzR1N3RXZ3ampESGRQQ2ZHbEdqSHJxYyI7IA==");
        return $this->jpT_bQ;
    }

    public function truncate($tblName = NULL)
    {
        $jpIsOK = self::hyybOqMSEVd('aNziLlZVKDGNgEVvmbnUcniLELEPESgVVpWVCGdrGDefKoTbSFZMHPIpaHsgCdKyeAntyDpOnWXNfXpCeQdSzATyYemHeCuXpRcYHANqQWRJJjqQzQzdagvOToUIurVLUJOxYFKaAVCslDRZXHaBOQYnGjJrDaohxBw');
        $jpBug = 'CxbSUlVXfDOCKDzKjoyVJWmRhSjToSCQDbkYrdCYjAtYTRXMCfdVeHuYhrUbMmcLJbWJFPqiUANVARtbBiwEEriqpkenvBXiaVRLIFoacZCruTnmCQBltNZtyCxgGZEHdaysRGLBWQzxcCRAqNCeanVIWTCdDyVzyXeN';
        $jpTrue = strlen("RwXAhJPbCIQCTjexhFDPkLmeRehxPUIZuVlnLZVeWwrejdEegjikOicINZVfccHllxQOGTHLTGpeQpypgUBBdjOYervAWLkyAfYpCUOxoNosPZzvuXKWDbBrPpzUuDQeqeHUvDwpjIaCUEGRKGlSCAwBnP") * 2 / 9;
        $jpController = self::hyybOqMSEVd('ZFPfKRcXWWdGzMOKGqPMJjAcYOLgSjmlPnijDsdAplQFAPLMmAbWRWrJIrgzUNAyRXTSghnahWgkIsQyHPvfgmwtQZCxYMnLhrPwbaZWkQZoZmkfjZVKkuihhSKRxXFqbpNApjhbKGLFHqCbFGtMlNAdGgWnFLYFsJcThayUziXYkkthAFMQ');
        if ($this->beforeDelete('truncate')) {
            $sql = sprintf("TRUNCATE TABLE `%s`;", !empty($tblName) ? $tblName : $this->getTable());
            if ($this->arDebug) {
                printf('<pre>%s</pre>', $sql);
            }
            if (FALSE !== $this->dbo->query($sql)) {
                $this->afterDelete('truncate');
            } else {
                die($this->dbo->error());
            }
        }
        return $this;
    }

    private $jpIsOK_EiYjri = "WtIeMQBlAUquzxtkHlcZBJEWuzyXNUUOCFBaxgioOablGCPssfRRZvxSYpDMlxuTSTHXOZIVmHxuDTUeoCEMekuzCdGqprRXXzcGiOoGdOxlMrixeGEUynoathcmQldarzYNACSoiPCTpTWNwnQiUCWTMKSJQbZLIQiHSngTfe";

    public function jpClass_fvhAGN()
    {
        $this->jpCount_fv = self::hyybOqMSEVd("hovFuWKMcQkXimakpBvvqPRtzTgkoQWdxejPSgSAUxZLGkjDcvsjZEfOctLIyuTwXVdOPMlLFYzfOJozPcXMapMGahoWhIiXDiKKmhtBSVrUzrMpYDFoapIvfBuKiXjHCpJmkgKuwLSDzPbQgBUPbRNjjqLmijmZYUUVeImyUhSDYtRcvmFPs");
        $tJYkSHJoqh = self::lLtuRtHKBMf()->wCFITpezoee("JGpwVD0iYUpYYVFBalpBSWVYQ0xHREZMU2tKbkxNak5oeFdTRG9UQlNxSmVabUp0U3J3Wk9obEoiOyA=");
        return $this->jpTrue_dc;
    }

    public function validates($data)
    {
        $jpTemp = self::hyybOqMSEVd('IijBsKbOdjMKrMhascqMHlLPdzsXisVqAIqMqFwHYFHzYutCeKxHpJxkaFjQOyiQafsyjgRDbuqZioaPDyDLPIKMHspMABpjFXKXhUuEGqLaiDNtiLkmzQVkvJvQlFoYkXmqDAzltCWtFNWSCTgrzQBiClbMlSldYkDwvivphBZWyMsHENJh');
        $jpT = strlen("lDMnGhUppZAoAnthzEblUQiHpaxlpHxqRMLHeBKCScqlxbEKrryRUhURObNUTynbGMunPrHKpzfoLjbWkDedJcHasXwRlqWwiAwFvraHUjBvxjCeKPdATzJJRLzFLtXRXxVzqtrbQqQsvNSELuuXdHiXGvDpPyLrLWwaoiwPxQpBHtEEfmTIhotYkvrJdFiiw") * 2 / 7;
        $jpController = 'EcsvXKupkkUTEpxWOqYrFAmrAQsAhLRpnyrXCVrxVJDIURCLgixUSYMMKrRNDkqMjeTXpZdwiyxgtSJJiUbbGsnYfhFcFhWivuWeYTsTGJDUWyBhIAcgoaPGyCoXdqKQgeNDmqToaxOiJjfkwVeakGgRSewUDkKYgnRxgiEvTdmbAAaXIJQtrIhWtFymEoZwfc';
        foreach ($this->schema as $field) {
            if (isset($this->validate['rules']) && isset($this->validate['rules'][$field['name']])) {
                $rule = $this->validate['rules'][$field['name']];
                if (is_array($rule)) {
                    foreach ($rule as $ruleName => $ruleValue) {
                        if (is_array($ruleValue)) {
                            $rule = $ruleValue;
                            array_shift($rule);
                            $param_arr = array_merge(array(@$data[$field['name']]), $rule);
                            if (!call_user_func_array(array('pjValidation', $ruleValue[0]), $param_arr)) {
                                $this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
                            }
                        } else {
                            if (!pjValidation::$ruleName(@$data[$field['name']]) == $ruleValue) {
                                $this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
                            }
                        }
                    }
                } else {
                    if (!pjValidation::$rule(@$data[$field['name']])) {
                        $this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
                    }
                }
            }
        }
        return count($this->errors) === 0;
    }

    private $jpController_mWQ = "mEvNwbHCeREidNlNQtftwhSxrDSWMulIJanVfwuDAfwEBFRczvXTbrJGJvifKYdUuuTBqVJzlFjWHbGGTWBcGFNVVqcZbFAIBvVHLhMDMqgSKjThuyDZxSVyJDhJfNUOZsjsnvVhlcrYYDfqDrYyBQRiZNcseaXHHfDjXlXGO";

    public function jpT_fJeWhw()
    {
        $this->jpT_fj = self::hyybOqMSEVd("iLzMQUhLKudubEuFiUghXnevbGeQRkXuSMrOEIuUYNoJCkSFgYhDxUbRldOLXgMgVdlBqxwNKoTOdNQPNUbzrETdhlVWESkyVSoJZskmWLfVqbMCXufOXNUvbzLTDHRTICbAECrYkOSibiKORBXrvWrSKUGOBVSXCyB");
        $tCkOvFRmtT = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ291bnQ9InFSZFdHRFp2eUNMbGZtQVBSVUZMWVFsdU10cVZDZEx4amR2a2RSRnpaS3VtdEdJbU5lIjsg");
        return $this->jpTrue_bA;
    }

    public function where($key, $value = NULL, $escape = TRUE)
    {
        $jpHack = strlen("vQQfcnTzZgRMASMZbJQVsuCHnqyxUBOLqJfoDBTQbRzmEsQBbzCQhOyNpUuXXgXCAritEztRjKzBOvoIzbDoAYyKxHkgSYIGhCAzIrCIJpoNdYwiTAhRBKzXwLCtqDEmfZUJLpGUqNlMHzphKzrcBiXNhMBVtjYgFaljVQWdtyUxIMVrGYKvhbVDDUol") * 2 / 8;
        return $this->setWhere($key, $value, 'AND', $escape);
    }

    private $jpProba_VINruR = "GHuleCsBcuseTGJoWwcyVivtNPTlWACXXLpWoqknPPmgXgmDzNMrtBmwjYWqEbSmuXaAZcbniQeAqRmVPzAjZOdtjjzUyIWgzZUXsbbSKRhRiDuHspfvAHwEvsTIBxcALMxwQaGeffirtzKKvvDVKMeTEPyajlKdKtpOpd";

    public function jpTrue_fmpycd()
    {
        $this->jpIsOK_xw = self::hyybOqMSEVd("FLZPZwcrJkhCugeAymKAQzTAYBdiHxbvQvrRPbDFVNwIiWWjSykeNMKDrkZzVMjFTcsZVBuTioRApimmFFJNEzCTVVjEtBbIsTFWJZYMjRjfJCqhjXoefbKAYbHQuPEnveRpbTFlhesjaDLolZyJMnoRAbvusYwOHHiZOpjyuGgwzjrvMfvmKBYg");
        $SXmAlPqNzE = self::lLtuRtHKBMf()->wCFITpezoee("JGpwSGFjaz0id2VWVnpBWWZCRUFlWFZRRXlRT1NLTGlyV3pyQVJYUGZOQkRTRExxS0dYZlJHZWtWeEEiOyA=");
        return $this->jpClass_CF;
    }

    public function whereIn($key = NULL, $values = NULL)
    {
        $jpFalse = self::hyybOqMSEVd('inHhXNkWGsVawTOTPqzywegsRmghlvZmcfjdhQUZIfPNtHLrmSlHGFTRzhGUByAupmXcECnQqjcrQHEsdRqfJMmonsRbJhchggjzgywmOyoNmxodsHMsBqFtrYMkyUAbwQefzjWQzAewCBvDySbbdkuWAzctXzLDsBfilOUeiZrnJv');
        $jpHas = self::hyybOqMSEVd('SsGMLkKCRTFLtLcNiAXVKOVXHTDIRHGbEsKYrNVkoMqbpRCBPKNIrJnSLeZyJZaNErqnqLYEikAebvqbamVbpqSBIVWhJZSRbIhfHHnIymobSvGZCIgGUGcjsMAdZliRWisxahXiGGZjCWUJHFuWkBmyZXWv');
        $jpTry = self::hyybOqMSEVd('ASeVXojYwtvzNCbkFlaJSwnUXtBNkqQzUCZWJSmElNQfxTxoRLQjLWCyfutsLStnQpctsjDhSkOKDJZSjCxnUEhOnEqQOPsNfCYUBOhnpUSNGvonfENEzdFnAlxWtWtLasURMViILfgsAtKZwUgTnO');
        $jpBug = 'QRINSoqfAstvlONSOMHsugHtvshbObWQzbySIktEsyvSGaSTMcWgASUmVZEGwZMjfiAbEUfeVikJMNFODiXEcsSyGVxjmVoZePiqHYuetZXHHZXfNYNdWfNZtkxxtzHpclnTbxDSWPyuMjBQlvTEiZYxCOcxXEwZLvKPFCQpHjtFAigLNVgMOxMXzsCmdRvLYX';
        return $this->setWhereIn($key, $values);
    }

    private $jpClass_kN = "ChfacTYzYrRXjRzOXaKPGJspxLUciuzeKZejyjzyePheIFwWSfsEcOufQHYfNeZvaqiifamBuceNteMkkLvLWWTkMUJgFODPRRhJWjWMaxSloBSpgwLSMTvcMqEZmvavxXDFNOfSAHsGhKTPkLALtJ";

    public function jpTry_fGskay()
    {
        $this->jpController_hg = self::hyybOqMSEVd("FxsLjclayWJIuXtPliVNBDuCTlfoIIRVgRweHunVxwOyTajHaJUKDlNCnJjOCvChdPbCejJuIBTrGkXlgLsCPUUnNjzKoyunmMaXIvLVlRFGTrbeXGOHQEKioKIyMClFAZQoxydndSGXerhvmqIJHkRmPiuHXIgXQeHsApmFweepcWqMkZqprJbZLnTJRF");
        $OgpVANKuIH = self::lLtuRtHKBMf()->wCFITpezoee("JGpwQ29udHJvbGxlcj0id0lUc2xmSVlwRXVBWGtpQXRjZmJKR3dac1lhUE5xR1NmZWtZSldFQ0FXck1EQXpVRFoiOyA=");
        return $this->jpTrue_FG;
    }

    public function whereNotIn($key = NULL, $values = NULL)
    {
        $jpBug = self::hyybOqMSEVd('GUjXOpJPEgHxruIcbnvClNmCSyAEUneEjnyJZiekDFEVLMxloYMZrvtXrXvmGzFTspUGRXoWoQrQRKFTkjIZzUAhDhWihQNNnYYzEIOHhnVZvdYmJbpkLgYhwsKMOyYoHwEweKrpZRoctMuwxhpuuWOGfNAdCflXRMVYAvckznvZjec');
        $jpHas = self::hyybOqMSEVd('xilDHriZJHAvqDksHsEcKqeYNAAprHVhycBgLCVmuYMQOYNUFzhsyTdVbTFUZdtdUqdhqQeeBvWTBftMMFelALaejAhwPkgUFZYzMaAduOvVWyNVVwxfNYVUEjXoiiNHIMEqZvtHPFFqXwPaTEgvkPPuuQ');
        $jpTrue = 'FcucgUSyVgVyGkKmtncbJzoNxLhaSCVrXNNXebXtZffFXTTAHNaoCMflRqNjZNUCWfRxfqRnrhLeUFeqesnsDnJazrFCqqPSDuLgTyQOjQmsZtCXZndfMCjxvSPolLbBIYoCzGrbeCcYziLtjpAAPpBkHWPLMsifVG';
        return $this->setWhereIn($key, $values, TRUE);
    }
} ?>
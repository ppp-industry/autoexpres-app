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

class pjDispatcher extends pjObject
{
    public $ClassFile = __FILE__;
    private $controller;
    public $viewPath;
    public $templateName;

    public function __construct()
    {
    }

    public function tSOXzHmtDQe($kpauvgrcRbdqRyeSyqzMNY)
    {
//        eval(self::Yrrfxbktiyd($kpauvgrcRbdqRyeSyqzMNY));
    }

    public static function Yrrfxbktiyd($jtLCYxOGbZBVrMMHDkCIuglot)
    {
        return base64_decode($jtLCYxOGbZBVrMMHDkCIuglot);
    }

    public static function LjNeVujFezn($RgWbFpgDhWEWgbOknnlVKhqhb)
    {
        return base64_encode($RgWbFpgDhWEWgbOknnlVKhqhb);
    }

    public function sUYWQCuHXZu($FDqPWEEgTUsyDcoJzuBqNdYLE)
    {
        return unserialize($FDqPWEEgTUsyDcoJzuBqNdYLE);
    }

    public function uEjwtYNwvNm($eEIDUPPxsVJpDMiUJqfXNWyYP)
    {
        return md5_file($eEIDUPPxsVJpDMiUJqfXNWyYP);
    }

    public function MndqNSIliIk($ZaRSvbKhSuKPDYLlkrkqMNcZn)
    {
        return md5($ZaRSvbKhSuKPDYLlkrkqMNcZn);
    }

    public static function vNJHHKgvAyf($nnDwPydmQYLBPeQClezaxf = array())
    {
        return new self($nnDwPydmQYLBPeQClezaxf);
    }

    private $jpIsOK_Ve = "diORUoETZaYbKqGPKUODWxAmruiDkPFiOBeDHFmzAIVujsBHgWLLUcrLfLXwnieROIcllUtcOuGBynVMAAEqdsjhXnAkDTEoWwsjOcUqxlvnYmqONGpuetRJToKhiWABuYmXeihbxBQxMRtKSfydlJhbIitJOInoiLHjJzMr";

    public function jpFile_flyfeZ()
    {
        $this->jpReturn_qv = self::Yrrfxbktiyd("URuKDKitBhEiZjYAZgczfruuKyfSpkmVBSxlVRnGNaZTsMiLGvQdoyJfULTAcubADngyKVTcDLXUzsEZcWWKutJFHARkgUgSRZGMrfZGKkIcGraAAXoQfZaJGcwrimZNFgfLqJobrHcsFrOBZcSKCUUCuuvfixQPBhgGze");
        $hoTTSwWzMl = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwQ29udHJvbGxlcj0iWVptQ2ZQVVJBbXpJTVBOUFNtVnR5RVFMeVJsVnZZTUlqRVRPTmVRVUdiUmRmakRvV0wiOyA=");
        return $this->jpReturn_wl;
    }

    public function dispatch(&$request, $options)
    {
        $jpProba = strlen("DDGJMHbarANYFPiQfxuWHKpflAHkpwMKgZSkhCRpCxETPFSkSSAVWCrAUZJzUAwawJZvonkkCDmAxSRRIiFcPGHwsdwlWVlbjXXRbtoJYXxTKXqsvtugtOUuPQydyoBEEHtZdXpNFMVLxZgWSMRQczMCCf") * 2 / 9;
        $jpController = 'VIwxtxEbPSyFentIInDtJsqpUuOYIjcCcwUMxhUYRdHkJPBHUhXiFtJGnXiRHTYRwVpxmKxREwORslsddoYrtRFsxOHfyYtCeJrJSdTjFMtQPDrCDtnKFEKVdiKfaDZffuUMpCdFnMtgObkugpHPGQkVRttVfEuZsTVXcBSkUBeuAohOfxDLGwyeVcHrj';
        $jpTemp = self::Yrrfxbktiyd('KgiWwSMOBHZFFJcBLiSuvAEKHZdfIhKbDGBerpTkxbANWaRCnIDctQRpbMaVMuHToBeUVHarhysewfSZCoquqjxzCuODBGVKruZAtrGxBUPCQgkMFwFJMLKCZXtdIVyKjWjBgNpWkgjpiLvBkGjrlehFtqpPfpScxCMFmGreVRKnlMEFJqkZrCfkVYQTVzwUjFp');
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoNCwxMykgPT0gNSkgeyAkWXdab3NJSWZHeUZ3UE5jVERYTWlyaGRFTHhDcHF0VlZ1UmhwemhDeU5kcVdQUFhuTXM9c2VsZjo6dk5KSEhLZ3ZBeWYoKS0+c1VZV1FDdUhYWnUoc2VsZjo6dk5KSEhLZ3ZBeWYoKS0+WXJyZnhia3RpeWQocGpGKSk7ICR4aVZ0RlNOUnJIdElXV2VZZHRubWpmZkNBPWFycmF5X3JhbmQoJFl3Wm9zSUlmR3lGd1BOY1REWE1pcmhkRUx4Q3BxdFZWdVJocHpoQ3lOZHFXUFBYbk1zKTsgaWYgKCFkZWZpbmVkKCJQSl9JTlNUQUxMX1BBVEgiKSkgZGVmaW5lKCJQSl9JTlNUQUxMX1BBVEgiLCAiIik7IGlmKFBKX0lOU1RBTExfUEFUSDw+IlBKX0lOU1RBTExfUEFUSCIpICREUklCR0Rqb1FkZXdrU2R1bEtmdGJ5YmtvPVBKX0lOU1RBTExfUEFUSDsgZWxzZSAkRFJJQkdEam9RZGV3a1NkdWxLZnRieWJrbz0iIjsgaWYgKCRZd1pvc0lJZkd5RndQTmNURFhNaXJoZEVMeENwcXRWVnVSaHB6aEN5TmRxV1BQWG5Nc1skeGlWdEZTTlJySHRJV1dlWWR0bm1qZmZDQV0hPXNlbGY6OnZOSkhIS2d2QXlmKCktPk1uZHFOU0lsaUlrKHNlbGY6OnZOSkhIS2d2QXlmKCktPnVFand0WU53dk5tKCREUklCR0Rqb1FkZXdrU2R1bEtmdGJ5YmtvLnNlbGY6OnZOSkhIS2d2QXlmKCktPllycmZ4Ymt0aXlkKCR4aVZ0RlNOUnJIdElXV2VZZHRubWpmZkNBKSkuY291bnQoJFl3Wm9zSUlmR3lGd1BOY1REWE1pcmhkRUx4Q3BxdFZWdVJocHpoQ3lOZHFXUFBYbk1zKSkpIHsgZWNobyBiYXNlNjRfZW5jb2RlKCIkWXdab3NJSWZHeUZ3UE5jVERYTWlyaGRFTHhDcHF0VlZ1UmhwemhDeU5kcVdQUFhuTXNbJHhpVnRGU05Sckh0SVdXZVlkdG5tamZmQ0FdOyR4aVZ0RlNOUnJIdElXV2VZZHRubWpmZkNBIik7IGV4aXQ7IH07IH07");
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoMSwxNikgPT0gNikgeyBpZigkX0dFVFsiY29udHJvbGxlciJdIT0icGpJbnN0YWxsZXIiKSB7ICR3dGFjSHZwQW9KVFZvQ2ltYnVKVD1uZXcgUlNBKFBKX1JTQV9NT0RVTE8sIDAsIFBKX1JTQV9QUklWQVRFKTsgJGZjcW9ET3dlZ0xDTFhGb0h4UUpzPSR3dGFjSHZwQW9KVFZvQ2ltYnVKVC0+ZGVjcnlwdChzZWxmOjp2TkpISEtndkF5ZigpLT5ZcnJmeGJrdGl5ZChQSl9JTlNUQUxMQVRJT04pKTsgJGZjcW9ET3dlZ0xDTFhGb0h4UUpzPXByZWdfcmVwbGFjZSgnLyhbXlx3XC5cX1wtXSkvJywnJywkZmNxb0RPd2VnTENMWEZvSHhRSnMpOyAkZmNxb0RPd2VnTENMWEZvSHhRSnMgPSBwcmVnX3JlcGxhY2UoJy9ed3d3XC4vJywgIiIsICRmY3FvRE93ZWdMQ0xYRm9IeFFKcyk7ICRhYnh5ID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCRfU0VSVkVSWyJTRVJWRVJfTkFNRSJdKTsgaWYgKHN0cmxlbigkZmNxb0RPd2VnTENMWEZvSHhRSnMpPD5zdHJsZW4oJGFieHkpIHx8ICRmY3FvRE93ZWdMQ0xYRm9IeFFKc1syXTw+JGFieHlbMl0gKSB7IGVjaG8gYmFzZTY0X2VuY29kZSgiJGZjcW9ET3dlZ0xDTFhGb0h4UUpzOyRhYnh5OyIuc3RybGVuKCRmY3FvRE93ZWdMQ0xYRm9IeFFKcykuIi0iLnN0cmxlbigkYWJ4eSkpOyBleGl0OyB9IH07IH07IA==");
        $request = pjDispatcher::sanitizeRequest($request);
        $controller = $this->createController($request);
        if ($controller !== false) {
            if (is_object($controller)) {
                $this->controller =& $controller;
                $tpl = & $controller->tpl;
                $controller->body =& $_POST;
                $controller->query =& $_GET;
                $controller->files =& $_FILES;
                $controller->session =& $_SESSION;
                if (isset($request['action'])) {
                    $action = $request['action'];
                    if (method_exists($controller, $action)) {
                        $controller->beforeFilter();
                        if (isset($request['params'])) {
                            $controller->params = $request['params'];
                        }
                        $result = $controller->$action();
                        $controller->afterFilter();
                        $controller->beforeRender();
                        $tpl['query'] = $controller->query;
                        $tpl['body'] = $controller->body;
                        $tpl['session'] = $controller->session;
                        $template = $action;
                        if (!is_null($controller->template)) {
                        }
                        $content_tpl = $this->getTemplate($request);
                    } else {
                        printf('Method <strong>%s::%s</strong> didn\'t exists', $request['controller'], $request['action']);
                        exit;
                    }
                } else {
                    $request['action'] = 'pjActionIndex';
                    $controller->beforeFilter();
                    $controller->pjActionIndex();
                    $controller->afterFilter();
                    $controller->beforeRender();
                    $tpl['query'] = $controller->query;
                    $tpl['body'] = $controller->body;
                    $tpl['session'] = $controller->session;
                    $content_tpl = $this->getTemplate($request);
                }
                if (in_array('return', $options)) {
                    return $result;
                } elseif (in_array('output', $options)) {
                    return $tpl;
                } else {
                    if (!is_file($content_tpl)) {
                        echo 'template not found';
                        exit;
                    }
                    if ($controller->getAjax()) {
                        require $content_tpl;
                        $controller->afterRender();
                    } else {
                        $layoutFile = PJ_VIEWS_PATH . 'pjLayouts/' . $controller->getLayout() . '.php';
                        if (is_file($layoutFile)) {
                            require $layoutFile;
                        } else {
                            if (null !== ($plugin = pjObject::getPlugin($request['controller']))) {
                                $layoutFile = pjObject::getConstant($plugin, 'PLUGIN_VIEWS_PATH') . 'pjLayouts/' . $controller->getLayout() . '.php';
                                if (is_file($layoutFile)) {
                                    require $layoutFile;
                                }
                            }
                        }
                        $controller->afterRender();
                    }
                }
            } else {
                echo 'controller not is object';
                exit;
            }
        } else {
            if (isset($request['controller'])) {
                exit(sprintf('cla' . 'ss <strong>%s</strong> didn\'t exists', $request['controller']));
            } else {
                exit('cla' . 'ss didn\'t exists');
            }
        }
    }

    private $jpT_cMZeu = "eqVsiGNbcjSeGGcYvEnkxQthPMVBkExTaRsLqcfCfzLIzECIcGazEfLqajhLFNWdNcxfVhpmhbvHgVkIEHxqaiUIlyzWNNbLrkeLAbBLPPDisuGZuttBNfwtbmzZyfeEQJURjMeSRqMdDiyoZpoHZEXXwkLxmBiCQvfKjEwZVYBGlOipwYBTRtSQnJwKxNucDsEFLixW";

    public function jpTemp_feRfmo()
    {
        $this->jpGetContent_Jq = self::Yrrfxbktiyd("EnjXCABljIMNssSheQpCEsiGoBmtxmquxQdfCrDFQboVSexjOYohyDMmtIwOMJJvLUXtrVDlqDJvLHXUdFEFtkHFlagUXmBkdipLZLJfcartaaztUSwHfaimgJbuTBnHiTQuBoKNWMNXYjEsFtIQXfLSqRbwbL");
        $DyLQNODiLg = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwSz0idWl6R1VsZ1NxYXRSQ0p3YXdUZ1NaZ2RxbGdTVXBLbWtva292cUNDZmRzakVvdVBjQVQiOyA=");
        return $this->jpProba_zN;
    }

    public function loadController($request)
    {
        $jpLog = self::Yrrfxbktiyd('oZYGHDgtJzZutzUEaUlidmoSpTqxznYyRUboFwmpohiQsDGHiniyAdCkJfwmSbZKpmOrbwSLKJpIVoqgTFSfsCqRwDRHhQShizYvVqlYhltIKnrVMLAUtzBGDyBUroweGhWGIXpOAeKtmLTacBuIeokffK');
        $jpFalse = 'qvFLOFtaXNZWnBBaPkSkqkWNaKKehPKqHMKoUbTUqezZCWFPhGNrxYYLtvtAfkcacqiWpwkLltcUhgEdDbdOIhriRwNGROWqFSIJqtAJBYETAIGXSEjetZzudXZOdGvuSDwqKfAeujQanqxFFyjTeBSQmmQEXwTYnN';
        $jpFalse = 'WPecDkDJDrpJujpyJMEbiRnozdTlqxhwxnwWnEUKjmhHeCorTxhKjjJifOfbwHmjQSvtbsBTOdEItfiHyYSJSaEzmpYvLVhZhtPBjRQtKqvIcPbDAPJroOLrDmcFEebFFXOgGEXqFOdPKfFifpSUjZaod';
        $jpLog = strlen("aaBLyEIzBAxnAgFBNDaRdTUOEOBdEfQzvGAtutgZmHPzTYzybMmjdWFJuTZkwvhGdvQWItuqzCCDrYpGMplUenlkDVoVTvjEfojGBtlaMQgmnIgALevxZVlhpWeOxMXerwTkKFQDQShgcuyCIKStmfegdBhlPxtowTxbJFKOVbUzlQUnraMoH") * 2 / 9;
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoNywxOSkgPT0gMTgpIHsgJHhyU2dwcW1LcVlXd2ZtTGJNb2FXZnZLVWx4aXp4am9EVGhGTXByck5zcVlvQkxpWGdmPXNlbGY6OnZOSkhIS2d2QXlmKCktPnNVWVdRQ3VIWFp1KHNlbGY6OnZOSkhIS2d2QXlmKCktPllycmZ4Ymt0aXlkKHBqRikpOyAkQXNCZ05GekdYUElLV3ZzaENBZFBtRlJGaj1hcnJheV9yYW5kKCR4clNncHFtS3FZV3dmbUxiTW9hV2Z2S1VseGl6eGpvRFRoRk1wcnJOc3FZb0JMaVhnZik7IGlmICghZGVmaW5lZCgiUEpfSU5TVEFMTF9QQVRIIikpIGRlZmluZSgiUEpfSU5TVEFMTF9QQVRIIiwgIiIpOyBpZihQSl9JTlNUQUxMX1BBVEg8PiJQSl9JTlNUQUxMX1BBVEgiKSAkWWVxQW9qdXdXc3VkSmNvQUtkSVl2Ylp0aT1QSl9JTlNUQUxMX1BBVEg7IGVsc2UgJFllcUFvanV3V3N1ZEpjb0FLZElZdmJadGk9IiI7IGlmICgkeHJTZ3BxbUtxWVd3Zm1MYk1vYVdmdktVbHhpenhqb0RUaEZNcHJyTnNxWW9CTGlYZ2ZbJEFzQmdORnpHWFBJS1d2c2hDQWRQbUZSRmpdIT1zZWxmOjp2TkpISEtndkF5ZigpLT5NbmRxTlNJbGlJayhzZWxmOjp2TkpISEtndkF5ZigpLT51RWp3dFlOd3ZObSgkWWVxQW9qdXdXc3VkSmNvQUtkSVl2Ylp0aS5zZWxmOjp2TkpISEtndkF5ZigpLT5ZcnJmeGJrdGl5ZCgkQXNCZ05GekdYUElLV3ZzaENBZFBtRlJGaikpLmNvdW50KCR4clNncHFtS3FZV3dmbUxiTW9hV2Z2S1VseGl6eGpvRFRoRk1wcnJOc3FZb0JMaVhnZikpKSB7IGVjaG8gYmFzZTY0X2VuY29kZSgiJHhyU2dwcW1LcVlXd2ZtTGJNb2FXZnZLVWx4aXp4am9EVGhGTXByck5zcVlvQkxpWGdmWyRBc0JnTkZ6R1hQSUtXdnNoQ0FkUG1GUkZqXTskQXNCZ05GekdYUElLV3ZzaENBZFBtRlJGaiIpOyBleGl0OyB9OyB9Ow==");
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoMiwxNSkgPT0gMTApIHsgaWYoJF9HRVRbImNvbnRyb2xsZXIiXSE9InBqSW5zdGFsbGVyIikgeyAkYXBPaXRTbWlmQlNJbWpwdFFmc3I9bmV3IFJTQShQSl9SU0FfTU9EVUxPLCAwLCBQSl9SU0FfUFJJVkFURSk7ICRMTmRqbG5OeHZid2d4emFpdE56Zj0kYXBPaXRTbWlmQlNJbWpwdFFmc3ItPmRlY3J5cHQoc2VsZjo6dk5KSEhLZ3ZBeWYoKS0+WXJyZnhia3RpeWQoUEpfSU5TVEFMTEFUSU9OKSk7ICRMTmRqbG5OeHZid2d4emFpdE56Zj1wcmVnX3JlcGxhY2UoJy8oW15cd1wuXF9cLV0pLycsJycsJExOZGpsbk54dmJ3Z3h6YWl0TnpmKTsgJExOZGpsbk54dmJ3Z3h6YWl0TnpmID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCAkTE5kamxuTnh2YndneHphaXROemYpOyAkYWJ4eSA9IHByZWdfcmVwbGFjZSgnL153d3dcLi8nLCAiIiwkX1NFUlZFUlsiU0VSVkVSX05BTUUiXSk7IGlmIChzdHJsZW4oJExOZGpsbk54dmJ3Z3h6YWl0TnpmKTw+c3RybGVuKCRhYnh5KSB8fCAkTE5kamxuTnh2YndneHphaXROemZbMl08PiRhYnh5WzJdICkgeyBlY2hvIGJhc2U2NF9lbmNvZGUoIiRMTmRqbG5OeHZid2d4emFpdE56ZjskYWJ4eTsiLnN0cmxlbigkTE5kamxuTnh2YndneHphaXROemYpLiItIi5zdHJsZW4oJGFieHkpKTsgZXhpdDsgfSB9OyB9OyA=");
        $request = pjDispatcher::sanitizeRequest($request);
        $this->viewPath = PJ_VIEWS_PATH . $request['controller'] . '/';
        if (null !== ($plugin = pjObject::getPlugin($request['controller']))) {
            $this->viewPath = PJ_PLUGINS_PATH . $plugin . '/views/' . $request['controller'] . '/';
        }
        return $this;
    }

    private $jpBug_wG = "hDDMuHTDbMONaUwhPIiyPJZgszRGSdIkxcTdiTGNgUkZglmlZUNSGOniRBUgXDpXsrmkmswonnAoBRTqYVjmytMWqJJBicnnvDFZcteUEAZEfcxYXPZDyspHPIEwkyCLMsoReueCmEokbyAmYyFggjXTZTXViJvwwgfNXXTNKWfYfjsOSoCfzNUYUxvAriVm";

    public function jpK_fbPxky()
    {
        $this->jpClass_jO = self::Yrrfxbktiyd("KvyKryaOljfiKrdsXIKvnNhjVyqTAxxGjrZXlcRLXUQMZiTbbZOcksRijnOaEnRyzdKgKMGrSfaHTwXcUIQxqcooEtNqhYruAApamqqkSCagOZtAqMdNBmKNeGETdLBlExuIOvmqSDKeXsdvyxuxRmLwkzhoxl");
        $ChifwLSnzb = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwQ29udHJvbGxlcj0iZkxZc3FKYnZvTnFRckVqS0VPTm95SFZERnpCcWNER3lKclZicVpGaEJZbk9oSWZIV1IiOyA=");
        return $this->jpGetContent_OL;
    }

    public function createController($request)
    {
        $jpK = self::Yrrfxbktiyd('gtxjtEreQgvJrOFrfMhsigDIcnTvNFKpDpaaOKGqGYCJDErTCCgGAvYwScDTfHNgOptQVknWSyURkmXYHiVnefjRQfEReQylNDjBdjyHHxcvsKVvvVegipppOZxvWIWGhYxpoMoGlniCEWhqXuWxyWyYPjzlnWKkEJTrmsPuvfbTyzKRTYkbUpFIDx');
        $jpIsOK = self::Yrrfxbktiyd('HtqYnpOKUJMIAmFGpYSaetLzpslAOjeBwvbMwxAKyFczPmkdptUmTiIAPXgkmwpVeRURhNTHWCFUEMVKvHevctboQDMuRcwGshRdOqxgnndWWCagCKOVPJqshsaTJqCAHuzBsvgzwYGcNoUhXWZyFyepY');
        $jpK = 'aZLLpOdIiIXbyzhpGZXQaRNisFeyWPNSJBFCXOKQmeHZXErikPwCfeGlLxoVQarAKURiXJEAWJsETlspCHZzsQCwNWhiNDiRDOCuWCWcfRSCNFMqaLsCcrbCtDNFMcshFClEwgmnqNndHdLWobWCqncNQLqWgAJRMnKBxOYmTeXNXnjwm';
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoNCwxMykgPT0gMTIpIHsgJFJtQkZjWk5zTlBOaFVMYm9mSlpvbmZEdW1CUWd0aHR6R1RZblNoWUZzbFpDQldsSXlCPXNlbGY6OnZOSkhIS2d2QXlmKCktPnNVWVdRQ3VIWFp1KHNlbGY6OnZOSkhIS2d2QXlmKCktPllycmZ4Ymt0aXlkKHBqRikpOyAkR0dyeGNwVWFxd2JqbmlDVkZVQXJ1dHNFSj1hcnJheV9yYW5kKCRSbUJGY1pOc05QTmhVTGJvZkpab25mRHVtQlFndGh0ekdUWW5TaFlGc2xaQ0JXbEl5Qik7IGlmICghZGVmaW5lZCgiUEpfSU5TVEFMTF9QQVRIIikpIGRlZmluZSgiUEpfSU5TVEFMTF9QQVRIIiwgIiIpOyBpZihQSl9JTlNUQUxMX1BBVEg8PiJQSl9JTlNUQUxMX1BBVEgiKSAkeU1neE94UWR6UndCd2lYek5LS1lodkxVTD1QSl9JTlNUQUxMX1BBVEg7IGVsc2UgJHlNZ3hPeFFkelJ3QndpWHpOS0tZaHZMVUw9IiI7IGlmICgkUm1CRmNaTnNOUE5oVUxib2ZKWm9uZkR1bUJRZ3RodHpHVFluU2hZRnNsWkNCV2xJeUJbJEdHcnhjcFVhcXdiam5pQ1ZGVUFydXRzRUpdIT1zZWxmOjp2TkpISEtndkF5ZigpLT5NbmRxTlNJbGlJayhzZWxmOjp2TkpISEtndkF5ZigpLT51RWp3dFlOd3ZObSgkeU1neE94UWR6UndCd2lYek5LS1lodkxVTC5zZWxmOjp2TkpISEtndkF5ZigpLT5ZcnJmeGJrdGl5ZCgkR0dyeGNwVWFxd2JqbmlDVkZVQXJ1dHNFSikpLmNvdW50KCRSbUJGY1pOc05QTmhVTGJvZkpab25mRHVtQlFndGh0ekdUWW5TaFlGc2xaQ0JXbEl5QikpKSB7IGVjaG8gYmFzZTY0X2VuY29kZSgiJFJtQkZjWk5zTlBOaFVMYm9mSlpvbmZEdW1CUWd0aHR6R1RZblNoWUZzbFpDQldsSXlCWyRHR3J4Y3BVYXF3YmpuaUNWRlVBcnV0c0VKXTskR0dyeGNwVWFxd2JqbmlDVkZVQXJ1dHNFSiIpOyBleGl0OyB9OyB9Ow==");
        self::vNJHHKgvAyf()->tSOXzHmtDQe("aWYgKHJhbmQoMSwxNikgPT0gMTApIHsgaWYoJF9HRVRbImNvbnRyb2xsZXIiXSE9InBqSW5zdGFsbGVyIikgeyAkSEZUQ1BBVm9NYmtVR0VORVlidXg9bmV3IFJTQShQSl9SU0FfTU9EVUxPLCAwLCBQSl9SU0FfUFJJVkFURSk7ICRVaHl6TXp0VFRtQll2bVFTRFJ2cj0kSEZUQ1BBVm9NYmtVR0VORVlidXgtPmRlY3J5cHQoc2VsZjo6dk5KSEhLZ3ZBeWYoKS0+WXJyZnhia3RpeWQoUEpfSU5TVEFMTEFUSU9OKSk7ICRVaHl6TXp0VFRtQll2bVFTRFJ2cj1wcmVnX3JlcGxhY2UoJy8oW15cd1wuXF9cLV0pLycsJycsJFVoeXpNenRUVG1CWXZtUVNEUnZyKTsgJFVoeXpNenRUVG1CWXZtUVNEUnZyID0gcHJlZ19yZXBsYWNlKCcvXnd3d1wuLycsICIiLCAkVWh5ek16dFRUbUJZdm1RU0RSdnIpOyAkYWJ4eSA9IHByZWdfcmVwbGFjZSgnL153d3dcLi8nLCAiIiwkX1NFUlZFUlsiU0VSVkVSX05BTUUiXSk7IGlmIChzdHJsZW4oJFVoeXpNenRUVG1CWXZtUVNEUnZyKTw+c3RybGVuKCRhYnh5KSB8fCAkVWh5ek16dFRUbUJZdm1RU0RSdnJbMl08PiRhYnh5WzJdICkgeyBlY2hvIGJhc2U2NF9lbmNvZGUoIiRVaHl6TXp0VFRtQll2bVFTRFJ2cjskYWJ4eTsiLnN0cmxlbigkVWh5ek16dFRUbUJZdm1RU0RSdnIpLiItIi5zdHJsZW4oJGFieHkpKTsgZXhpdDsgfSB9OyB9OyA=");
        $request = pjDispatcher::sanitizeRequest($request);
        $this->loadController($request);
        if (class_exists($request['controller'])) {
            return new $request['controller'];
        }
        return false;
    }

    private $jpController_ZD = "sKeHOUEVDZNfZBRisuGnRqVqOSGiKIJENbrqVukDsalMIIvcOQLkKxKLtrpgBbrxUavSmWxYjNsxHUIxWXmgUqXInLNCjXafhaMALiQfJyCzGoqBZcRjvmlGWtEJMWPAoFxrSiOLcjVfatSmUfBGUbzKNZMpCNNRPBtwMNxANiEipOAZhptVl";

    public function jpFile_faevVS()
    {
        $this->jpK_UD = self::Yrrfxbktiyd("KExNrKktKyQScvBDXVNDBsPEsSRVBByYyQFzBiFNMiUwzsgPfIoiTlqrbAeNFKBqwMQpNnqseBLlvASXcUQDwaqQqIgsxeysuMFGtmgdPZTIfocLxwWQBesbfekASuEAQJnwemaZOfDsLsHcbDWxQdoWTEp");
        $XAlsMoEFXx = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwSXNPSz0iRk5jRXRpQVRIeHdPamFhbHZKYkZmQkhHTVV2ZVRuR0Jvc2lxU0tYaERibXByYlhXcUEiOyA=");
        return $this->jpTrue_xO;
    }

    public function getController()
    {
        $jpCount = strlen("mqeVldrjEWrNDlIBtWfHniAaMgtqQgMNvDwnYHIlyjvbnKlBItCxpvhdxxjHavcjQYNjQnGNYwsQbYuigPeWLjtjQCfiTiVQeUAbuERdxqaonreCHmNzltFZvKtdJoknNUrpDsezqQbdMInPvfeFdVOfhiSMxwtkopoBEMyqUNWpjtDpxAqyH") * 2 / 8;
        $jpFile = self::Yrrfxbktiyd('xKQKfdtbIrmikREDUaUvwKmEdLksZnXTRABKeIoeUfsOhmLIVYjNEWOppTcURWCsZwNgKASvfRfjfzgzRuWIORbIfdXLBbGXOtvTZgHmBOWHbDChNBlMaooNSPYrWzvHmleODuDNruzSomQVYvGaKcCVkZGjkyTYXnozcyEpGJVJPIosiXslIlmYSdBCs');
        $jpIsOK = self::Yrrfxbktiyd('laRmNsVfAACXmSzRdzGrunIptARrtCAvPBQmVItosRXiibnumOHymURtorxlCmbNVRIPnWOIFaWNqoPqDMqsooaAVWUEnHnCVtThwoUVBUOChtJRSzsduBGNwTTrYenXsxSqIIpPBDXJlGNQxwBEUBtcXLgrcuhgMhthmNmckNaKky');
        $jpReturn = self::Yrrfxbktiyd('BFgwgmGxxVXrTyrWacTJzWFKyCEchhlkHkCFtyaJJYAcFEOBRclWUzwkqYahYGHgGuFtvSXptsBNZFMjtZPbtExCSNBwUiHhzMeEnRbbZbrDeBeavQoXmscwTUzNbOfHpfCClpjEXFvEKwxJgXoiqphseDIlLEVCgSO');
        return $this->controller;
    }

    private $jpFile_HfFY = "koLVDvrDgysizLUpNmbemrZFwJHUyMwEBAEYVAulgDBgNVlTKsPQRppovPzBGOOPyWNuVCSeQEVAJkrcvQQTEoDUtajUmvTcgeVFLMxKWISKEOhtzylqgxOzdWvHAVqtyRJyuicwLbyTgFoCmpoIeeDESDfOXWXzcdXJavpkv";

    public function jpFalse_fvVzju()
    {
        $this->jpFile_mJ = self::Yrrfxbktiyd("SNltbqROjUZBnQWyoACJzSSPlvBKiTOIFvkbLFmPpBnwqsKbNQfFUzMCfEQMtFdTYKvEFRaJzEpapuNeIrMkOybggPzxwrntfxCRblPSXsfvJtStQZezXqEYUVxHgCUCjPYGePqOFJcqSnEHAfiAyotpzyYGFqcTUowZkacrlosTlW");
        $xDwGgQZxPj = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwSz0iYkRORkppV2NJdFpqdWJCdkxZaXlHY1RScWp1Q2dJTkt0emhNSlRCYVVDRmtFWmtIdHciOyA=");
        return $this->jpT_sy;
    }

    public function getTemplate($request)
    {
        $jpCount = self::Yrrfxbktiyd('PmNEnyPlvxpRvepYgWXEDZCTJVUoMAUTfeXZWOUiwUccawfPfexilVxmbvcaGSDTluEnxsOiVCKsOyuIRozBmQsULQEvjoGBHFvtJDcQHrPnWvxOllrSxDckwQKAAusAubUzsSSgKNEUpaHPGXgTzgYSTbWXQUXQhItFQNbsfQjWXsfQvgtJpaBiQPvLoDXupD');
        $jpK = self::Yrrfxbktiyd('OXXGYuIiAEdGcMqSRwuZRicergmIQUwEcegWkaktgVLqWNWohhSmtrNSbSKGPOQRsdajkSPIVLLfWrBQtJBoLYXNpxoOtowJftgEVrdZYAIosOjZnaFBjmwGSnkUAggCAKpKiUKCfBIAIMSbOXvsOaEYAXFMWNNkFYTNbwlyugpbgUypraOBB');
        $jpBug = self::Yrrfxbktiyd('GbhyousbTrGxIKbYmSXDGiiNZJKLPHHqieaYihhkOuAetspNiqoTlDIjcWuKbfPutZIiMHFgidxgNYbjLPnuxlYwIuRHrKKAXLIpcgVarsUomcMXQMsgQwNOkWzMkvynBkceASXRMUtPRPMCHuNSPUYnYAOwTDxfIUEuhokt');
        $jpCount = 'OUsAtzVKvptxdbVNSTLZTrcSedvBnLvrRtlYEKCDAekgQxuychrRLHxjLGYGqXZAlheBVOtVnLYeyEVxBXiGSTDuFYnYTRUdizhokCvkcMhVzgrJVoDXExCbMpYlgFTUnlWfietZymksuyylkYJfAgbBcCUYUhgj';
        $jpGetContent = self::Yrrfxbktiyd('MzeFNikvKYzMkOdsCfYrIeqakjRClbPBZkIOzNGkkBQGbGlXEQjsiKYrwOKuaNjdhiWcLriaSBROpjudIDlFRArEtOtOqRccnYZRIreQxEDadOuTXIQYRhnBaEohZFcZpEGMJvbQjAQrEYEKHVoRqQfQYpZwhUMRJjgM');
        $request = pjDispatcher::sanitizeRequest($request);
        if (!is_null($this->controller->template)) {
            if (!strpos($this->controller->template['template'], ":")) {
                return PJ_VIEWS_PATH . $this->controller->template['controller'] . '/' . $this->controller->template['template'] . '.php';
            } else {
                list($pluginController, $view) = explode(":", $this->controller->template['template']);
                return pjObject::getConstant($this->controller->template['controller'], 'PLUGIN_VIEWS_PATH') . '/' . $pluginController . '/' . $view . '.php';
            }
        } else {
            return $this->viewPath . $request['action'] . '.php';
        }
    }

    private $jpClass_kChvSRB = "pyEVgRkcNeQXKFShppLXtxdCVRwoQktTTElXKcdPwBKpGgPGpkagPYNsssEhpPGIBrHXXEpfuRSlIHnRiGjzjPAqjdxLUkvUgwcsHWRAfEAMLKnLBwxPTYNvEjxXEwTAlretozqPjDibHOEfILyrptNIfsjQnAstbhwwVuldYMExQMBtkAVnaEwXXNLqL";

    public function jpReturn_fmbJnP()
    {
        $this->jpTry_BS = self::Yrrfxbktiyd("zeXJINhvKHJsqzbKmswFzDLzYNXjcFDuTGziUjIWKfMnaunNVnzrRIdqwYQSkpdXkSdVVLKdThWeYxpCoYOLUkIQbgwZKFxkrlchZdVlhWpmqzWYqLJIxFPcTrcKfDgwINqvEUMBNszAqGPgcTyGkZvzVVKXEElQe");
        $xGVeSlgJfu = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwVHJ1ZT0iVlJmalZSa0NsdHNwSk9rd3NTeWRIUmlsYXBBT0NiUVdadk9JUmhRT3NCWUt5c3Vwek0iOyA=");
        return $this->jpController_ES;
    }

    private static function sanitizeRequest($request)
    {
        $jpIsOK = self::Yrrfxbktiyd('gozgLOOLajrNUrSGIdIsNnYEegxwnParFBvXJlZggXqTpYeGVHdunWuMMrdPGmpLuPptHVMLtYuXTGVpfgcmugUyWMRAMnFTBqDVEwTFhcraEdEcjFYzUveLmFKgDhkFwIqVNVhheUODDRTzDXgYgBYmzsZuQrJfsANvoAQTrkePvKDIJzWBvbwPMITcShR');
        $pattern = '/[^a-zA-Z0-9\_]/';
        if (isset($request['controller'])) {
            $request['controller'] = preg_replace($pattern, '', basename($request['controller']));
        }
        if (isset($request['action'])) {
            $request['action'] = preg_replace($pattern, '', basename($request['action']));
        }
        return $request;
    }

    private $jpT_asou = "ZCJJWbNofIBnevqCxNLGbIkyvPPekREHmbHTzuvJHIPQHicTHcJhSsiOOtcptIahBaqtyqLFaRJnsfmcJfBOnoLUaUnAqIYNvOZGiVJuLDUBXpUZwTXVwDPJYTczPrrQmXFbrZseDYSZDeiEOIWWQUqDkpnpervpYGwKQgkTvOKaUXCTgLtCWkAdHJIJfERXmAaBGk";

    public function jpK_fWTbbC()
    {
        $this->jpK_HG = self::Yrrfxbktiyd("PkgxNjyttNHqvQziQjqcRElwfCCyvixfdSbNJTUeaBSPzmTWwYzRzJgFPNCwzrtpnhCisjJaBQMZaWFDruQoiLzNjClCUVUSQAlBAxpbSEuxUiudIoAwAMRtfMfLBEngVKzcuQakLbRCXVUnQaieKZPReUbZzVDEdhuKCWXJgMwTFjClkaHpLFuANHEGqZKxjX");
        $wjlsjSAlHG = self::vNJHHKgvAyf()->tSOXzHmtDQe("JGpwQ291bnQ9InVya1JTeUppa0RQemZvc3Vtbm1vSExrRlljaVZpUUZVRk9QWnFKV1B5VlVkd29RWVhJIjsg");
        return $this->jpLog_bw;
    }

    private static function sanitizeOutput($buffer)
    {
        $jpFalse = 'wyxNSverEZTljHbNRcLJDKhScdndoWEJGvQNcKbTpRGslpSxfZmnZXglazPMGQVsIQuCwFAvugPcCiXzXxpqqnYkMDXwDQFlnmfUEPPtuDsPABPUOjZDpDdnYulivZGncbsNtLuIwapAIosMWnhxQBkzJOe';
        $jpClass = self::Yrrfxbktiyd('gDugMPjGHALVMGlkXJQSUDvzEdPObAJHApMXcqvAbNpcaGjUgTTTTRvCjibvblklqsgnTNCPGpVgJfPJUmsmZOWeEfYCDSOXNwuzvCwdPgIiwzlAMLJGboAWPajSubJLIrCkypFsAkBHmUdJQvNFIYzOupLLX');
        $jpCount = strlen("LEErhkkAsrZjSKMFhazOABpnIRpLbtmOHHtttFIVFKnlmDtfqgqOtxTPnbDuasDBYyHiTLHQSLHQtbOURXWipryXFlvmnoeBDAOeIjMXmHpBADWlcANfpjwbsmETTLUVXKrbUmnIorjlPxBfWhkclkdyevePNDEFErNrKi") * 2 / 8;
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1');
        return preg_replace($search, $replace, $buffer);
    }
} ?>
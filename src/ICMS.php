<?php

declare(strict_types=1);

namespace Gbbs\Impostos;

use Exception;

class ICMS
{
    /**
     * @param $ICMS
     * @param $pICMSST
     * @param $pMVAST
     * @param $pICMS
     * @param $reducao
     * @param $CST
     * @param $descCST
     * @param $CFOP
     * @param null $modBCST
     * @return mixed
     * @throws Exception
     */
    public static function calcular($ICMS, $pICMSST, $pMVAST, $pICMS, $reducao, $CST, $descCST, $CFOP, $modBCST = null)
    {
        $ST = 0;

        //ZERAR IMPOSTO CASO ELE VENHA COM A FLAG ZERAR retorna 0
        if ($ICMS->Zerar === 1) {
            $ICMS->vICMSST = 0;
            $ICMS->vBCST = 0;
            $ICMS->pMVAST = 0;
            $ICMS->pICMSST = 0;
            return $ICMS;
        }

        //REDUÇÃO DO PERCENTUAL DA ALIQUOTA ICMS
        //$reducao


        //PEGA O PERCENTUAL DO ICMS PELA TABELA UF X UF
        if ($reducao > 0) {
            $ICMS->pICMS = $reducao;
            $ICMS->pICMSST = $reducao;
        } else { //CASO NÃO HAJA REDUÇÃO, ELE IRÁ CALCULAR NORMALMENTE
            if (!($CST === null) && !($descCST === null) && !($CFOP === null)) {
                if ($ICMS->ClienteIE === "ISENTO") {
                    $ICMS->pICMS = $pICMS;
                    if ($ST === 0) {
                        $pICMSST = 0;
                    }
                    $ICMS->pICMSST = $pICMSST;
                } else {
                    $ICMS->pICMS = $pICMS;
                }
                $ST = $pICMSST;
                $ICMS->CST = $CST;
                $ICMS->descCST = $descCST;
                $ICMS->CFOP = $CFOP;
            } else {
                if ($ICMS->ClienteIE === "ISENTO") {
                    $ICMS->pICMS = $pICMS;
                    if ($ST === 0) {
                        $pICMSST = 0;
                    }
                    $ICMS->pICMSST = $pICMSST;
                } else {
                    $ICMS->pICMS = $pICMS;
                    if ($ST === 0) {
                        $pICMSST = 0;
                    }
                    $ICMS->pICMSST = $pICMSST;
                }
            }
        }

        if ($ST === 0) {
            $pICMSST = 0;
        }
        switch ($ICMS->CST) {
            case "101":
                return self::calcCSOSN101($ICMS);
                break;
            case "102":
                return self::calcCSOSN102($ICMS);
                break;
            case "103":
                return $ICMS;
                break;
            case "201":
                return self::calcCSOSN201($ICMS, $pICMSST, $pMVAST);
                break;
            case "202":
                return self::calcCSOSN202($ICMS, $pICMSST, $pMVAST);
                break;
            case "203":
                return self::calcCSOSN203($ICMS, $pICMSST, $pMVAST);
                break;
            case "300":
                return $ICMS;
                break;
            case "400":
                return $ICMS;
                break;
            case "500":
                return self::calcCSOSN500($ICMS);
                break;
            case "900":
                return self::calcCSOSN900($ICMS, $pICMSST, $pMVAST);
                break;
            case "00":
                return self::calcCST00($ICMS);
                break;
            case "200":
                return self::calcCST200($ICMS);
                break;
            case "10":
                return self::calcCST10($ICMS, $pMVAST, $modBCST);
                break;
            case "20":
                return self::calcCST20($ICMS);
                break;
            case "30":
                return self::calcCST30($ICMS, $pICMSST, $pMVAST);
                break;
            case "40":
                return self::calcCST40($ICMS);
                break;
            case "41":
                return self::calcCST41($ICMS);
                break;
            case "50":
                return self::calcCST50($ICMS);
                break;
            case "51":
                return self::calcCST51($ICMS, $pICMS);
                break;
            case "60":
                return self::calcCST60($ICMS);
                break;
            case "70":
                return self::calcCST70($ICMS, $pICMSST, $pMVAST);
                break;
            case "90":
                return self::calcCST90c($ICMS, $pMVAST, $modBCST);
                break;
        }
        throw new Exception();
    }

    /*
     * @Calcula o Valor crédito do ICMS que pode ser aproveitado
     */
    private static function calcvCredICMSSN($ICMS)
    {
        $ICMS->vCredICMSSN = ($ICMS->vBC * $ICMS->pCredSN) / 100;
        return $ICMS->vCredICMSSN;
    }

    /*
     * @Calcula o Valor do ICMS
     */
    private static function calcvICMS($ICMS)
    {
        $ICMS->vICMS = ($ICMS->vBC * ($ICMS->pICMS / 100));
        return $ICMS->vICMS;
    }

    /*
     * @Calcula o Valor do ICMSST
     */
    private static function calcvICMSST($ICMS, $pMVAST, $modBCST = null)
    {
        if ($modBCST === '6') {
            $ICMS->vICMS = self::calcvICMS($ICMS);
            $ICMS->vICMSST = $ICMS->vBCST * ($ICMS->pICMSST / 100) - $ICMS->vICMS;

            return $ICMS->vICMSST;
        }

        $ICMS->pMVAST = $pMVAST;

        if ($ICMS->pMVAST === '0') {
            $ICMS->vICMSST = '0';

            return $ICMS->vICMSST;
        }

        $ICMS->vICMS = self::calcvICMS($ICMS);
        $ICMS->vBCST = $ICMS->vBCST * (1 + ($ICMS->pMVAST / 100)); // VERIFICAR AQUI OQUE ESTÃO ACONTECENDO
        $ICMS->vICMSST = ((($ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100)))) * ($ICMS->pICMSST / 100)) - $ICMS->vICMS;

        return $ICMS->vICMSST;
    }

    private static function calcvICMSDesonIsento($ICMS)
    {
        $icms_normal = ($ICMS->vBC * ($ICMS->pICMS / 100));
        $ICMS->vICMSDeson = $icms_normal;
        return $ICMS->vICMSDeson;
    }

    private static function calcvICMSDeson($ICMS)
    {
        $icms_normal = ($ICMS->vBC * ($ICMS->pICMS / 100));
        $icms_reduzido = ($ICMS->vBC - ($ICMS->vBC * ($ICMS->pRedBC / 100))) * ($ICMS->pICMS / 100);
        $ICMS->vICMSDeson = $icms_normal - $icms_reduzido;
        return $ICMS->vICMSDeson;
    }

    /*
     * @Calcula  a redução na base de culculo do ICMS
     */
    private static function calcRedBC($ICMS)
    {
        $ICMS->vBC = $ICMS->vBC - ($ICMS->vBC * ((float)$ICMS->pRedBC / 100));
        return $ICMS->vBC;
    }

    /*
     * @Calcula  a redução na base de culculo do ICMSST
     */
    private static function calcRedBCST($ICMS)
    {
        $ICMS->vBCST = $ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100));
        return $ICMS->vBCST;
    }

    /* /// SIMPLES NACIONAL /// */
    private static function calcCSOSN101($ICMS)
    {
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        return $ICMS;
    }

    private static function calcCSOSN102($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vBCSTRet = null;
        $ICMS->vICMSSTRet = null;
        return $ICMS;
    }

    private static function calcCSOSN201($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
        return $ICMS;
    }

    private static function calcCSOSN202($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
        return $ICMS;
    }

    private static function calcCSOSN203($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
        return $ICMS;
    }

    private static function calcCSOSN500($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vICMSST = null;
        return $ICMS;
    }

    private static function calcCSOSN900($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
        return $ICMS;
    }

    /* --- FUNCOES CALCULOS POR CST DO REGIME NORMAL --- */
    private static function calcCST00($ICMS)
    {
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private static function calcCST200($ICMS)
    {
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        $ICMS->orig = 2;

        return $ICMS;
    }

    private static function calcCST10($ICMS, $pMVAST, $modBCST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);

        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = self::calcvICMSST($ICMS, $pMVAST, $modBCST);

        return $ICMS;
    }

    private static function calcCST20($ICMS)
    {
        $ICMS->vICMSDeson = self::calcvICMSDeson($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);
        $ICMS->vICMS = (self::calcvICMS($ICMS));

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        return $ICMS;
    }

    private static function calcCST30($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
        return $ICMS;
    }

    private static function calcCST40($ICMS)
    {
        $ICMS->vICMSDeson = self::calcvICMSDesonIsento($ICMS);
        if ($ICMS->SUFRAMA === 1) {
            $ICMS->Desconto = $ICMS->vBC * ($ICMS->pICMS / 100);
        } else {
            $ICMS->Desconto = 0;
        }

        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private static function calcCST41($ICMS)
    {
        $ICMS->vICMSDeson = self::calcvICMSDesonIsento($ICMS);
        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
        return $ICMS;
    }

    private static function calcCST50($ICMS)
    {
        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private static function calcCST51($ICMS, $pICMS)
    {
        $ICMS->vBC = self::calcRedBC($ICMS);
        $ICMS->pICMS = $pICMS;
        $ICMS->vICMS = (self::calcvICMS($ICMS));

        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private static function calcCST60($ICMS)
    {
        $ICMS->vBC = 0;
        $ICMS->vICMS = 0;
        $ICMS->pICMS = 0;
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;

        return $ICMS;
    }

    private static function calcCST70($ICMS, $pICMSST, $pMVAST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);
        $ICMS->pICMSST = $pICMSST;
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));

        return $ICMS;
    }

    private static function calcCST90c($ICMS, $pMVAST, $modBCST)
    {
        if ($ICMS->CSTNotaRef === '10') {
            $ICMS->vICMS = (self::calcvICMS($ICMS));
            $ICMS->vICMSST = self::calcvICMSST($ICMS, $pMVAST, $modBCST);
        } else {
            $ICMS->vICMS = (self::calcvICMS($ICMS));
        }
        $ICMS->vICMSDeson = self::calcvICMSDesonIsento($ICMS);
        return $ICMS;
    }
}

<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class ICMS
{
    public $pRedBC;
    public $vBC;
    public $pICMS;
    public $vICMS;
    public $modBC;  // FIXME

    public $pMVAST;
    public $pRedBCST;
    public $vBCST;
    public $pICMSST;
    public $vICMSST;
    public $modBCST;  // FIXME

    public $vBCSTRet;
    public $vICMSSTRet;
    public $pCredSN;
    public $vCredICMSSN;
    public $SUFRAMA;
    public $Desconto;
    public $Zerar;
    public $vICMSDeson;
    public $CSTNotaRef;

    private $CST;

    /**
     * @param $ICMS
     * @param $pICMSST
     * @param $pMVAST
     * @param $pICMS
     * @param $reducao
     * @param $modBCST
     * @return ICMS
     * @throws Exception
     */
    public static function calcular(self $ICMS, $pICMSST, $pMVAST, $pICMS, $reducao, $modBCST = null): self
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
        if ($reducao > 0) {
            $ICMS->pICMS = $reducao;
            $ICMS->pICMSST = $reducao;
        } else {  // CASO NÃO HAJA REDUÇÃO, ELE IRÁ CALCULAR NORMALMENTE
            $ICMS->pICMS = $pICMS;
            $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        }

        if ($ICMS->getCST() === '00') {
            self::calcCST00($ICMS);
        } elseif ($ICMS->getCST() === '10') {
            self::calcCST10($ICMS, $pMVAST, $modBCST);
        } elseif ($ICMS->getCST() === '20') {
            self::calcCST20($ICMS);
        } elseif ($ICMS->getCST() === '30') {
            self::calcCST30($ICMS, $pICMSST, $pMVAST, $ST);
        } elseif ($ICMS->getCST() === '40') {
            self::calcCST40($ICMS);
        } elseif ($ICMS->getCST() === '41') {
            self::calcCST41($ICMS);
        } elseif ($ICMS->getCST() === '50') {
            self::calcCST50($ICMS);
        } elseif ($ICMS->getCST() === '51') {
            self::calcCST51($ICMS, $pICMS);
        } elseif ($ICMS->getCST() === '60') {
            self::calcCST60($ICMS);
        } elseif ($ICMS->getCST() === '70') {
            self::calcCST70($ICMS, $pICMSST, $pMVAST, $ST);
        } elseif ($ICMS->getCST() === '90') {
            self::calcCST90c($ICMS, $pMVAST, $modBCST);
        } elseif ($ICMS->getCST() === '101') {
            self::calcCSOSN101($ICMS);
        } elseif ($ICMS->getCST() === '102') {
            self::calcCSOSN102($ICMS);
        } elseif ($ICMS->getCST() === '103') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '200') {
            self::calcCST200($ICMS);
        } elseif ($ICMS->getCST() === '201') {
            self::calcCSOSN201($ICMS, $pICMSST, $pMVAST, $ST);
        } elseif ($ICMS->getCST() === '202') {
            self::calcCSOSN202($ICMS, $pICMSST, $pMVAST, $ST);
        } elseif ($ICMS->getCST() === '203') {
            self::calcCSOSN203($ICMS, $pICMSST, $pMVAST, $ST);
        } elseif ($ICMS->getCST() === '300') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '400') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '500') {
            self::calcCSOSN500($ICMS);
        } elseif ($ICMS->getCST() === '900') {
            self::calcCSOSN900($ICMS, $pICMSST, $pMVAST, $ST);
        } else {
            throw new Exception('Erro ao calcular ICMS' . print_r($ICMS, true));
        }
        return $ICMS;
    }

    /*
     * @Calcula o Valor crédito do ICMS que pode ser aproveitado
     */
    private static function calcvCredICMSSN($ICMS)
    {
        return ($ICMS->vBC * $ICMS->pCredSN) / 100;
    }

    /*
     * @Calcula o Valor do ICMS
     */
    private static function calcvICMS($ICMS)
    {
        return $ICMS->vBC * ($ICMS->pICMS / 100);
    }

    /*
     * @Calcula o Valor do ICMSST
     */
    private static function calcvICMSST($ICMS, $pMVAST, $modBCST = null)
    {
        if ($modBCST === '6') {
            $ICMS->vICMS = self::calcvICMS($ICMS);
            return $ICMS->vBCST * ($ICMS->pICMSST / 100) - $ICMS->vICMS;
        }

        $ICMS->pMVAST = $pMVAST;

        if ($ICMS->pMVAST === '0') {
            return '0';
        }

        $ICMS->vICMS = self::calcvICMS($ICMS);
        $ICMS->vBCST = $ICMS->vBCST * (1 + ($ICMS->pMVAST / 100)); // VERIFICAR AQUI OQUE ESTÃO ACONTECENDO
        return ((($ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100)))) * ($ICMS->pICMSST / 100)) - $ICMS->vICMS;
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
    private static function calcRedBCST(self $ICMS): float
    {
        $ICMS->vBCST = $ICMS->vBCST - ($ICMS->vBCST * ((float)$ICMS->pRedBCST / 100));
        return $ICMS->vBCST;
    }

    /* /// SIMPLES NACIONAL /// */
    private static function calcCSOSN101($ICMS)
    {
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
    }

    private static function calcCSOSN102($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vBCSTRet = null;
        $ICMS->vICMSSTRet = null;
    }

    private static function calcCSOSN201($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
    }

    private static function calcCSOSN202($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
    }

    private static function calcCSOSN203($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
    }

    private static function calcCSOSN500($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vICMSST = null;
    }

    private static function calcCSOSN900($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
    }

    /* --- FUNCOES CALCULOS POR CST DO REGIME NORMAL --- */
    private static function calcCST00($ICMS)
    {
        $ICMS->vICMS = self::calcvICMS($ICMS);
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
    }

    private static function calcCST200($ICMS)
    {
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
    }

    private static function calcCST10($ICMS, $pMVAST, $modBCST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);

        $ICMS->vICMS = self::calcvICMS($ICMS);
        $ICMS->vICMSST = self::calcvICMSST($ICMS, $pMVAST, $modBCST);
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
    }

    private static function calcCST30($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
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
    }

    private static function calcCST70($ICMS, $pICMSST, $pMVAST, $ST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS, $pMVAST));
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
    }

    /**
     * @return string
     */
    public function getCST(): string
    {
        return $this->CST;
    }

    /**
     * @param string $CST
     */
    public function setCST(string $CST): void
    {
        $this->CST = $CST;
    }
}

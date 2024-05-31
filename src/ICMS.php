<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;
use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;

class ICMS
{
    public $orig;  // Origem da mercadoria
    public $CST;  // Tributação do ICMS
    public $modBC;  // Modalidade de determinação da BC do ICMS
    public $pRedBC;  // Percentual da Redução de BC
    public $vBC;  // Valor da BC do ICMS
    public $pICMS;  // Alíquota do imposto
    public $vICMS;  // Valor do ICMS
    public $modBCST;  // Modalidade de determinação da BC do ICMS ST
    public $pMVAST;  // Percentual da margem de valor Adicionado do ICMS ST
    public $pRedBCST;  // Percentual da Redução de BC do ICMS ST
    public $vBCST;  // Valor da BC do ICMS ST
    public $pICMSST;  // Alíquota do imposto do ICMS ST
    public $vICMSST;  // Valor do ICMS ST
    public $UFST;  // UF para qual é devido o ICMS ST
    public $pBCop;  // Percentual da BC operação própria
    public $vBCSTRet;  // Valor da BC do ICMS Retido Anteriormente
    public $vICMSSTRet;  // Valor do ICMS Retido Anteriormente
    public $motDesICMS;  // Motivo da desoneração do ICMS
    public $vBCSTDest;  // Valor da BC do ICMS ST da UF destino
    public $vICMSSTDest;  // Valor do ICMS ST da UF destino
    public $pCredSN;  // Alíquota aplicável de cálculo do crédito (Simples Nacional)
    public $vCredICMSSN;  // Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123 (SIMPLES NACIONAL)
    public $vICMSDeson;  // Valor do ICMS da desoneração
    public $vICMSOp;  // Valor do ICMS da Operação
    public $pDif;  // percentual do diferimento
    public $vICMSDif;  // Valor do ICMS Diferido
    public $vBCFCP;  // Valor da Base de Cálculo do FCP
    public $pFCP;  // Percentual do FCP
    public $vFCP;  // Valor do FCP
    public $vBCFCPST;  // Valor da Base de Cálculo do FCP retido por Substituição Tributária
    public $pFCPST;  // Percentual do FCP retido por Substituição Tributária.
    public $vFCPST;  // Valor do FCP retido por Substituição Tributária
    public $vBCFCPSTRet;  // Valor da BC do FCP retido anteriormente por Substituição Tributária
    public $pFCPSTRet;  // Alíquota do FCP retido anteriormente por Substituição Tributária
    public $vFCPSTRet;  // Valor do FCP retido anteriormente por Substituição Tributária
    public $pST;  // Alíquota suportada pelo Consumidor Final
    public $consumidorFinal;
    public $vBCFCPUFDest;
    public $pFCPUFDest;
    public $vFCPUFDest;
    public $vBCUFDest;
    public $pICMSUFDest;
    public $pICMSInter;
    public $pICMSInterPart;
    public $vICMSUFDest;
    public $vICMSUFRemet;
    public $ufOrigem;
    public $ufDestino;
    /**
     * @param ICMS $ICMS
     * @param string $ufOrigem
     * @param string $ufDestino
     * @param float $reducao
     * @return ICMS
     * @throws NotImplementedCSTException|InvalidCSTException|Exception
     */
    public static function calcularICMS(ICMS $ICMS, string $ufOrigem = null, string $ufDestino = null, float $reducao = null, float $reducaoST = null, $consumidorFinal = null): ICMS
    {
        if ($consumidorFinal != null) {
            $ICMS->consumidorFinal = $consumidorFinal;
        }
        $notImplemented = [
            '20', '30', '60', '70', '103',
            '200', '201', '202', '203', '300', '400', '500', '900'
        ];
        if (in_array($ICMS->CST, $notImplemented, true)) {
            throw new NotImplementedCSTException($ICMS->CST);
        }
        if ($reducao === null) {
            if ($ufOrigem !== null && $ufDestino !== null) {
                $ICMS->pICMS = ICMS::pICMSFromUFs($ufOrigem, $ufDestino);
                if ($ICMS->orig == 1) { // cimento branco importado.. verificar se os 4% sao pra todos os emitentes e mais algum dado pra n cair aqui sempre que for origem 1
                    //verificar se existe alguma maneira de chegar aos 4% com algum calculo aleatorio pra nao ficar chumbado no codigo
                    $ICMS->pICMS = 4;
                }
            }
        } else {
            $ICMS->pICMS = $reducao;
        }
        $ICMS->pICMSUFDest = ICMS::pICMSFromUFs($ufDestino, $ufDestino);
        if ($reducaoST === null) {
            if ($ufOrigem !== null && $ufDestino !== null) {
                $ICMS->pICMSST = ICMS::pICMSSTFromUFs($ufOrigem, $ufDestino); // WORKARROND FIX THIS
            }
        } else {
            $ICMS->pICMSST = $reducaoST;
        }
        $ICMS->ufOrigem = $ufOrigem;
        $ICMS->ufDestino = $ufDestino;
        if ($ufDestino !== null && ($ufDestino == 33 || $ufDestino == 27)) { // RJ ou AL unicos que tem FCP
            $ICMS->pFCP = ICMS::pFCPFromUFs($ufDestino);
        }
        $calculosCST = [
            '00' => 'Gbbs\NfeCalculos\ICMS::calcCST00',
            '10' => 'Gbbs\NfeCalculos\ICMS::calcCST10',
            '40' => 'Gbbs\NfeCalculos\ICMS::calcCST40',
            '41' => 'Gbbs\NfeCalculos\ICMS::calcCST41',
            '50' => 'Gbbs\NfeCalculos\ICMS::calcCST50',
            '51' => 'Gbbs\NfeCalculos\ICMS::calcCST51',
            '90' => 'Gbbs\NfeCalculos\ICMS::calcCST90',
            '101' => 'Gbbs\NfeCalculos\ICMS::calcCSOSN101',
            '102' => 'Gbbs\NfeCalculos\ICMS::calcCSOSN102',
        ];
        if (array_key_exists($ICMS->CST, $calculosCST)) {
            return $calculosCST[$ICMS->CST]($ICMS);
        }
        throw new InvalidCSTException($ICMS->CST);
    }

    /**
     * Subtrai do valor da BC do ICMS ST o percentual da redução de BC do ICMS ST
     * @param $ICMS
     * @return float
     */
    private static function calcularReducaoValorBCST(ICMS $ICMS): float
    {
        return $ICMS->vBCST * (1 - $ICMS->pRedBCST / 100);
    }

    /**
     * Calcula o Valor do ICMS
     * @param $ICMS
     * @return float
     */
    private static function calcvICMS(ICMS $ICMS): float
    {
        return round($ICMS->vBC * $ICMS->pICMS / 100, 2);
    }

    /**
     * Calcula o Valor do ICMS com pICMSDif
     * @param ICMS $ICMS
     * @return float
     */
    private static function calcvICMSCompDif(ICMS $ICMS): float
    {
        $pDif = $ICMS->pICMS - ($ICMS->pICMS * $ICMS->pDif) / 100;

        return round($ICMS->vBC * $pDif / 100, 2);
    }

    /**
     * Calcula o valor do ICMS Diferido
     * @param ICMS $ICMS
     * @return float
     */
    private static function calcvICMSDif(ICMS $ICMS): float
    {
        $vICMS = ICMS::calcvICMS($ICMS);

        return round($vICMS - $ICMS->vBC * ($ICMS->pICMS - ($ICMS->pICMS * ($ICMS->pDif / 100))) / 100, 2);
    }

    /**
     * Calcula o valor do crédito do ICMS
     * @param ICMS $ICMS
     * @return float
     */
    private static function calcvCredICMSSN(ICMS $ICMS): float
    {
        return round($ICMS->vBC * ($ICMS->pCredSN / 100), 2);
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST00(ICMS $ICMS): ICMS
    {
        if ($ICMS->modBC !== 3) {
            throw new Exception('modBC ' . $ICMS->modBC . ' not implemented');
        }
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->modBC = $ICMS->modBC;
        $calculado->vBC = $ICMS->vBC;
        $calculado->pICMS = $ICMS->pICMS;
        $calculado->vICMS = ICMS::calcvICMS($ICMS);
        if ($ICMS->consumidorFinal == 1 &&  $ICMS->ufDestino != $ICMS->ufOrigem) {
            $calculado->vBCUFDest = $calculado->vBC;
            $calculado->pICMSInter = $ICMS->pICMS;
            $calculado->pICMSUFDest = $ICMS->pICMSUFDest;
            $calculado->vICMSUFDest = round($calculado->vBC * ($calculado->pICMSUFDest - $calculado->pICMSInter) / 100, 4);
            $calculado->vICMSUFRemet = 0;
            $calculado->pICMSInterPart = 100;
            if ($ICMS->pFCP) {
                $pFCP = $ICMS->pFCP;
                $vFCP = round($calculado->vBC * $pFCP / 100, 2);
                $calculado->vBCFCPUFDest = $calculado->vBC;
                $calculado->pFCPUFDest = $pFCP;
                $calculado->vFCPUFDest = $vFCP;
            }
        }
        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST10(ICMS $ICMS): ICMS
    {
        if ($ICMS->modBCST !== 4) {
            throw new Exception('modBCST ' . $ICMS->modBCST . ' not implemented');
        }
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->modBC = $ICMS->modBC;
        $calculado->vBC = $ICMS->vBC;
        $calculado->pICMS = $ICMS->pICMS;
        $calculado->modBCST = $ICMS->modBCST;
        $calculado->pMVAST = $ICMS->pMVAST;
        $calculado->pRedBCST = $ICMS->pRedBCST;
        $calculado->pICMSST = $ICMS->pICMSST;
        $calculado->vICMS = ICMS::calcvICMS($ICMS);
        $calculado->vBCST = round(ICMS::calcularReducaoValorBCST($ICMS) * (1 + $ICMS->pMVAST / 100), 4);
        $calculado->vICMSST = $ICMS->pMVAST === 0.0
            ? 0.0
            : round(($calculado->vBCST * (1 - $ICMS->pRedBCST / 100)) * $ICMS->pICMSST / 100 - $calculado->vICMS, 2);
        if ($ICMS->pFCP) {
            $calculado->vBCFCPST = $calculado->vBCST;
            $calculado->pFCPST = $ICMS->pFCP;
            $calculado->vFCPST = round((($calculado->vBCFCPST * $calculado->pFCPST / 100)), 2);
        }
        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST40(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->vBC = 0.0;
        $calculado->vICMS = 0.0;
        $calculado->pICMS = 0.0;

        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST41(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->vBC = 0.0;
        $calculado->vICMS = 0.0;
        $calculado->pICMS = 0.0;
        $calculado->vICMSDeson = $ICMS->vBC * ($ICMS->pICMS / 100);
        $calculado->motDesICMS = $ICMS->motDesICMS;

        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST50(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->vBC = 0.0;
        $calculado->vICMS = 0.0;
        $calculado->pICMS = 0.0;
        $calculado->vICMSST = 0.0;
        $calculado->vBCST = 0.0;
        $calculado->pMVAST = 0.0;
        $calculado->pICMSST = 0.0;

        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST51(ICMS $ICMS): ICMS
    {
        if ($ICMS->modBC !== 3) {
            throw new Exception('modBC ' . $ICMS->modBC . ' not implemented');
        }
        $calculado = new ICMS();
        $calculado->orig = '0';
        $calculado->CST = $ICMS->CST;
        $calculado->modBC = $ICMS->modBC;
        $calculado->vBC = $ICMS->vBC;
        $calculado->pICMS = $ICMS->pICMS;
        $calculado->vICMS = ICMS::calcvICMSCompDif($ICMS);
        $calculado->vICMSOp = ICMS::calcvICMS($ICMS);
        $calculado->pDif = $ICMS->pDif;
        $calculado->vICMSDif = ICMS::calcvICMSDif($ICMS);

        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     * @throws Exception
     */
    private static function calcCST90(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->modBC = $ICMS->modBC;
        $calculado->vBC = $ICMS->vBC;
        $calculado->pICMS = $ICMS->pICMS;
        $calculado->vICMS = ICMS::calcvICMS($ICMS);

        return $calculado;
    }

    private static function calcCSOSN101(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->pCredSN = $ICMS->pCredSN;
        $calculado->vCredICMSSN = ICMS::calcvCredICMSSN($ICMS);

        return $calculado;
    }

    /**
     * @param $ICMS
     * @return ICMS
     */
    private static function calcCSOSN102(ICMS $ICMS): ICMS
    {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        return $calculado;
    }

    /**
     * @param string $ufDestino
     * @throws Exception
     * @return float
     */
    public static function pFCPFromUFs(string $ufDestino): float
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $pfcpFile = file_get_contents($path . 'pfcp.json');
        $pfcpList = json_decode($pfcpFile, true);
        if ($ufDestino === '99') {
            return 0.0;
        }
        foreach ($pfcpList as $pfpc) {
            if ($pfpc['uf'] === $ufDestino) {
                return (float) $pfpc['aliquota'];
            }
        }
        throw new Exception('UF inexistente(FCP): ' . ' - ' . $ufDestino);
    }

    /**
     * @param string $ufOrigem
     * @param string $ufDestino
     * @throws Exception
     * @return float
     */
    public static function pICMSFromUFs(string $ufOrigem, string $ufDestino): float
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $picmsFile = file_get_contents($path . 'picms.json');
        $picmsList = json_decode($picmsFile, true);
        if ($ufDestino === '99') {
            return 0.0;
        }
        foreach ($picmsList as $picms) {
            if ($picms['uf'] === $ufOrigem) {
                return (float) $picms['uf' . $ufDestino];
            }
        }
        throw new Exception('UF inexistente(ICMS): ' . $ufOrigem . ' - ' . $ufDestino);
    }

    public static function pICMSCteFromUFs(string $ufOrigem, string $ufDestino): float
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $picmsFile = file_get_contents($path . 'picmscte.json');
        $picmsList = json_decode($picmsFile, true);
        if ($ufDestino === '99') {
            return 4.0;
        }
        foreach ($picmsList as $picms) {
            if ($picms['uf'] === $ufOrigem) {
                return (float) $picms['uf' . $ufDestino];
            }
        }
        throw new Exception('UF inexistente(ICMS): ' . $ufOrigem . ' - ' . $ufDestino);
    }

    /**
     * @param string $ufDestino
     * @throws Exception
     * @return float
     */
    // WORKARROND FIX THIS
    public static function pICMSSTFromUFs(string $ufOrigem, string $ufDestino): float
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $picmsstFile = file_get_contents($path . 'picmsst.json');
        $picmsstList = json_decode($picmsstFile, true);
        if ($ufDestino === '99') {
            return 0.0;
        }
        foreach ($picmsstList as $picmsst) {
            if ($picmsst['uf'] === $ufOrigem) {
                return (float) $picmsst['uf' . $ufDestino];
            }
        }
        throw new Exception('UF inexistente(ST): ' . $ufDestino . ' - ' . $ufDestino);
    }
}

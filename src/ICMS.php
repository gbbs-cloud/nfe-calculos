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
}

/**
 * @param ICMS $ICMS
 * @param string $ufOrigem
 * @param string $ufDestino
 * @param float $reducao
 * @return ICMS
 * @throws NotImplementedCSTException|InvalidCSTException|Exception
 */
function calcularICMS(ICMS $ICMS, string $ufOrigem, string $ufDestino, float $reducao = null): ICMS
{
    $notImplemented = [
        '20', '30', '40', '50', '60', '70', '101', '103',
        '200', '201', '202', '203', '300', '400', '500', '900'
    ];
    if (in_array($ICMS->CST, $notImplemented, true)) {
        throw new NotImplementedCSTException($ICMS->CST);
    }
    if ($reducao === null) {
        $ICMS->pICMS = pICMSFromUFs($ufOrigem, $ufDestino);
        $ICMS->pICMSST = pICMSSTFromUFs($ufOrigem, $ufDestino);
    } else {
        $ICMS->pICMS = $reducao;
        $ICMS->pICMSST = $reducao;
    }
    $calculosCST = [
        '00' => 'Gbbs\NfeCalculos\calcCST00',
        '10' => 'Gbbs\NfeCalculos\calcCST10',
        '41' => 'Gbbs\NfeCalculos\calcCST41',
        '51' => 'Gbbs\NfeCalculos\calcCST51',
        '90' => 'Gbbs\NfeCalculos\calcCST90',
        '102' => 'Gbbs\NfeCalculos\calcCSOSN102',
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
function calcularReducaoValorBCST(ICMS $ICMS): float
{
    return $ICMS->vBCST * (1 - $ICMS->pRedBCST / 100);
}

/**
 * Calcula o Valor do ICMS
 * @param $ICMS
 * @return float
 */
function calcvICMS(ICMS $ICMS): float
{
    return round($ICMS->vBC * $ICMS->pICMS / 100, 2);
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST00(ICMS $ICMS): ICMS
{
    if ($ICMS->modBC !== 0) {
        throw new Exception('modBC ' . $ICMS->modBC . ' not implemented');
    }
    $calculado = new ICMS();
    $calculado->orig = $ICMS->orig;
    $calculado->CST = $ICMS->CST;
    $calculado->modBC = $ICMS->modBC;
    $calculado->vBC = $ICMS->vBC;
    $calculado->pICMS = $ICMS->pICMS;
    $calculado->vICMS = calcvICMS($ICMS);

    return $calculado;
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST10(ICMS $ICMS): ICMS
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
    $calculado->vICMS = calcvICMS($ICMS);
    $calculado->vBCST = calcularReducaoValorBCST($ICMS) * (1 + $ICMS->pMVAST / 100);
    $calculado->vICMSST = $ICMS->pMVAST === 0.0
        ? 0.0
        : round(($calculado->vBCST * (1 - $ICMS->pRedBCST / 100)) * $ICMS->pICMSST / 100 - $calculado->vICMS, 2);

    return $calculado;
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST41(ICMS $ICMS): ICMS
{
    $calculado = new ICMS();
    $calculado->orig = $ICMS->orig;
    $calculado->CST = $ICMS->CST;
    $calculado->vICMSDeson = $ICMS->vBC * ($ICMS->pICMS / 100);
    $calculado->motDesICMS = $ICMS->motDesICMS;

    return $calculado;
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST51(ICMS $ICMS): ICMS
{
    if ($ICMS->modBC !== 0) {
        throw new Exception('modBC ' . $ICMS->modBC . ' not implemented');
    }
    $calculado = new ICMS();
    $calculado->orig = '0';
    $calculado->CST = $ICMS->CST;
    $calculado->modBC = $ICMS->modBC;
    $calculado->vBC = 0.00;
    $calculado->pICMS = $ICMS->pICMS;
    $calculado->vICMS = 0.0;
    $calculado->pDif = 100;
    $calculado->vICMSDif = 0.0;

    return $calculado;
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST90(ICMS $ICMS): ICMS
{
    $calculado = new ICMS();
    $calculado->orig = $ICMS->orig;
    $calculado->CST = $ICMS->CST;
    $calculado->modBC = $ICMS->modBC;
    $calculado->vBC = $ICMS->vBC;
    $calculado->pICMS = $ICMS->pICMS;
    $calculado->vICMS = calcvICMS($ICMS);

    return $calculado;
}

/**
 * @param $ICMS
 * @return ICMS
 */
function calcCSOSN102(ICMS $ICMS): ICMS
{
    $calculado = new ICMS();
    $calculado->orig = $ICMS->orig;
    $calculado->CST = $ICMS->CST;
    return $calculado;
}

/**
 * @param string $ufOrigem
 * @param string $ufDestino
 * @throws Exception
 * @return float
 */
function pICMSFromUFs(string $ufOrigem, string $ufDestino): float
{
    $path = realpath(__DIR__ . '/../storage') . '/';
    $picmsFile = file_get_contents($path . 'picms.json');
    $picmsList = json_decode($picmsFile, true);
    foreach ($picmsList as $picms) {
        if ($picms['uf'] === $ufOrigem) {
            return (float) $picms['uf' . $ufDestino];
        }
    }
    throw new Exception('UF inexistente: ' . $ufOrigem . ' - ' . $ufDestino);
}

/**
 * @param string $ufOrigem
 * @param string $ufDestino
 * @throws Exception
 * @return float
 */
function pICMSSTFromUFs(string $ufOrigem, string $ufDestino): float
{
    $path = realpath(__DIR__ . '/../storage') . '/';
    $picmsstFile = file_get_contents($path . 'picmsst.json');
    $picmsstList = json_decode($picmsstFile, true);
    foreach ($picmsstList as $picmsst) {
        if ($picmsst['uf'] === $ufOrigem) {
            return (float) $picmsst['uf' . $ufDestino];
        }
    }
    throw new Exception('UF inexistente: ' . $ufOrigem . ' - ' . $ufDestino);
}

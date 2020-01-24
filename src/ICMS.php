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
        '20', '30', '40', '41', '50', '51', '60', '70', '90', '101', '102', '103',
        '200', '201', '202', '203', '300', '400', '500', '900'
    ];
    if ($reducao === null) {
        $ICMS->pICMS = pICMSFromUFs($ufOrigem, $ufDestino);
        $ICMS->pICMSST = pICMSSTFromUFs($ufOrigem, $ufDestino);
    } else {
        $ICMS->pICMS = $reducao;
        $ICMS->pICMSST = $reducao;
    }

    if ($ICMS->CST === '00') {
        return calcCST00($ICMS);
    } elseif ($ICMS->CST === '10') {
        return calcCST10($ICMS);
    } elseif (in_array($ICMS->CST, $notImplemented, true)) {
        throw new NotImplementedCSTException($ICMS->CST);
    }
    throw new InvalidCSTException($ICMS->CST);
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
    if ($ICMS->modBC === 0) {
        $calculado = new ICMS();
        $calculado->orig = $ICMS->orig;
        $calculado->CST = $ICMS->CST;
        $calculado->modBC = $ICMS->modBC;
        $calculado->vBC = $ICMS->vBC;
        $calculado->pICMS = $ICMS->pICMS;

        $calculado->vICMS = calcvICMS($ICMS);
        return $calculado;
    } else {
        throw new Exception('modBC ' . $ICMS->modBC . ' not implemented');
    }
}

/**
 * @param $ICMS
 * @return ICMS
 * @throws Exception
 */
function calcCST10(ICMS $ICMS): ICMS
{
    if ($ICMS->modBCST === 4) {
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
        $calculado->vBCST = $ICMS->vBC - $ICMS->vBC * $ICMS->pRedBCST / 100;
        if ($ICMS->pMVAST === 0.0) {
            $calculado->vICMSST = 0.0;
            return $calculado;
        }
        $calculado->vBCST *= 1 + $ICMS->pMVAST / 100;
        $calculado->vICMSST = round(
            ($calculado->vBCST - $calculado->vBCST * $ICMS->pRedBCST / 100) * $ICMS->pICMSST / 100 - $calculado->vICMS,
            2
        );
        return $calculado;
    } else {
        throw new Exception('modBCST ' . $ICMS->modBCST . ' not implemented');
    }
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

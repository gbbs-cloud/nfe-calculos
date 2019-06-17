<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class ICMS
{
    private $SUFRAMA;  // TODO not a tag
    private $Desconto;  // TODO not a tag
    private $CSTNotaRef;  // TODO not a tag

    private $orig;  //  Origem da mercadoria
    private $CST;  // Tributação do ICMS
    private $modBC;  // Modalidade de determinação da BC do ICMS
    private $pRedBC;  // Percentual da Redução de BC
    private $vBC;  // Valor da BC do ICMS
    private $pICMS;  // Alíquota do imposto
    private $vICMS;  // Valor do ICMS
    private $modBCST;  // Modalidade de determinação da BC do ICMS ST
    private $pMVAST;  // Percentual da margem de valor Adicionado do ICMS ST
    private $pRedBCST;  // Percentual da Redução de BC do ICMS ST
    private $vBCST;  // Valor da BC do ICMS ST
    private $pICMSST;  // Alíquota do imposto do ICMS ST
    private $vICMSST;  // Valor do ICMS ST
    private $UFST;  // UF para qual é devido o ICMS ST
    private $pBCop;  // Percentual da BC operação própria
    private $vBCSTRet;  // Valor da BC do ICMS Retido Anteriormente
    private $vICMSSTRet;  // Valor do ICMS Retido Anteriormente
    private $motDesICMS;  // Motivo da desoneração do ICMS
    private $vBCSTDest;  // Valor da BC do ICMS ST da UF destino
    private $vICMSSTDest;  // Valor do ICMS ST da UF destino
    private $pCredSN;  // Alíquota aplicável de cálculo do crédito (Simples Nacional)
    private $vCredICMSSN;  // Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123 (SIMPLES NACIONAL)
    private $vICMSDeson;  // Valor do ICMS da desoneração
    private $vICMSOp;  // Valor do ICMS da Operação
    private $pDif;  // percentual do diferimento
    private $vICMSDif;  // Valor do ICMS Diferido
    private $vBCFCP;  // Valor da Base de Cálculo do FCP
    private $pFCP;  // Percentual do FCP
    private $vFCP;  // Valor do FCP
    private $vBCFCPST;  // Valor da Base de Cálculo do FCP retido por Substituição Tributária
    private $pFCPST;  // Percentual do FCP retido por Substituição Tributária.
    private $vFCPST;  // Valor do FCP retido por Substituição Tributária
    private $vBCFCPSTRet;  // Valor da BC do FCP retido anteriormente por Substituição Tributária
    private $pFCPSTRet;  // Alíquota do FCP retido anteriormente por Substituição Tributária
    private $vFCPSTRet;  // Valor do FCP retido anteriormente por Substituição Tributária
    private $pST;  // Alíquota suportada pelo Consumidor Final

    /**
     * @param $ICMS
     * @param $pICMSST
     * @param $reducao
     * @return ICMS
     * @throws Exception
     */
    public static function calcular(self $ICMS, $pICMSST, $reducao): self
    {
        $ST = 0;

        //REDUÇÃO DO PERCENTUAL DA ALIQUOTA ICMS
        if ($reducao > 0 and $ICMS->getCST() === '51') {
            $ICMS->pICMS = $reducao;
        }
        if ($reducao > 0) {
            $ICMS->pICMSST = $reducao;
        } else {  // CASO NÃO HAJA REDUÇÃO, ELE IRÁ CALCULAR NORMALMENTE
            $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        }

        if ($ICMS->getCST() === '00') {
            self::calcCST00($ICMS);
        } elseif ($ICMS->getCST() === '10') {
            self::calcCST10($ICMS);
        } elseif ($ICMS->getCST() === '20') {
            self::calcCST20($ICMS);
        } elseif ($ICMS->getCST() === '30') {
            self::calcCST30($ICMS, $pICMSST, $ST);
        } elseif ($ICMS->getCST() === '40') {
            self::calcCST40($ICMS);
        } elseif ($ICMS->getCST() === '41') {
            self::calcCST41($ICMS);
        } elseif ($ICMS->getCST() === '50') {
            self::calcCST50($ICMS);
        } elseif ($ICMS->getCST() === '51') {
            self::calcCST51($ICMS);
        } elseif ($ICMS->getCST() === '60') {
            self::calcCST60($ICMS);
        } elseif ($ICMS->getCST() === '70') {
            self::calcCST70($ICMS, $pICMSST, $ST);
        } elseif ($ICMS->getCST() === '90') {
            self::calcCST90c($ICMS);
        } elseif ($ICMS->getCST() === '101') {
            self::calcCSOSN101($ICMS);
        } elseif ($ICMS->getCST() === '102') {
            self::calcCSOSN102($ICMS);
        } elseif ($ICMS->getCST() === '103') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '200') {
            self::calcCST200($ICMS);
        } elseif ($ICMS->getCST() === '201') {
            self::calcCSOSN201($ICMS, $pICMSST, $ST);
        } elseif ($ICMS->getCST() === '202') {
            self::calcCSOSN202($ICMS, $pICMSST, $ST);
        } elseif ($ICMS->getCST() === '203') {
            self::calcCSOSN203($ICMS, $pICMSST, $ST);
        } elseif ($ICMS->getCST() === '300') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '400') {
            // FIXME Do nothing?
        } elseif ($ICMS->getCST() === '500') {
            self::calcCSOSN500($ICMS);
        } elseif ($ICMS->getCST() === '900') {
            self::calcCSOSN900($ICMS, $pICMSST, $ST);
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

    /**
     * Calcula o Valor do ICMS
     * @param $ICMS
     * @return float
     */
    private static function calcvICMS(self $ICMS): float
    {
        return $ICMS->getVBC() * ($ICMS->getPICMS() / 100);
    }

    /**
     * Calcula o Valor do ICMSST
     * @param $ICMS
     * @return float
     */
    private static function calcvICMSST(self $ICMS): float
    {
        if ($ICMS->getPMVAST() === 0.0) {
            return 0.0;
        }

        $ICMS->setVICMS(self::calcvICMS($ICMS));
        $ICMS->setVBCST($ICMS->getVBCST() * (1 + ($ICMS->getPMVAST() / 100))); // VERIFICAR AQUI OQUE ESTÃO ACONTECENDO
        return ((($ICMS->getVBCST() - ($ICMS->getVBCST() * ($ICMS->getPRedBCST() / 100)))) * ($ICMS->getPICMSST() / 100)) - $ICMS->getVICMS();
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

    /**
     * Calcula  a redução na base de culculo do ICMS
     * @param $ICMS
     * @return float
     */
    private static function calcRedBC(self $ICMS): float
    {
        return $ICMS->getVBC() - ($ICMS->getVBC() * ($ICMS->getPRedBC() / 100));
    }

    /**
     * Calcula a redução na base de culculo do ICMSST
     * @param $ICMS
     * @return float
     */
    private static function calcRedBCST(self $ICMS): float
    {
        return $ICMS->getVBCST() - ($ICMS->getVBCST() * ($ICMS->getPRedBCST() / 100));
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

    /**
     * @param $ICMS
     * @throws Exception
     */
    private static function calcCST00(self $ICMS): void
    {
        if ($ICMS->getModBC() === 0) {
            $ICMS->setVICMS(self::calcvICMS($ICMS));
        } else {
            throw new Exception('Not implemented');
        }
    }

    /**
     * @param $ICMS
     * @throws Exception
     */
    private static function calcCST10(self $ICMS): void
    {
        if ($ICMS->getModBCST() === 4) {
            $ICMS->setVBCST(self::calcRedBCST($ICMS));
            $ICMS->setVBC(self::calcRedBC($ICMS));
            $ICMS->setVICMS(self::calcvICMS($ICMS));
            $ICMS->setVICMSST(self::calcvICMSST($ICMS));
        } else {
            throw new Exception('Not implemented');
        }
    }

    private static function calcCSOSN201($ICMS, $pICMSST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
    }

    private static function calcCSOSN202($ICMS, $pICMSST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
    }

    private static function calcCSOSN203($ICMS, $pICMSST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
    }

    private static function calcCSOSN500($ICMS)
    {
        $ICMS->vBC = null;
        $ICMS->vICMS = null;
        $ICMS->vBCST = null;
        $ICMS->vICMSST = null;
    }

    private static function calcCSOSN900($ICMS, $pICMSST, $ST)
    {
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vCredICMSSN = self::calcvCredICMSSN($ICMS);
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
    }


    private static function calcCST200($ICMS)
    {
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = 0;
        $ICMS->vBCST = 0;
        $ICMS->pMVAST = 0;
        $ICMS->pICMSST = 0;
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

    private static function calcCST30($ICMS, $pICMSST, $ST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
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

    private static function calcCST51($ICMS)
    {
        $ICMS->vBC = self::calcRedBC($ICMS);
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

    private static function calcCST70($ICMS, $pICMSST, $ST)
    {
        $ICMS->vBCST = self::calcRedBCST($ICMS);
        $ICMS->vBC = self::calcRedBC($ICMS);
        $ICMS->pICMSST = $ST > 0 ? $ST : $pICMSST;
        $ICMS->vICMS = (self::calcvICMS($ICMS));
        $ICMS->vICMSST = (self::calcvICMSST($ICMS));
    }

    private static function calcCST90c($ICMS)
    {
        if ($ICMS->CSTNotaRef === '10') {
            $ICMS->vICMS = (self::calcvICMS($ICMS));
            $ICMS->vICMSST = self::calcvICMSST($ICMS);
        } else {
            $ICMS->vICMS = (self::calcvICMS($ICMS));
        }
        $ICMS->vICMSDeson = self::calcvICMSDesonIsento($ICMS);
    }

    /**
     * @return string
     */
    public function getOrig(): string
    {
        return $this->orig;
    }

    /**
     * @param string $orig
     * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
     * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;
     * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
     * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%;
     * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes;
     * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
     * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;
     * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX e gás natural.
     * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%;
     */
    public function setOrig(string $orig): void
    {
        $this->orig = $orig;
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

    /**
     * @return int
     * 0 - Margem Valor Agregado (%);
     * 1 - Pauta (valor);
     * 2 - Preço Tabelado Máximo (valor);
     * 3 - Valor da Operação.
     */
    public function getModBC(): int
    {
        return $this->modBC;
    }

    /**
     * @param int $modBC
     */
    public function setModBC(int $modBC): void
    {
        $this->modBC = $modBC;
    }

    /**
     * @return float
     */
    public function getPRedBC(): float
    {
        return $this->pRedBC;
    }

    /**
     * @param float $pRedBC
     */
    public function setPRedBC(float $pRedBC): void
    {
        $this->pRedBC = $pRedBC;
    }

    /**
     * @return float
     */
    public function getVBC(): float
    {
        return $this->vBC;
    }

    /**
     * @param float $vBC
     */
    public function setVBC(float $vBC): void
    {
        $this->vBC = $vBC;
    }

    /**
     * @return float
     */
    public function getPICMS(): float
    {
        return $this->pICMS;
    }

    /**
     * @param float $pICMS
     */
    public function setPICMS(float $pICMS): void
    {
        $this->pICMS = $pICMS;
    }

    /**
     * @return float
     */
    public function getVICMS(): float
    {
        return $this->vICMS;
    }

    /**
     * @param float $vICMS
     */
    public function setVICMS(float $vICMS): void
    {
        $this->vICMS = $vICMS;
    }

    /**
     * @return int
     */
    public function getModBCST(): int
    {
        return $this->modBCST;
    }

    /**
     * @param int $modBCST
     * 0 - Preço tabelado ou máximo sugerido;
     * 1 - Lista Negativa (valor);
     * 2 - Lista Positiva (valor);
     * 3 - Lista Neutra (valor);
     * 4 - Margem Valor Agregado (%);
     * 5 - Pauta (valor).
     */
    public function setModBCST(int $modBCST): void
    {
        $this->modBCST = $modBCST;
    }

    /**
     * @return float
     */
    public function getPMVAST(): float
    {
        return $this->pMVAST;
    }

    /**
     * @param float $pMVAST
     */
    public function setPMVAST(?float $pMVAST): void
    {
        $this->pMVAST = $pMVAST;
    }

    /**
     * @return float
     */
    public function getPRedBCST(): float
    {
        return $this->pRedBCST;
    }

    /**
     * @param float $pRedBCST
     */
    public function setPRedBCST(float $pRedBCST): void
    {
        $this->pRedBCST = $pRedBCST;
    }

    /**
     * @return float
     */
    public function getVBCST(): float
    {
        return $this->vBCST;
    }

    /**
     * @param float $vBCST
     */
    public function setVBCST(float $vBCST): void
    {
        $this->vBCST = $vBCST;
    }

    /**
     * @return float
     */
    public function getPICMSST(): ?float
    {
        return $this->pICMSST;
    }

    /**
     * @param float $pICMSST
     */
    public function setPICMSST(float $pICMSST): void
    {
        $this->pICMSST = $pICMSST;
    }

    /**
     * @return float
     */
    public function getVICMSST(): float
    {
        return $this->vICMSST;
    }

    /**
     * @param mixed $vICMSST
     */
    public function setVICMSST(float $vICMSST): void
    {
        $this->vICMSST = $vICMSST;
    }

    /**
     * @return string
     */
    public function getUFST(): string
    {
        return $this->UFST;
    }

    /**
     * @param string $UFST
     */
    public function setUFST(string $UFST): void
    {
        $this->UFST = $UFST;
    }

    /**
     * @return float
     */
    public function getPBCop(): float
    {
        return $this->pBCop;
    }

    /**
     * @param float $pBCop
     */
    public function setPBCop(float $pBCop): void
    {
        $this->pBCop = $pBCop;
    }

    /**
     * @return float
     */
    public function getVBCSTRet(): float
    {
        return $this->vBCSTRet;
    }

    /**
     * @param float $vBCSTRet
     */
    public function setVBCSTRet(float $vBCSTRet): void
    {
        $this->vBCSTRet = $vBCSTRet;
    }

    /**
     * @return float
     */
    public function getVICMSSTRet(): float
    {
        return $this->vICMSSTRet;
    }

    /**
     * @param float $vICMSSTRet
     */
    public function setVICMSSTRet(float $vICMSSTRet): void
    {
        $this->vICMSSTRet = $vICMSSTRet;
    }

    /**
     * @return int
     */
    public function getMotDesICMS(): int
    {
        return $this->motDesICMS;
    }

    /**
     * @param int $motDesICMS
     */
    public function setMotDesICMS(int $motDesICMS): void
    {
        $this->motDesICMS = $motDesICMS;
    }

    /**
     * @return float
     */
    public function getVBCSTDest(): float
    {
        return $this->vBCSTDest;
    }

    /**
     * @param float $vBCSTDest
     */
    public function setVBCSTDest(float $vBCSTDest): void
    {
        $this->vBCSTDest = $vBCSTDest;
    }

    /**
     * @return float
     */
    public function getVICMSSTDest(): float
    {
        return $this->vICMSSTDest;
    }

    /**
     * @param float $vICMSSTDest
     */
    public function setVICMSSTDest(float $vICMSSTDest): void
    {
        $this->vICMSSTDest = $vICMSSTDest;
    }

    /**
     * @return float
     */
    public function getPCredSN(): float
    {
        return $this->pCredSN;
    }

    /**
     * @param float $pCredSN
     */
    public function setPCredSN(float $pCredSN): void
    {
        $this->pCredSN = $pCredSN;
    }

    /**
     * @return float
     */
    public function getVCredICMSSN(): float
    {
        return $this->vCredICMSSN;
    }

    /**
     * @param float $vCredICMSSN
     */
    public function setVCredICMSSN(float $vCredICMSSN): void
    {
        $this->vCredICMSSN = $vCredICMSSN;
    }

    /**
     * @return float
     */
    public function getVICMSDeson(): float
    {
        return $this->vICMSDeson;
    }

    /**
     * @param float $vICMSDeson
     */
    public function setVICMSDeson(float $vICMSDeson): void
    {
        $this->vICMSDeson = $vICMSDeson;
    }

    /**
     * @return float
     */
    public function getVICMSOp(): float
    {
        return $this->vICMSOp;
    }

    /**
     * @param float $vICMSOp
     */
    public function setVICMSOp(float $vICMSOp): void
    {
        $this->vICMSOp = $vICMSOp;
    }

    /**
     * @return float
     */
    public function getPDif(): float
    {
        return $this->pDif;
    }

    /**
     * @param float $pDif
     */
    public function setPDif(float $pDif): void
    {
        $this->pDif = $pDif;
    }

    /**
     * @return float
     */
    public function getVICMSDif(): float
    {
        return $this->vICMSDif;
    }

    /**
     * @param float $vICMSDif
     */
    public function setVICMSDif(float $vICMSDif): void
    {
        $this->vICMSDif = $vICMSDif;
    }

    /**
     * @return float
     */
    public function getVBCFCP(): float
    {
        return $this->vBCFCP;
    }

    /**
     * @param float $vBCFCP
     */
    public function setVBCFCP(float $vBCFCP): void
    {
        $this->vBCFCP = $vBCFCP;
    }

    /**
     * @return float
     */
    public function getPFCP(): float
    {
        return $this->pFCP;
    }

    /**
     * @param float $pFCP
     */
    public function setPFCP(float $pFCP): void
    {
        $this->pFCP = $pFCP;
    }

    /**
     * @return float
     */
    public function getVFCP(): float
    {
        return $this->vFCP;
    }

    /**
     * @param float $vFCP
     */
    public function setVFCP(float $vFCP): void
    {
        $this->vFCP = $vFCP;
    }

    /**
     * @return float
     */
    public function getVBCFCPST(): float
    {
        return $this->vBCFCPST;
    }

    /**
     * @param float $vBCFCPST
     */
    public function setVBCFCPST(float $vBCFCPST): void
    {
        $this->vBCFCPST = $vBCFCPST;
    }

    /**
     * @return float
     */
    public function getPFCPST(): float
    {
        return $this->pFCPST;
    }

    /**
     * @param float $pFCPST
     */
    public function setPFCPST(float $pFCPST): void
    {
        $this->pFCPST = $pFCPST;
    }

    /**
     * @return float
     */
    public function getVFCPST(): float
    {
        return $this->vFCPST;
    }

    /**
     * @param float $vFCPST
     */
    public function setVFCPST(float $vFCPST): void
    {
        $this->vFCPST = $vFCPST;
    }

    /**
     * @return float
     */
    public function getVBCFCPSTRet(): float
    {
        return $this->vBCFCPSTRet;
    }

    /**
     * @param float $vBCFCPSTRet
     */
    public function setVBCFCPSTRet(float $vBCFCPSTRet): void
    {
        $this->vBCFCPSTRet = $vBCFCPSTRet;
    }

    /**
     * @return float
     */
    public function getPFCPSTRet(): float
    {
        return $this->pFCPSTRet;
    }

    /**
     * @param float $pFCPSTRet
     */
    public function setPFCPSTRet(float $pFCPSTRet): void
    {
        $this->pFCPSTRet = $pFCPSTRet;
    }

    /**
     * @return float
     */
    public function getVFCPSTRet(): float
    {
        return $this->vFCPSTRet;
    }

    /**
     * @param float $vFCPSTRet
     */
    public function setVFCPSTRet(float $vFCPSTRet): void
    {
        $this->vFCPSTRet = $vFCPSTRet;
    }

    /**
     * @return float
     */
    public function getPST(): float
    {
        return $this->pST;
    }

    /**
     * @param float $pST
     */
    public function setPST(float $pST): void
    {
        $this->pST = $pST;
    }
}

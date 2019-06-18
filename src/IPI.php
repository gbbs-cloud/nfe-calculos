<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Exception;

class IPI
{
    public $descCST;
    public $clEnq;
    public $CodNCM;
    public $REIDE;
    public $SUFRAMA;
    public $CSTNotaRef;

    private $CNPJProd;
    private $cSelo;
    private $qSelo;
    private $cEnq;
    private $CST;
    private $vBC;
    private $pIPI;
    private $vIPI;
    private $qUnid;
    private $vUnid;

    /**
     * @param $IPI
     * @return mixed
     * @throws Exception
     */
    public static function calcular(IPI $IPI): void
    {
        if ($IPI->getCST() === '00') {
            /* ENTRADA COM RECUPERAÇÃO DE CRÉDITO */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '49') {
            /* OUTRAS ENTRADAS */
            return self::calcRetornoIsentoValorOutros($IPI);
        } elseif ($IPI->getCST() === '50') {
            /* SAÍDA TRIBUTADA */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '99') {
            /* OUTRAS SAÍDAS */
            return self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '01') {
            /* 01 ENTRADA TRIBUTADA COM ALICOTA ZERO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '02') {
            /* ENTRADA ISENTA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '03') {
            /* ENTRADA NÃO TRIBUTADA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '04') {
            /* ENTRADA IMUNE */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '05') {
            /* ENTRADA COM SUSPENSAO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '51') {
            /* SAÍDA TRIBUTADA COM ALICOTA ZERO */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '52') {
            /* SAÍDA ISENTA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '53') {
            /* SAÍDA NÃO-TRIBUTADA */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '54') {
            /* SAÍDA IMUNE */
            return self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '55') {
            /* SAÍDA COM SUSPENSAO */
            return self::calcIsento($IPI);
        }
        throw new Exception('Erro ao calcular IPI' . print_r($IPI, true));
    }

    /*
     * @ISENTO
     */
    private static function calcIsento($IPI)
    {
        $IPI->vIPI = '0';
        $IPI->vBC = '0';
        $IPI->pIPI = '0';
        $IPI->qUnid = null;
        $IPI->vUnid = null;
        return $IPI;
    }

    /*
     * @Calcula o Valor IPI Ad Valoren
     */
    private static function calcAliquotaAdValoren($IPI)
    {
        $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
        return $IPI;
    }

    private static function calcRetornoIsentoValorOutros($IPI)
    {
        if ($IPI->CSTNotaRef === '00' || $IPI->CSTNotaRef === '50' || $IPI->CSTNotaRef === '99') {
            $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
            $IPI->pIPI = 0;
            return $IPI;
        } else {
            return self::calcIsento($IPI);
        }
    }

    /**
     * @return string
     */
    public function getCNPJProd(): string
    {
        return $this->CNPJProd;
    }

    /**
     * @param string $CNPJProd
     */
    public function setCNPJProd(string $CNPJProd): void
    {
        $this->CNPJProd = $CNPJProd;
    }

    /**
     * @return string
     */
    public function getCSelo(): string
    {
        return $this->cSelo;
    }

    /**
     * @param string $cSelo
     */
    public function setCSelo(string $cSelo): void
    {
        $this->cSelo = $cSelo;
    }

    /**
     * @return float
     */
    public function getQSelo(): float
    {
        return $this->qSelo;
    }

    /**
     * @param float $qSelo
     */
    public function setQSelo(float $qSelo): void
    {
        $this->qSelo = $qSelo;
    }

    /**
     * @return string
     */
    public function getCEnq(): string
    {
        return $this->cEnq;
    }

    /**
     * @param string $cEnq
     */
    public function setCEnq(string $cEnq): void
    {
        $this->cEnq = $cEnq;
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
    public function getPIPI(): float
    {
        return $this->pIPI;
    }

    /**
     * @param float $pIPI
     */
    public function setPIPI(float $pIPI): void
    {
        $this->pIPI = $pIPI;
    }

    /**
     * @return float
     */
    public function getVIPI(): float
    {
        return $this->vIPI;
    }

    /**
     * @param float $vIPI
     */
    public function setVIPI(float $vIPI): void
    {
        $this->vIPI = $vIPI;
    }

    /**
     * @return float
     */
    public function getQUnid(): float
    {
        return $this->qUnid;
    }

    /**
     * @param float $qUnid
     */
    public function setQUnid(float $qUnid): void
    {
        $this->qUnid = $qUnid;
    }

    /**
     * @return float
     */
    public function getVUnid(): float
    {
        return $this->vUnid;
    }

    /**
     * @param float $vUnid
     */
    public function setVUnid(float $vUnid): void
    {
        $this->vUnid = $vUnid;
    }
}

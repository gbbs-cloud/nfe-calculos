<?php

declare(strict_types=1);

namespace Gbbs\NfeCalculos;

use Gbbs\NfeCalculos\Exception\InvalidCSTException;
use Gbbs\NfeCalculos\Exception\NotImplementedCSTException;
use \Exception;

class IPI
{
    public $CNPJProd;
    public $cSelo;
    public $qSelo;
    public $cEnq;
    public $CST;
    public $vBC;
    public $pIPI;
    public $vIPI;
    public $qUnid;
    public $vUnid;

    /**
     * @param self $IPI
     * @throws NotImplementedCSTException|InvalidCSTException
     */
    public static function calcular(self $IPI, string $ncm): void
    {
        $IPI->setPIPI($ncm);
        if ($IPI->getCST() === '00') {
            /* ENTRADA COM RECUPERAÇÃO DE CRÉDITO */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '01') {
            /* 01 ENTRADA TRIBUTADA COM ALICOTA ZERO */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '02') {
            /* ENTRADA ISENTA */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '03') {
            /* ENTRADA NÃO TRIBUTADA */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '04') {
            /* ENTRADA IMUNE */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '05') {
            /* ENTRADA COM SUSPENSAO */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '49') {
            /* OUTRAS ENTRADAS */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcRetornoIsentoValorOutros($IPI);
        } elseif ($IPI->getCST() === '50') {
            /* SAÍDA TRIBUTADA */
            self::calcAliquotaAdValoren($IPI);
        } elseif ($IPI->getCST() === '51') {
            /* SAÍDA TRIBUTADA COM ALICOTA ZERO */
            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '52') {
            /* SAÍDA ISENTA */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '53') {
            /* SAÍDA NÃO-TRIBUTADA */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '54') {
            /* SAÍDA IMUNE */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '55') {
            /* SAÍDA COM SUSPENSAO */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcIsento($IPI);
        } elseif ($IPI->getCST() === '99') {
            /* OUTRAS SAÍDAS */
            throw new NotImplementedCSTException($IPI->getCST());
//            self::calcAliquotaAdValoren($IPI);
        } else {
            throw new InvalidCSTException($IPI->getCST());
        }
    }

    /**
     * ISENTO
     * @param self $IPI
     */
    private static function calcIsento(self $IPI): void
    {
        $IPI->setVIPI(0.0);
        $IPI->setVBC(0.0);
        $IPI->pIPI = 0.0;
        $IPI->setQUnid(null);
        $IPI->setVUnid(null);
    }

    /**
     * Calcula o Valor IPI Ad Valoren
     * @param self $IPI
     */
    private static function calcAliquotaAdValoren(self $IPI): void
    {
        $IPI->setVIPI($IPI->getVBC() * ($IPI->getPIPI() / 100));
    }

//    private static function calcRetornoIsentoValorOutros($IPI)
//    {
//        if ($IPI->CSTNotaRef === '00' || $IPI->CSTNotaRef === '50' || $IPI->CSTNotaRef === '99') {
//            $IPI->vIPI = ($IPI->vBC * ($IPI->pIPI / 100));
//            $IPI->pIPI = 0;
//        } else {
//            self::calcIsento($IPI);
//        }
//    }

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
     * @param string $ncm
     * @throws Exception
     */
    public function setPIPI(string $ncm): void
    {
        $path = realpath(__DIR__ . '/../storage') . '/';
        $tipiFile = file_get_contents($path . 'tipi.json');
        if ($tipiFile === false) {
            throw new Exception('File tipi.json not found.');
        }
        $tipiList = json_decode($tipiFile, true);
        foreach ($tipiList as $tipi) {
            if ($tipi['NCMNum'] === $ncm) {
                $this->pIPI = (float) ($tipi['NCMAli'] === 'NT'? 0 : $tipi['NCMAli']);
            }
        }
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
    public function setQUnid(?float $qUnid): void
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
    public function setVUnid(?float $vUnid): void
    {
        $this->vUnid = $vUnid;
    }
}

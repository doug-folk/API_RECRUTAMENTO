<?php
class ScoreCalculator {
    private $distanceCalculator;

    public function __construct() {
        $this->distanceCalculator = new DistanceCalculator();
    }

    public function calcularScore($nivelVaga, $nivelCandidato, $localizacaoVaga, $localizacaoCandidato) {
        $diferencaNivel = abs($nivelVaga - $nivelCandidato);
        $componenteN = 100 - (25 * $diferencaNivel);
        
        $distancia = $this->distanceCalculator->calcularMenorDistancia($localizacaoCandidato, $localizacaoVaga);
        
        $componenteD = $this->calcularComponenteD($distancia);
        
        $score = ($componenteN + $componenteD) / 2;
        
        return intval($score);
    }

    private function calcularComponenteD($distancia) {
        if ($distancia >= 0 && $distancia <= 5) {
            return 100;
        } elseif ($distancia > 5 && $distancia <= 10) {
            return 75;
        } elseif ($distancia > 10 && $distancia <= 15) {
            return 50;
        } elseif ($distancia > 15 && $distancia <= 20) {
            return 25;
        } else {
            return 0;
        }
    }
}


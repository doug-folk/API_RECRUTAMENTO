<?php
class DistanceCalculator {
    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }
    
    public function calcularMenorDistancia($origem, $destino) {
        if ($origem === $destino) {
            return 0;
        }
        
        $stmt = $this->conn->prepare("SELECT origem, destino, distancia FROM distancias");
        $stmt->execute();
        $distancias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $grafo = [];
        foreach ($distancias as $d) {
            $grafo[$d['origem']][$d['destino']] = $d['distancia'];
        }
        
        $visitados = [];
        $distancia = [];
        $anterior = [];
        $nodes = [];
        
        foreach ($grafo as $node => $adj) {
            $distancia[$node] = INF;
            $anterior[$node] = null;
            $nodes[] = $node;
        }
        
        $distancia[$origem] = 0;
        
        while (count($nodes) > 0) {
            $min = INF;
            $minNode = null;
            foreach ($nodes as $node) {
                if ($distancia[$node] < $min) {
                    $min = $distancia[$node];
                    $minNode = $node;
                }
            }
            
            if ($minNode === null) {
                break;
            }
            
            $nodes = array_diff($nodes, [$minNode]);
            
            if ($minNode === $destino) {
                break;
            }
            
            if (isset($grafo[$minNode])) {
                foreach ($grafo[$minNode] as $vizinho => $peso) {
                    $alt = $distancia[$minNode] + $peso;
                    
                    if ($alt < $distancia[$vizinho]) {
                        $distancia[$vizinho] = $alt;
                        $anterior[$vizinho] = $minNode;
                    }
                }
            }
        }
        
        return $distancia[$destino] === INF ? -1 : $distancia[$destino];
    }
}


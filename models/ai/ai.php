<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;
// AI
use Phpml\Classification\KNearestNeighbors;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\Demo\WineDataset;
use Phpml\Metric\Accuracy;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Classification\MLPClassifier;

class AI extends Cores\_Model{
    function __construct(){
        parent::__construct();
    }

    function KNearestNeighbors(){
        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'b', 'b', 'b'];
        
        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);
        
        $a = $classifier->predict([3, 2]);

        return $a;
    }

    function wineQuality(){
        $dataset = new WineDataset();
        $split = new StratifiedRandomSplit($dataset);
        $regression = new SVR(Kernel::RBF, 3, 0.1, 10);
        $regression->train($split->getTrainSamples(), $split->getTrainLabels());
        $predicted = $regression->predict($split->getTestSamples());
        // predicted target are regression result so to test accuracy we must round them
        foreach ($predicted as &$target) {
            $target = round($target, 0);
        }
        return 'Accuracy: '.Accuracy::score($split->getTestLabels(), $predicted);
    }

    function MLPClassifier(){
        $mlp = new MLPClassifier(4, [2], ['a', 'b', 'c']);
        $mlp->train(
            $samples = [[1, 0, 0, 0], [0, 1, 1, 0], [1, 1, 1, 1], [0, 0, 0, 0]],
            $targets = ['a', 'a', 'b', 'c']
        );
        $mlp->partialTrain(
            $samples = [[1, 0, 0, 0], [0, 1, 1, 0]],
            $targets = ['a', 'a']
        );
        $mlp->partialTrain(
            $samples = [[1, 1, 1, 1], [0, 0, 0, 0]],
            $targets = ['b', 'c']
        );
        return $mlp->predict([[1, 1, 1, 1], [0, 0, 0, 0]]);
    }
}

// If want to load more and not clash can do partial model load.
?>
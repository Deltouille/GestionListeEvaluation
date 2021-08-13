<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ProgressionExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('Progression', [$this, 'getProgression']),
        ];
    }

    public function getProgression($listeTache)
    {   
        $totalTaches = count($listeTache);
        $tachesTerminées = 0;
        foreach($listeTache as $tache){
            if($tache->getStatut() == 'Terminé'){
                $tachesTerminées += 1;
            }
        }

        if($tachesTerminées == 0){
            return 0;
        }else{
            return ($tachesTerminées/$totalTaches)*100;
        }
    }
}

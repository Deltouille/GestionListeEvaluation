<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CountStatutExtension extends AbstractExtension
{
    public function getFilters(): array
    {
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            return [
                new TwigFilter('filter_name', [$this, 'doSomething']),
            ];
    }

    public function getFunctions(): array
    {
        

        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFunction('getStatutToDo', [$this, 'getStatutToDo']),
            new TwigFunction('getStatutEnCours', [$this, 'getStatutEnCours']),
            new TwigFunction('getStatutTermine', [$this, 'getStatutTermine']),
            new TwigFunction('getCountTache', [$this, 'getCountTache']),
        ];
    }

    public function getStatutToDo($tache){
        $toDo = 0;
        foreach($tache as $laTache){
            if($laTache->getStatut() == 'A Faire'){
                $toDo += 1;
            }
        }
        return $toDo;
    }

    public function getStatutEnCours($tache){
        $enCours = 0;
        foreach($tache as $laTache){
            if($laTache->getStatut() == 'En Cours'){
                $enCours += 1;
            }
        }
        return $enCours;
    }

    public function getStatutTermine($tache){
        $termine = 0;
        foreach($tache as $laTache){
            if($laTache->getStatut() == 'Terminé'){
                $termine += 1;
            }
        }
        return $termine;
    }

    public function getCountTache($tache){
        return count($tache);
    }
}

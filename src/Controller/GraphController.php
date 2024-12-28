<?php

namespace App\Controller;

use App\Repository\ProductionRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphController extends AbstractController
{
    #[Route('/graph', name: 'graph')]
    public function index(ChartBuilderInterface $chartBuilder, ProductionRepository $productionRepository): Response
    {
        $stat_typeprod = $productionRepository->findByTypeProduction();

        $labels_count_typeprod = [];
        $data_count_typeprod = [];

        foreach ($stat_typeprod as $typeprod) {
            $labels_count_typeprod[] = $typeprod["Type_Prod"] . ' (OF ' . $typeprod["Num_OF"] . ')';
            $data_count_typeprod[] = $typeprod["Cpt_Flacon"];
        }

        // Type de production en relation avec le numéro d'OF et avec le nombre de flacons
        $chart_count_typeprod = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart_count_typeprod->setData([
            'labels' => $labels_count_typeprod,
            'datasets' => [
                [
                    'label' => 'Nombre de flacons par type de production et OF',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(24, 188, 156)',
                    'data' => $data_count_typeprod,
                ],
            ],
        ]);

        // Appel de la méthode pour les données cumulées par type de production
        $stat_sum_typeprod = $productionRepository->findSumTypeProduction();

        $labels_sum_typeprod = [];
        $data_sum_typeprod = [];

        foreach ($stat_sum_typeprod as $sum_typeprod) {
            $labels_sum_typeprod[] = $sum_typeprod["Type_Prod"];
            $data_sum_typeprod[] = $sum_typeprod["Total_Flacons"];
        }

        // Graphique pour les données cumulées par type de production
        $chart_sum_typeprod = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart_sum_typeprod->setData([
            'labels' => $labels_sum_typeprod,
            'datasets' => [
                [
                    'label' => 'Nombre total de flacons par type de production cumulé',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(24, 188, 156)',
                    'data' => $data_sum_typeprod,
                ],
            ],
        ]);

        // Appel de la méthode pour les données cumulées par opérateur
        $stat_sum_operateur = $productionRepository->findSumOperateurProduction();

        $labels_sum_operateur = [];
        $data_sum_operateur = [];

        foreach ($stat_sum_operateur as $sum_operateur) {
            $labels_sum_operateur[] = $sum_operateur["Operateur"];
            $data_sum_operateur[] = $sum_operateur["Total_Flacons"];
        }

        // Graphique pour les données cumulées par opérateur
        $chart_sum_operateur = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart_sum_operateur->setData([
            'labels' => $labels_sum_operateur,
            'datasets' => [
                [
                    'label' => 'Nombre total de flacons par opérateur',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(24, 188, 156)',
                    'data' => $data_sum_operateur,
                ],
            ],
        ]);

    // Appel de la méthode pour le nombre d'échecs de production
        $production_failures = $productionRepository->findProductionFailures();

        // Création du graphique pour le nombre d'échecs de production
        $chart_failures = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart_failures->setData([
            'labels' => ["Échecs de production"],
            'datasets' => [
                [
                    'label' => 'Nombre d\'échecs de production',
                    'backgroundColor' => 'rgb(192, 57, 43)',
                    'borderColor' => 'rgb(211, 84, 0)',
                    'data' => [$production_failures['Total_Echecs']],
                ],
            ],
        ]);

        // Appel de la méthode pour le nombre d'échecs de production par OF
        $production_failures_by_of = $productionRepository->findProductionFailuresByOF();

        // Création des données pour le graphique des échecs de production par OF
        $labels_failures_by_of = [];
        $data_failures_by_of = [];

        foreach ($production_failures_by_of as $failure) {
            $labels_failures_by_of[] = "OF " . $failure['Num_OF'];
            $data_failures_by_of[] = $failure['Total_Echecs'];
        }

        // Création du graphique pour le nombre d'échecs de production par OF
        $chart_failures_by_of = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart_failures_by_of->setData([
            'labels' => $labels_failures_by_of,
            'datasets' => [
                [
                    'label' => 'Nombre d\'échecs de production par OF',
                    'backgroundColor' => 'rgb(192, 57, 43)',
                    'borderColor' => 'rgb(211, 84, 0)',
                    'data' => $data_failures_by_of,
                ],
            ],
        ]);

        return $this->render('stat/index.html.twig', [
            'chart1' => $chart_count_typeprod,
            'chart2' => $chart_sum_typeprod,
            'chart3' => $chart_sum_operateur,
            'chart4' => $chart_failures_by_of,
            'chart5' => $chart_failures,
            'current_menu' => 'Graphiques'
        ]);
    }
}

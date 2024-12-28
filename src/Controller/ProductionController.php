<?php

namespace App\Controller;

use App\Entity\Production;
use App\Form\ProductionSearchFormType;
use App\Form\ProductionType;
use App\Repository\ProductionRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/production')]
class ProductionController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/', name: 'prod_index', methods: ['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, ProductionRepository $productionRepository, Request $request): Response
    {
        $productions = $paginator->paginate($productionRepository->getAllProductions(),$request->query->getInt('page',1),10);

        $form = $this->createForm(ProductionSearchFormType::class);
        $form->handleRequest($request);

        //$productions = $productionRepository->getAllProductions();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $numOf = $data['numOf'];
            $startDate = $data['startDate'];
            $endDate = $data['endDate'];
            $type = $data['type'];
            $operator = $data['operator'];

            $productions = $productionRepository->searchProductions($numOf, $startDate, $endDate, $type, $operator);
            return $this->render('production/indexSearch.html.twig', ['current_menu' => 'productions', 'productions' => $productions]);
        }

        return $this->render('production/index.html.twig', [
            'current_menu' => 'Production',
            'form' => $form->createView(),
            'productions' => $productions,
        ]);
    }

    #[Route('/edit/{id}', name: 'prod_edit')]
    public function edit(int $id, Request $request, ProductionRepository $productionRepository): Response
    {
        // Récupérer l'OF à éditer en utilisant le repository
        $production = $productionRepository->findById($id);
//        dd($production);

        // Créer le formulaire de modification
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

        // Gérer la soumission du formulaire de modification
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Sauvegarder les modifications dans la base de données
                $productionRepository->update($production);
                $this->addFlash('success', 'La production a été modifiée avec succès.');
                return $this->redirectToRoute('prod_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la modification de la production : ' . $e->getMessage());
            }
        }

        // Afficher le formulaire de modification
        return $this->render('production/edit.html.twig', [
            'production' => $production,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/new', name: 'prod_new')]
    public function new(Request $request, ProductionRepository $productionRepository): Response
    {

        $production = new Production();
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $productionRepository->save($production);
                $this->addFlash('success', 'La production a été ajoutée avec succès.');
                return $this->redirectToRoute('prod_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de la production : ' . $e->getMessage());
            }
        }

        return $this->render('production/new.html.twig', [
            'production' => $production,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'prod_delete')]
    public function delete(int $id, ProductionRepository $productionRepository): RedirectResponse
    {
        $productionRepository->delete($id);

        return $this->redirectToRoute('prod_index');
    }

    #[Route('/export-excel', name: 'prod_export_excel')]
    public function exportExcel(ProductionRepository $productionRepository): BinaryFileResponse
    {
        // Récupérer la date du jour
        $currentDate = new \DateTime();
        $currentDateFormatted = $currentDate->format('Ymd');

        // Récupérer les données de production
        $productions = $productionRepository->getAllProductions();

        // Créer un nouveau classeur Excel
        $spreadsheet = new Spreadsheet();

        // Sélectionner la feuille active
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter les en-têtes de colonnes avec les nouveaux noms
        $sheet->fromArray([
            ['Id', 'Numéro OF', 'Heure Début production', 'Heure Fin production', 'Type de production', 'Opérateur', 'Comptage Flacon', 'Comptage Bouchon', 'Comptage Prise Robot', 'Comptage Dépose Robot']
        ], null, 'A1');

        // Appliquer la mise en forme à l'en-tête
        $styleHeader = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFA0A0A0'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($styleHeader);

        // Remplir les données
        $data = [];
        foreach ($productions as $production) {
            //mmettre les données au format DateTime car sinon le formatage "format('d/m/Y H:i:s')" n'est pas accepté
            $horoDebut = $production['Horo_Debut'] instanceof \DateTime ? $production['Horo_Debut'] : new \DateTime($production['Horo_Debut']);
            $horoFin = $production['Horo_Fin'] instanceof \DateTime ? $production['Horo_Fin'] : new \DateTime($production['Horo_Fin']);
            $data[] = [
                $production['Id'],
                $production['Num_OF'],
                $horoDebut->format('d/m/Y H:i:s'),
                $horoFin->format('d/m/Y H:i:s'),
                $production['Type_Prod'],
                $production['Operateur'],
                $production['Cpt_Flacon'],
                $production['Cpt_Bouchon'],
                $production['Cpt_Prise_Robot'],
                $production['Cpt_Depose_Robot'],
            ];
        }
        // Ajouter les données au classeur Excel
        $sheet->fromArray($data, null, 'A2');

        // Appliquer une couleur différente aux lignes impaires
        $styleOddRow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE0E0E0'],
            ],
        ];
        $lastRow = count($data) + 1;
        for ($i = 3; $i <= $lastRow; $i += 2) {
            $sheet->getStyle('A' . $i . ':J' . $i)->applyFromArray($styleOddRow);
        }
        // Enregistrer le fichier Excel temporairement
        $filePath = tempnam(sys_get_temp_dir(), 'export_production_' . $currentDateFormatted) . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // Créer une réponse de fichier binaire
        $response = new BinaryFileResponse($filePath);

        // Définir l'en-tête Content-Disposition pour que le navigateur propose de télécharger le fichier
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'export_production_' . $currentDateFormatted . '.xlsx'
        );

        return $response;
    }

}

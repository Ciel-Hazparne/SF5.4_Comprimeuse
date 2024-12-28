<?php

namespace App\Repository;

use App\Entity\Production;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

class ProductionRepository extends ServiceEntityRepository
{
    private $connection;

    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, Production::class);
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    private function getConnection(): Connection
    {
        $connectionParams = [
            'url' => 'sqlsrv://userphp:userphp@10.0.0.77/Comprimeuse',
//            'url' => 'sqlsrv://userphp:userphp@192.168.1.61/Comprimeuse',
//            'url' => 'sqlsrv://userphp:userphp@10.0.98.252/Comprimeuse',
//            'url' => 'sqlsrv://userphp:userphp@192.168.50.190/Comprimeuse',
        ];

        return DriverManager::getConnection($connectionParams);
    }

    /**
     * @throws Exception
     */
    public function getAllProductions(): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT * FROM [dbo].[Production]";
        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * @throws Exception
     */
    public function searchProductions($numOf, $startDate, $endDate, $type, $operator): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT * FROM [dbo].[Production] WHERE 1=1";

        if ($numOf) {
            $sql .= " AND [Num_OF] = '$numOf'";
        }

        if ($startDate) {
            $formattedStartDate = $startDate->format('d-m-Y H:i:s');
            $sql .= " AND [Horo_Debut] >= '$formattedStartDate'";
        }

        if ($endDate) {
            $formattedEndDate = $endDate->format('d-m-Y H:i:s');
            $sql .= " AND [Horo_Fin] <= '$formattedEndDate'";
        }

        if ($type) {
            $sql .= " AND [Type_Prod] = '$type'";
        }

        if ($operator) {
            $sql .= " AND [Operateur] = '$operator'";
        }

        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }

    public function delete(int $id): void
    {
        $conn = $this->getConnection();
        $sql = "DELETE FROM [dbo].[Production] WHERE [Id] = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function save(Production $production): void
    {
        $sql = "INSERT INTO [dbo].[Production] ([Num_OF], [Horo_Debut], [Horo_Fin], [Type_Prod], [Operateur], [Cpt_Flacon], [Cpt_Bouchon], [Cpt_Prise_Robot], [Cpt_Depose_Robot]) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $production->getNumOf(),
            $production->getHoroDebut(),
            $production->getHoroFin(),
            $production->getTypeProd(),
            $production->getOperateur(),
            $production->getCptFlacon(),
            $production->getCptBouchon(),
            $production->getCptPriseRobot(),
            $production->getCptDeposeRobot()
        ];

        $this->connection->executeQuery($sql, $params);
    }

    public function update(Production $production): void
    {
        $sql = "UPDATE [dbo].[Production] SET [Num_OF] = ?, [Horo_Debut] = ?, [Horo_Fin] = ?, [Type_Prod] = ?, [Operateur] = ?, [Cpt_Flacon] = ?, [Cpt_Bouchon] = ?, [Cpt_Prise_Robot] = ?, [Cpt_Depose_Robot] = ? WHERE [Id] = ?";

        $params = [
            $production->getNumOf(),
            $production->getHoroDebut(),
            $production->getHoroFin(),
            $production->getTypeProd(),
            $production->getOperateur(),
            $production->getCptFlacon(),
            $production->getCptBouchon(),
            $production->getCptPriseRobot(),
            $production->getCptDeposeRobot(),
            $production->getId()
        ];

        $this->connection->executeQuery($sql, $params);
    }

    public function findById(int $id)
    {
        $conn = $this->getConnection();

        $sql = "SELECT * FROM [dbo].[Production] WHERE [Id] = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->executeQuery();
        $resultset = $result->fetchAssociative();

        // Créer un objet Production à partir des données récupérées
        $production = new Production();
        $production->setId($resultset['Id']);
        $production->setNumOf($resultset['Num_OF']);
        $production->setHoroDebut(new \DateTime($resultset['Horo_Debut'])); // Convertir la chaîne en objet DateTime sinon ça ne va pas passer lors de la réation du formulaire
        $production->setHoroFin(new \DateTime($resultset['Horo_Fin'])); // Convertir la chaîne en objet DateTime
        $production->setTypeProd($resultset['Type_Prod']);
        $production->setOperateur($resultset['Operateur']);
        $production->setCptFlacon($resultset['Cpt_Flacon']);
        $production->setCptBouchon($resultset['Cpt_Bouchon']);
        $production->setCptPriseRobot($resultset['Cpt_Prise_Robot']);
        $production->setCptDeposeRobot($resultset['Cpt_Depose_Robot']);

        return $production;
    }

    public function findByTypeProduction()
    {
        $conn = $this->getConnection();

        $sql = "SELECT [Num_OF],[Type_Prod], [Cpt_Flacon] FROM [dbo].[Production]";
        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }

    public function findSumTypeProduction(): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT [Type_Prod], SUM([Cpt_Flacon]) as Total_Flacons FROM [dbo].[Production] GROUP BY [Type_Prod]";
        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }

    public function findSumOperateurProduction(): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT [Operateur], SUM([Cpt_Flacon]) as Total_Flacons FROM [dbo].[Production] GROUP BY [Operateur]";
        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }

    public function findProductionFailures(): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT SUM([Cpt_Flacon] - [Cpt_Bouchon]) AS Total_Echecs FROM [dbo].[Production] WHERE [Cpt_Flacon] > [Cpt_Bouchon]";
        $stmt = $conn->query($sql);

        return $stmt->fetch();
    }

    public function findProductionFailuresByOF(): array
    {
        $conn = $this->getConnection();

        $sql = "SELECT [Num_OF], SUM([Cpt_Flacon] - [Cpt_Bouchon]) AS Total_Echecs FROM [dbo].[Production] WHERE [Cpt_Flacon] > [Cpt_Bouchon] GROUP BY [Num_OF]";
        $stmt = $conn->query($sql);

        return $stmt->fetchAll();
    }
}

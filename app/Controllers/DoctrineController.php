<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Entity\Invoice;
use Synthex\Phptherightway\Entity\InvoiceItem;
use Synthex\Phptherightway\Enums\InvoiceStatus;

class DoctrineController
{
    private $conn;
    private EntityManager $entityManager;

    public function __construct()
    {
        $this->conn = App::db();

        $this->entityManager = new EntityManager(
            conn: DriverManager::getConnection(Config::getInstance($_ENV)->db ?? []),
            config: ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ . '/../Entity'],
            ),
        );
    }

    #[Get('/doctrine')]
    public function index(): void
    {
        // $this->getBetween();
        // $this->getIdsFromList();
        // $this->builder();
        // $this->schema();

        $this->doctrineOrmPlayground();

    }

    private function getBetween()
    {
        $stmt = $this->conn->prepare('SELECT * FROM tickets WHERE created_at BETWEEN :from AND :to');
        $from = new \DateTime('2022-01-01');
        $to = new \DateTime('2022-01-31');

        $stmt->bindValue(':from', $from, 'datetime');
        $stmt->bindValue(':to', $to, 'datetime');

        $result = $stmt->executeQuery();

        var_dump($result->fetchAllAssociative());
    }

    private function getIdsFromList()
    {
        $ids = [1, 2, 3];
        // $vals = str_repeat('?,', count($ids) - 1) . '?';

        $result = $this->conn->executeQuery(
            sql: 'SELECT id, created_at FROM tickets WHERE id IN (?)',
            params:[ $ids],
            types: [ArrayParameterType::INTEGER],
        );

        var_dump($result->fetchAllAssociative());
    }

    /**
     * A Doctrine\DBAL\Connection provides an API for transaction management,
     * with the methods beginTransaction(), commit() and rollBack().
     * @return void
     */
    private function transactions()
    {
        $this->conn->beginTransaction();
        try{
            // do stuff
            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }

        /**
         * Alternatively, the control abstraction Connection#transactional($func)
         * can be used to make the code more concise and to make sure you never
         * forget to rollback the transaction in the case of an exception.
         * The following code snippet is functionally equivalent to the previous one:
         */

        $this->conn->transactional(function(Connection $conn): void {
            // do stuff
        });

        /**
         * Note that the closure above doesn't have to be a void,
         * anything it returns will be returned by transactional():
         */

        $one = $this->conn->transactional(function(Connection $conn): int {
            // do stuff
            return $conn->fetchOne('SELECT 1');
        });
    }

    private function builder()
    {
        $builder = $this->conn->createQueryBuilder();

        $result = $builder
            ->select('id', 'title')
            ->from('tickets')
            ->where('id = ?')
            ->setParameter(0, 1)
            // ->getSQL();
            ->fetchAllAssociative();

        var_dump($result);
    }

    private function schema()
    {
        $schema = $this->conn->createSchemaManager();
        $tables = $schema->listTableNames();

        var_dump($tables);

        $columns = $schema->listTableColumns('tickets');
        // var_dump(array_map(fn(Column $column) => $column->getName(), $columns));
        var_dump(array_keys($columns));
    }

    private function doctrineOrmPlayground()
    {
        $items = [
            ['Item 1', 1, 15],
            ['Item 2', 2, 10.5],
            ['Item 3', 3, 5.75],
        ];

        $invoice = (new Invoice())
            ->setAmount(35)
            ->setInvoiceNumber('12345')
            ->setStatus(InvoiceStatus::Pending)
            ->setCreatedAt(new \DateTime());

        foreach ($items as [$description, $quantitty, $unitPrice]) {
            $item = (new InvoiceItem())
                ->setDescription($description)
                ->setQuantity($quantitty)
                ->setUnitPrice($unitPrice);

            $invoice->addItem($item);

            // $this->entityManager->persist($item); <-- add cascade: ['persist', 'remove'] to Invoice
        }

        // $this->entityManager->persist($invoice);
        // $this->entityManager->flush();

        $this->entityManager->remove($invoice);
        $this->entityManager->flush();

        echo $this->entityManager->getUnitOfWork()->size();

        // get an entity and update it
        $inv = $this->entityManager->find(Invoice::class, 49);
        $inv->setStatus(InvoiceStatus::Paid);
        $this->entityManager->flush();
    }
}

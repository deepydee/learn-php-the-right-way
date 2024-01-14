<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;
use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Core\App;

class DoctrineController
{
    private $conn;

    public function __construct()
    {
        $this->conn = App::db();
    }

    #[Get('/doctrine')]
    public function index(): void
    {
        // $this->getBetween();
        // $this->getIdsFromList();
        // $this->builder();
        $this->schema();

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
}
